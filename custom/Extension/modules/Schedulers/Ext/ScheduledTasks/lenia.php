<?php
	array_push($job_strings, 'lenia');

    function lenia() {
        //ECB 10/08/2022 Actualiza reuniones de Lenia con error
		$telefonos = array();
        $query="select a.id from meetings a, meetings_cstm b where a.id = b.id_c and a.deleted = 0 and a.status = 'Planned' and b.error_lenia_c = 1";
        $results = $GLOBALS['db']->query($query);
        while($row = $GLOBALS['db']->fetchByAssoc($results)) {
			$bean = BeanFactory::retrieveBean('Meetings', $row['id'] ,array('disable_row_level_security' => true));
			$bean->save();
		}
        return true;
    }