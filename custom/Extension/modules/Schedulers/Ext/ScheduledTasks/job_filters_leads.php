<?php
/*
* Created by: ECB.Tactos
* 03/03/2021
* Job para ejecutar actualización de filtros en módulo de leads
*/
array_push($job_strings, 'job_filters_leads');

function job_filters_leads()
{
    //Inicia ejecución
    $GLOBALS['log']->fatal('Job Update Filters Leads: Inicia');
    ##########################################
    ## 1.- Elimina filtros existentes: Mis Leads
    ##########################################
    $sqlQuery1 = "DELETE FROM filters WHERE date_entered='2021-02-26 18:00:00' AND name = 'Mis Leads';";
    $result1 = $GLOBALS['db']->query($sqlQuery1);
    ##########################################
    ## 2.- Inserta filtro: Mis Leads
    ##########################################
	// Agentes Telefonicos
    $sqlQuery2 = "insert IGNORE into filters(id, name, date_entered, date_modified, modified_user_id, created_by, description, deleted, team_id, team_set_id, assigned_user_id,filter_definition,filter_template,module_name, acl_team_set_id)
select u.id,
       'Mis Leads' as name,
       '2021-02-26 18:00:00' as date_entered,
       '2021-02-26 18:00:00' as date_modified,
       u.id as modified_user_id,
       u.id as created_by,
       null as description,
       0 as deleted,
       u.default_team as team_id,
       u.team_set_id as team_set_id,
       null assigned_user_id,
       concat('[{\"assigned_user_id\":{\"\$in\":[\"',u.id,'\"]}},{\"regimen_fiscal_c\":{\"\$in\":[\"3\"]}},{\"subtipo_registro_c\":{\"\$in\":[\"1\",\"2\",\"4\"]}}]') as filter_definition,
       concat('[{\"assigned_user_id\":{\"\$in\":[\"',u.id,'\"]}},{\"regimen_fiscal_c\":{\"\$in\":[\"3\"]}},{\"subtipo_registro_c\":{\"\$in\":[\"1\",\"2\",\"4\"]}}]') as filter_template,
       'Leads' as module_name,
       null as acl_team_set_id
from users u, users_cstm uc
where u.id= uc.id_c and uc.puestousuario_c = '27'
and u.status = 'Active';
    ";
    $result2 = $GLOBALS['db']->query($sqlQuery2);
	// Asesores
    $sqlQuery3 = "insert IGNORE into filters(id, name, date_entered, date_modified, modified_user_id, created_by, description, deleted, team_id, team_set_id, assigned_user_id,filter_definition,filter_template,module_name, acl_team_set_id)
select uuid(),
       'Mis Leads' as name,
       '2021-02-26 18:00:00' as date_entered,
       '2021-02-26 18:00:00' as date_modified,
       u.id as modified_user_id,
       u.id as created_by,
       null as description,
       0 as deleted,
       u.default_team as team_id,
       u.team_set_id as team_set_id,
       null assigned_user_id,
       concat('[{\"assigned_user_id\":{\"\$in\":[\"',u.id,'\"]}},{\"contacto_asociado_c\":{\"\$equals\":\"0\"}}]') as filter_definition,
       concat('[{\"assigned_user_id\":{\"\$in\":[\"',u.id,'\"]}},{\"contacto_asociado_c\":{\"\$equals\":\"0\"}}]') as filter_template,
       'Leads' as module_name,
       null as acl_team_set_id
from users u, users_cstm uc
where u.id= uc.id_c and uc.puestousuario_c in ('5','11','16','53','54')
and u.status = 'Active';
    ";
    $result3 = $GLOBALS['db']->query($sqlQuery3);	
    $GLOBALS['log']->fatal('Job Update Filters Leads: Fin');
    return true;
}
