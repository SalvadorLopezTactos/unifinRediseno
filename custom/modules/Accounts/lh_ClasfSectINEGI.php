<?php

class clase_ClasfSectorialINEGI
{
    function func_ClasfSectorialINEGI($bean, $event, $arguments)
    {
        $GLOBALS['log']->fatal("ACTUALIZA CLASIFICACION SECTORIAL INEGI");
        $idCuenta = $bean->id;
        $actEco = $bean->actividadeconomica_c;
        if (!empty($actEco) && !empty($idCuenta)) {
            $GLOBALS['log']->fatal("INEGI: " . $idCuenta);
			global $db;
			$query = <<<SQL
SELECT * FROM catalogo_clasificacion_sectorial WHERE id_actividad_economica_cnbv = '{$actEco}'
SQL;
			$queryResult = $db->query($query);
			$row = $db->fetchByAssoc($queryResult);
			$bean->subsectoreconomico_c = $row['id_subsector_economico_cnbv'];
			$bean->sectoreconomico_c = $row['id_sector_economico_cnbv'];
			$bean->tct_macro_sector_ddw_c = $row['id_macro_sector_cnbv'];
			$beanINEGI = BeanFactory::retrieveBean('tct02_Resumen', $idCuenta);
			$beanINEGI->inegi_clase_c = $row['id_clase_inegi'];
			$beanINEGI->inegi_subrama_c = $row['id_subrama_inegi'];
			$beanINEGI->inegi_rama_c = $row['id_rama_inegi'];
			$beanINEGI->inegi_subsector_c = $row['id_subsector_inegi'];
			$beanINEGI->inegi_sector_c = $row['id_sector_inegi'];
			$beanINEGI->inegi_macro_c = $row['id_macro_inegi'];
            $beanINEGI->save();
            $GLOBALS['log']->fatal("FINALIZA HOOK CLASIFICACION SECTORIAL ");
        }
    }
}