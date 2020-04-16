<?php
class eliminarLeads extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'eliminarLeads' => array(
                'reqType' => 'POST',
                'path' => array('eliminarLeads'),
                'pathVars' => array(''),
                'method' => 'eliminaLeads',
                'shortHelp' => 'Elimina Leads',
            ),
        );
    }

    public function eliminaLeads($api, $args)
    {
        global $db;
        foreach ($args['data']['seleccionados'] as $key => $value) {
          $query = "update leads set deleted = 1 where id = '{$value}'";
          $result = $db->query($query);
        }
		    return $result;
    }
}
