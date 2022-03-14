<?php

class class_account_relation
{
    public function add_gpo_empresarial($bean = null, $event = null, $args = null)
    {
        $GLOBALS['log']->fatal("LH model after rel",$args['module']);
        $GLOBALS['log']->fatal("LLH model after rel",$args['related_module'] );

        if($args['module'] == 'Accounts'){
            $GLOBALS['log']->fatal("LH Grupo Empresarial en Relacion");
            $GLOBALS['log']->fatal("relate".$args['related_id']);
            $GLOBALS['log']->fatal("id".$args['id']);
        
            $beanrel = BeanFactory::retrieveBean('Accounts', $args['related_id']);
            if($beanrel != null) $beanrel->save();

            $beanP = BeanFactory::retrieveBean('Accounts', $args['id']);
            if($beanP != null) $beanP->save();
        }        
    }
}