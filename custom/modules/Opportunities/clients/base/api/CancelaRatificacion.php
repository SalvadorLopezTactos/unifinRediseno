<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 7/1/2015
 * Time: 11:03 PM
 */
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class CancelaRatificacion extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'postCancelaRatificacion' => array(
                'reqType' => 'POST',
                'path' => array('CancelaRatificacion'),
                'pathVars' => array('',''),
                'method' => 'cancelRatificacion',
                'shortHelp' => 'Cancela la Operacion Padre de ratificacion',
            ),
        );
    }

    public function cancelRatificacion($api, $args)
    {
        global $db, $current_user;
        $isParentId = false;
        $id = $args['data']['id'];
		$conProceso = $args['data']['conProceso'];
        $tipo_de_operacion_c = $args['data']['tipo_de_operacion_c'];
        $tipo_operacion_c = $args['data']['tipo_operacion_c'];



		if($conProceso==0){
			$GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : id hijo " . $id);
			$query2 = <<<SQL
UPDATE opportunities_cstm
SET estatus_c = 'K'
where id_c='{$id}'
SQL;
			$GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : query: " . $query2);
			$queryResult2 = $db->query($query2);
			$GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> :Resultado query: " . print_r($queryResult2,true));
			if($queryResult2 != null){
                $isParentId = true;
            }

            //$this->cancelaBacklogs($id);
        }

	if($tipo_de_operacion_c=='RATIFICACION_INCREMENTO' && $tipo_operacion_c=='1'){
        //obtiene el idpadre:
        $padre = "Select id_linea_credito_c from opportunities_cstm where id_c='{$id}';";
        $padreQuery = $db->query($padre);
        while ($row = $db->fetchByAssoc($padreQuery)) {
            $id_linea_padre = $row['id_linea_credito_c'];
        }
        $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : consulta2  " . $padre);
        $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : fila  " . $id_linea_padre);
        if($id_linea_padre!="" && strlen($id_linea_padre)>0 && $id_linea_padre!=0 && $id_linea_padre != 'NULL'){
            $query = <<<SQL
UPDATE opportunities_cstm
SET /*tipo_de_operacion_c = 'LINEA_NUEVA', */ plazo_ratificado_incremento_c ="",
ratificacion_incremento_c=0, monto_ratificacion_increment_c=0.00,
ri_ca_tasa_c = 0,
 ri_deposito_garantia_c = 0,
 ri_porcentaje_ca_c = 0,
 ri_porcentaje_renta_inicial_c = 0,
 ri_vrc_c = 0,
 ri_vri_c = 0,
 ri_usuario_bo_c=''
where id_linea_credito_c = $id_linea_padre /* and tipo_de_operacion_c = 'RATIFICACION_INCREMENTO' */ and  tipo_operacion_c = "2" and estatus_c = "N"
SQL;
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : query: " . $query);
            $queryResult = $db->query($query);
        }
		if($queryResult2 != null){
			$isParentId = true;
		}
	}
        return $isParentId;
    }

    public function cancelaBacklogs($oppId)
    {
        try {
            global $db;
            $query = <<<SQL
SELECT lb.id FROM lev_backlog lb
INNER JOIN lev_backlog_opportunities_c lbo ON lbo.lev_backlog_opportunitieslev_backlog_idb = lb.id AND lbo.deleted = 0
INNER JOIN opportunities o ON o.id = lbo.lev_backlog_opportunitiesopportunities_ida AND o.deleted = 0
WHERE o.id = '{$oppId}' AND lb.deleted = 0
SQL;

            $queryResult = $db->query($query);
            while ($row = $db->fetchByAssoc($queryResult)) {
                $backlog = BeanFactory::retrieveBean('lev_Backlog', $row['id']);
                $backlog->estatus_de_la_operacion = "Cancelada";
                $backlog->monto_comprometido_cancelado = "-" . $backlog->monto_comprometido;
                $backlog->renta_inicialcomp_can = "-" . $backlog->renta_inicial_comprometida;
                $backlog->monto_real_logrado = 0;
                $backlog->renta_inicial_real = 0;
                $backlog->save();
            }
        } catch (Exception $e) {
            error_log(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " Error: " . $e->getMessage());
            $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " Error " . $e->getMessage());
        }
    }

    /** BEGIN CUSTOMIZATION: jgarcia@levementum.com 3/28/2016 Description: Cancela todos los Backlogs relacionados */
    /*public function cancelaBacklogs($oppId)
    {
        try {
            global $db;
            $query = <<<SQL
SELECT lb.id FROM lev_backlog lb
INNER JOIN lev_backlog_opportunities_c lbo ON lbo.lev_backlog_opportunitieslev_backlog_idb = lb.id AND lbo.deleted = 0
INNER JOIN opportunities o ON o.id = lbo.lev_backlog_opportunitiesopportunities_ida AND o.deleted = 0
WHERE o.id = '{$oppId}'
SQL;

            $queryResult = $db->query($query);
            while ($row = $db->fetchByAssoc($queryResult)) {
                $backlog = BeanFactory::retrieveBean('lev_Backlog', $row['id']);
                $backlog->estatus_de_la_operacion = "Cancelada por cliente";
                $backlog->monto_comprometido_cancelado = "-" . $backlog->monto_comprometido;
                $backlog->renta_inicialcomp_can = "-" . $backlog->renta_inicial_comprometida;
                $backlog->monto_real_logrado = 0;
                $backlog->renta_inicial_real = 0;
                $backlog->save();
            }
        } catch (Exception $e) {
            error_log(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " Error: " . $e->getMessage());
            $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " Error " . $e->getMessage());
        }
    }*/
}