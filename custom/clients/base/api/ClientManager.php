<?php
/**
 * Created by Salvador Lopez.
 * User: salvador.lopez@tactos.com.mx
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class ClientManager extends SugarApi
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
                'reqType' => 'GET',
                //endpoint path
                'path' => array('GetCMInfoKanban'),
                //endpoint variables
                'pathVars' => array('method'),
                //method to call
                'method' => 'getInfoKanban',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Obtiene información para poblar dashlet con vista Kanban de Client Manager',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),


        );

    }

    public function getInfoKanban($api, $args){
        global $sugar_config,$db,$current_user;
        $id_usuario=$current_user->id;

        $query = <<<SQL
			SELECT lc.nombre_c nombre,
        lc.apellido_paterno_c apellido,
        lc.nombre_empresa_c nombre_empresa,
        lc.tipo_registro_c tipo_registro,
        lc.subtipo_registro_c subtipo_registro,
        l.assigned_user_id,
        l.date_modified 
        FROM leads l INNER JOIN leads_cstm lc
        ON l.id=lc.id_c 
        WHERE lc.tipo_registro_c IN ('1','2','3')
        AND lc.subtipo_registro_c IN('1','2','7')
        AND l.assigned_user_id ='{$id_usuario}'
        AND l.deleted=0
        UNION
        SELECT ac.primernombre_c,
        ac.apellidopaterno_c,
        ac.razonsocial_c,
        ac.tipo_registro_cuenta_c,
        ac.subtipo_registro_cuenta_c,
        a.assigned_user_id,
        a.date_modified
        FROM accounts a INNER JOIN accounts_cstm ac
        ON a.id=ac.id_c
        WHERE ac.tipo_registro_cuenta_c IN ('1','2','3')
        AND ac.subtipo_registro_cuenta_c IN('1','2','7','8','9','11','17')
        AND a.assigned_user_id ='{$id_usuario}'
        AND a.deleted=0;
SQL;

        $result = $db->query($query);

        $registros_sin_contactar=array();
        $total_leads_sin_contactar=0;

        $registros_contactado=array();
        $total_prospecto_contactado=0;

        $registros_interesado=array();
        $total_prospecto_interesado=0;

        $registros_int_expediente=array();
        $total_int_expediente=0;

        $registros_credito=array();
        $total_prospecto_credito=0;

        $registros_cliente_linea_sin_operar=array();
        $total_cliente_linea_sin_operar=0;

        $registros_cliente_activo=array();
        $total_cliente_activo=0;

        $registros_cliente_perdido=array();
        $total_cliente_perdido=0;
        
        while ($row = $db->fetchByAssoc($result)) {
          $tipo=$row['tipo_registro']; 
          $subtipo=$row['subtipo_registro'];
          $nombre=$row['nombre']." ".$row['apellido'];
          $date_modified=$row['date_modified'];
          $nombre_empresa=$row['nombre_empresa'];
            //Lead sin Contactar
            if($tipo=='1' && $subtipo=='1'){
                $total_leads_sin_contactar+=1;
                $array_lead_sin_contactar=array(
                    "Nombre"=>($nombre_empresa=="" || $nombre_empresa==null) ? $nombre:$nombre_empresa,
                    "Dias_Etapa"=>"2",
                    "Favorito"=>1,
                    "Date_Modified"=>$date_modified,
                    "Preview"=>array("Info Preview")
                ); 
                
                $registros_sin_contactar[]=$array_lead_sin_contactar;
            }

            //Prospecto Contactado
            if($tipo=='2' && $subtipo=='2'){
                $total_prospecto_contactado+=1;
                $array_prospecto_contactado=array(
                    "Nombre"=>($nombre_empresa=="" || $nombre_empresa==null) ? $nombre:$nombre_empresa,
                    "Dias_Etapa"=>"2",
                    "Favorito"=>1,
                    "Date_Modified"=>$date_modified,
                    "Preview"=>array("Info Preview")
                ); 
                
                $registros_contactado[]=$array_prospecto_contactado;
            }

            //Prospecto Interesado
            if($tipo=='2' && $subtipo=='7'){
                $total_prospecto_interesado+=1;
                $array_prospecto_interesado=array(
                    "Nombre"=>($nombre_empresa=="" || $nombre_empresa==null) ? $nombre:$nombre_empresa,
                    "Dias_Etapa"=>"2",
                    "Favorito"=>1,
                    "Date_Modified"=>$date_modified,
                    "Preview"=>array("Info Preview")
                ); 
                
                $registros_interesado[]=$array_prospecto_interesado;
            }

            //Prospecto Integración de Expediente
            if($tipo=='2' && $subtipo=='8'){
                $total_int_expediente+=1;
                $array_prospecto_int_expediente=array(
                    "Nombre"=>($nombre_empresa=="" || $nombre_empresa==null) ? $nombre:$nombre_empresa,
                    "Dias_Etapa"=>"2",
                    "Favorito"=>1,
                    "Date_Modified"=>$date_modified,
                    "Preview"=>array("Info Preview")
                ); 
                
                $registros_int_expediente[]=$array_prospecto_int_expediente;
            }

            //Prospecto en Crédito
            if($tipo=='2' && $subtipo=='9'){
                $total_prospecto_credito+=1;
                $array_prospecto_credito=array(
                    "Nombre"=>($nombre_empresa=="" || $nombre_empresa==null) ? $nombre:$nombre_empresa,
                    "Dias_Etapa"=>"2",
                    "Favorito"=>1,
                    "Date_Modified"=>$date_modified,
                    "Preview"=>array("Info Preview")
                ); 
                
                $registros_credito[]=$array_prospecto_credito;
            }

            //Cliente con Línea sin Operar
            /*ToDo: FALTA SABER ID */
            /*
            if($tipo=='2' && $subtipo=='7'){
                $total_prospecto_interesado+=1;
                $array_prospecto_interesado=array(
                    "Nombre"=>($nombre_empresa=="" || $nombre_empresa==null) ? $nombre:$nombre_empresa,
                    "Dias_Etapa"=>"2",
                    "Favorito"=>1,
                    "Date_Modified"=>$date_modified,
                    "Preview"=>array("Info Preview")
                ); 
                
                $registros_interesado[]=$array_prospecto_interesado;
            }
            */

            //Cliente Activo
            if($tipo=='2' && $subtipo=='11'){
                $total_cliente_activo+=1;
                $array_cliente_activo=array(
                    "Nombre"=>($nombre_empresa=="" || $nombre_empresa==null) ? $nombre:$nombre_empresa,
                    "Dias_Etapa"=>"2",
                    "Favorito"=>1,
                    "Date_Modified"=>$date_modified,
                    "Preview"=>array("Info Preview")
                ); 
                
                $registros_cliente_activo[]=$array_cliente_activo;
            }

            //Cliente Perdido
            if($tipo=='2' && $subtipo=='17'){
                $total_cliente_perdido+=1;
                $array_cliente_perdido=array(
                    "Nombre"=>($nombre_empresa=="" || $nombre_empresa==null) ? $nombre:$nombre_empresa,
                    "Dias_Etapa"=>"2",
                    "Favorito"=>1,
                    "Date_Modified"=>$date_modified,
                    "Preview"=>array("Info Preview")
                ); 
                
                $registros_cliente_perdido[]=$array_cliente_perdido;
            }
        }

        $response=array(
            "Lead_Sin_Contactar"=>array(
                "Total_Registros"=>$total_leads_sin_contactar,
                "Total_Monto"=>0,
                "Registros"=>$registros_sin_contactar
            ),
            "Prospecto_Contactado"=>array(
                "Total_Registros"=>$total_prospecto_contactado,
                "Total_Monto"=>0,
                "Registros"=>$registros_contactado
            ),
            "Prospecto_Interesado"=>array(
                "Total_Registros"=>$total_prospecto_interesado,
                "Total_Monto"=>0,
                "Registros"=>$registros_interesado
            ),
            "Prospecto_Integracion_Expediente"=>array(
                "Total_Registros"=>$total_int_expediente,
                "Total_Monto"=>0,
                "Registros"=>$registros_int_expediente
            ),
            "Prospecto_Credito"=>array(
                "Total_Registros"=>$total_prospecto_credito,
                "Total_Monto"=>0,
                "Registros"=>$registros_credito
            ),
            "Cliente_Linea_Sin_Operar"=>array(
                "Total_Registros"=>$total_cliente_linea_sin_operar,
                "Total_Monto"=>0,
                "Registros"=>$registros_cliente_linea_sin_operar
            ),
            "Cliente_Activo"=>array(
                "Total_Registros"=>$total_cliente_activo,
                "Total_Monto"=>0,
                "Registros"=>$registros_cliente_activo
            ),
            "Cliente_Perdido"=>array(
                "Total_Registros"=>$total_cliente_perdido,
                "Total_Monto"=>0,
                "Registros"=>$registros_cliente_perdido
            ),
        );


        /*
        $response=array(
            "Lead_Sin_Contactar"=>array(
                "Total_Registros"=>"180",
                "Total_Monto"=>"20000",
                "Registros"=>array(
                    array(
                        "Nombre"=>"Lead 1",
                        "Dias_Etapa"=>"2",
                        "Favorito"=>1,
                        "Preview"=>array("Info Preview")
                    ),
                    array(
                        "Nombre"=>"Lead 2",
                        "Dias_Etapa"=>"2",
                        "Favorito"=>0,
                        "Preview"=>array("Info Preview")
                    )
                )
            ),
            "Prospecto_Contactado"=>array(
                "Total_Registros"=>"180",
                "Total_Monto"=>"20000",
                "Registros"=>array(
                    array(
                        "Nombre"=>"Lead 1",
                        "Dias_Etapa"=>"2",
                        "Favorito"=>"true",
                        "Preview"=>array("Info Preview")
                    ),
                    array(
                        "Nombre"=>"Lead 2",
                        "Dias_Etapa"=>"2",
                        "Favorito"=>"true",
                        "Preview"=>array("Info Preview")
                    )
                )
            )
            
        );
        */

        return $response;

    }

}

?>
