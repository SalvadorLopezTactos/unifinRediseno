<?php

class clase_ClasfSectorialINEGI
{
    function func_ClasfSectorialINEGI($bean, $event, $arguments)
    {
        $GLOBALS['log']->fatal("ACTUALIZA CLASIFICACION SECTORIAL INEGI");

        $idCuenta = $bean->id;
        //Campo custom Clasificacion Sectorial
        $clasfSectorial = $bean->account_clasf_sectorial;
        // $GLOBALS['log']->fatal("ClasfSectorialCustom " . print_r($clasfSectorial, true));

        if (!empty($clasfSectorial) && !empty($idCuenta)) {
            // $GLOBALS['log']->fatal("INEGI " . $idCuenta);
            $beanINEGI = BeanFactory::retrieveBean('tct02_Resumen', $idCuenta);
            $beanINEGI->inegi_sector_c = $clasfSectorial['inegi_sector'];
            $beanINEGI->inegi_subsector_c = $clasfSectorial['inegi_subsector'];
            $beanINEGI->inegi_rama_c = $clasfSectorial['inegi_rama'];
            $beanINEGI->inegi_subrama_c = $clasfSectorial['inegi_subrama'];
            $beanINEGI->inegi_clase_c = $clasfSectorial['inegi_clase'];
            $beanINEGI->inegi_descripcion_c = $clasfSectorial['inegi_descripcion'];
            $beanINEGI->save();
            // $GLOBALS['log']->fatal("FINALIZA HOOK CLASIFICACION SECTORIAL ");
        }
    }
}
