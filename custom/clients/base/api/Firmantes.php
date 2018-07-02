<?php
/**
 * @author: CVV
 * @date: 25/07/2017
 */


if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class Firmantes extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'Firmantes' => array(
                'reqType' => 'GET',
                'path' => array('Firmantes','getFirmantes','?'),
                'pathVars' => array('', '', 'id'),
                'method' => 'getFirmantesList',
                'shortHelp' => 'Obtiene la lista de firmantes de un cliente.',
            ),
        );
    }

    public function getFirmantesList($api, $args)
    {
        global $db, $current_user;
        $idCliente = $args['id'];
        try
        {
            $Firmantes = $this->getRelaciones($idCliente,1);
            return $Firmantes;

        }catch (Exception $e){
            error_log(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error: ".$e->getMessage());
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error ".$e->getMessage());
        }

    }

    private function getRelaciones($idPersona, $all)
    {
        global $db, $current_user;
        try
        {
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Ingresa a getRelaciones, para obteber relaciones de ", print_r($idPersona,1));
            //Obtiene los firmantes del cliente
            $query = <<<SQL
select acc.id GUID, acc.name Nombre, cs.tipodepersona_c Regimen, rel.relaciones_activas Relaciones
from rel_relaciones_accounts_c rel_acc
INNER JOIN rel_relaciones rel ON rel_acc.rel_relaciones_accountsrel_relaciones_idb = rel.id
INNER JOIN rel_relaciones_cstm rel_cs ON rel_cs.id_c = rel.id
INNER JOIN Accounts acc ON acc.id = rel_cs.account_id1_c
INNER JOIN Accounts_cstm cs ON acc.id = cs.id_c
WHERE rel_acc.rel_relaciones_accountsaccounts_ida = '{$idPersona}'
SQL;
            if($all == 1){
                $query .= "AND relaciones_activas not in ('^Conyuge^','^Contacto^','^Directivo^','^Referencia^','^Referencia Personal^','^Referencia Cliente^','^Accionista^','^Referencia Proveedor^')";
            }else{
                $query .= "AND relaciones_activas like '%^Representante^%'";
            }

            $Rows = $db->query($query);
            //Recorremos listado de firmantes
            while ($Persona = $db->fetchByAssoc($Rows)) {
                $Firmante = Array(
                    "GUID"=>$Persona['GUID'],
                    "Nombre"=>$Persona['Nombre'],
                    "Regimen"=>$Persona['Regimen'],
                    "Relaciones"=>$Persona['Relaciones']
                );
                //Desglosa relaciones
                $Relaciones = str_replace('^','',$Persona['Relaciones']);
                $RelacionesList = explode(',', $Relaciones);
                $Firmante['Relaciones'] = $RelacionesList;
                // Si es PM agregar representantes
                if($Persona['Regimen'] == 'Persona Moral'){
                    $Firmante['Representantes'] = $this->getRelaciones($Persona['GUID'],0);
                }

                $DatosFirmantes[] = $Firmante;
            }

            return $DatosFirmantes;

        }catch (Exception $e){
            error_log(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error: ".$e->getMessage());
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error ".$e->getMessage());
        }

    }

}