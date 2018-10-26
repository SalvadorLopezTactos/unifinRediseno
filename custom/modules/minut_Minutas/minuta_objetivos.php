<?php
/**
 * Created by PhpStorm.
 * User: Adrian Arauz
 * Date: 26/10/18
 * Time: 09:30 AM
 */

class Objetivos_minuta
{

function obtenobjetivos ($bean = null, $event = null, $args = null)
    {

        foreach ($bean->reunion_objetivos['records'] as $objetivo) {
            if ($objetivo['id']) {
                //Actualiza
                $GLOBALS['log']->fatal('Añade Objetivos a minuta');
                $GLOBALS['log']->fatal($objetivo['name']);
                $beanObjetivo = BeanFactory::retrieveBean('minuta_objetivos', $objetivo->id);
                $beanObjetivo->name = $objetivo['name'];
                $beanObjetivo->save();
                }
        }
    }


}