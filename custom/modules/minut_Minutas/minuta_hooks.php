<?php
    /**
     * Created by JCM
     * Date: 23/10/2018
     */

class Minuta_Hooks
{
    //@Jesus Carrillo
    //
    function SaveMinuta($bean = null, $event = null, $args = null)
    {

        $GLOBALS['log']->fatal('>>>>>>>Entro Minuta Hook: ');//------------------------------------
        $GLOBALS['log']->fatal('Tipo de Minuta_compromisos: '.gettype($bean->minuta_compromisos));//------------------------------------
        $GLOBALS['log']->fatal('Count de Minuta_compromisos: '.count($bean->minuta_compromisos));//------------------------------------
        $GLOBALS['log']->fatal('Minuta_compromisos: '.print_r($bean->minuta_compromisos,true));//------------------------------------

        if(count($bean->minuta_compromisos)>0 && gettype($bean->minuta_compromisos)=="array"){
        	foreach($bean->minuta_compromisos as $compromiso){

		            $bean_compromiso = BeanFactory::newBean('minut_Compromisos');
		            $bean_compromiso->name = $compromiso['compromiso'];
		            $bean_compromiso->minut_minutas_minut_compromisosminut_minutas_ida=$bean->id;

		            $bean_tarea = BeanFactory::newBean('Tasks');
                    $bean_tarea->name = $compromiso['compromiso'];
                    $bean_tarea->parent_type='Accounts';
                    $bean_tarea->parent_id=$compromiso['cuenta_madre'];

		            $hour = date('H:i');
                    $now = date('d/m/Y h:i a');
                    $end=date("d/m/Y h:i a", strtotime($compromiso['fecha']."T".$hour));

		            $bean_tarea->date_start=$now;
                    $bean_tarea->date_due=$end;
                    $bean_compromiso->tct_fecha_compromiso_c=$end;

		            $dummy_bean = BeanFactory::retrieveBean('Accounts', $compromiso['id_resp']);
		            $GLOBALS['log']->fatal('Count de dummy: '.count($dummy_bean));//------------------------------------

		            if(count($dummy_bean)>0){//si el id del responsable es una cuenta

                        //$GLOBALS['log']->fatal('El compromiso es de una cuenta, su id es: '.$bean->assigned_user_id);//------------------------------------
		                $bean_compromiso->assigned_user_id=$bean->assigned_user_id;
                        $bean_compromiso->description=" Esta tarea ha sido asignada al contacto: ".$compromiso['responsable']."\n Con el compromiso: ".$compromiso['compromiso'];
		                $bean_tarea->assigned_user_id=$bean->assigned_user_id;
                        $bean_tarea->description=" Esta tarea ha sido asignada al contacto: ".$compromiso['responsable']."\n Con el compromiso: ".$compromiso['compromiso'];
		                $bean_tarea->priority='High';

		            }else{//si el id del responsable es un usuario

                        //$GLOBALS['log']->fatal('El compromiso es de un usuario, su id es: '.$compromiso['id_resp']);//------------------------------------
		                $bean_compromiso->assigned_user_id=$compromiso['id_resp'];
		                $bean_tarea->assigned_user_id=$compromiso['id_resp'];
                        $bean_tarea->priority='Low';

		            }

		            $bean_tarea->save();
		            $GLOBALS['log']->fatal('Se ha creado la tarea para '.$compromiso['responsable']);//------------------------------------
		            $bean_compromiso->save();
		            $GLOBALS['log']->fatal('Se ha creado el compromiso para '.$compromiso['responsable']);//------------------------------------
                    $GLOBALS['log']->fatal('-------------------------------');//------------------------------------


	        	 //$GLOBALS['log']->fatal('Responsable: '.$compromiso[responsable].'=='.$compromiso[deleted]);//------------------------------------
	        }
    	}else{
    		$GLOBALS['log']->fatal('No hay nada para guardar');//------------------------------------
    	}



    }
}