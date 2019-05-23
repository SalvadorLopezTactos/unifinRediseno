<?php
/**
 * Created by Adrian Arauz.
 * User: root
 * Date: 23/05/19
 * Time: 09:24 AM
 */

    //add the job key to the list of job strings
    array_push($job_strings, 'job_duplicados');

function job_duplicados()
    {
        $GLOBALS['log']->fatal('Entra Job para eliminar duplicados');

        $valida_fecha = "
         SELECT COUNT(assigned_user_id)
         FROM uni_brujula
         where name='Registro Duplicado'
         and deleted =0";

        $registrosdup =  $GLOBALS['db']->getOne($valida_fecha);

        $query= "DELETE FROM uni_brujula
        where name='Registro Duplicado'
        and deleted =0";

        $queryResult = $GLOBALS['db']->query($query);
        $GLOBALS['log']->fatal('Eliminacion exitosa, se han eliminado' .$registrosdup. 'registros.');
        return true;
    }