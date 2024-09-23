<?php
require_once 'include/api/SugarApiException.php';
class Validate_Email
{
    public function existsEmail($bean = null, $event = null, $args = null)
    {
        global $db;
        $id_publico_objetivo = $bean->id;
        $email = $bean->email1;

        $qEmailExists = "SELECT p.id id_po,pc.clean_name_c,e.email_address from prospects p
        inner join prospects_cstm pc on p.id=pc.id_c
        left join email_addr_bean_rel er on er.bean_id = p.id and er.deleted=0
        left join email_addresses e on e.id=er.email_address_id and e.deleted =0
        WHERE e.email_address = '{$email}'";
        
        $queryResultEmail = $db->query($qEmailExists);
        $ids_po = array();
        if ($queryResultEmail->num_rows > 0) {

            while ($row = $GLOBALS['db']->fetchByAssoc($queryResultEmail)) {
                $id_po = $row['id_po'];
                $name_po = $row['clean_name_c'];
                if( $id_po != $id_publico_objetivo ){
                    array_push( $ids_po, array( "id_po" => $id_po,"name_po" => $name_po ) );
                }
            }
        }
        $str_link_po = "";
        if( count($ids_po) > 0 ){
            for ($i=0; $i < count($ids_po); $i++) { 
                $str_link_po .= $ids_po[$i]["name_po"].',';
            }
            
        }
        if($db->getRowCount($queryResultEmail) > 0 && count($ids_po) > 0){
            if( $_SESSION['platform'] == 'base' ){
                throw new SugarApiExceptionInvalidParameter('No se puede guardar el registro. El correo electrónico '.$email.' ya existe en Público Objetivo en los siguientes registros: ' .$str_link_po. ' favor de corregir');
            }
        } 
    }

    public function checkUpdateEmailPO($bean = null, $event = null, $args = null){

        //Corroborar si el email cambió
        if( $bean->fetched_row['email1'] != $bean->email1 ){

            $GLOBALS['log']->fatal('CAMBIÓ EL EMAL DE PROSPECTO');

            $newEmail = $bean->email1;
            
            if( $bean->estatus_po_c == '3' ){ //Si es Convertido, actualizamos sus registros relacionados de Lead y Cuenta

                //Obtenemos id de Lead para actualizarlo
                $idLeadRelacionado = $bean->lead_id;

                if( !empty( $idLeadRelacionado ) ){
                    $GLOBALS['log']->fatal('ACTUALIZANDO EMAIL DE LEAD');
                    //Obtenemos bean de Lead
                    $beanLead = BeanFactory::retrieveBean('Leads', $idLeadRelacionado, array('disable_row_level_security' => true));
                    $beanLead->email1 = $newEmail;

                    $beanLead->save();

                    //Comprobar si el Lead está Convertido, en caso de ser así, se obtiene la cuenta y a la cuenta se le actualiza el email
                    $statusLead = $beanLead->subtipo_registro_c;

                    if( $statusLead == '4' ){ //Convertido
                        //  Obtenemos id de la cuenta relacionada
                        $idCuentaRelacionada = $beanLead->account_id;

                        if( !empty( $idCuentaRelacionada ) ){
                            $GLOBALS['log']->fatal('ACTUALIZANDO EMAIL DE CUENTA');
                            $beanCuentaRelacionada = BeanFactory::retrieveBean('Accounts', $idCuentaRelacionada, array('disable_row_level_security' => true));
                            $beanCuentaRelacionada->email1 = $newEmail;

                            $beanCuentaRelacionada->save();

                        }else{
                            $GLOBALS['log']->fatal('NO HAY UNA CUENTA RELACIONADA');
                        }

                    }

                }else{
                    $GLOBALS['log']->fatal('NO HAY UN LEAD RELACIONADO');
                }


            }


        }



    }
}
