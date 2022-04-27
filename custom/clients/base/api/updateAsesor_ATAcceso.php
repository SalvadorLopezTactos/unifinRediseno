<?php
/**
 * Created by JG.
 * User: tactos
 * Date: 24/12/20
 * Time: 02:05 PM
 */

class updateAsesor_ATAcceso extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'POSTreUpdateAcceso' => array(
                'reqType' => 'POST',
                'path' => array('updateAsesores'),
                'pathVars' => array(''),
                'method' => 'updateAgentesTele',
                'shortHelp' => 'Método POST para actualizar el horario de acceso a CRM de los Agentes Telefonicos',
            ),

        );
    }

    public function updateAgentesTele($api, $args)
    {
        $records = $args['data']['seleccionados'];
        $nuevoHorario = $args['data']['horario'];
        //$GLOBALS['log']->fatal("Usuarios " . print_r($nuevoHorario, true));
        //$GLOBALS['log']->fatal("Records  " . count($args['data']['seleccionados']));

        for ($i = 0; $i < count($records); $i++) {
            //$GLOBALS['log']->fatal("Records  " . $records[$i]);
            $idUser = $records[$i];
            $user = BeanFactory::getBean('Users', $idUser, array('disable_row_level_security' => true));
            $arrNHorario = json_decode($nuevoHorario, true);
            //$GLOBALS['log']->fatal("antes del update json" , $arrNHorario);
            $hAnterior = json_decode($user->access_hours_c, true);
            if (!$args['data']['excluir']) {
                if ($hAnterior != "") {
                    //$GLOBALS['log']->fatal("antes del update " . print_r($hAnterior, true));
                    foreach ($arrNHorario as $index => $item) {
                        //$GLOBALS['log']->fatal("index" . $index);
                        $row_update = $arrNHorario[$index]['update'];
                        //$GLOBALS['log']->fatal("Horario nuevo index  " . $index);
                        //$GLOBALS['log']->fatal("Horario nuevo update  " . $arrNHorario[$index]['update']);

                        if ($row_update == "true") {
                            //$GLOBALS['log']->fatal("Actualizado ");
                            $hAnterior[$index]['entrada'] = $arrNHorario[$index]['entrada'];
                            $hAnterior[$index]['salida'] = $arrNHorario[$index]['salida'];
                            /***************************************/
                            $hAnterior[$index]['comida'] = $arrNHorario[$index]['comida'];
                            $hAnterior[$index]['regreso'] = $arrNHorario[$index]['regreso'];                                
                        }
                    }
                    //$GLOBALS['log']->fatal("despues del update " . print_r($hAnterior, true));

                    $jsonhorario = json_encode($hAnterior, true);
                    $this->updateQuery($jsonhorario, $idUser);

                } else {
                    $this->updateQuery($nuevoHorario, $idUser);
                }
            } else {
                $this->updateQuery($nuevoHorario, $idUser);
            }
        }
        return true;
    }

    public function updateQuery($nuevoHorario, $id)
    {
        global $db;
        try {
            $Query = "UPDATE users_cstm
 SET access_hours_c ='{$nuevoHorario}'
 WHERE id_c = '{$id}'";
            $result = $GLOBALS['db']->query($Query);
        } catch (Exception $e) {
            $GLOBALS['log']->fatal("Error Actualizando  " . $e);
        }


    }


}