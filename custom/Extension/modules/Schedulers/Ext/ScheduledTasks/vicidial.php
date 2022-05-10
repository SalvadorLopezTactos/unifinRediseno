<?php
    array_push($job_strings, 'vicidial');

    function vicidial()
    {
        // Relaciona las llamadas de Vicidial con los registros del módulo #Calls
        $GLOBALS['log']->fatal('>>>>>> INICIA JOB VICIDIAL <<<<<<');
        $host="192.168.10.22";
        $user="root";
        $passbd="4cc3s0";
        $bd="asteriskcdrdb";
        $con=new PDO("mysql:host=$host;port=3306;dbname=$bd;",$user,$passbd);
        $contador = 0;
        if($con) {
            $query2 = 'select b.* from calls a, calls_cstm b where a.id = b.id_c and a.deleted = 0 and a.status = "Planned" and b.tct_call_issabel_c = 1';
            $result2 = $GLOBALS['db']->query($query2);
            while ($row2 = $GLOBALS['db']->fetchByAssoc($result2)) {
                $id = $row2['id_c'];
				$fecha = date("Y-m-d", strtotime("-1 day"));
                $query1 = "SELECT C.*,C2.cid_name FROM `cdr` as C, `cel` C2 where C.calldate >= '{$fecha}' and C.uniqueid=C2.uniqueid and C2.cid_name like '%{$id}' ORDER BY `C`.`calldate` DESC";
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
                    $beanCall = BeanFactory::retrieveBean('Calls', $id);
                    $beanCall->tct_call_issabel_c = 0;
                    $beanCall->tct_call_from_issabel_c = 1;
                    $beanCall->status = 'Held';
                    $beanCall->description = $beanCall->description . " - El resultado de la llamada fue: {$row['disposition']}";
                    $beanCall->date_start = $date_start;
                    $beanCall->date_end = $date_end;
                    $beanCall->save();
                }
				else {
					$beanCall = BeanFactory::retrieveBean('Calls', $id);
					$beanCall->description = $beanCall->description . " - Intento no exitoso";
                    $beanCall->save();
				}
				$contador++;
				$GLOBALS['log']->fatal('Se ha modificado llamada:' . $id);//-----------------
            }
        }
        $GLOBALS['log']->fatal('>>>>>> TERMINA JOB VICIDIAL, llamadas modificadas: '.$contador);
        return true;
    }
