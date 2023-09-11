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
        if($db->getRowCount($queryResultEmail) > 0 && count($ids_po) > 0) throw new SugarApiExceptionInvalidParameter('No se puede guardar el registro. El correo electrónico '.$email.' ya existe en Público Objetivo en los siguientes registros: ' .$str_link_po. ' favor de corregir'); 
    }
}
