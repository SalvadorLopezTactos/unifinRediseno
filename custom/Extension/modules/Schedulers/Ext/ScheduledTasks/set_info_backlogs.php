<?php
/**
 * Created by Salvador Lopez.
 * Date: 18/10/18
 */

//add the job key to the list of job strings
array_push($job_strings, 'set_info_backlogs');

function set_info_backlogs()
{

    //Inicia ejecución
    $GLOBALS['log']->fatal('set_info_backlogs: Inicia ');

    //Obteniendo mes actual
    $currentMonth=(int)date('m');
    $curretMonthN=$currentMonth+1;
    $currentMonthStr=''.$curretMonthN;

    $currentYear=date('Y');

    $beanQuery = BeanFactory::newBean('lev_Backlog');
    $sugarQuery = new SugarQuery();
    $sugarQuery->select(array('id'));
    $sugarQuery->from($beanQuery);
    $sugarQuery->where()
        ->equals('mes',$currentMonthStr)
        ->equals('anio',$currentYear);
    //$sugarQueryt->where()->notNull('processing_order_txf');
    //$sugarQueryInt->orderBy('processing_order_txf', 'ASC');



    $resultBL = $sugarQuery->execute();
    $countBL = count($resultBL);
    for($current=0; $current < $countBL; $current++)
    {
        //Obtiene valores de los registros sobre integraciones
        $GLOBALS['log']->fatal('PROCESANDO ID '.$resultBL[$current]['id']);
        $beanBL = BeanFactory::retrieveBean('lev_Backlog', $resultBL[$current]['id']);
        $beanBL->tct_bloqueo_txf_c = '0';
        $beanBL->save();
    }

    //Concluye ejecución
    $GLOBALS['log']->fatal('set_info_backlogs: Termina');
    return true;

}
