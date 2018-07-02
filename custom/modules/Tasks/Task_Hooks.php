<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 6/26/2015
 * Time: 8:07 PM
 */
class Task_Hooks{

    public function afterWorkflow($bean=null,$event=null,$args=null){

        if($bean->parent_type == 'Accounts' && $bean->estatus_c == 'No Interesado'){
            $account = BeanFactory::getBean('Accounts', $bean->parent_id);
            $bean->name = 'Prospecto No Interesado ' . $account->name . ' - ' . $account->tipodemotivo_c;
            $bean->description = $account->motivo_c;
            $bean->date_start = $bean->date_entered;
        }
        
    }
}