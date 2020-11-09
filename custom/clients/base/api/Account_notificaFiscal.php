<?php
/**
 * Created by PhpStorm.
 * User: tactos
 * Date: 8/09/20
 * Time: 12:48 PM
 */


class Account_notificaFiscal extends SugarApi
{

    public function registerApiRest()
    {
        return array(
            'existsAccounts' => array(
                //request type
                'reqType' => 'POST',
                //set authentication
                'noLoginRequired' => false,
                //endpoint path
                'path' => array('notificaFiscal'),
                //endpoint variables
                'pathVars' => array(''),
                //method to call
                'method' => 'function_notificaFiscal',
                //short help string to be displayed in the help documentation
                'shortHelp' => ' Notificación de cotización de precio, UNI2 ',
                //long help to be displayed in the help documentation
                'longHelp' => 'Validará que no se haya generado una notificación durante los últimos 3 meses,
                 de ser así se deberá notificar al área fiscal. En caso contrario, no se ejecutará el envío de la notificación',
            )

        );
    }
    // Para la notificación de cotización de precio,
    // uni2 deberá ejecutar la petición a CRM y dentro de
    // CRM se validará que no se haya generado una notificación durante
    // los últimos 3 meses, de ser así se deberá notificar al área fiscal.
    // En caso contrario, no se ejecutará el envío de la notificación.


    public function function_notificaFiscal($api, $args)
    {
        $idCuenta = $args['idCuenta'];
        $nombreUsuario = $args['nombreUsuario'];
        $d = strtotime("now");
        $hoy = date("Y-m-d H:i:s", $d);
        if (!empty($idCuenta) && !empty($nombreUsuario)) {
            $beanAccount = BeanFactory::retrieveBean('Accounts', $idCuenta, array('disable_row_level_security' => true));

            if (!empty($beanAccount) && $beanAccount != null) {

                $mailTo = $this->getmailTo();

                if (!empty($mailTo)) {
                    $noti_accounts = "SELECT * FROM notification_accounts
WHERE account_id = '{$idCuenta}'
      AND notification_type = '3'
      AND date_entered > DATE_SUB(now(), INTERVAL 3 MONTH)
ORDER BY date_entered DESC";

                    $results = $GLOBALS['db']->query($noti_accounts);

                    $row = $GLOBALS['db']->fetchByAssoc($results);

                    $d = strtotime($row['date_entered']);
                    $fechaEnvio = date("Y-m-d", $d);

                    $responses = [];

                    if ($results->num_rows == 0) {
                        
						if ($enviado == "") {
                            $insert = "insert notification_accounts (id ,account_id,date_entered,notification_type,description,status,comprador)
					values ( uuid() , '" . $idCuenta . "','" . $hoy . "','3','Valor utilizado para guardar registro de notificación a partir de solicitud de compra.','1','{$nombreUsuario}')";
                            try {
                                $GLOBALS['db']->query($insert);
                            } catch (Exception $ex) {
                                $GLOBALS['log']->fatal("Exception " . $ex);
                            }
                            if ($ex == "") {
                                $responses = array("code" => "200", "status" => "success", "description" => "Se ha planificado exitosamente el envío de notificación al área fiscal.");
                            } else {
                                $responses = array("code" => "400", "status" => "error", "description" => $ex);
                            }
                        } else {
                            $responses = array("code" => "400", "status" => "error", "description" => $enviado);
                        }

                    } else {
                        $responses = array("code" => "200", "status" => "success", "description" => "La última actualización de este proveedor fue el $fechaEnvio. Por lo tanto no se notificó al área fiscal ");
                    }
                }

            } else {
                $responses = array("code" => "400", "status" => "error", "description" => "No existe la cuenta");
            }
        } else {
            $responses = array("code" => "400", "status" => "error", "description" => "Información incompleta");
        }
        return $responses;
    }

    public function getmailTo()
    {
        $query = "SELECT A.id,A.first_name,A.last_name,E.email_address
FROM users A
  INNER JOIN users_cstm B
    ON B.id_c = A.id
  INNER JOIN email_addr_bean_rel rel
    ON rel.bean_id = B.id_c
       AND rel.bean_module = 'Users'
       AND rel.deleted = 0
  INNER JOIN email_addresses E
    ON E.id = rel.email_address_id
  AND E.deleted=0
WHERE B.notifica_fiscal_c = 1 AND
 A.employee_status = 'Active' AND A.deleted = 0
 AND (A.status IS NULL OR A.status = 'Active') ";

        $results = $GLOBALS['db']->query($query);
        $mailTo = [];

        while ($row = $GLOBALS['db']->fetchByAssoc($results)) {

            //$GLOBALS['log']->fatal('nombre' .  $row['first_name'] . ' - correo ' . $row['email_address']);
            $full_name = $row['first_name'] . " " . $row['last_name'];
            $mailTo["{$full_name}"] = $row['email_address'];
        }

        return $mailTo;
    }

}