<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetClasfSectorial extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GetClasfSectorialAPI' => array(
                'reqType' => 'GET',
                'noLoginRequired' => false,
                'path' => array('GetClasfSectorial', '?'),
                'pathVars' => array('module', 'id'),
                'method' => 'getClasfSectorialAE',
                'shortHelp' => 'Obtiene los montos de las solicitudes por Grupo Empresarial, suma y obtiene el Total',
            ),
        );
    }
    public function getClasfSectorialAE($api, $args)
    {
        //Recupera $dictionary del vardef del campo indicado
        include("custom/Extension/modules/Accounts/Ext/Vardefs/sugarfield_actividadeconomica_c.php");
        include("custom/Extension/modules/Accounts/Ext/Vardefs/sugarfield_subsectoreconomico_c.php");
        include("custom/Extension/modules/Accounts/Ext/Vardefs/sugarfield_sectoreconomico_c.php");
        include("custom/Extension/modules/Accounts/Ext/Vardefs/sugarfield_tct_macro_sector_ddw_c.php");

        try {

            //Recibe el key de la Actividad Economica
            $idActividadEconomica = $args['id'];
            $GLOBALS['log']->fatal("IDAE " . $idActividadEconomica);

            $result = [];
            $result["combinaciones"] = [];
            $result["ae"] = [];
            $result["ae"]["id"] = "";
            $result["sse"] = [];
            $result["sse"]["id"] = "";
            $result["se"] = [];
            $result["se"]["id"] = "";
            $result["ms"] = [];
            $result["ms"]["id"] = "";

            //Recupera los vardef de cada campo
            $vardefAE = $dictionary['Account']['fields']['actividadeconomica_c']['visibility_grid']['values'];
            $vardefSSE = $dictionary['Account']['fields']['subsectoreconomico_c']['visibility_grid']['values'];
            $vardefSE = $dictionary['Account']['fields']['sectoreconomico_c']['visibility_grid']['values'];


            foreach ($vardefAE as $keyvarae => $subsectecon) {

                foreach ($subsectecon as $keyae => $acteconomica) {

                    if ($idActividadEconomica == $acteconomica) {

                        //Actividad Economica con Subsectoreconomico
                        $result["ae"]["id"] = $acteconomica;
                        $result["sse"]["id"] = $keyvarae;
                        //Posibles combinaciones
                        $result["combinaciones"][$acteconomica][$keyvarae] = [];

                        foreach ($vardefSSE as $keyvarsse => $sectorecon) {

                            foreach ($sectorecon as $keysse => $subsector) {

                                if ($keyvarae == $subsector) {

                                    //Sector Economico
                                    $result["se"]["id"] = $keyvarsse;
                                    //Posibles combinaciones
                                    $result["combinaciones"][$acteconomica][$keyvarae][$keyvarsse] = [];

                                    foreach ($vardefSE as $keyvarse => $macrosector) {

                                        foreach ($macrosector as $keyse => $sectore) {

                                            if ($keyvarsse == $sectore) {

                                                //Macro Sector Economico
                                                $result["ms"]["id"] = $keyvarse;
                                                //Posibles combinaciones
                                                $result["combinaciones"][$acteconomica][$keyvarae][$keyvarsse][] = $keyvarse;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            return $result;

        } catch (Exception $e) {

            $GLOBALS['log']->fatal("Error: " . $e->getMessage());
        }
    }
}
