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

    public function setMontosMultiEtapa($bean = null, $event = null, $args = null){
        global $current_user;
        //Solo se ejecuta al insertar
        if (empty($bean->fetched_row['id'])) {
            $bean->monto_con_solicitud_c = 0;
            $bean->ri_con_solicitud_c = 0;
            $bean->monto_credito_c = 0;
            $bean->ri_credito_c = 0;
            $bean->monto_rechazado_c = 0;
            $bean->ri_rechazada_c = 0;

            if($bean->monto_original >= ($bean->monto_comprometido - $bean->renta_inicial_comprometida)){
                $bean->monto_prospecto_c = 0;
                $bean->ri_prospecto_c = 0;
                $bean->monto_sin_solicitud_c = $bean->monto_comprometido ;
                $bean->ri_sin_solicitud_c = $bean->renta_inicial_comprometida ;
            }else{
                $bean->monto_sin_solicitud_c = $bean->monto_original;
                $bean->ri_sin_solicitud_c = $bean->porciento_ri > 0 ? $bean->monto_original * ($bean->porciento_ri/100) : 0 ;
                $bean->monto_prospecto_c = $bean->monto_comprometido - $bean->monto_sin_solicitud_c;
                $bean->ri_prospecto_c = $bean->renta_inicial_comprometida - $bean->ri_sin_solicitud_c;
            }
        }
        if($bean->progreso == 2 && $bean->etapa == 'Prospecto' && $bean->monto_original > 0){
            if($bean->monto_original >= ($bean->monto_comprometido - $bean->renta_inicial_comprometida)){
                $bean->etapa = 'Autorizada';
                $bean->etapa_preliminar = 'Autorizada';
            }
        }
    }
}