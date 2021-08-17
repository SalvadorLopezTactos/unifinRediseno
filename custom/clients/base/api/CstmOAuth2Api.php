<?php
/**
 * User: JG
 * Date: 29/12/20
 * Time: 06:16 PM
 */

/** caso uno campo horario en vacio deja entrar  OK
 * caso 2 tiene horario  bloqueado no deja entrar por el dia compelto
 * caso tres tiene horario libre deja entrar todo el dia
 * cambiar nulos por vacio
 * Agregar validación de acceso a vista a usuario con privilegio especial “Gestión de Agente Telefónico”
 */

require_once("clients/base/api/CurrentUserApi.php");

class CstmOAuth2Api extends OAuth2Api
{
    public function token(ServiceBase $api, array $args)
    {
        global $current_user, $db;
        $userArray = parent::token($api, $args);
        $hoy = getdate();
        // Obtenemos la fecha Actual
        $query = "SELECT date_format(NOW(),'%W %H %i') AS Fecha,UTC_TIMESTAMP()";
        $queryResult = $db->query($query);
        $row = $db->fetchByAssoc($queryResult);
        $date_Hoy = $row['Fecha'];
        $array_date = explode(" ", $date_Hoy);
        $dia_semana = $array_date[0];
        $horaDia = $array_date[1] . ":" . $array_date[2];
        $dateInput = date('H:i', strtotime($horaDia));

        //$GLOBALS['log']->fatal('Puesto ' . $current_user->puestousuario_c);
        if ($current_user->puestousuario_c == '27') {
            if ($current_user->access_hours_c != "") {

                $horas = json_decode($current_user->access_hours_c, true);
                $dateIn = $horas[$dia_semana]['entrada'];
                $dateOut = $horas[$dia_semana]['salida'];
                $dateComida = $horas[$dia_semana]['comida'];
                $dateRegreso = $horas[$dia_semana]['regreso'];

                if ($dateIn != "Libre" && $dateIn != "Bloqueado") {
                    $from = $dateIn;
                    $to = $dateOut;
                    $input = $dateInput;
                    $response = $this->accessHours($dateIn, $dateOut, $dateComida, $dateRegreso, $input);
                    $GLOBALS['log']->fatal('Resultado horario ' . $response);
                    if (!$response) {
                        $userArray = null;
                        $e = new SugarApiExceptionError(
                            "<br>Esta fuera de Horario",
                            null,
                            null,
                            0,
                            null
                        );
                        $api->needLogin($e);
                    }
                } elseif ($dateIn == "Bloqueado") {
                    $userArray = null;
                    $e = new SugarApiExceptionError(
                        "<br>Hoy no cuenta con Acceso al CRM ",
                        null,
                        null,
                        0,
                        null
                    );
                    $api->needLogin($e);
                }

            }
        }
        //Recupera lista de usuarios
        // $GLOBALS['log']->fatal('Usuario '. $current_user->user_name);
        // $GLOBALS['log']->fatal('Platform '. $args['platform']);
        $usuario = isset($current_user->user_name) ? $current_user->user_name : '';
        $plataforma = isset($args['platform']) ? $args['platform'] : '';
        global $app_list_strings;
        $usuariosExternos = $app_list_strings['usuarios_api_ext_list'];
        $plataformaNoValida = $app_list_strings['plataformas_no_validas_ext_list'];
        //Valida usuario y plataforma definidos
        if (!empty($usuario) && !empty($plataforma)) {
            //Valida si es usuario de integracion(externo) y si plataforma no está habilitada para usuario de integración
            if (in_array($usuario, $usuariosExternos) && in_array($plataforma, $plataformaNoValida) ){
                $userArray = null;
                $e = new SugarApiExceptionError(
                    "La plataforma: ".$plataforma. " no es valida para usuario de integración",
                    null,
                    null,
                    0,
                    null
                );
                $api->needLogin($e);
            }
        }

        return $userArray;
    }

    public function accessHours($from, $to, $comida, $regreso, $login)
    {
        //$GLOBALS['log']->fatal('FRom ' . $from . "  " . $to . "  " . $login);
        //$GLOBALS['log']->fatal('FRom ' . $comida . "  " . $regreso . "  " . $login);

        /*$dateFrom = DateTime::createFromFormat('!H:i', $from);
        $dateTo = DateTime::createFromFormat('!H:i', $to);
        $dateLogin = DateTime::createFromFormat("!H:i", $login);*/
        $dateFrom = date("H:i", strtotime($from));
        $dateTo = date("H:i", strtotime($to));
        $respuesta = ($A == $B) ? "A es igual a B" : "A no es igual a B";
        $dateComida = ($comida != "") ? date("H:i", strtotime($comida)) : "";
        $dateRegreso = ($regreso != "") ? date("H:i", strtotime($regreso)) : "";

        $dateLogin = date("H:i", strtotime($login));

        $GLOBALS['log']->fatal('FRom ' . $dateFrom);
        $GLOBALS['log']->fatal('To ' . $dateTo);
        $GLOBALS['log']->fatal('comida ' . $dateComida);
        $GLOBALS['log']->fatal('regreso ' . $dateRegreso);

        $GLOBALS['log']->fatal('Login ' . $dateLogin);

        /*if ($dateFrom > $dateTo) {
            $dateTo->modify('+1 day');
        }*/
        $salida = false;
        if($dateComida != "" && $dateRegreso != ""){
            if(($dateFrom <= $dateLogin && $dateLogin <= $dateComida)
            || ($dateRegreso <= $dateLogin && $dateLogin <= $dateTo) ){
                $salida = true;
            }
        }else if($dateFrom <= $dateLogin && $dateLogin <= $dateTo){
            $salida = true;
        }

        return $salida;//|| ($dateFrom <= $dateLogin->modify('+1 day') && $dateLogin <= $dateTo);
    }
}
