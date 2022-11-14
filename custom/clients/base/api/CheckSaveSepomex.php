<?php

use Sugarcrm\Sugarcrm\Util\Uuid;

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class CheckSaveSepomex extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'checkSaveRecordSepomex' => array(
                'reqType' => 'POST',
                'path' => array('CheckSaveSepomex'),
                'pathVars' => array('endpoint',),
                'method' => 'checkAndSaveSepomex',
                'shortHelp' => 'Método para guardar nuevo registro en tabla de Sepomex solo en caso de que los datos ingresados no existan en dicha tabla',
            ),
        );
    }
    
    public function checkAndSaveSepomex($api, $args)
    {
        global $current_user;
        $response=array();
        $cp=$args['cp'];
        $pais=$args['pais'];
        $labelPais=$args['labelPais'];
        $estado=$args['estado'];
        $labelEstado=$args['labelEstado'];
        $ciudad=$args['ciudad'];
        $labelCiudad=$args['labelCiudad'];
        $municipio=$args['municipio'];
        $labelMunicipio=$args['labelMunicipio'];
        //$colonia=$args['colonia'];
        $labelColonia=$args['labelColonia'];

        $selectSepomex="SELECT id FROM dir_sepomex WHERE codigo_postal='{$cp}' AND id_pais='{$pais}' AND id_estado='{$estado}' AND id_ciudad='{$ciudad}' AND id_municipio='{$municipio}' and colonia='{$labelColonia}'";

        $result=$GLOBALS['db']->query($selectSepomex);

        $GLOBALS['log']->fatal("Num rows: ".$result->num_rows);
        if($result->num_rows>0){
            $response['result']="error";
            $response['msg']="Este código postal ya está registrado con la colonia indicada";
        }else{
            //Inserta registro
            $new_id_sep=Uuid::uuid1();
            $id_user=$current_user->id;
            $current_date=TimeDate::getInstance()->nowDb();
            $name=$labelPais ." ".$cp." ".$labelEstado." ".$labelColonia;//labelPais CP Estado Colonia
            $qinsertRecordSepomex="INSERT INTO `dir_sepomex` (`id`, `name`, `date_entered`, `date_modified`, `modified_user_id`, `created_by`, `deleted`, `pais`, `id_pais`, `codigo_postal`, `estado`, `id_estado`, `ciudad`, `id_ciudad`, `municipio`, `id_municipio`, `colonia`) VALUES ('{$new_id_sep}', '{$name}', '{$current_date}', '{$current_date}', '{$id_user}', '{$id_user}', '0', '{$labelPais}', '{$pais}', '{$cp}', '{$labelEstado}', '{$estado}','{$labelCiudad}', '{$ciudad}', '{$labelMunicipio}', '{$municipio}', '{$labelColonia}');";
            //$GLOBALS['log']->fatal("INSERTANDO SEPOMEX");
            //$GLOBALS['log']->fatal($qinsertRecordSepomex);

            $GLOBALS['db']->query($qinsertRecordSepomex);

            $response["result"]="OK";
            $response["msg"]="La Colonia se ha insertado correctamente";

        }

        return $response;
    }
}