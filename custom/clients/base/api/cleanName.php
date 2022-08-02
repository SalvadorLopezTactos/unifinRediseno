<?php
/**
 * Created by Tactos.
 * User: AFlores
 * Date: 23/04/2021
 * Description: API para generar nombre de Lead o Cuenta limpio (clean_name)
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class cleanName extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            //POST
            'POST_cleanName' => array(
                //request type
                'reqType' => 'POST',
                //endpoint path
                'path' => array('getCleanName'),
                //endpoint variables
                'pathVars' => array(),
                //method to call
                'method' => 'getCleanName',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Regresa valor de nombre con implementación de algoritmo de limpieza',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),
        );
    }

    public function getCleanName($api, $args) {
        //$GLOBALS['log']->fatal('getCleanName::Init');
        ############################
        ## Declara atributos para procesamiento
        if(isset($args['names'])){
            $names = $args['names'];
        }else{
            $names="";
        }
        $name = $args['name'];            //Nombre por procesar
        $mode = (empty($names))?'1':'n';  //Modo de procesamiento; 1 sólo nombre, múltiples nombres

        ############################
        ## Procesa petición de limpieza
        //Modo 1
        if ($mode == '1') {
            if(!empty($name)){
                $itemResult = cleanName::makeClearName($name);
            }else{
                $itemResult['error'] = 'Es necesario enviar nombre por procesar';
                $itemResult['status'] = '400';
            }
        } else {
            //Modo N
            $resultList = [];
            for ($item=0; $item < count($names) ; $item++) {
                $name = $names[$item]['name'];
                $itemResult = [];
                if(!empty($name)){
                    $itemResult = cleanName::makeClearName($name);
                }else{
                    //No se identifca nombre
                    $itemResult['error'] = 'Es necesario enviar nombre por procesar';
                    $itemResult['status'] = '400';
                }
                $resultList[] = $itemResult;
            }
        }

        ############################
        ## Devuleve resultado
        $result = ($mode=='1')?$itemResult:$resultList;
        //$GLOBALS['log']->fatal('getCleanName::End');
        return $result;
    }

    public function makeClearName($name) {
        ############################
        ## Procesa petición de limpieza
        $cleanName = $name;
        $error = '';
        $status = '200';
        try {
            //Define excepciones
            $lsExceptions = array(
                array(",", " "),
                array(".", " "),
                array("(", " ("),
                array(")", " )"),
                array(" DE.C.V", " DE C.V."),
                array("DEC.V.", " DE C.V."),
                array(".C.V.", "C.V."),
                array(" ARIAS ", " £ARIAS£ "),
                array(" CASA ", " £CASA£ "),
                array(" ART ", " £ART£ "),
                array(" AR ", " £AR£ "),
                array(" SI ", " £SI£ "),
                array(" SPA ", " £SPA£ "),
                array(" PC ", " £PC£ "),
                array("  ", " "),
                array(" MI P","£MI£P"),
                array("MI Q","£MI£Q"),
                array(" MI R","£MI£R"),
                array(" MI L","£MI£L"),
                array(" MI F","£MI£F"),
                array(" MI C","£MI£C"),
                array(" MI G","£MI£G"),
                array(" MI A","£MI£A")
            );
            //Remplaza caracteres especiales
            $specialChar = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                        'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                        'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                        'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
            $cleanName = strtr( $cleanName, $specialChar );
            //Itera y remplaza excepciones
            for ($index = 0; $index < count($lsExceptions); $index++) {
                $cleanName = str_replace($lsExceptions[$index][0],$lsExceptions[$index][1],$cleanName);
            }
            //Format
            $cleanName = strtoupper($cleanName);

            //Valida expresión regular e identifica match
            $cleanName = preg_replace('((\s)((((B[ ]{0,1})((V)))|((I[ ]{0,1})(((N[ ]{0,1})((C)))))|((P)(( DE | EN | )?)((C)))|(M[ ]{0,1}I)|((I)(( DE | EN | )?)((B[ ]{0,1}P)|(A[ ]{0,1}((S[ ]{0,1}P)|(P)|(S)))))|((F)(( DE | EN | )?)((A)|(C)))|((C[ ]{0,1})((E[ ]{0,1}L)|((POR )?A)))|((A)(( DE | EN | )?)((L(( DE | )?(P[ ]{0,1}R)))|(R(( DE | )?(I[ ]{0,1}C))?)|(B[ ]{0,1}P)|(P(([ ]{0,1}[ELN]))?)|([ACG])))|((U)(( DE | )?)(((S)(( DE | )?(P[ ]{0,1}R)))|(E(([ ]{0,1}C))?)|(C)))|((S[ ]{0,1}O[ ]{0,1}F[ ]{0,1})(((O[ ]{0,1})(([LM](([ ]{0,1}(E[ ]{0,1}(N[ ]{0,1})?R)))?)))|(I[ ]{0,1}P[ ]{0,1}O)))|((S[ ]{0,1}A)(([ ]{0,1}B)|([ ]{0,1}P[ ]{0,1}I)|([ ]{0,1}P[ ]{0,1}I[ ]{0,1}B))?)|((S)((( DE | EN | )?)((I((( DE | EN | )?)((I((( DE | )?(D(( PARA | )?(P[ ]{0,1}M))?))?))|(O[ ]{0,1}L[ ]{0,1})|(R[ ]{0,1}V[ ]{0,1})|(C[ ]{0,1}V)|(R[ ]{0,1}S)|(R[ ]{0,1}[IL])|(C[ ]{0,1}))?))|((C)((( DE | EN | )?)((C[ ]{0,1}V)|(([CP])((( DE | )?((B[ ]{0,1}S)|(S)))|([ ]{0,1}([RC])))?)|(A[ ]{0,1}P)|((POR )?A)|(R[ ]{0,1}[LVS])|(R[ ]{0,1}I)|([SPUL]))?))|(G[ ]{0,1}C)|(N[ ]{0,1}C)|((S[ ]{0,1})(S))|((P)(([ ]{0,1}(A|R)))?)|(L)))))|((S( DE | DE| )?R[ ]{0,1}L)|(DE |DE| )?((R[ ]{0,1}L)|(I[ ]{0,1}P)|(C[ ]{0,1}V)|(R[ ]{0,1}S)|(R[ ]{0,1}I)|(R[ ]{0,1}V)|(O[ ]{0,1}L)|(A[ ]{0,1}R[ ]{0,1}T)|(M[ ]{0,1}I)|((E[ ]{0,1}(N[ ]{0,1})?R)))))(\\b))', "", $cleanName);

            //Itera y revierte excepciones
            for ($index = 0; $index < count($lsExceptions); $index++) {
                if ($lsExceptions[$index][1] != " " && $lsExceptions[$index][0] != "(" && $lsExceptions[$index][0]!=".") {
                    $cleanName = str_replace($lsExceptions[$index][1],$lsExceptions[$index][0],$cleanName);
                }
            }
            $cleanName = preg_replace('!\s+!', ' ', $cleanName);
            $cleanName=trim($cleanName);
            $status = '200';
        } catch (Exception $e) {
            //Error al procesar petición
            $error = $e->getMessage();
            $status = '500';
        }

        ############################
        ## Valida respuesta de salida
        $itemResult = array();
        $itemResult['status'] = $status;
        if (!empty($error)) {
            $itemResult['error'] = $error;
        }else{
            $itemResult['originalName'] = $name;
            $itemResult['cleanName'] = $cleanName;
        }
        return $itemResult;
    }

}
