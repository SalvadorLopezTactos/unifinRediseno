<link rel="stylesheet" href="styleguide/assets/css/bootstrap.css">
<link rel="stylesheet" href="styleguide/assets/css/sugar.css">
<?php
/**
 * @namespace Levementum
 * @file workList.php 
 * @author jescamilla@levementum.com 
 * @date 6/11/2015 1:11 PM
 * @brief Genera una lista de tareas del BPM y la combina con una lista de tareas de SugarCRM
 * @details 
 */
    require_once("custom/Levementum/UnifinAPI.php");
    global $db, $sugar_config, $current_user;
    $callApi = new UnifinAPI();
    $bpmTareas = $callApi->obtenerTareaAssignadas($current_user->user_name);

    foreach($bpmTareas as $index=>$array){
       foreach($array as $key=>$value) {
           $name = $value['variables']['nombrePersona'];
           $idPersona = $value['variables']['idClienta'];
           $valorListaNegra = $value['variables']['listaNegra'];
           $valorPEP = $value['variables']['listaPEP'];
           $idTarea = $value['id'];
           $sugarId = $value['variables']['guidPersona'];

            $query = <<<SQL
SELECT primernombre_c, segundonombre_c, apellidopaterno_c, apellidomaterno_c, razonsocial_c
FROM accounts_cstm
WHERE id_c = '{$value['variables']['guidPersona']}'
SQL;

            $queryResult = $db->query($query);
            while($row = $db->fetchByAssoc($queryResult))
            {
               $primerNombre = $row['primernombre_c'];
               $segundoNombre = $row['segundonombre_c'];
               $apellidoP = $row['apellidopaterno_c'];
               $apellidoM = $row['apellidomaterno_c'];
               $razonSocial = $row['razonsocial_c'];
            }
                $bpmRows .= "   <tr class='single'>
                            <td>
                                <span sfuuid='880' class='list'>
                                    <div class='ellipsis_inline' data-placement='bottom'>
                                        <img src='include/images/kb.png' width='10' height='10' />
                                        <a href='{$sugar_config['site_url']}/#bwc/index.php?entryPoint=oficialCumplimientoConsulta&primerNombre=$primerNombre&segundoNombre=$segundoNombre&apellidoPaterno=$apellidoP&apellidoMaterno=$apellidoM&idTarea=$idTarea&IdPersona=$idPersona&sugarId=$sugarId&razonSocial=$razonSocial' target='_blank'><span style='font-family: Helvetica, Arial, sans-serif; font-size: 12px;'>$name - Coincidencias</span></a>
                                    </div>
                                </span>
                            </td>

                       <td>
                                <span sfuuid='880' class='list'>
                                    <div class='ellipsis_inline' data-placement='bottom'>
                                       <span style='font-family: Helvetica, Arial, sans-serif; font-size: 12px;'>Nueva</span>
                                    </div>
                                </span>
                            </td>

                    </tr>";

        }
    }

    /* Get all the SugarTasks */
    $query = "SELECT * FROM tasks
               WHERE assigned_user_id = '{$current_user->id}' AND status = 'Not Started'";
    
     $queryResult = $db->query($query);
        
     while($row = $db->fetchByAssoc($queryResult))
     {
       $sugarRows .= "
                    <tr class='single'>
                            <td>
                                <span sfuuid='880' class='list'>
                                    <div class='ellipsis_inline' data-placement='bottom'>
                                        <img src='include/images/badge_26.png' width='10' height='10' />
                                        <a href='{$sugar_config['site_url']}/#Tasks/{$row['id']}' target='_blank'><span style='font-family: Helvetica, Arial, sans-serif; font-size: 12px;'>{$row['name']}</span></a>
                                    </div>
                                </span>
                            </td>

                       <td>
                                <span sfuuid='880' class='list'>
                                    <div class='ellipsis_inline' data-placement='bottom'>
                                        <span style='font-family: Helvetica, Arial, sans-serif; font-size: 12px;'>{$row['status']}</span>
                                    </div>
                                </span>
                            </td>

                    </tr>";
     }

   echo "
       <table class='table table-striped dataTable' >
            <thead>
                <tr>

                        <th data-fieldname='name' data-orderby='' tabindex='-1'>
                            <span>Nombre</span>
                        </th>

                        <th data-fieldname='status' data-orderby='' tabindex='-1'>
                            <span>Estatus</span>
                        </th>

                </tr>
            </thead>
            <tbody>
                {$bpmRows}
                {$sugarRows}
            </tbody>
        </table>
   ";

