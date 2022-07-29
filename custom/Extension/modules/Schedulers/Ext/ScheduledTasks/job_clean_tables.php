<?php
array_push($job_strings, 'job_clean_tables');

function job_clean_tables()
{
    try {

        $GLOBALS['log']->fatal('Entra Job para depurar Tablas CRM');
        $fechaDepuracion = date("Y-m-d"); //Fecha de Hoy

        /**********Leer tabla unifin_clear_tables e identificar tablas por depurar***********/
        $query = "SELECT table_name, column_depurate, status FROM unifin_clear_tables where status = 1";
        $queryResult = $GLOBALS['db']->query($query);
        $contador=0;

        while($row = $GLOBALS['db']->fetchByAssoc($queryResult))
        {   
            /*******Iterar tablas por depurar******/
            $tableName = $row['table_name'];
            $columnDepurate = $row['column_depurate'];
            $GLOBALS['log']->fatal('Tabla a depurar: '.$tableName.' - Columna referencia: '.$columnDepurate);
            $contador++;

            /*********Recuperar fecha de último respaldo en tabla unifin_clear_dwh_sync por nombre de tabla**********/
            $queryDB = "SELECT table_name, date_backup FROM unifin_clear_dwh_sync 
            WHERE date_backup = (SELECT MAX(date_backup)FROM unifin_clear_dwh_sync where table_name = '{$tableName}')";
            $queryResultDB = $GLOBALS['db']->query($queryDB);

            $bandera = false;
            while($rowdb = $GLOBALS['db']->fetchByAssoc($queryResultDB))
            {   
                $datebckp = $rowdb['date_backup'];
                $GLOBALS['log']->fatal('Fecha última depuración de la tabla: '.$datebckp);
                $bandera = true;            
            }

            /********Ejecutar depuración a partir de última fecha de respaldo de cada tabla a depurar********/
            if ($bandera == true){

                $queryDT= "DELETE FROM $tableName where $columnDepurate < '{$datebckp}'";
                $queryResultDT = $GLOBALS['db']->query($queryDT);
                $GLOBALS['log']->fatal('Depurando Tabla... ');
                

                /************Actualizar tabla unifin_clear_tables indicando fecha de depuración de cada tabla a depurar*********/
                $updateDD = "UPDATE unifin_clear_tables SET date_cleared ='{$fechaDepuracion}' where table_name = '{$tableName}'";
                $updateResult = $GLOBALS['db']->query($updateDD);
                $GLOBALS['log']->fatal('Update Fecha de Depuracion de la Tabla: '.$fechaDepuracion);

            }
        }
        
        $GLOBALS['log']->fatal('Depuración de '.$contador. ' Tabla(s) Exitosa(s).');
        return true;


    } catch (Exception $e) {
        $GLOBALS['log']->fatal("Error: " . $e->getMessage());
    }
}