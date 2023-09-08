<?php
require_once 'include/api/SugarApiException.php';
class Validate_Email
{
    public function existsEmail($bean = null, $event = null, $args = null)
    {
        global $db;
        $email = $bean->email1;

        $qEmailExists = "SELECT p.id,pc.clean_name_c,e.email_address from prospects p
        inner join prospects_cstm pc on p.id=pc.id_c
        left join email_addr_bean_rel er on er.bean_id = p.id and er.deleted=0
        left join email_addresses e on e.id=er.email_address_id and e.deleted =0
        WHERE e.email_address = '{$email}'";
        
        $queryResultEmail = $db->query($qEmailExists);
        if($db->getRowCount($queryResultEmail) > 0) throw new SugarApiExceptionInvalidParameter('No se puede guardar el registro. El correo electrónico '.$email.' ya exite en Público Objetivo, favor de corregir'); 
    }
}
