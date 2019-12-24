<?php
/**
 * Created by PhpStorm.
 * User: salvadorlopez
 * Date: 23/12/19
 * Time: 10:20
 */
class AuditTable
{
    function insertAuditFields($bean = null, $event = null, $args = null){

        global $current_user;
        global $app_list_strings;
        $date= TimeDate::getInstance()->nowDb();

        //Valida cambio de puesto
        if($args['isUpdate']){

            if($bean->fetched_row['puestousuario_c'] != $bean->puestousuario_c){

                $id_u_audit=create_guid();
                $tipo=$this->getFieldType($bean,'puestousuario_c');
                $anterior=$bean->fetched_row["puestousuario_c"];
                $actual=$bean->puestousuario_c;
                $sqlInsert="insert into users_audit (id, parent_id, date_created, created_by, field_name, data_type, before_value_string, after_value_string, before_value_text, after_value_text, event_id, date_updated)
                  VALUES ('{$id_u_audit}', '{$bean->id}', '{$date}', '{$current_user->id}', 'puestousuario_c', '{$tipo}', '{$anterior}', '{$actual}', '{$app_list_strings["puestousuario_c_list"][$anterior]}', '{$app_list_strings["puestousuario_c_list"][$actual]}', '1', '{$date}')";
                $GLOBALS['db']->query($sqlInsert);

            }

        }

    }

    function getFieldType($bean,$field){
        return $bean->field_defs[$field]['type'];
    }

}