<?php
/**
 * Created by Salvador Lopez.
  */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class FilterLeadsToProtocoloDB extends SugarApi
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
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('FilterLeadsToDB','?'),
                //endpoint variables
                'pathVars' => array('method','oficina'),
                //method to call
                'method' => 'getLeadsFromFilterDB',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método que obtiene registros de Leads disponibles para reasignación automática por Base de Datos desde Protocolo de reasignación',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),

        );

    }

    public function getLeadsFromFilterDB($api, $args)
    {
        global $db;
        //$nombre_archivo=$args['nombre_archivo'];
        $oficina=$args['oficina'];
        $records = array('records' => array());

        //Query para obtener el número de leads asignados al usuario actual
        $query = "SELECT l.id FROM leads l INNER JOIN leads_cstm lc
        ON l.id=lc.id_c
        WHERE oficina_c='{$oficina}' and l.deleted=0 order by l.date_modified DESC LIMIT 5;";
        
        $result = $db->query($query);
        $pos = 0;
        $array_leads=array();
        $array_beans_leads=array();
        while($row = $db->fetchByAssoc($result)){
            //De cada lead encontrado, se obtienen sus Contactos Asociados
            //array('id'=>"1234","tipo"=>"lead","nombre"=>"LEAD 1", "relacionados"=>23,"ventas"=>34000),
            $idLead="";
            $nombreLead="";
            $numeroRelacionados=0;
            $relacionadoValido=false;
            
            $beanLead = BeanFactory::getBean('Leads', $row['id'],array('disable_row_level_security' => true));
            if(!empty($beanLead)){
                if ($beanLead->load_relationship('leads_leads_1')) {
                    $contactosRelacionados = $beanLead->leads_leads_1->get();
                    $idLead=$beanLead->id;
                    $nombreLead="";

                    if($beanLead->regimen_fiscal_c!="3"){
                        $nombreLead=$beanLead->nombre_c." ".$beanLead->apellido_paterno_c;
                    }else{
                        $nombreLead=$beanLead->nombre_empresa_c;
                    }

                    $numeroContactosRelacionados=count($contactosRelacionados);
                    if($numeroContactosRelacionados>0){
                        
                        $GLOBALS['log']->fatal($nombreLead." tiene ".$numeroContactosRelacionados);
    
                        //Se obtiene definición de cada contacto relacionado saber si cuenta con teléfonos de contacto,
                        //los cuales tienen mayor prioridad en la asignación
                        for ($i=0; $i < $numeroContactosRelacionados; $i++) {
                            //Obtiene teléfonos de cada contacto relacionado
                            $beanRelacionado = BeanFactory::getBean('Leads', $contactosRelacionados[$i],array('disable_row_level_security' => true));
                            $GLOBALS['log']->fatal("MOBILE ".$beanRelacionado->phone_mobile);
                            $GLOBALS['log']->fatal("HOME ".$beanRelacionado->phone_home);
                            $GLOBALS['log']->fatal("WORK ".$beanRelacionado->phone_work);
                            if($beanRelacionado->phone_mobile != "" || $beanRelacionado->phone_home != "" || $beanRelacionado->phone_work !=""){
                                $array_beans_leads[]=array('id'=>$idLead,"tipo"=>"lead","nombre"=>$nombreLead, "relacionados"=>$numeroContactosRelacionados);;
                                //Se establece $i para terminar con el ciclo for
                                $i=$numeroContactosRelacionados;
                            }else{
                                //Condición para comprobar si ya llegó al último contacto relacionado y éste no tiene teléfonos de contacto
                                //relacionados se establece en 0 ya que ningún contacto cuenta con teléfonos relacionados
                                if($i==$numeroContactosRelacionados-1){
                                    $array_beans_leads[]=array('id'=>$idLead,"tipo"=>"lead","nombre"=>$nombreLead, "relacionados"=>0);;

                                }
                            }
                        }

                    }else{
                        $array_beans_leads[]=array('id'=>$idLead,"tipo"=>"lead","nombre"=>$nombreLead, "relacionados"=>0);;
                    }
                    
                }
            }
            
            //$records['records'][]= $array_leads;
            //$records['records'][]= array('id'=>$idLead,"tipo"=>"lead","nombre"=>$nombreLead, "relacionados"=>$numeroRelacionados);
            //$pos++;
        }

        //Se ordenan los leads dependiendo la cantidad de contactos relacionados
        $conRel = array();
        foreach ($array_beans_leads as $key => $row){
            $conRel[$key] = $row['relacionados'];
        }
        array_multisort($conRel, SORT_DESC, $array_beans_leads);
        

        $records['records']=$array_beans_leads;

        $GLOBALS['log']->fatal(print_r($array_beans_leads,true));

        return $records;

    }


}

?>
