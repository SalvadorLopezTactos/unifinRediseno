<?php
    //add the job key to the list of job strings
    array_push($job_strings, 'match_calls');

    function match_calls()
    {
        // Relaciona las llamadas de Issabel con los registros del modulo #Calls
        $GLOBALS['log']->fatal('------------------------');//------------------------------------
        $GLOBALS['log']->fatal('>>>>>>COMIENZA JOB MATCH_CALLS:');//------------------------------------

        $host="192.168.11.254";
        $user="unifin";
        $passbd="1ss4b3lun1f1n";
        $bd="asteriskcdrdb";
        $con=new PDO("mysql:host=$host;port=3306;dbname=$bd;",$user,$passbd);
        $contador = 0;

        if($con) {
            $GLOBALS['log']->fatal('Conexion Exitosa');//-----------------------------------

            $query2 = 'select * from calls_cstm where tct_call_issabel_c=1';
            $result2 = $GLOBALS['db']->query($query2);

            while ($row2 = $GLOBALS['db']->fetchByAssoc($result2)) {

                $id = $row2['id_c'];
                $query1 = "select * from cdrunifincrm where id_call='{$id}'";
                $statement = $con->prepare($query1);
                $statement->execute();

                if ($row = $statement->fetch(PDO::FETCH_ASSOC)) {

                    $temp = explode(" ", $row['calldate']);
                    $temp2 = explode(":", $temp[1]);
                    $seconds = ($temp2[0] * 60 * 60) + ($temp2[1] * 60) + $temp2[2];
                    $seconds = $seconds + $row['billsec'];
                    $temp[1] = gmdate("H:i", $seconds);
                    $final = implode(" ", $temp);
                    $end = date("Y-m-d H:i:s", strtotime($final));

                    $timeDateOBjBasico = new TimeDate();
                    $datestart = $timeDateOBjBasico->fromString($row['calldate']);
                    $date_start = $datestart->asDb();
                    $dateend = $timeDateOBjBasico->fromString($end);
                    $date_end = $dateend->asDb();

                    $query3 = "update calls_cstm set tct_call_issabel_c=0 where id_c='{$id}'";
                    $query4 = "update calls set description='El resultado de la llamada fue: {$row['disposition']}',date_start='{$date_start}', date_end='{$date_end}' where id='{$id}'";
                    $GLOBALS['db']->query($query3);
                    $GLOBALS['db']->query($query4);

                    $contador++;
                    $GLOBALS['log']->fatal('Se ha modificado llamada:' . $id);//-----------------
                }
            }

        }

        $GLOBALS['log']->fatal('>>>>>>TERMINA JOB MATCH_CALLS, llamadas modificadas:'.$contador);//------------------------------------
        $GLOBALS['log']->fatal('------------------------');//------------------------------------
        return true;
    }