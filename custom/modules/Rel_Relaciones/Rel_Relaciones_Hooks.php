<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 6/12/2015
 * Time: 9:37 PM
 */
require_once("custom/Levementum/UnifinAPI.php");
class Rel_Relaciones_Hooks{

    public function SetName($bean=null,$event=null,$args=null){

         global $db;
         $query = <<<SQL
SELECT name FROM accounts WHERE id = '{$bean->account_id1_c}'
SQL;
         $queryResult = $db->query($query);

        // $relacionesActivas = $bean->relaciones_activas;
        // $relacionesActivas = str_replace('^','',$relacionesActivas);
         while($row = $db->fetchByAssoc($queryResult))
         {
             // $bean->name = $relacionesActivas . " - " . $row['name'];
             $bean->name = $row['name'];
         }
    }

    public function insertarRelacionenUNICS($bean=null,$event=null,$args=null){
		//only for new records
		/*** CVV INICIO ***/
		//Debe validarse si el cliente ya  tiene id_UNICS
		global $db, $current_user;
        $GLOBALS['log']->fatal(" <".$current_user->user_name."> Entra a insertarRelacionenUNICS");
        $callApiAccounts = new UnifinAPI();
		try {
		    /*
		     * F. Javier G. Solar
		     * 20/08/2018
		     * Valida si la cuenta arelacionar esta en estado Lead y no ha sido sincronizda
		     * envia la petición
		    **/
            $CuentaC =  BeanFactory::getBean('Accounts',$bean->account_id1_c);
            if(($CuentaC->tipo_registro_c=='Lead' || $CuentaC->tipo_registro_c=='Prospecto') && $CuentaC->sincronizado_unics_c==0){
                $GLOBALS['log']->fatal(" el id de la cuenta es ingredsado por JA  " . $bean->account_id1_c);
                $CuentaC->idcliente_c =$callApiAccounts->generarFolios(1);
                $GLOBALS['log']->fatal(" Folio de unix " . $CuentaC->idcliente_c);
                $actualizaIdClienteLead= <<<SQL
update accounts_cstm set idcliente_c = '{$CuentaC->idcliente_c}' where id_c = '{$CuentaC->id}';
SQL;
                $db->query($actualizaIdClienteLead);
                $lead = $callApiAccounts->insertarClienteCompleto($CuentaC);
			}

        $query = <<<SQL
SELECT acc.idcliente_c idCliente, acc.sincronizado_unics_c ClienteSincronizado,
contact.idcliente_c idRelacionado, contact.sincronizado_unics_c RelacionadoSincronizado, contact.id_c GuidRelacionado
FROM rel_relaciones_accounts_c rel
inner join accounts_cstm acc on rel.rel_relaciones_accountsaccounts_ida = acc.id_c
inner join rel_relaciones_cstm Relcontact on Relcontact.id_c = rel.rel_relaciones_accountsrel_relaciones_idb
inner join accounts_cstm contact on contact.id_c = Relcontact.account_id1_c
where rel.rel_relaciones_accountsrel_relaciones_idb = '{$bean->id}'
SQL;
            $GLOBALS['log']->fatal(" <".$current_user->user_name."> query" . $query);
			$queryResult = $db->query($query);
			while ($row = $db->fetchByAssoc($queryResult)) {
			$GLOBALS['log']->fatal(" <".$current_user->user_name."> : El valor de idCliente_c al agregar relacion: " . $row['idCliente'] . " El cliente se encuentra sincronizado con UNICS:". $row['ClienteSincronizado']);
			$callApi = new UnifinAPI();

			//Las relaciones solo se enviaran si el cliente ya se encuentra en UNICS
			if ($row['ClienteSincronizado'] == 1){
				//Si la persona no esta enviada a UNICS, debe sincronizarse antes de guardar la relación
                if ($row['RelacionadoSincronizado'] == 0){
                	$GLOBALS['log']->fatal(" <".$current_user->user_name."> : La persona relacionada NO se encuentra sincronizada con UNICS");
                	$contacto =  BeanFactory::getBean('Accounts', $row['GuidRelacionado']);
                	$GLOBALS['log']->fatal(" <".$current_user->user_name."> : Contenido de relacion en persona: " . print_r($contacto->tipo_relacion_c ,true));
                	$contacto->save();
				}

				///Envia la relación
				if (empty($bean->fetched_row['id'])) {
						$relacion = $callApi->creaRelacion($bean);
				}else{
                    // TODO Validar que la relación se encuentre sincronizada con UNICS antes de invocar el servicio de actualizarRelación
                    if($bean->fetched_row['sincronizado_unics_c'] == '1'){
                        $relacion = $callApi->ActualizaRelacion($bean);
                    }else{
                        $relacion = $callApi->creaRelacion($bean);
                    }
                }
                    //Actualiza el campo de sincronizdo UNICS de la relación
                $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ .  " <".$current_user->user_name."> : RELACION " . print_r($relacion,true));
				if ($relacion == true){
					$fieldUnicsSincronize = <<<SQL
update rel_relaciones_cstm set sincronizado_unics_c = '1' where id_c = '{$bean->id}';
SQL;
                    $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ .  " <".$current_user->user_name."> : CONSULTA " . $fieldUnicsSincronize);
					$db->query($fieldUnicsSincronize);
				}
            }
		}

        } catch (Exception $e) {
            error_log(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ .  " <".$current_user->user_name."> : Error: " . $e->getMessage());
            $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ .  " <".$current_user->user_name."> : Error " . $e->getMessage());
        }
    }

    public function detectaEstadoRelacion($bean = null, $event = null, $args = null)
    {
        global $current_user;
        if (empty($bean->fetched_row['id'])) {
            $_SESSION['estadoRelacion'] = 'insertando';
        } else {
            $_SESSION['estadoRelacion'] = 'actualizando';
        }
        $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : ESTADO: " . $_SESSION['estadoRelacion'] );
    }
}
