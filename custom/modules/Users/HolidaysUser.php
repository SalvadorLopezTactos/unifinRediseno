<?php
/**
 * Created by Salvador Lopez.
 * salvador.lopez@tactos.com.mx
 */
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class HolidaysUser
{
    function createHolidayUser($bean, $event, $arguments)
    {
        global $app_list_strings;
        $inicio=$bean->vacaciones_inicio_c;
        $fin=$bean->vacaciones_fin_c;
        if(!empty($inicio) && !empty($fin)){
            
            $holiDaysArr = array();
            $inicio_dateTS = strtotime($inicio);
            $fin_dateTS = strtotime($fin);

            /*
            Se genera ciclo para obtener todas las fechas que se encuentran entre la fecha inicio y fin
            */
            for ($currentDateTS = $inicio_dateTS; $currentDateTS <= $fin_dateTS; $currentDateTS += (60 * 60 * 24)) {
                // use date() and $currentDateTS to format the dates in between
                $currentDateStr = date("Y-m-d",$currentDateTS);
                $holiDaysArr[] = $currentDateStr;
            }

            $GLOBALS['log']->fatal(print_r($holiDaysArr,true));
            if(count($holiDaysArr) > 0){
                $listMonth=$app_list_strings['mes_list'];
                //Por cada día se genera un registro en módulo de Holydays
                for ($i=0; $i < count($holiDaysArr) ; $i++) { 
                    $dateExplode=explode("-",$holiDaysArr[$i]);
                    $year=$dateExplode[0];
                    $month=$dateExplode[1];
                    $monthDesc=$listMonth[$month];
                    $beanHoliday = BeanFactory::newBean('Holidays');
                    $beanHoliday->name="Vacaciones ".$monthDesc." ".$year;
                    $beanHoliday->holiday_date=$holiDaysArr[$i];
                    $beanHoliday->description=$bean->vacaciones_detalle_c;
                    $beanHoliday->person_id=$bean->id;
                    $beanHoliday->save();   
                }

                //Una vez establecidos los días de vacaciones, se proceden a limpiar los campos de la sección de vacaciones
                $bean->vacaciones_inicio_c="";
                $bean->vacaciones_fin_c="";
                $bean->vacaciones_detalle_c="";

            }
        }
        
    }
}

?>