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

        if($bean->minuta_objetivos !=null || !empty($bean->minuta_objetivos)){

            foreach ($bean->minuta_objetivos['records'] as $objetivo) {
                if ($objetivo['id']) {
                    //Actualiza
                    $GLOBALS['log']->fatal('Actualiza Objetivos');
                    $GLOBALS['log']->fatal($objetivo['name']);
                    $beanObjetivo = BeanFactory::retrieveBean('minut_Objetivos', $objetivo['id']);
                    $beanObjetivo->name = $objetivo['name'];
                    $beanObjetivo->save();
                }else{
                    //Crea
                    $GLOBALS['log']->fatal('Inserta Objetivos');
                    $GLOBALS['log']->fatal($objetivo['name']);
                    $beanObjetivo = BeanFactory::newBean('minut_Objetivos');
                    $beanObjetivo->name = $objetivo['name'];
                    $beanObjetivo->meetings_minut_objetivos_1meetings_ida = $bean->id;
                    $beanObjetivo->save();
                }

            }

        }

    }


}