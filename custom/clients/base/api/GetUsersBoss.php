<?php
/**
 * @author F. Javier G. Solar
 * Date: 31/07/2018
 * Time: 09:16 AM
 */

require_once('modules/ACLRoles/ACLRole.php');

class GetUsersBoss extends SugarApi
{
    /**
     * Registro de todas las rutas para consumir los servicios del API
     *
     */
    public function registerApiRest()
    {
        return array(
            //GET
            'retrieve' => array(
                //request type
                'reqType' => 'GET',
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('GetUsersBoss', '?'),
                //endpoint variables
                'pathVars' => array('module', 'id_cuenta'),
                //method to call
                'method' => 'GetUserHeadByTeam',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método GET para validar que cumpla con los datos necesarios para crear la solicitud',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),

        );

    }

    /**
     * Obtiene los Jefes y usuarios relacionados con la Cuenta
     *
     * Método que obtiene los jefes y usuarios relacionados con una Cuenta y compara
     * con el usuario firmado para otorgar permisos de visibilidad sonbre el campo correo y teléfonos
     *
     * @param array $api
     * @param array $args Array con los parámetros enviados para su procesamiento
     * @return bander true o false
     * @throws SugarApiExceptionInvalidParameter
     */
    public function GetUserHeadByTeam($api, $args)
    {
  		$flag = false;
  		$idCuenta = $args['id_cuenta'];
  		$flag = GetUsersBoss::GetUsersBossMethod($idCuenta);
      if(!$flag)
      {
    		global $db;
    		$query = "select id_c from rel_relaciones_cstm where account_id1_c = '$idCuenta'";
        $result = $db->query($query);
    		while($row = $db->fetchByAssoc($result))
    		{
    			$idrel = $row['id_c'];
    			$query1 = "select rel_relaciones_accounts_1accounts_ida from rel_relaciones_accounts_1_c where rel_relaciones_accounts_1rel_relaciones_idb = '$idrel'";
    			$result1 = $db->query($query1);
    			while($row1 = $db->fetchByAssoc($result1))
    			{
    				$idCuenta1 = $row1['rel_relaciones_accounts_1accounts_ida'];
            if(!$flag)
            {
              $flag = GetUsersBoss::GetUsersBossMethod($idCuenta1);
            }
    			}
  		  }
      }
      return $flag;
    }

	  public function GetUsersBossMethod($idCuenta)
	  {
        $flag = false;
        $beanAccounts = BeanFactory::getBean("Accounts", $idCuenta);
        global $current_user;
        global $app_list_strings;
        $usrLeasing = $beanAccounts->user_id_c;
        $usrFactoraje = $beanAccounts->user_id1_c;
        $usrCredito = $beanAccounts->user_id2_c;
        $usrFleet = $beanAccounts->user_id6_c;
        $usrUniclick = $beanAccounts->user_id7_c;
        $usuarioLog = $current_user->id;
        $queryR = "Select R.id, R.name
		 from acl_roles R
		 left join acl_roles_users RU
		 on  RU.role_id=R.id
		 Where RU.user_id='{$usuarioLog}' and RU.deleted=0";

        /*
         * Validamos si el usuario Firmado es igual a credito, factoraje y leasing.
         * Modificación para obtener padres e hijos del usuario logueado. Adrian Arauz 3/10/2018
        **/

        if ($usuarioLog == $usrLeasing || $usuarioLog == $usrFactoraje || $usuarioLog == $usrCredito || $usuarioLog==$usrFleet || $usuarioLog==$usrUniclick) {
            $flag = true;
        }

        if ($flag == false)  {
            $query = "select id from (select * from users order by reports_to_id,id) users_sorted,
                (select @pv :='{$usuarioLog}') iniatialisation
                where find_in_set(reports_to_id, @pv)
                and length(@pv := concat(@pv,',',id));";
            $result = $GLOBALS['db']->query($query);
            while ($row = $GLOBALS['db']->fetchByAssoc($result)){
                if (  $row['id'] == $usrLeasing ||  $row['id'] == $usrFactoraje ||  $row['id'] ==$usrCredito || $row['id'] == $usrFleet) {
                    $flag = true;
                }
            }
        }

        //Valida Rol full access
        if ($app_list_strings['full_access_accounts_list'] != "" && $flag == false) {
            $list = $app_list_strings['full_access_accounts_list'];
            $result = $GLOBALS['db']->query($queryR);
            while ($row = $GLOBALS['db']->fetchByAssoc($result)) {

                $temp = $row['name'];

                foreach ($list as $newList) {

                    if ($row['name'] == $newList) {
                        $flag = true;
                        //  $GLOBALS['log']->fatal("coincide: " . $row['name']);
                    }
                }
            }
        }

        //Valida Admin
        if ($current_user->is_admin == true) {
          $flag = true;
        }

        //Valida BO
        if ($flag == false && ($current_user->puestousuario_c == '6' || $current_user->puestousuario_c == '12' || $current_user->puestousuario_c == '17'))  {
            //Define variables
            $equiposPromotores = '';
            $equiposBO = '';
            $concidencias = array();
            //Recupera equipos de promotores
            $queryP = "select group_concat(replace(concat( equipos_c, ',', equipo_c),'^',''),'') as equipos
                      from users_cstm
                      where id_c in ('{$usrLeasing}','{$usrFactoraje}','{$usrCredito}'),'{$usrFleet}'";
            $resultP = $GLOBALS['db']->query($queryP);
            while ($row = $GLOBALS['db']->fetchByAssoc($resultP)){
                if($row['equipos'] !='' && $row['equipos']!= null) {
                    $equiposPromotores = explode(",",$row['equipos']);
                }
            }
            //Recupera equipos de BO
            $queryBO = "select group_concat(replace(concat( equipos_c, ',', equipo_c),'^',''),'') as equipos
                      from users_cstm
                      where id_c in ('{$usuarioLog}');";
            $resultBO = $GLOBALS['db']->query($queryBO);
            while ($row = $GLOBALS['db']->fetchByAssoc($resultBO)){
                if($row['equipos'] !='' && $row['equipos']!= null) {
                    $equiposBO = explode(",",$row['equipos']);
                }
            }
            //Compara equipos
            $GLOBALS['log']->fatal("Compara equipos:" );
            if ($equiposPromotores!='' && $equiposBO!='') {
              $equiposPromotores = array_unique($equiposPromotores);
              $equiposBO = array_unique($equiposBO);
              $concidencias = array_intersect($equiposPromotores, $equiposBO);
              // $GLOBALS['log']->fatal(print_r($equiposPromotores,true));
              // $GLOBALS['log']->fatal(print_r($equiposBO,true));
              // $GLOBALS['log']->fatal(print_r($concidencias,true));
              if (count($concidencias)>0) {
                $flag= true;
              }
            }
        }

		    return $flag;
	  }
}
