<?php
/**
 * Created by Levementum.
 * User: jgarcia@levementum.com
 * Date: 3/8/2016
 * Time: 10:40 AM
 */
require_once("custom/Levementum/UnifinAPI.php");
class backlog_hooks {

    public function setFormatName($bean = null, $event = null, $args = null){

        if($bean->lev_backlog_opportunitiesopportunities_ida == null) {
            $account = BeanFactory::retrieveBean('Accounts', $bean->account_id_c);  

            if(empty($bean->numero_de_backlog)) {
                $callApi = new UnifinAPI();
                $numeroDeFolio = $callApi->generarBacklogFolio();
                $bean->numero_de_backlog = $numeroDeFolio;
            }

            //BackLog Mes Año – FolioBacklog - Cliente
            $bean->name = 'BackLog ' . $bean->mes . " " . $bean->anio . " - " . $bean->numero_de_backlog . " - " . $account->name;

        }
    }

    public function setComentarios($bean = null, $event = null, $args = null){

        global $current_user;
        $todayDate = date("n/j/Y", strtotime("now"));
        if(!empty($bean->comentario)){
            $bean->description .= "\r\n" . $current_user->first_name . " " . $current_user->last_name . " - " . $todayDate . ": " . $bean->comentario;
            $bean->comentario = "";
        }
    }
}