<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetClientManager_Backlog extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GetClientManager_Backlog_API' => array(
                'reqType' => 'GET',
                'noLoginRequired' => false,
                'path' => array('GetClientManager_BacklogTabla','?'),
                'pathVars' => array('module','id'),
                'method' => 'getDetalleSumaBacklog',
                'shortHelp' => 'Obtiene la suma de cantidades para backlog',
            ),
        );
    }
    public function getDetalleSumaBacklog($api, $args){

        try {
            global $current_user;
            $id_user = $current_user->id;
            $posicion_operativa = $current_user->posicion_operativa_c;
            $equipo_c = $current_user->equipo_c;

            //$GLOBALS['log']->fatal('posicion_operativa', $posicion_operativa);
            //$GLOBALS['log']->fatal('id_user', $id_user.' - '.$current_user->user_name);
            //$GLOBALS['log']->fatal('equipo_c', $id_user.' - '.$current_user->equipo_c);
            
            $records = [];
            $records_totales = [];

            $pos = strrpos($posicion_operativa, "3");
            //$GLOBALS['log']->fatal('pos', $pos);

            $records=$this->getTotalesQuery();
            /*
            if($pos != ""){
                $records = $this->getTotalesAsesor( "'".$id_user."'" , "'".$equipo_c."'");
                $GLOBALS['log']->fatal('records', $records);
            }else{
                
                list ($usuarios, $equipo , $reg) = $this->getusuarios($id_user , $posicion_operativa);
                $GLOBALS['log']->fatal('usuarios', $usuarios);
                $GLOBALS['log']->fatal('equipo', $equipo);
                $GLOBALS['log']->fatal('reg', $reg);

                $records = $this->getTotales( $usuarios ,  $equipo );
            }*/
            
            //$GLOBALS['log']->fatal('records2-json', json_encode($records));
            $GLOBALS['log']->fatal('records', $records);
            return $records;
        } catch (Exception $e) {

            $GLOBALS['log']->fatal("Error: " . $e->getMessage());
        }
    }

    public function getTotalesQuery(){
       
        $sugarQuery = new SugarQuery();
        $sugarQuery->select(array('equipo','monto_final_comprometido_c'));
        $sugarQuery->from(BeanFactory::newBean('lev_Backlog'));
        $sugarQuery->where()->equals('estatus_operacion_c', '2');
        $sugarQuery->select()->setCountQuery();
        $sugarQuery->groupByRaw('lev_Backlog.equipo');
        $result = $sugarQuery->execute();
        $d0 = $this->groupArray($result,'equipo', 'equipo');
        //$GLOBALS['log']->fatal('result', $d0);
        $dataFinal = array();
        $x= 0;
        
        foreach($d0 as $val){
            $item=null;
            $montoTotal= 0.0;
            $conteoTotal=0;
            //$GLOBALS['log']->fatal('fl', $val);
            $nameteam = $val['equipo'];
            $dataaux = $val[$nameteam];
            $item['equipo'] = $val['equipo'];
            //$GLOBALS['log']->fatal('item', $item);
            foreach ($dataaux as $key){
                $montoTotal += floatval($key['monto_final_comprometido_c']);
                $conteoTotal += intval($key['record_count']);
            }
            $item['montoTotal'] = $montoTotal;
            $item['conteoTotal'] = $conteoTotal;
            $return[$x]=$item;
            $x++;
        }
        //$GLOBALS['log']->fatal('totales', $return);

        $sugarQuery = new SugarQuery();
        $sugarQuery->select(array('equipo','cliente','etapa_solicitud_c','etapa_c','progreso','monto_final_comprometido_c'));
        $sugarQuery->from(BeanFactory::newBean('lev_Backlog'));
        $sugarQuery->where()->equals('estatus_operacion_c', '2');
        $sugarQuery->select()->setCountQuery();
        $sugarQuery->groupByRaw('lev_Backlog.equipo','lev_Backlog.etapa_solicitud_c');
        $result = $sugarQuery->execute();
        //$GLOBALS['log']->fatal('result', $result);

        $d0 = $this->groupArray($result,'equipo', 'equipo');
        //$GLOBALS['log']->fatal('resultd0', $d0);
        
        $j=0;
        $aux = null;
        foreach($d0 as $val){
            $newitem=null; 
            //$GLOBALS['log']->fatal('fl', $val);
            $nameteam = $val['equipo'];
            $dataaux = $val[$nameteam];
            $newitem['equipo'] = $val['equipo'];
            //$GLOBALS['log']->fatal('item', $item);
            $prospecto=0.0;
            $credito=0.0;
            $rechazada=0.0;
            $sinsc=0.0;
            $consc=0.0;
    
            foreach ($dataaux as $key){
                //$GLOBALS['log']->fatal('record_count',parseInt( $key['record_count']));
                //for ($z = 0; $z < parseInt($key['record_count']) ; $z++) {
                    if($key['etapa_c'] == '1'){
                        if($key['progreso'] == '2'){ $sinsc += (floatval($key['monto_final_comprometido_c']) * floatval($key['record_count'])) ; }
                        if($key['progreso'] == '1'){ $consc += (floatval($key['monto_final_comprometido_c']) * floatval($key['record_count'])) ; }
                    }else{
                        if($key['etapa_c'] == '3' || $key['etapa_c'] == ''){ $prospecto += (floatval($key['monto_final_comprometido_c']) * floatval($key['record_count'])) ;}
                        if($key['etapa_c'] == '4'){ $credito += (floatval($key['monto_final_comprometido_c']) * floatval($key['record_count']));   }
                        if($key['etapa_c'] == '2'){ $rechazada += (floatval($key['monto_final_comprometido_c']) * floatval($key['record_count'])); }
                    }
                //}
            }
            $newitem['total'] = $sinsc + $consc; 
            $newitem['prospecto'] =  $prospecto;
            $newitem['credito'] =  $credito; 
            $newitem['rechazada'] =  $rechazada; 
            $newitem['sinsc'] = $sinsc; 
            $newitem['consc'] = $consc; 
    
            $return1[$j]=$newitem;
            $j++;
            //dato1.total = parseFloat(dato1.sinsc) + parseFloat(dato1.consc); 
            //$busca = array_search($value[$groupkey], $groupcriteria); 
        }
        //$GLOBALS['log']->fatal('d00', $return1);
        $y=0;
        foreach($return1 as $value1){
            $itemf=null;
            foreach($return as $value){
                if($value['equipo'] == $value1['equipo']){
                    $itemf['equipo'] = $value1['equipo'];
                    $itemf['total'] = $value1['total'];
                    $itemf['prospecto'] = $value1['prospecto'];
                    $itemf['credito'] = $value1['credito'];
                    $itemf['rechazada'] = $value1['rechazada'];
                    $itemf['sinsc'] = $value1['sinsc'];
                    $itemf['consc'] = $value1['consc'];
                    $itemf['montoTotal'] = $value['montoTotal'];
                    $itemf['conteoTotal'] = $value['conteoTotal'];
                    $return2[$y]=$itemf;
                    $y++;
                }
            }
        }
        //$GLOBALS['log']->fatal('final', $return2);
        return $return2;
    }

    public function groupArray($array,$groupkey,$newgroup){
        //$GLOBALS['log']->fatal('entro a agrupar '.$groupkey.' '.$newgroup);
        //$GLOBALS['log']->fatal('grouparray ',$array);
        if (count($array)>0){
     	    $keys = array_keys($array[0]);
     	    $removekey = array_search($groupkey, $keys);
            if ($removekey===false)
     		    return array("Clave \"$groupkey\" no existe");
     	    else
     		    unset($keys[$removekey]);

     	    $groupcriteria = array();
     	    $return=array();
     	    foreach($array as $value){
     		    $item=null; 
     		    foreach ($keys as $key){
     			    $item[$key] = $value[$key];
     		    }
     	 	    $busca = array_search($value[$groupkey], $groupcriteria);
                  //$GLOBALS['log']->fatal('grouparray - '.$value[$groupkey]);
                  if ($busca === false){
                    $groupcriteria[]=$value[$groupkey];
                    $return[]=array($groupkey=>$value[$groupkey],$value[$groupkey]=>array());
                    //$return[]=array($groupkey=>$value[$groupkey],$nt=>array());
                    $busca=count($return)-1;
                }
     		    $return[$busca][$value[$groupkey]][]=$item;
                //$return[$busca][$nt][]=$item;
     	    }
     	    return $return;
        }else
     	    return array();
    }
    
}
