<?php

class clase_ClasfSectorial
{
    public function func_ClasfSectorial($bean = null, $event = null, $args = null)
    {
        $GLOBALS['log']->fatal("ACTUALIZA CLASF SECTORIAL");
        //Campo custom Clasificacion Sectorial
        $clasfSectorial = $bean->account_clasf_sectorial;
        // $GLOBALS['log']->fatal("ClasfSectorialCustom". print_r($clasfSectorial,true));
        
        if (!empty($clasfSectorial)) {

            foreach ($clasfSectorial as $key => $value) {

                switch ($key) {
                    case "ae":
                        // $GLOBALS['log']->fatal("ID_AE " . print_r($value['id'], true));
                        $bean->actividadeconomica_c = $value['id'];
                        break;
                    case "sse":
                        // $GLOBALS['log']->fatal("ID_SSE " . print_r($value['id'], true));
                        $bean->subsectoreconomico_c = $value['id'];
                        break;
                    case "se":
                        // $GLOBALS['log']->fatal("ID_SE " . print_r($value['id'], true));
                        $bean->sectoreconomico_c = $value['id'];
                        break;
                    case "ms":
                        // $GLOBALS['log']->fatal("ID_MS " . print_r($value['id'], true));
                        $bean->tct_macro_sector_ddw_c = $value['id'];
                        break;                    
                }
            }
        }
    }
}
