<?php
    //add the job key to the list of job strings
    array_push($job_strings, 'match_calls');

    function match_calls()
    {
    	// Relaciona las llamadas de Issabel con los registros del modulo #Calls
        $GLOBALS['log']->fatal('>>>>>>COMIENZA JOB MATCH_CALLS:');//------------------------------------

        $host="192.168.11.254";
		$user="UNIFIN";
		$passbd="1SS4B3LUN1F1N";
		$bd="ASTERISKCDRDB";
		$con=new PDO("mysql:host=$host;dbname=$bd;",$user,$passbd);

		if($con){
			$GLOBALS['log']->fatal('Conexion Exitosa');//------------------------------------
			$contador=0;
			$query="select * from cdrunifincrm";
			$statement=$conexion->prepare($query);
			$statement->execute();
			while($row=$statement->fetch(PDO::FETCH_ASSOC)){
				$id = $row['id_call'];
            	$bean_call = BeanFactory::retrieveBean('Calls', $id);
            	if($bean_call->tct_call_issabel_c==1){
            		$bean_call->tct_call_issabel_c=0;
            		$bean_call->description='El resultado de la llamada fue: '.$row['disposition'];
            		$bean_call->date_start=row['calldate']; 
            		$temp=explode("T", $bean_call);
            		$temp2=explode(":", $temp[1]);
            		$seconds = ($temp2[0] * 60 * 60) + ($temp2[1] * 60) + $temp2[2];
            		$seconds.=row['billsec'];
            		$temp[1]=gmdate("H:i:s", $seconds);
            		$bean_call->date_end=implode("T", $temp);
            		$bean_call->save();
            		$contador++;
            	}else{
            		continue;
            	}
			}
		}else{
			$GLOBALS['log']->fatal('Hubo un problema al conectar con Issabel');//------------------------------------
		}

        $GLOBALS['log']->fatal('>>>>>>TERMINA JOB MATCH_CALLS,LLAMADAS MODIFICADAS:'+$contador);//------------------------------------
		return true;
    }