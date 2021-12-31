<?php
/**
 * Created by: salvadorlopez
 * Date: 30/12/21
 * Time: 10:07
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class SetAuditBacklogs extends SugarApi
{

    /**
     * Registro de todas las rutas para consumir los servicios del API
     *
     */
    public function registerApiRest()
    {
        return array(
            //GET
            'retrieve' => array(
                //request type
                'reqType' => 'POST',
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('SetAuditBacklogs'),
                //endpoint variables
                'pathVars' => array('method'),
                //method to call
                'method' => 'setAuditBacklogsFunc',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método que obtiene arreglo de backlogs y genera inserts a la tabla de auditoria (lev_backlog_audit)',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),


        );

    }

    public function setAuditBacklogsFunc($api, $args)
    {
        global $current_user;

        if(count($args["backlogs_audit"])>0){

            for ($i=0; $i < count($args["backlogs_audit"]); $i++) { 
                $id=create_guid();
                $id_backlog=$args["backlogs_audit"][$i];
                $fecha=TimeDate::getInstance()->nowDb();
                $sqlInsert="INSERT INTO lev_backlog_audit (id, parent_id, date_created, created_by, field_name, data_type,after_value_string) VALUES ('{$id}', '{$id_backlog}', '{$fecha}', '{$current_user->id}', 'vista', 'varchar','Administración Backlog')";

                $GLOBALS['db']->query($sqlInsert);
            }
            

        }
        
        return array("message"=>"Se han insertado ".count($args["backlogs_audit"])." registros en la tabla de auditoría de Backlog");

    }


}

?>
