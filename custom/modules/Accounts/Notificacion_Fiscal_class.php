<?php

class Notificacion_Fiscal_class
{
    public function notificacionF($bean, $event, $args)
    {
        $esproveedor = $bean->esproveedor_c;
        $tipo_registro_cuenta = $bean->tipo_registro_cuenta_c;
        $idAccount = $bean->id;
        
        $NombreProveedor = $bean->name;
        $rfc = $bean->rfc_c;
        $d = strtotime("now");
        $hoy = date("Y-m-d H:i:s", $d);
		//$GLOBALS['log']->fatal('NombreProveedor'.$NombreProveedor);
        if ($esproveedor  || $tipo_registro_cuenta == '5') {
            $bean_user = BeanFactory::retrieveBean('Users', $bean->created_by, array('disable_row_level_security' => true));
            if (!empty($bean_user)) {
                $name_user = $bean_user->full_name;
            }
            $mailTo = $this->getEmailNotiFiscal();
			//$GLOBALS['log']->fatal('mailTo',$mailTo);
            if (!empty($mailTo)) {
               
                /** Valida si esta actualizando o fue creación*/
                if (isset($args['isUpdate']) && $args['isUpdate'] == false) {
					$insert = "insert notification_accounts (id ,account_id,date_entered,notification_type,description,status,comprador)
					values ( uuid() , '" . $idAccount . "','" . $hoy . "','1','Valor utilizado para guardar registro de notificación en creación de nuevo proveedor.','1','".$name_user."')";
                    $GLOBALS['db']->query($insert);
                } else {
                    $query = "select * from notification_accounts where account_id = '" . $idAccount . "' and  notification_type in ('1','2')";
                    $results = $GLOBALS['db']->query($query);
                    if ($results->num_rows == 0) {
                        $insert = "insert notification_accounts (id ,account_id,date_entered,notification_type,description,status,comprador)
						values ( uuid() , '" . $idAccount . "','" . $hoy . "','2','Valor utilizado para guardar registro de notificación en actualización de cuenta como proveedor.','1','".$name_user."')";
                        $GLOBALS['db']->query($insert);                        
                    }
                }
            }
        }
    }

    public function getEmailNotiFiscal()
    {
        $mailTo = [];
        $query1 = "SELECT
  nombre_completo_c,
  email_address
FROM (
       SELECT
         A.id,
         B.nombre_completo_c
       FROM users A
         INNER JOIN users_cstm B ON B.id_c = A.id
                                    AND A.status = 'Active'
                                    AND A.deleted = 0
                                    AND B.notifica_fiscal_c = 1) USUARIOS,
  (SELECT
     erel.bean_id,
     email.email_address
   FROM email_addr_bean_rel erel
     JOIN email_addresses email
       ON email.id = erel.email_address_id
   WHERE erel.bean_module = 'Users' AND erel.primary_address = 1 AND erel.deleted = 0 AND email.deleted = 0) EMAILS
WHERE EMAILS.bean_id = USUARIOS.id";


        $results1 = $GLOBALS['db']->query($query1);

        while ($row = $GLOBALS['db']->fetchByAssoc($results1)) {
            $correo = $row['email_address'];
            $nombre = $row['nombre_completo_c'];
            if ($correo != "") {
                $mailTo ["$correo"] = $nombre; 
            }
        }

        return $mailTo;
    }
}

?>