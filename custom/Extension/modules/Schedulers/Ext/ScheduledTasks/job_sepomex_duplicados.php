<?php
//add the job key to the list of job strings
array_push($job_strings, 'job_sepomex_duplicados');

function job_sepomex_duplicados()
    {
        $GLOBALS['log']->fatal('-----Comienza Planificador para depuración Sepomex-----');
        //1. Encontrar duplicados
        //2. Marcar deleted los registros que han sido dados de alta manualmente
        //3. Actualizar las direcciones que tengan un ID Sepomex marcado como Deleted, añadiendo el valor del id Sepomex que permaneció
        //4. Actualizar también la fecha de modificación

        /*Valores a concatenar: Código Postal, Estado, Ciudad, Municipio, Colonia*/
        //Se obtienen registros duplicados a través de un contador
        $qDuplicados="SELECT CONCAT(codigo_postal,estado,ciudad,municipio,colonia) name_direccion, COUNT(*) total
        FROM dir_sepomex
        group by name_direccion
        HAVING total>1;";

        $rDuplicados=$GLOBALS['db']->query($qDuplicados);

        $total_duplicados=$rDuplicados->num_rows;

        $names_dup=array();
        if($total_duplicados>0){
            $GLOBALS['log']->fatal("Se encontraron duplicados, se procede a depurar");
            while($row = $GLOBALS['db']->fetchByAssoc($rDuplicados)){
                array_push($names_dup, $row['name_direccion']);
            }
        }

        //Por cada duplicado encontrado, se procede a evaluar su respectivo id para saber si fue dado de alta manualmente, en caso de ser así,
        //se procede a marcar como deleted
        if(count($names_dup)>0){

            $array_ids_deleted=array();
            $id_prevaleciente="";
            for ($i=0; $i<count($names_dup) ; $i++) {
                $nombre_concatenado=$names_dup[$i];
                $qRegistrosRepetidos="SELECT * FROM dir_sepomex WHERE CONCAT(codigo_postal,estado,ciudad,municipio,colonia)='{$nombre_concatenado}';";    
                $rRegistrosRepetidos=$GLOBALS['db']->query($qRegistrosRepetidos);

                while($row = $GLOBALS['db']->fetchByAssoc($rRegistrosRepetidos)){
                    $id_registro_repetido=$row['id'];
                    $lenID=strlen($id_registro_repetido);
                    //Cuando la longitud del id es de 36 dígitos, quiere decir que dicho registro fue dado de alta manualmente, se procede a marcarlo deleted
                    if($lenID==36){
                        $qUpdateSepomexDeleted="UPDATE dir_sepomex SET deleted = '1' WHERE id = '{$id_registro_repetido}'";
                        $rUpdateSepomexDeleted=$GLOBALS['db']->query($qUpdateSepomexDeleted);
                        array_push($array_ids_deleted,$id_registro_repetido);
                        $GLOBALS['log']->fatal("Se marca deleted el registro sepomex: ".$id_registro_repetido);
                    }else{
                        $id_prevaleciente=$id_registro_repetido;
                        $GLOBALS['log']->fatal("El ID que prevalece es: ".$id_registro_repetido);
                    }
                }
            }

            //Se procede a actualizar direcciones que tengan relacionado un id de sepomex que se haya marcado como deleted
            if(count($array_ids_deleted)>0){
                for ($i=0; $i < count($array_ids_deleted); $i++) { 
                    $idDeleted=$array_ids_deleted[$i];
                    $qDireccionesAactualizar="SELECT * FROM dir_sepomex_dire_direccion_c WHERE dir_sepomex_dire_direcciondir_sepomex_ida='{$idDeleted}'";
                    $rDireccionesAactualizar=$GLOBALS['db']->query($qDireccionesAactualizar);

                    if($rDireccionesAactualizar->num_rows > 0){
                        while($row = $GLOBALS['db']->fetchByAssoc($rDireccionesAactualizar)){
                            $qUpdateDirSepomex="UPDATE dir_sepomex_dire_direccion_c SET dir_sepomex_dire_direcciondir_sepomex_ida = '{$id_prevaleciente}' WHERE id = '{$row['id']}'";
                            $rUpdateDirSepomex=$GLOBALS['db']->query($qUpdateDirSepomex);
                            $GLOBALS['log']->fatal("Se ha actualizado la direccion: ".$row['dir_sepomex_dire_direcciondire_direccion_idb']);
                        }
                    }
                }
                
            }
        }
        
        $GLOBALS['log']->fatal('-----Termina Planificador para depuración Sepomex-----');
        return true;
    }