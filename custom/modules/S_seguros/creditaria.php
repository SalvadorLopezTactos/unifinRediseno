<?php
/*
 * Created by Tactos
 * Email: eduardo.carrasco@tactos.com.mx
 * Date: 21/06/2023
*/
require_once("custom/Levementum/UnifinAPI.php");

class creditaria_clas
{
    public function creditaria_func($bean = null, $event = null, $args = null)
    {
    		global $db;
    		$hoy = date("Y-m-d");
    		if($bean->inicio_vigencia_emitida_c <= $hoy && $bean->fin_vigencia_emitida_c >= $hoy){
            $update = "update uni_productos p inner join uni_productos_cstm pc on pc.id_c = p.id inner join accounts_uni_productos_1_c ap on ap.accounts_uni_productos_1uni_productos_idb = p.id set p.estatus_atencion = 1, pc.status_management_c = 1 where ap.accounts_uni_productos_1accounts_ida = '{$bean->parent_id}' and ap.deleted = 0 and p.tipo_producto = 10 and p.deleted = 0";
        }else{
           $update = "update uni_productos p inner join accounts_uni_productos_1_c ap on ap.accounts_uni_productos_1uni_productos_idb = p.id set p.estatus_atencion = 1 where ap.accounts_uni_productos_1accounts_ida = '{$bean->s_seguros_accountsaccounts_ida}' and ap.deleted = 0 and p.tipo_producto = 10 and p.deleted = 0";
        }
    		$result = $db->query($update);
    }
    
    public function actualiza_creditaria_func($bean = null, $event = null, $args = null)
    {
        /*Actualización de estatus a Creditaria
        * 1) Oportunidad tiene Id Odoo
        * 2) Se detecta cambio de estado
        */
        if($bean->id_odoo_c && $bean->fetched_row['etapa'] != $bean->etapa){
            //Forma request
            try {
              global $sugar_config;
              $url = $sugar_config['creditaria_host'].'/unifin';  //https://test.creditaria.online.'/unifin';
              $params = array(
                  'idSugar'=>$bean->id,
                  'idOdoo'=>$bean->id_odoo_c,
                  'etapa'=>$bean->etapa
              );
              
              $callApi = new UnifinAPI();
              $response = $callApi->unifinPostCall($url,$params);
                            
            } catch (Exception $e) {
                $GLOBALS['log']->fatal("Error al procesar actualización Creditaria: " .$e->getMessage());
            }
              
        }
    }
}
