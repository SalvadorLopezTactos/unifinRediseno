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
        //$GLOBALS['log']->fatal('Minuta_compromisos: '.print_r($bean->minuta_compromisos,true));//------------------------------------

        if(isset($bean->minut_Compromisos)){
        	foreach($bean->minuta_compromisos as $compromiso){
	        	/*if($compromiso[deleted]==0){

		            $bean_compromiso = BeanFactory::newBean('minut_Compromisos');
		            $bean_compromiso->name = $compromiso[compromiso];
		            $bean_compromiso->minut_minutas_minut_compromisosminut_minutas_ida=$bean->id;

		            $hour = date('H:i');
		            $date = date("Y-m-d");
		            $now=$date."T".$hour;
		            $bean_tarea = BeanFactory::newBean('Tasks');
		            $bean_tarea->name = $compromiso[compromiso];
		            $bean_tarea->date_Start=$now;
		            $bean_tarea->date_due=$compromiso[fecha]."T".$hour;

		            $dummy_bean = BeanFactory::retrieveBean('Accounts', $compromiso[id_resp]);
		            $GLOBALS['log']->fatal('Count de dummy: '.count($dummy_bean));//------------------------------------

		            if(count($dummy_bean)>0){//si el id del responsable es una cuenta

		                $bean_compromiso->assigned_user_id=$bean->assigned_user_id;
		                $bean_tarea->assigned_user_id=$bean->assigned_user_id;

		            }else{//si el id del responsable es un usuario
		                $bean_compromiso->assigned_user_id=$compromiso[id_resp];
		                $bean_tarea->assigned_user_id=$compromiso[id_resp];
		            }

		            $bean_tarea->save();
		            $GLOBALS['log']->fatal('Se ha la tarea para '.$compromiso[responsable]);//------------------------------------
		            $bean_compromiso->save();
		            $GLOBALS['log']->fatal('Se ha creado el compromiso para '.$compromiso[responsable]);//------------------------------------

	        	} */
	        	 $GLOBALS['log']->fatal('Responsable: '.$compromiso[responsable].'=='.$compromiso[deleted]);//------------------------------------
	        }
    	}else{
    		$GLOBALS['log']->fatal('No hay nada mapra guardar');//------------------------------------
    	}



    }
}