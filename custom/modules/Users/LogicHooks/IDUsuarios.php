<?php
/**
 * Created by Adrian Arauz.
 * User: root
 * Date: 12/06/19
 * Time: 06:30 PM
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class UsuarioID
{

    function validausuariosid($bean, $event, $arguments)
    {
        $errores="";
        //Iniciar cambio de contraseña
        if (!empty($bean->tct_id_unics_txf_c)) {

            global $current_user, $db;
            $tipoID = 1;
            $valorid = $bean->tct_id_unics_txf_c;
            $usuario = $bean->id;
            $contador = 0;

            try {
                if ($tipoID == 1) {
                    $query = "select * from users_cstm where tct_id_unics_txf_c='{$valorid}' and id_c!='{$usuario}';";
                    $idunics = $db->query($query);
                    while ($row = $GLOBALS['db']->fetchByAssoc($idunics)) {
                        $contador++;
                    }
                    if ($contador > 0) {
                        $errores= $errores . "El ID <b>" . $valorid. "</b> de unics ya existe. Número de conincidencias: " ."<b>". $contador ."</b>";
                    }
                }
            } catch (Exception $e) {
                $errores= $errores . $e->getMessage();
            }
        }
        if (!empty($bean->tct_id_uni2_txf_c)) {
            global $current_user, $db;
            $tipoID = 2;
            $valorid = $bean->tct_id_uni2_txf_c;
            $usuario = $bean->id;
            $contador2 = 0;

            try {
                if ($tipoID == 2) {
                    $query = "select * from users_cstm where tct_id_uni2_txf_c='{$valorid}' and id_c!='{$usuario}';";
                    $iduni2 = $db->query($query);

                    while ($row = $GLOBALS['db']->fetchByAssoc($iduni2)) {
                        $contador2++;
                    }
                    if ($contador2 > 0) {
                        $errores= $errores . "<br>El ID <b>" .$valorid. "</b> de uni2 ya existe. Número de conincidencias: " ."<b>". $contador2 ."</b>";
                    }
                }
            } catch (Exception $e) {
                $errores= $errores . $e->getMessage();
            }
        }
        if (!empty($bean->id_active_directory_c)) {

            global $current_user, $db;
            $tipoID = 3;
            $valoractive = $bean->id_active_directory_c;
            $usuario = $bean->id;
            $contador3 = 0;

            try {
                if ($tipoID == 3) {
                    $GLOBALS['log']->fatal($valoractive);
                    if (preg_match("/^(\{)?[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}(?(1)\})$/",$valoractive)) {
                        $query = "select * from users_cstm where id_active_directory_c='{$valoractive}' and id_c!='{$usuario}';";
                        $idactive = $db->query($query);
                        while ($row = $GLOBALS['db']->fetchByAssoc($idactive)) {
                            $contador3++;
                        }
                        if ($contador3 > 0) {
                            $errores = $errores . "El ID <b>" . $valoractive . "</b> de Active Directory ya existe. Número de conincidencias: " . "<b>" . $contador3 . "</b>";
                        }
                    }else {
                        $errores = $errores . "El ID Active Directory no cumple con el formato, intente de nuevo.";
                    }

                }
            } catch (Exception $e) {
                $errores= $errores . $e->getMessage();
            }
        }

        if ($errores!=""){
            sugar_die($errores);
        }

    }
}