<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once("clients/base/api/PersonFilterApi.php");

class CustomPersonFilterApi extends PersonFilterApi {

    public function filterList(ServiceBase $api, array $args, $acl = 'list')
    {

        if($args['filter'][0]['$and']!=null){
            //Condición que sirve solo para cuando está definido el filtro default del campo puestousuario_c,
            // se omite condición status $not_equals 'Inactive' para mostrar usuarios tanto Activos como Inactivos
            if($args['filter'][0]['$and'][0]['puestousuario_c']!=null){
                $args['filter'][0]['$and'][1]=$args['filter'][0]['$and'][1]['$and'][1];
            }else{
                //Esta línea sobreescribe el filtro cuando NO se tiene el filtro predefinido del campo puestousuario_c de Agentes Telefónicos
                //y entra cuando se escribe en la caja de texto (sin tener filtro predefinido seleccionado), se está omitiendo la condición
                //status $not_equals 'Inactive' para mostrar usuarios tanto activos como inactivos
                $args['filter'][0]=$args['filter'][0]['$and'][1];
            }

        }

        if (!empty($args['q'])) {
            return $this->globalSearch($api, $args);
        }

        $args['module'] = $args['module_list'];

        $api->action = 'list';
        list($args, $q, $options, $seed) = $this->filterListSetup($api, $args);

        $this->getCustomWhereForModule($args['module_list'], $q);

        return $this->runQuery($api, $args, $q, $options, $seed);
    }
    
    protected function getCustomWhereForModule($module, $query = null) {
        if ($query instanceof SugarQuery) {
            if ($module == 'Employees') {
                $query->where()->equals('employee_status', 'Active')->equals('show_on_employees','1');
                return;
            }
            $query->where()->queryOr()->equals('status', 'Active')->equals('status', 'Inactive')->equals('portal_only', '0');
            return;
        }

        if ($module == 'Employees') {
            return "users.employee_status = 'Active' AND users.show_on_employees = 1";
        }
        
        return "users.status = 'Active' OR users.status = 'Inactive' AND users.portal_only = 0";
    }
}
