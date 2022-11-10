<?php
    //add the job key to the list of job strings
    array_push($job_strings, 'insertSepomex');

    function insertSepomex()
    {
        global $db,$current_user,$sugar_config;
    	// Busca las llamadas vencidas en status "planificada" y les cambia el estado a "no realizada"
        $GLOBALS['log']->fatal('>>>>>>COMIENZA PROCESO DE OBTENCIÓN CP - SEPOMEX:');//------------------------------------
        //Declara variables
			$path = $sugar_config['url_sepomex']; //Ubicación pública de archivo sepomex
			//Inicia
			//Lee archivo
			$fila = 0;
			$filaBloque = 0;
			$bloque = 1000;
			$sqlInsertCP = 'INSERT IGNORE INTO dir_sepomex (`id`, `name`, `date_entered`, `date_modified`, `modified_user_id`, `created_by`, `deleted`, `pais`, `id_pais`, `codigo_postal`, `estado`, `id_estado`, `ciudad`, `id_ciudad`, `municipio`, `id_municipio`, `colonia`, `id_colonia`,`team_id`,`team_set_id`) VALUES';

			/*
			* Mapeo columnas; d_codigo|d_asenta|d_tipo_asenta|D_mnpio|d_estado|d_ciudad|d_CP|c_estado|c_oficina|c_CP|c_tipo_asenta|c_mnpio|id_asenta_cpcons|d_zona|c_cve_ciudad
					[0]d_codigo -> Código Postal
					[1]d_asenta -> Colonia
					[2]d_tipo_asenta
					[3]D_mnpio -> Municipio
					[4]d_estado -> Estado
					[5]d_ciudad -> Ciudad
					[6]d_CP
					[7]c_estado -> Id Estado
					[8]c_oficina
					[9]c_CP
					[10]c_tipo_asenta
					[11]c_mnpio ->Id Municipio
					[12]id_asenta_cpcons -> Id único asentamiento
					[13]d_zona
					[14]c_cve_ciudad -> Id Ciudad
					2.[0].[7].[11].[12] -> Id CRM
			*/
			if (($gestor = fopen($path, "r")) !== FALSE) {
			    while (($datos = fgetcsv($gestor, 0, "|")) !== FALSE) {
							$datos = array_map("utf8_encode", $datos);
							if ($filaBloque==$bloque) {
								$filaBloque=0;
							}
                            if($fila>1){ //Utilizada para omitir cabeceras 0 y 1
                                $id_usuario=$current_user->id;
							    $date = TimeDate::getInstance()->nowDb();
								$id_pais="2";
								$pais="México";
								$codigo_postal=$datos[0];
								$estado=$datos[4];
								$id_estado=$datos[7];
								$ciudad=($datos[5]=="") ? "Sin Ciudad":$datos[5];
								$id_ciudad=($datos[14]=="" )? "0":$datos[14];
								$municipio=$datos[3];
								$id_municipio=$datos[11];
								$colonia=$datos[1];
								$id_colonia=$datos[12];

								$insertStatement ="('2".$datos[0].$datos[7].$datos[11].$datos[12]."','México ".$datos[0]." ".$datos[4]." ".$datos[1]."','{$date}','{$date}','{$id_usuario}','{$id_usuario}',0,'México','2','{$codigo_postal}','{$estado}','{$id_estado}','{$ciudad}','{$id_ciudad}','{$municipio}','{$id_municipio}','{$colonia}','{$id_colonia}','1','1');";
                                
                                try {
                                    $insertInto=$sqlInsertCP.$insertStatement;
                                    //$GLOBALS['log']->fatal("INSERT SEPOMEX: ".$insertInto);
                                    $db->query($insertInto);
                                 } catch (Exception $e) {
                                    $GLOBALS['log']->fatal("Error: " . $e->getMessage());
                                }
								 $filaBloque++;

							}
							$fila++;
			    }
			    fclose($gestor);
            }
            
        $GLOBALS['log']->fatal('>>>>>>FINALIZA PROCESO SEPOMEX');
		return true;
    }
