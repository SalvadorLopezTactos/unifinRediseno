<?php
/**
 * Created by PhpStorm.
 * User: salvadorlopez
 * Date: 07/08/18
 * Time: 10:07
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class UpdateLeadFromProtocoloDB extends SugarApi
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
                'path' => array('UpdateLeadFromProtocolo','?','?','?'),
                //endpoint variables
                'pathVars' => array('method','id_lead','id_usuario','modulo'),
                //method to call
                'method' => 'updateLeadFromProtocoloMethod',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método que actualiza registro de Lead a través de Protocolo con la opción de Base de Datos',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),


        );

    }

    public function updateLeadFromProtocoloMethod($api, $args)
    {
        global $db;
        $id_lead=$args['id_lead'];
        $id_usuario=$args['id_usuario'];
        $modulo=$args['modulo'];
        $GLOBALS['log']->fatal('---------Módulo para reasignación-----------');
        $GLOBALS['log']->fatal($modulo);
        $GLOBALS['log']->fatal($id_lead);


        $arreglo_response=array();

        if($modulo=="Lead"){
            //Obtiene información del usuario para establecer correctamente los campos de equipos para que éste tenga permiso de verlo
            $queryUser = "SELECT default_team,team_set_id FROM users WHERE id='{$id_usuario}'";
            $resultUser = $db->query($queryUser);
            $team_id="";
            $team_set_id="";
            while($row = $db->fetchByAssoc($resultUser)){
                $team_id=$row['default_team'];
                $team_set_id=$row['team_set_id'];
            }
            
            //$queryAsignado = "UPDATE leads SET assigned_user_id='{$id_usuario}',team_id='{$team_id}',team_set_id='{$team_set_id}' WHERE id='{$id_lead}'";
            //$result = $db->query($queryAsignado);
            $beanLeadReasignado=BeanFactory::retrieveBean('Leads',$id_lead,array('disable_row_level_security' => true));
            $beanLeadReasignado->assigned_user_id=$id_usuario;
            $beanLeadReasignado->team_id=$team_id;
            $beanLeadReasignado->team_set_id=$team_set_id;
            $beanLeadReasignado->fecha_asignacion_c=date('Y-m-d');
            $beanLeadReasignado->metodo_asignacion_lm_c='3'; //Metodo de asignacion LM - 3.- Asignación Automática
            $beanLeadReasignado->save();
            
            
            //Reasignar también los "Contactos asociados" para que el usuario tenga permiso de verlos
            $queryGetContactosAsociados="SELECT leads_leads_1leads_idb FROM leads_leads_1_c 
            WHERE leads_leads_1leads_ida='{$id_lead}'
            and deleted=0";
            $resultGetContactos=$db->query($queryGetContactosAsociados);

            if( $resultGetContactos->num_rows > 0 ){
                while($row = $db->fetchByAssoc($resultGetContactos)){
                    $idContactoRelacionado=$row['leads_leads_1leads_idb'];
                    $GLOBALS['log']->fatal("CONTACTO RELACIONADO: ".$idContactoRelacionado);
                    if($idContactoRelacionado!=""){
                        $beanLeadReasignadoRel=BeanFactory::retrieveBean('Leads',$idContactoRelacionado,array('disable_row_level_security' => true));
                        if($beanLeadReasignadoRel!=null){
                            $beanLeadReasignadoRel->assigned_user_id=$id_usuario;
                            $beanLeadReasignadoRel->team_id=$team_id;
                            $beanLeadReasignadoRel->team_set_id=$team_set_id;
                            $beanLeadReasignadoRel->fecha_asignacion_c=date('Y-m-d');
                            $beanLeadReasignadoRel->metodo_asignacion_lm_c='3'; //Metodo de asignacion LM - 3.- Asignación Automática
                            $beanLeadReasignadoRel->save();
                        }
                        

                    }
                    //Query de actualizacón para los contactos asociados
                    //$queryContactoAsignado = "UPDATE leads SET assigned_user_id='{$id_usuario}',team_id='{$team_id}',team_set_id='{$team_set_id}' WHERE id='{$idContactoRelacionado}'";

                    //$GLOBALS['log']->fatal('---------QUERY ACTUALIZACION CONTACTOS ASOCIADOS-----------');
                    //$GLOBALS['log']->fatal($queryContactoAsignado);

                    //$resultNuevoAsignadoContacto = $db->query($queryContactoAsignado);

                    
                }
            }
            
            //Query para regresar información del lead actualizado y poder manipularlo desde el js de protocolo
            $queryLead = "SELECT id_c,name_c FROM leads_cstm WHERE id_c='{$id_lead}'";
            
            $resultLead = $db->query($queryLead);
            
            while($row = $db->fetchByAssoc($resultLead)){
                $GLOBALS['log']->fatal('---------QUERY LEAD-----------');
                $GLOBALS['log']->fatal($row['name_c']);

                $arreglo_response['id']=$row['id_c'];
                $arreglo_response['name']=$row['name_c'];
            }

        }else{// Cuando el registro a reasignar pertenece al módulo de Cuentas

            //Obtiene información del usuario para establecer correctamente los campos de equipos para que éste tenga permiso de verlo
            $queryUser = "SELECT default_team,team_set_id FROM users WHERE id='{$id_usuario}'";
            $resultUser = $db->query($queryUser);
            $team_id="";
            $team_set_id="";
            while($row = $db->fetchByAssoc($resultUser)){
                $team_id=$row['default_team'];
                $team_set_id=$row['team_set_id'];
            }

            //Actualizando el Usuario del producto leasing de la Cuenta
            $queryAsignado = "UPDATE accounts_cstm SET user_id_c='{$id_usuario}' WHERE id_c='{$id_lead}'";
            $resultAsignadoCstm = $db->query($queryAsignado);

            //Actualizando los equipos de la cuenta para que el nuevo usuario reasignado pueda ver el registro
            $queryTeams = "UPDATE accounts SET team_id='{$team_id}',team_set_id='{$team_set_id}' WHERE id='{$id_lead}'";
            $resultAsignado = $db->query($queryAsignado);

            /*Sección para reasignar el producto leasing de la Cuenta*/
            //Query para obtener el id del producto y poderle reasignar el nuevo usuario
            $queryProd = "SELECT p.id idProducto FROM accounts a
            INNER JOIN accounts_uni_productos_1_c ap on ap.accounts_uni_productos_1accounts_ida=a.id
            INNER JOIN uni_productos p on p.id = ap.accounts_uni_productos_1uni_productos_idb
            WHERE p.tipo_producto=1 and a.id='{$id_lead}'";
            $resultProd = $db->query($queryProd);
            $idProducto="";
            while($row = $db->fetchByAssoc($resultProd)){
                $idProducto=$row['idProducto'];
            }

            //Actualizando información del uni_producto con el nuevo usuario
            $queryAsignadoProd = "UPDATE uni_productos p INNER JOIN uni_productos_cstm pc ON p.id=pc.id_c
            SET assigned_user_id='{$id_usuario}',team_id='{$team_id}',team_set_id='{$team_set_id}',metodo_asignacion_lm_c=3,fecha_asignacion_c=CURDATE()
            WHERE id='{$idProducto}'";
            $rProd = $db->query($queryAsignadoProd);

            /* Sección para obtener las relaciones de la cuenta reasignada*/
            $queryGetRelaciones="SELECT rel_relaciones_accounts_1rel_relaciones_idb FROM rel_relaciones_accounts_1_c
            WHERE rel_relaciones_accounts_1accounts_ida='{$id_lead}'
            AND deleted=0";
            $resultGetRelaciones=$db->query($queryGetRelaciones);

            if( $resultGetRelaciones->num_rows > 0 ){
                while($row = $db->fetchByAssoc($resultGetRelaciones)){
                    $idRelacion=$row['rel_relaciones_accounts_1rel_relaciones_idb'];
                    //Query de actualizacón para las relaciones
                    $queryRelacion = "UPDATE rel_relaciones SET assigned_user_id='{$id_usuario}',team_id='{$team_id}',team_set_id='{$team_set_id}' WHERE id='{$idRelacion}'";

                    $GLOBALS['log']->fatal('---------QUERY ACTUALIZACION REL RELACION-----------');
                    $GLOBALS['log']->fatal($queryRelacion);

                    $resultNuevoAsignadoRelacion = $db->query($queryRelacion);
                }
            }


            //Query para regresar información de la cuenta actualizada y poder manipularlo desde el js de protocolo
            $queryAccount = "SELECT id_c,primernombre_c,apellidopaterno_c,razonsocial_c,tipodepersona_c FROM accounts_cstm WHERE id_c='{$id_lead}'";
            
            $resultAcc = $db->query($queryAccount);
            
            while($row = $db->fetchByAssoc($resultAcc)){
                $GLOBALS['log']->fatal('---------QUERY ACCOUNT-----------');
                $GLOBALS['log']->fatal($row['tipodepersona_c']);

                $GLOBALS['log']->fatal($row['primernombre_c']);
                $GLOBALS['log']->fatal($row['apellidopaterno_c']);
                $GLOBALS['log']->fatal($row['razonsocial_c']);

                $nombre="";
                if($row['tipodepersona_c']!='Persona Moral'){
                    $nombre=$row['primernombre_c']." ".$row['apellidopaterno_c'];
                }else{
                    $nombre=$row['razonsocial_c'];
                }

                $GLOBALS['log']->fatal("Nombre: ".$nombre);

                $arreglo_response['id']=$row['id_c'];
                $arreglo_response['name']=$nombre;
            }

        }

        return $arreglo_response;

    }


}

?>
