<?php
    //add the job key to the list of job strings
    array_push($job_strings, 'statusReferenciaVentaCruzada');

    function statusReferenciaVentaCruzada()
    {
        $GLOBALS['log']->fatal('DESDE CORE');
    	// Obtener Referencias que fueron creadas 3 meses atrás
        $hoy= date("Y-m-d H:i:s");
        $tres_meses=date( "Y-m-d H:i:s", strtotime( $hoy ." -3 month" ) );

        //Se obtiene un día menos a los tres meses para recuperar los registros creados en todo el día
        //y no solo casarlo con el operador (equals) ya que el campo es datetime y no solo date
        $tres_meses_un_dia_antes=date( "Y-m-d H:i:s", strtotime( $tres_meses ." -1 day" ) );
        //2020-04-28 20:42:26
        //2020-04-27 20:42:26

        $query = <<<SQL
select * from ref_venta_cruzada 
where date_entered between '{$tres_meses_un_dia_antes}' and '{$tres_meses}' 
order by date_entered desc
SQL;
        $GLOBALS['log']->fatal("EL QUERY");
        $GLOBALS['log']->fatal($query);
        $result = $GLOBALS['db']->query($query);
        $countRef=$result->num_rows;

        $GLOBALS['log']->fatal(print_r($result,true));

		if($countRef>0){

            while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                //Obtiene valores del cliente
                $beanRef = BeanFactory::retrieveBean('Ref_Venta_Cruzada', $row['id']);

                if(!empty($beanRef)){

                    $numeroAnexos=$beanRef->numero_anexos;
                    if($numeroAnexos>0){
                        $GLOBALS['log']->fatal("Tiene anexos, es exitosa");
                        //Exitosa
                        $beanRef->estatus='4';
                        $beanRef->save();
                        //Crea Notificacion
                        /*
                        $notification_bean = BeanFactory::getBean("Notifications");
                        $notification_bean->name = 'Referencia exitosa';
                        $notification_bean->description = 'Se le informa que la referencia de venta cruzada para la cuenta:'..', ha sido exitosa y ya cuenta con anexos/contratos activos.\n
Para ver el detalle de la referencia dé click aquí (link a registro de referencia en CRM)\nAtentamente Unifin
';
                        $notification_bean->parent_id = $resultRef[$current]['accounts_ref_venta_cruzada_1accounts_ida'];
                        $notification_bean->parent_type = 'Accounts';
                        $notification_bean->assigned_user_id = $resultRef[$current]['assigned_user_id'];
                        $notification_bean->severity = "alert";
                        $notification_bean->is_read = 0;
                        $notification_bean->save();
                        */
                    }else{
                        //Expirada
                        $beanRef->estatus='5';
                    }


                }

            }
        }

        /*
        //Notificaciones 1 mes antes
        // Obtener Referencias que fueron creadas 3 meses atrás
        $un_mes=date( "Y-m-d H:i:s", strtotime( $hoy ." -1 month" ) );
        $un_mes_un_dia_antes=date( "Y-m-d H:i:s", strtotime( $un_mes ." -1 day" ) );


        $beanQuery = BeanFactory::newBean('Ref_Venta_Cruzada');
        $sugarQueryRef = new SugarQuery();
        $sugarQueryRef->select(array('id','accounts_ref_venta_cruzada_1_name','assigned_user_id'));
        $sugarQueryRef->from($beanQuery);
        $sugarQueryRef->where()->dateBetween('date_entered',array('2020-07-28 00:46:49','2020-07-28 22:46:49'));
        $resultRef = $sugarQueryRef->execute();
        $countRef = count($resultRef);

        if($countRef>0){

            for($current=0; $current < $countRef; $current++)
            {
                //Obtiene valores del cliente
                $beanRef = BeanFactory::retrieveBean('Ref_Venta_Cruzada', $resultRef[$current]['id']);

                if(!empty($beanRef)){

                    $numeroAnexos=$beanRef->numero_anexos;
                    if($numeroAnexos>0){
                        //Exitosa
                        $beanRef->estatus='4';
                        $beanRef->save();
                        //Crea Notificacion
                        /*
                        $notification_bean = BeanFactory::getBean("Notifications");
                        $notification_bean->name = 'Referencia exitosa';
                        $notification_bean->description = 'Se le informa que la referencia de venta cruzada para la cuenta:'..', ha sido exitosa y ya cuenta con anexos/contratos activos.\n
Para ver el detalle de la referencia dé click aquí (link a registro de referencia en CRM)\nAtentamente Unifin
';
                        $notification_bean->parent_id = $resultRef[$current]['accounts_ref_venta_cruzada_1accounts_ida'];
                        $notification_bean->parent_type = 'Accounts';
                        $notification_bean->assigned_user_id = $resultRef[$current]['assigned_user_id'];
                        $notification_bean->severity = "alert";
                        $notification_bean->is_read = 0;
                        $notification_bean->save();

                    }else{
                        //Enviar notificación sobre recordatorio

                    }


                }

            }
        }
        */

      return true;
    }