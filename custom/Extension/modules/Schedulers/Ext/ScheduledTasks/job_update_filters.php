<?php
/*
* Created by: AF.Tactos
* 24/07/2019
* Job para ejecutar actualización de filtros en módulo de cuentas
*/
array_push($job_strings, 'job_update_filters');

function job_update_filters()
{
    //Inicia ejecución
    $GLOBALS['log']->fatal('Job Update Filters: Inicia');
    ##########################################
    ## 1.- Elimina filtros existentes: Mis cuentas
    ##########################################
    //$GLOBALS['log']->fatal('Job Update Filters: Delete 1 Inicio');
    //Estructura delete
    $sqlQueryD = "DELETE FROM filters WHERE date_entered='2018-09-29 18:0:00' AND name='Mis Cuentas';";
    //Ejecuta delete
    $resultD = $GLOBALS['db']->query($sqlQueryD);
    //$GLOBALS['log']->fatal($sqlQueryD);
    //$GLOBALS['log']->fatal('Job Update Filters: Delete 1 Fin');

    ##########################################
    ## 2.- Inserta filtro: Propietario
    ##########################################
    //$GLOBALS['log']->fatal('Job Update Filters: Insert 1 Inicio');
    //Estructura insert
    $sqlQueryIP = "INSERT IGNORE into filters(id, name, date_entered, date_modified, modified_user_id, created_by, description, deleted, team_id, team_set_id, assigned_user_id,filter_definition,filter_template,module_name, acl_team_set_id)
                select u.id,
                'Mis Cuentas' as name,
                '2018-09-29 18:0:00' as date_entered,
                '2018-09-29 18:0:00' as date_modified,
                u.id as modified_user_id,
                u.id as created_by,
                null as description,
                0 as deleted,
                u.default_team as team_id,
                u.team_set_id as team_set_id,
                null assigned_user_id,
                concat('[{\"',case when uc.tipodeproducto_c=1 then \"user_id_c\"
                       when uc.tipodeproducto_c=3 then \"user_id2_c\"
                       when uc.tipodeproducto_c=4 then \"user_id1_c\" end ,'\":{\"\$in\":[\"',u.id,'\"]}}]') as filter_definition,
               concat('[{\"',case when uc.tipodeproducto_c=1 then \"user_id_c\"
                      when uc.tipodeproducto_c=3 then \"user_id2_c\"
                      when uc.tipodeproducto_c=4 then \"user_id1_c\" end ,'\":{\$in\":[\"',u.id,'\"]}}]') as filter_template,
                      'Accounts' as module_name,
                      null as acl_team_set_id
                from users u, users_cstm uc
                where u.id= uc.id_c and uc.puestousuario_c IN ('5','11','16')
                and u.status = 'Active';
    ";
    //Ejecuta insert
    $resultIP = $GLOBALS['db']->query($sqlQueryIP);
    //$GLOBALS['log']->fatal($sqlQueryIP);
    //$GLOBALS['log']->fatal('Job Update Filters: Insert 1 Fin');

    ##########################################
    ## 3.- Inserta filtro: Reportan A
    ##########################################
    //$GLOBALS['log']->fatal('Job Update Filters: Insert 2 Inicio');
    //Estructura insert
    $sqlQueryII = "INSERT IGNORE into filters(id, name, date_entered, date_modified, modified_user_id, created_by, description, deleted, team_id, team_set_id, assigned_user_id,filter_definition,filter_template,module_name, acl_team_set_id)
                select u.id,
                'Mis Cuentas' as name,
                '2018-09-29 18:0:00' as date_entered,
                '2018-09-29 18:0:00' as date_modified,
                u.id as modified_user_id,
                u.id as created_by,
                null as description,
                0 as deleted,
                u.default_team as team_id,
                u.team_set_id as team_set_id,
                null assigned_user_id,
                concat('[{\"',case when uc.tipodeproducto_c=1 then \"user_id_c\"
                       when uc.tipodeproducto_c=3 then \"user_id2_c\"
                       when uc.tipodeproducto_c=4 then \"user_id1_c\" end ,'\":{\"\$in\":[',(select
                          CASE
                          WHEN (select GROUP_CONCAT(CONCAT(b.id)) from users b where b.reports_to_id = u.id) is null THEN concat('\"',u.id,'\"')
                          WHEN (select GROUP_CONCAT(CONCAT(b.id)) from users b where b.reports_to_id = u.id) is not null THEN concat('\"',u.id,'\",',(select GROUP_CONCAT(CONCAT('\"',b.id,'\"')) from users b where b.reports_to_id = u.id))
                          END),']}}]') as filter_definition,
                concat('[{\"',case when uc.tipodeproducto_c=1 then \"user_id_c\"
                       when uc.tipodeproducto_c=3 then \"user_id2_c\"
                       when uc.tipodeproducto_c=4 then \"user_id1_c\" end ,'\":{\"\$in\":[',(select
                          CASE
                          WHEN (select GROUP_CONCAT(CONCAT(b.id)) from users b where b.reports_to_id = u.id) is null THEN concat('\"',u.id,'\"')
                          WHEN (select GROUP_CONCAT(CONCAT(b.id)) from users b where b.reports_to_id = u.id) is not null THEN concat('\"',u.id,'\",',(select GROUP_CONCAT(CONCAT('\"',b.id,'\"')) from users b where b.reports_to_id = u.id))
                          END),']}}]') as filter_template,
                'Accounts' as module_name,
                null as acl_team_set_id
                from users u, users_cstm uc
                where u.id= uc.id_c and uc.puestousuario_c IN ('3','4','9','10','15')
                and u.status = 'Active';
    ";
    //Ejecuta insert
    $resultII = $GLOBALS['db']->query($sqlQueryII);
    //$GLOBALS['log']->fatal($sqlQueryII);
    //$GLOBALS['log']->fatal('Job Update Filters: Insert 2 Fin');

    ##########################################
    ## 4.- Inserta filtro: Equipos
    ##########################################
    //$GLOBALS['log']->fatal('Job Update Filters: Insert 3 Inicio');
    //Estructura insert
    $sqlQueryIE = "INSERT IGNORE into filters(id, name, date_entered, date_modified, modified_user_id, created_by, description, deleted, team_id, team_set_id, assigned_user_id,filter_definition,filter_template,module_name, acl_team_set_id)
                select u.id,
                    'Mis Cuentas' as name,
                    '2018-09-29 18:0:00' as date_entered,
                    '2018-09-29 18:0:00' as date_modified,
                    u.id as modified_user_id,
                    u.id as created_by,
                    null as description,
                    0 as deleted,
                    u.default_team as team_id,
                    u.team_set_id as team_set_id,
                    null assigned_user_id,
                    concat('[{\"unifin_team\":{\"\$in\":[',replace(equipos_c,'^','\"') ,']}}]') as filter_definition,
                    concat('[{\"unifin_team\":{\"\$in\":[',replace(equipos_c,'^','\"') ,']}}]') as filter_template,
                    'Accounts' as module_name,
                    null as acl_team_set_id
                from users u, users_cstm uc
                where u.id=uc.id_c
                and u.status = 'Active'
                and uc.puestousuario_c IN ('1','2','6','7','8','12','13','14','17','33');
    ";
    //Ejecuta insert
    $resultIE = $GLOBALS['db']->query($sqlQueryIE);
    //$GLOBALS['log']->fatal($sqlQueryIE);
    //$GLOBALS['log']->fatal('Job Update Filters: Insert 3 Fin');


    $GLOBALS['log']->fatal('Job Update Filters: Fin');
    return true;
}
