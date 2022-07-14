<?php
/*/**
 * Created by EJC
 * Date: 30/06/22
 */
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class consultaObjetivos extends SugarApi
{

    public function registerApiRest()
    {
        return array(
                'consultaObjetivos' => array(
                'reqType' => 'GET',
                'path' => array('getObjetivos','?'),
                'pathVars' => array('', 'data'),
                'method' => 'getDetalleObjetivos',
                'shortHelp' => 'Consumo para obtener los datos de Objetivos de ususarios de DWH',
            ),
        );
    }

    public function getDetalleObjetivos($api, $args){

        try {
            $datos = json_decode($args['data']);
            $GLOBALS['log']->fatal('datos', $datos);
            $id_user = $datos->id_user;
            $mes = $datos->mes;
            $anio = $datos->anio;
            $posicion_operativa  = $datos->posicion;
            $equipo  = $datos->equipo;
            $region  = $datos->region;

            $records = [];
            $records_totales = [];

            $pos = strrpos($posicion_operativa, "3");
            $url = $this->getUrl($id_user, $posicion_operativa ,  $equipo, $region, $mes, $anio );
            $GLOBALS['log']->fatal("URL: " ,$url);
            $records = $this->getTotales($url,  $equipo, $region, $mes, $anio );
        
            //$GLOBALS['log']->fatal('records2-json', json_encode($records));
            //$GLOBALS['log']->fatal('records', $records);
            return $records;
        } catch (Exception $e) {

            $GLOBALS['log']->fatal("Error: " . $e->getMessage());
        }
    }
    
    public function getUrl($idUsuario, $posicion_operativa, $equipo, $region, $mes, $anio){
        $mes+=1;
        
        global $app_list_strings, $current_user,$sugar_config,$db;
        //http://172.20.4.72:8081/DWHApiRest/public/api/modelo?mes=&anio=2022&usuario=bf51077a-e2d8-5f5a-5ddf-5626cdbe9c37&idequipo=null&idregion=null
        //http://172.20.4.72:8081/DWHApiRest/public/api/modelo?mes=null&anio=122&usuario=12a7c616-599b-ea48-ef37-586ff89ff852
        
        $pos = strrpos($posicion_operativa, "3");
        if($pos != ""){
            $host1=$sugar_config['dwh_objetivos'].'?mes=&anio='.$anio.'&usuario='.$idUsuario;
        }else{
            $pos = strrpos($posicion_operativa, "1");
            if($pos != "" ){
                $host1=$sugar_config['dwh_objetivos'].'?mes=&anio='.$anio.'&usuario=null&idequipo='.$equipo.'&idregion=null';
            }else{
                $host1=$sugar_config['dwh_objetivos'].'?mes=&anio='.$anio.'&usuario=null&idequipo=null&idregion='.$region;
            }
        }
        return $host1;
    }
    
    public function getTotales($url, $equipo, $region, $mes, $anio){
        
        $mes+=1;

        global $app_list_strings, $current_user,$sugar_config,$db;
        $response=null;
        
        //Ejecuta primer servicio para validar que exista usuario en Proveedores, si no existe ejecuta segundo servicio
        try {
            $GLOBALS['log']->fatal('Realiza consumo objetivos');
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_ENCODING, '');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            $result = curl_exec($ch);
            $curl_info = curl_getinfo($ch);
            $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $response1 = json_decode($result, true);
            $GLOBALS['log']->fatal($url);
            $GLOBALS['log']->fatal("Respuesta primer servicio: " . print_r($response1, true));
        } catch (Exception $exception) {
            $GLOBALS['log']->fatal('Error',$exception);
        }
        
        $presupuestoTotal = 0.0;
        $cubiertoTotal = 0.0;
        $presupuestoMensual = 0.0;
        $cubiertoMensual = 0.0;
        $item=null; 
        $item1=null; 
            
        foreach($response1 as $val){
                $presupuestoTotal += floatval($val['Presupuesto']);
                $cubiertoTotal += floatval($val['MontoCubierto']);
                if($val['mes'] == $mes){
                    $presupuestoMensual += floatval($val['Presupuesto']);
                    $cubiertoMensual += floatval($val['MontoCubierto']);
                }
        }

        $item['tipo'] = 'mensual';
        $item['mes'] = $mes;
        $item['presupuesto'] =  $presupuestoMensual;
        $item['montocubierto'] =  $cubiertoMensual;
        if($presupuestoMensual != 0 && $cubiertoMensual != 0){
            $item['avance'] = round( (($cubiertoMensual /  $presupuestoMensual) * 100) , 2);
        }else{
            $item['avance'] = 0;
        }
        
        $item1['tipo'] = 'anual';
        $item1['anio'] = $anio;
        $item1['presupuesto'] =  $presupuestoTotal;
        $item1['montocubierto'] =  $cubiertoTotal;
        if($presupuestoTotal != 0 && $cubiertoTotal != 0){
            $item1['avance'] = round( (($cubiertoTotal / $presupuestoTotal) * 100) ,2 );     
        }else{
            $item1['avance'] = 0;
        }
        
        //$GLOBALS['log']->fatal('mensual', $return);
        //$GLOBALS['log']->fatal('anual', $return1);
        /*$item['presupuesto'] =  500000;
        $item['montocubierto'] =  550000;
        $item['avance'] = 110;
        $item1['presupuesto'] =  1000000;
        $item1['montocubierto'] =  300000;
        $item1['avance'] = 200;
        */
        if($item['avance'] > 0 && $item['avance']<=49.9){
            $item['avance_gr'] = (($item['avance'] *100)/50) * 0.33;
        }else if($item['avance'] >= 50 && $item['avance']<=100){
            $item['avance_gr'] =  33+(($item['avance'] - 50) * 0.66);
        }else if($item['avance'] > 100){
            $item['avance_gr'] = 66 + (($item['avance']-100) * .33);
        }

        if($item1['avance'] > 0 && $item1['avance']<=49.9){
            $item1['avance_gr'] = (($item1['avance'] *100)/50) * 0.33;
        }else if($item1['avance'] >= 50 && $item1['avance']<=100){
            $item1['avance_gr'] =  33+(($item1['avance'] - 50) * 0.66);
        }else if($item1['avance'] > 100){
            $item1['avance_gr'] = 66 + (($item1['avance']-100) * .33);
        }

        $salida = array_merge(
            array('Mensual' => $item),
            array('Anual' => $item1)
        );
        //$GLOBALS['log']->fatal('records_in', $records_in);
        return $salida;
    }

    public function getTotalesAsesor($idUsuario , $mes , $anio){
        $mes+=1;

        global $app_list_strings, $current_user,$sugar_config,$db;
        $response=array();
        //http://172.20.4.72:8081/DWHApiRest/public/api/modelo?mes=&anio=2022&usuario=bf51077a-e2d8-5f5a-5ddf-5626cdbe9c37&idequipo=null&idregion=null
        //http://172.20.4.72:8081/DWHApiRest/public/api/modelo?mes=null&anio=122&usuario=12a7c616-599b-ea48-ef37-586ff89ff852
        $host1=$sugar_config['dwh_objetivos'].'?mes=&anio='.$anio.'&usuario='.$idUsuario;
        //Ejecuta primer servicio para validar que exista usuario en Proveedores, si no existe ejecuta segundo servicio
        try {
            $GLOBALS['log']->fatal('Realiza consumo objetivos');
            
            $url = $host1;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_ENCODING, '');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            $result = curl_exec($ch);
            $curl_info = curl_getinfo($ch);
            $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $response1 = json_decode($result, true);
            $GLOBALS['log']->fatal($host1);
            //$GLOBALS['log']->fatal("Respuesta primer servicio: " . print_r($response1, true));
        } catch (Exception $exception) {
            $GLOBALS['log']->fatal('Error',$exception);
        }
        
        //$d0 = $this->groupArray($response1,'IdProducto', 'IdProducto');
        //$GLOBALS['log']->fatal('d0', $d0);
        
        $presupuestoTotal = 0.0;
        $cubiertoTotal = 0.0;
        $presupuestoMensual = 0.0;
        $cubiertoMensual = 0.0;
        $item=null; 
        $item1=null; 
            
        foreach($response1 as $val){
           
                $presupuestoTotal += floatval($val['Presupuesto']);
                $cubiertoTotal += floatval($val['MontoCubierto']);
                if($val['mes'] == $mes){
                    $presupuestoMensual += floatval($val['Presupuesto']);
                    $cubiertoMensual += floatval($val['MontoCubierto']);
                }
        }

        $item['tipo'] = 'mensual';
        $item['mes'] = $mes;
        $item['presupuesto'] =  $presupuestoMensual;
        $item['montocubierto'] =  $cubiertoMensual;
        if($presupuestoMensual != 0 && $cubiertoMensual != 0 ){
            $item['avance'] = round( (($cubiertoMensual /  $presupuestoMensual) * 100) , 2);     
        }
        

        $item1['tipo'] = 'anual';
        $item1['anio'] = $anio;
        $item1['presupuesto'] =  $presupuestoTotal;
        $item1['montocubierto'] =  $cubiertoTotal;
        if($cubiertoTotal != 0 && $presupuestoTotal != 0 ){
            $item1['avance'] = round( (($cubiertoTotal / $presupuestoTotal) * 100) ,2 );     
        }
        /*$item['presupuesto'] =  500000;
        $item['montocubierto'] =  550000;
        $item['avance'] = 15;
        $item1['presupuesto'] =  1000000;
        $item1['montocubierto'] =  300000;
        $item1['avance'] = 45;
        */
        if($item['avance'] > 0 && $item['avance']<=35){
            $item['avance_gr'] = (($item['avance'] *100)/35) * 0.25;
        }else if($item['avance'] > 35 && $item['avance']<=50){
            $item['avance_gr'] = 25+(($item['avance'] - 35) * 1.665);
        }else if($item['avance'] > 50 && $item['avance']<=100){
            $item['avance_gr'] =  50+(($item['avance'] - 50) * 0.5);
        }else if($item['avance'] > 100){
            $item['avance_gr'] = 75 + (($item['avance']-100) * .25);
        }

        if($item1['avance'] > 0 && $item1['avance']<=35){
            $item1['avance_gr'] = (($item1['avance'] *100)/35) * 0.25;
        }else if($item1['avance'] > 35 && $item1['avance']<=50){
            $item1['avance_gr'] = 25+(($item1['avance'] - 35) * 1.665);
        }else if($item1['avance'] > 50 && $item1['avance']<=100){
            $item1['avance_gr'] =  50+(($item1['avance'] - 50) * 0.5);
        }else if($item1['avance'] > 100){
            $item1['avance_gr'] = 75 + (($item1['avance']-100) * .25);
        }

        //$GLOBALS['log']->fatal('mensual', $return);
        //$GLOBALS['log']->fatal('anual', $return1);
        $salida = array_merge(
            array('Mensual' => $item),
            array('Anual' => $item1)
        );
        //$GLOBALS['log']->fatal('records_in', $records_in);
        return $salida;
    }


}
