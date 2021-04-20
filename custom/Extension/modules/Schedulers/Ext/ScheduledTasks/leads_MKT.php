<?php
array_push($job_strings, 'assignLeadMktToUser');

function assignLeadMktToUser()
{
    $GLOBALS['log']->fatal("INICIA JOB REASIGNAR LEADS CON USR GRUPO 9.- MKT A USR AGENTE TELEFONICO" );
    global $db;
    /* Obetenemos el id del usuario de grupo de 9.- MKT*/
    $QueryId = "SELECT id from users
WHERE first_name LIKE '%9.-%' AND last_name LIKE 'MKT'";
    $queryResultId = $db->query($QueryId);
    $row = $db->fetchByAssoc($queryResultId);
    $idMKT = $row['id'];
    /** Buscamos los Leads que tengan asignados el usuario de grupo 9.- MKT */
    $getLeads = "select a.id id, b.compania_c compania from leads a, leads_cstm b where a.id = b.id_c and a.assigned_user_id='{$idMKT}'";
    $ResultLeads = $db->query($getLeads);
    while ($row = $GLOBALS['db']->fetchByAssoc($ResultLeads)) {
		// Obtiene Compañía
		$compania_c = $row['compania'];
		if($compania_c == 1) $subpuesto_c = 3;
		if($compania_c == 2) $subpuesto_c = 4;
        $usrEnable = GetUserMKT($subpuesto_c);
        $indices = $usrEnable['indice'];
        if (!empty($usrEnable['id'])) {
            $update_assigne_user = "UPDATE leads SET  assigned_user_id ='{$usrEnable['id']}'  WHERE id ='{$row['id']}' ";
            $db->query($update_assigne_user);
            if ($indices > -1) {
                $update_assigne_user = "UPDATE config SET value = $indices  WHERE category = 'AltaLeadsServices' AND name = 'last_assigned_user'";
                $db->query($update_assigne_user);
            }
        }
    }
    $GLOBALS['log']->fatal("TERMINA JOB REASIGNAR LEADS CON USR GRUPO 9.- MKT A USR AGENTE TELEFONICO" );
    return true;
}

function GetUserMKT($subpuesto_c)
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
    $query = "Select value from config  where name='last_assigned_user' ";
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
  INNER JOIN leads lead
    ON lead.assigned_user_id = user.id
where puestousuario_c='27' AND subpuesto_c='$subpuesto_c'
GROUP BY lead.assigned_user_id ORDER BY total_asignados,date_entered ASC";
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
	if($dateFrom <= $dateLogin && $dateLogin <= $dateTo) $enable = 1;
	if($dateEat <= $dateLogin && $dateLogin <= $dateRet) $enable = 0;
    return ($enable);
}