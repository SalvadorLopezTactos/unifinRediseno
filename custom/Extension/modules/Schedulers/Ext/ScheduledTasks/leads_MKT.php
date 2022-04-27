<?php
array_push($job_strings, 'assignLeadMktToUser');

function assignLeadMktToUser()
{
    $GLOBALS['log']->fatal("INICIA JOB REASIGNAR LEADS CON USR GRUPO 9.- MKT A USR AGENTE TELEFONICO");
    global $db, $app_list_strings;
    $alianzas_carrusel_do_list = $app_list_strings['alianzas_carrusel_do_list'];
    $alianzas_responable_do_list = $app_list_strings['alianzas_responable_do_list'];
    $key_carrusel_do_list = [];
    $key_responable_do_list = [];

    foreach ($alianzas_carrusel_do_list as $key => $value) {
        $key_carrusel_do_list[] = $key;
    }
    foreach ($alianzas_responable_do_list as $key => $value) {
        $key_responable_do_list[] = $key;
    }

    $query = "SELECT category, name, value from config where category = 'AltaLeadsServices'";
    $result = $db->query($query);

    while ($row = $GLOBALS['db']->fetchByAssoc($result)) {

        if ($row['name'] == 'id_usuario_alianza') $idAsesorAlianza = $row['value'];
        if ($row['name'] == 'id_usuario_centro_prospeccion') $idAsesorCP = $row['value'];
        if ($row['name'] == 'id_usuario_closer') $idAsesorCloser = $row['value'];
        if ($row['name'] == 'id_usuario_growth') $idAsesorGrowth = $row['value'];
        if ($row['name'] == 'id_usuario_asignar_unilease') $idAsesorUnilease[] = $row['value'];
        if ($row['name'] == 'id_ultimo_unilease') $indiceUnilease = $row['value'];
    }

    /* Obetenemos el id del usuario de grupo de 9.- MKT*/
    $QueryId = "SELECT id from users
    WHERE first_name LIKE '%9.-%' AND last_name LIKE 'MKT'";
    $queryResultId = $db->query($QueryId);
    $row = $db->fetchByAssoc($queryResultId);
    $idMKT = $row['id'];
    /** Buscamos los Leads que tengan asignados el usuario de grupo 9.- MKT */
    $getLeads = "SELECT a.id id, b.compania_c compania , b.id_landing_c id_landing_c, b.origen_c origen_c, b.detalle_origen_c detalle_origen_c, b.producto_financiero_c producto_financiero_c from leads a, leads_cstm b where a.id = b.id_c and a.assigned_user_id='{$idMKT}'";
    $ResultLeads = $db->query($getLeads);
    while ($row = $GLOBALS['db']->fetchByAssoc($ResultLeads)) {

        $compania_c = $row['compania']; // Obtiene Compañía
        $origen_c = $row['origen_c']; //Obtiene Origen 
        $detalle_origen_c = $row['detalle_origen_c']; //Obtiene Detalle Origen 
        $id_landing_c = $row['id_landing_c']; // Obtiene id_landing
        $productoFinanciero = $row['producto_financiero_c']; //PRODUCTO FINANCIERO

        //VALIDACION DE REVISTA MEDICA
        if ($id_landing_c != 'LP REVISTA MÉDICA') {

            $flagCarrusel = 1;

            if (strpos(strtoupper($id_landing_c), 'INSURANCE') !== false) {
                $subpuesto_c = 5;
            } else {
                if ($compania_c == 1) $subpuesto_c = 3;
                if ($compania_c == 2) $subpuesto_c = 4;
            }

            //VALIDACION DE ASESORES COMPANIA UNIFIN - PRODUCTO FINANCIERO UNILEASE 
            if ($compania_c == 1 && $productoFinanciero == 41) {
                $flagCarrusel = 0;

                if (count($idAsesorUnilease) > 0) {
                    $newIndiceUnilease = $indiceUnilease >= count($idAsesorUnilease) - 1 ? 0 : $indiceUnilease + 1;
                    $assign_Asesor_Unilease = $idAsesorUnilease[$newIndiceUnilease];

                    $update_assigned_responsable = "UPDATE leads l INNER JOIN users u on u.id='" . $assign_Asesor_Unilease . "' SET l.team_id=u.default_team, l.team_set_id=u.team_set_id, l.assigned_user_id ='{$assign_Asesor_Unilease}'  WHERE l.id ='{$row['id']}'";
                    $db->query($update_assigned_responsable);

                    $update_Indice_Unilease = "UPDATE config c SET c.value ='{$newIndiceUnilease}' WHERE c.name ='id_ultimo_unilease' and c.category = 'AltaLeadsServices'";
                    $db->query($update_Indice_Unilease);
                }
            }
            //COMPANIA UNICLICK, ORIGEN ALIANZAS Y DETALLE ORIGEN
            if ($compania_c == 2 && $origen_c == 12 && in_array($detalle_origen_c, $key_responable_do_list)) {
                $update_assigned_responsable = "UPDATE leads l INNER JOIN users u on u.id='" . $idAsesorAlianza . "' SET l.team_id=u.default_team, l.team_set_id=u.team_set_id, l.assigned_user_id ='{$idAsesorAlianza}'  WHERE l.id ='{$row['id']}'";
                $db->query($update_assigned_responsable);
                $flagCarrusel = 0;
            }
            //COMPANIA UNICLICK Y ORIGEN CENTRO DE PROSPECCION
            if ($compania_c == 2 && $origen_c == 13) {
                $update_assigned_responsable = "UPDATE leads l INNER JOIN users u on u.id='" . $idAsesorCP . "' SET l.team_id=u.default_team, l.team_set_id=u.team_set_id, l.assigned_user_id ='{$idAsesorCP}'  WHERE l.id ='{$row['id']}'";
                $db->query($update_assigned_responsable);
                $flagCarrusel = 0;
            }
            //COMPANIA UNICLICK Y ORIGEN CLOSER
            if ($compania_c == 2 && $origen_c == 14) {
                $update_assigned_responsable = "UPDATE leads l INNER JOIN users u on u.id='" . $idAsesorCloser . "' SET l.team_id=u.default_team, l.team_set_id=u.team_set_id, l.assigned_user_id ='{$idAsesorCloser}'  WHERE l.id ='{$row['id']}'";
                $db->query($update_assigned_responsable);
                $flagCarrusel = 0;
            }
            //COMPANIA UNICLICK Y ORIGEN GROWTH
            if ($compania_c == 2 && $origen_c == 15) {
                $update_assigned_responsable = "UPDATE leads l INNER JOIN users u on u.id='" . $idAsesorGrowth . "' SET l.team_id=u.default_team, l.team_set_id=u.team_set_id, l.assigned_user_id ='{$idAsesorGrowth}'  WHERE l.id ='{$row['id']}'";
                $db->query($update_assigned_responsable);
                $flagCarrusel = 0;
            }


            if ($flagCarrusel == 1) {

                $usrEnable = GetUserMKT($subpuesto_c, $compania_c);
                $indices = $usrEnable['indice'];
                if (!empty($usrEnable['id'])) {
                    $update_assigne_user = "UPDATE leads l INNER JOIN users u on u.id='" . $usrEnable['id'] . "' SET l.team_id=u.default_team, l.team_set_id=u.team_set_id, l.assigned_user_id ='{$usrEnable['id']}'  WHERE l.id ='{$row['id']}' ";
                    $db->query($update_assigne_user);
                    if ($indices > -1) {
                        if ($compania_c == 1) $update_assigne_user = "UPDATE config SET value = $indices WHERE category = 'AltaLeadsServices' AND name = 'last_assigned_user_unifin'";
                        if ($compania_c == 2) $update_assigne_user = "UPDATE config SET value = $indices WHERE category = 'AltaLeadsServices' AND name = 'last_assigned_user_uniclick'";
                        //COMPANIA UNICLICK Y ORIGEN MARKETING
                        if ($compania_c == 2 && $origen_c == 1) $update_assigne_user = "UPDATE config SET value = $indices WHERE category = 'AltaLeadsServices' AND name = 'last_assigned_user_uniclick'";
                        //COMPANIA UNICLICK, ORIGEN ALIANZAS Y DETALLE ORIGEN
                        if ($compania_c == 2 && $origen_c == 12 && in_array($detalle_origen_c, $key_carrusel_do_list)) $update_assigne_user = "UPDATE config SET value = $indices WHERE category = 'AltaLeadsServices' AND name = 'last_assigned_user_uniclick'";

                        $db->query($update_assigne_user);
                    }
                }
            }
            
        } else {

            //USUARIOS QUE TIENEN EL EQUIPO PRINCIPAL UNICS 7 SE LEAS ASIGNA LEADS CON 9.- MKT - REVISTA MEDICA
            $query_revista = "SELECT
            user.id,
            user.date_entered,
            count(lead.assigned_user_id) AS total_asignados,
            uc.access_hours_c
            FROM users user
            INNER JOIN users_cstm uc
                ON uc.id_c = user.id
            LEFT JOIN leads lead
                ON lead.assigned_user_id = user.id
            WHERE user.status = 'Active' AND equipo_c = 7
            GROUP BY lead.assigned_user_id , user.id ORDER BY total_asignados,date_entered ASC
            LIMIT 1";

            $result_rm = $db->query($query_revista);
            $conteo = $result_rm->num_rows;

            if ($conteo > 0) {
                while ($rowUsr7 = $db->fetchByAssoc($result_rm)) {

                    $update_assigne_user = "UPDATE leads l INNER JOIN users u on u.id='" . $rowUsr7['id'] . "' SET l.team_id=u.default_team, l.team_set_id=u.team_set_id, l.assigned_user_id ='{$rowUsr7['id']}'  WHERE l.id ='{$row['id']}' ";
                    $db->query($update_assigne_user);
                }
            }
        }
    }
    $GLOBALS['log']->fatal("TERMINA JOB REASIGNAR LEADS CON USR GRUPO 9.- MKT A USR AGENTE TELEFONICO");
    return true;
}

function GetUserMKT($subpuesto_c, $compania_c)
{
    global $db;
    $users = [];
    $new_assigned_user = "";

    /* Obtiene  el dia y la hora actual*/
    $queryFEcha = "SELECT date_format(NOW(),'%W %H %i') AS Fecha,UTC_TIMESTAMP()";
    $queryResult = $db->query($queryFEcha);
    $row = $db->fetchByAssoc($queryResult);
    $date_Hoy = $row['Fecha'];
    $array_date = explode(" ", $date_Hoy);
    $dia_semana = $array_date[0];
    $horaDia = $array_date[1] . ":" . $array_date[2];
    $dateInput = date('H:i', strtotime($horaDia));

    /* Obtiene el ultimo  usuario asignado y registrado en el config*/
    if ($compania_c == 1) $query = "Select value from config where name='last_assigned_user_unifin'";
    if ($compania_c == 2) $query = "Select value from config where name='last_assigned_user_uniclick'";

    $result = $db->query($query);
    $row = $db->fetchByAssoc($result);
    $last_indice = $row['value'];

    /** Obtenemos los usuarios disponibles */
    $query_asesores = "SELECT
    user.id,
    user.date_entered,
    count(lead.assigned_user_id) AS total_asignados,
    uc.access_hours_c
    FROM users user
    INNER JOIN users_cstm uc
        ON uc.id_c = user.id
    LEFT JOIN leads lead
        ON lead.assigned_user_id = user.id
    where puestousuario_c='27' AND user.status = 'Active' AND subpuesto_c='$subpuesto_c'
    GROUP BY lead.assigned_user_id , user.id ORDER BY total_asignados,date_entered ASC";
    $result_usr = $db->query($query_asesores);

    while ($row = $db->fetchByAssoc($result_usr)) {
        $hours = json_decode($row['access_hours_c'], true);
        $hoursIn = !empty($hours) ? $hours[$dia_semana]['entrada'] : "";
        $hoursComida = !empty($hours) ? $hours[$dia_semana]['comida'] : "";
        $hoursRegreso = !empty($hours) ? $hours[$dia_semana]['regreso'] : "";
        $hoursOut = !empty($hours) ? $hours[$dia_semana]['salida'] : "";
        if ($hoursIn != "" && $hoursOut != "") {
            if (($hoursIn != "Bloqueado" && $hoursOut != "Bloqueado") && ($hoursIn != "Libre" && $hoursOut != "Libre")) {
                $enable = accessHours($hoursIn, $hoursComida, $hoursRegreso, $hoursOut, $dateInput);
                if ($enable) {
                    $users[] = $row['id'];
                }
            } elseif ($hoursIn == "Libre" && $hoursOut == "Libre") {
                $users[] = $row['id'];
            }
        }
    }
    //$GLOBALS['log']->fatal("Usuarios disponibles MKT en JOB " . print_r($users, true));

    if (count($users) > 0) {
        $new_indice = $last_indice >= count($users) - 1 ? 0 : $last_indice + 1;
        $new_assigned_user = $users[$new_indice];
    }
    return array("id" => $new_assigned_user, "indice" => $new_indice);
}

function accessHours($from, $eat, $return, $to, $login)
{
    $dateFrom = date("H:i", strtotime($from));
    $dateEat = date("H:i", strtotime($eat));
    $dateRet = date("H:i", strtotime($return));
    $dateTo = date("H:i", strtotime($to));
    $dateLogin = date("H:i", strtotime($login));
    if ($dateFrom <= $dateLogin && $dateLogin <= $dateTo) $enable = 1;
    if ($dateEat <= $dateLogin && $dateLogin <= $dateRet) $enable = 0;
    return ($enable);
}
