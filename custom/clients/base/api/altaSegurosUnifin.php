<?php
/*/**
 * Created by Eduardo Carrasco Beltrán
 * Date: 11/07/2023
 */
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class altaSegurosUnifin extends SugarApi
{

    public function registerApiRest()
    {
        return array(
            'altaSegurosUnifin' => array(
                'reqType' => 'POST',
                'path' => array('altaSegurosUnifin'),
                'pathVars' => array(''),
                'method' => 'altaSeguros',
                'shortHelp' => 'Consumo para dar de alta Oportunidades de Seguro de Creditaria',
            ),
        );
    }

	public function altaSeguros($api, $args) {
		$response = array();
		try {
			$beanSeguro = BeanFactory::newBean('S_seguros');
			if($args['usuario']) {
				$beanSeguro->created_by = $args['usuario'];
				$beanSeguro->assigned_user_id = $args['usuario'];
				$beanSeguro->user_id1_c = $args['usuario'];
			}
			$beanSeguro->creditaria_c = "Creditaria";
			require_once("custom/clients/base/api/creditaria_api.php");
			$apiCreditaria = new creditaria_api();
			$body = array('id_cuenta'=>$args['s_seguros_accounts_name']);
			$respuesta = $apiCreditaria->atendido(null,$body);
			if($respuesta['status_management_c'] == 1) $beanSeguro->revision_c = 1;
			if($respuesta['estatus_atencion'] == 1) $beanSeguro->atendido_c = 1;
			if($args['s_seguros_accounts_name']) $beanSeguro->s_seguros_accountsaccounts_ida = $args['s_seguros_accounts_name'];
			if($args['tipo']) $beanSeguro->tipo = $args['tipo'];
			if($args['subramos_c']) $beanSeguro->subramos_c = $args['subramos_c'];
			if($args['tipo_venta_c']) $beanSeguro->tipo_venta_c = $args['tipo_venta_c'];
			if($args['ejecutivo_c']) $beanSeguro->ejecutivo_c = $args['ejecutivo_c'];
			if($args['referenciador']) $beanSeguro->user_id1_c = $args['referenciador'];
			if($args['fecha_req']) $beanSeguro->fecha_req = $args['fecha_req'];
			if($args['tipo_registro_sf_c']) $beanSeguro->tipo_registro_sf_c = $args['tipo_registro_sf_c'];
			if($args['tipo_poliza_c']) $beanSeguro->tipo_poliza_c = $args['tipo_poliza_c'];
			if($args['tipo_sf_c']) $beanSeguro->tipo_sf_c = $args['tipo_sf_c'];
			if($args['tipo_referenciador']) $beanSeguro->tipo_referenciador = $args['tipo_referenciador'];
			if($args['region']) $beanSeguro->region = $args['region'];
			if($args['area']) $beanSeguro->area = $args['area'];
			if($args['fecha_cierre_c']) $beanSeguro->fecha_cierre_c = $args['fecha_cierre_c'];
			if($args['prima_obj_c']) $beanSeguro->prima_obj_c = $args['prima_obj_c'];
			if($args['requiere_ayuda_c']) $beanSeguro->requiere_ayuda_c = $args['requiere_ayuda_c'];
			if($args['oficina_c']) $beanSeguro->oficina_c = $args['oficina_c'];
			if($args['kam_c']) $beanSeguro->kam_c = $args['kam_c'];
			if($args['info_actual']) $beanSeguro->info_actual = $args['info_actual'];
			if($args['servicios_a_incluir_c']) $beanSeguro->servicios_a_incluir_c = $args['servicios_a_incluir_c'];
			if($args['asesor_vta_cruzada_c']) $beanSeguro->asesor_vta_cruzada_c = $args['asesor_vta_cruzada_c'];
			if($args['nacional_c']) $beanSeguro->nacional_c = $args['nacional_c'];
			if($args['prima_neta_c']) $beanSeguro->prima_neta_c = $args['prima_neta_c'];
			if($args['compania']) $beanSeguro->compania = $args['compania'];
			if($args['siniestralidad']) $beanSeguro->siniestralidad = $args['siniestralidad'];
			if($args['fecha_ini']) $beanSeguro->fecha_ini = $args['fecha_ini'];
			if($args['fecha_fin']) $beanSeguro->fecha_fin = $args['fecha_fin'];
			if($args['forma_pago_act']) $beanSeguro->forma_pago_act = $args['forma_pago_act'];
			if($args['tipo_cliente_c']) $beanSeguro->tipo_cliente_c = $args['tipo_cliente_c'];
			if($args['description']) $beanSeguro->description = $args['description'];
			$beanSeguro->save();
			$idSeguro = $beanSeguro->id;
			if($idSeguro) {
				$response['statusCode']='200';
				$response['message']='Registro procesado de forma correcta';
				$response['id']=$idSeguro;
			}
			else {
				$response['statusCode']='500';
				$response['message']='Error al procesar la solicitud';
			}
        } catch (Exception $e) {
            $response['statusCode']='400';
            $response['message']=$e->getMessage();
        }
		return $response;
	}
}
