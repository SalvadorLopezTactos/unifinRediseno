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

        //Query para obtener el número de cuentas y leads ya ordenados deendiendo los contactos relacionados con teléfnos
        $query = "(
            SELECT 
            l.id idRegistro,count(ld.id) total, 'Lead' modulo
            FROM leads l INNER JOIN leads_cstm lc
            ON l.id=lc.id_c
            LEFT JOIN leads_leads_1_c ll
            ON l.id=ll.leads_leads_1leads_ida
            LEFT JOIN leads ld ON ld.id=ll.leads_leads_1leads_idb 
             AND (length(ld.phone_mobile)>=10 or length(ld.phone_home)>=10 or length(ld.phone_work)>=10)
             where lc.oficina_c='{$oficina}' 
             AND l.assigned_user_id='569246c7-da62-4664-ef2a-5628f649537e' -- USUARIO 9 SN GESTOR
             AND l.deleted=0
            group by l.id
            order by count(ld.id) DESC 
            LIMIT 5
            )
            union
            -- QUERY CUENTAS
            (select
            a.id idRegistro, count(distinct ap.id) total, 'Cuenta' modulo
            from accounts a
            inner join accounts_cstm ac on ac.id_c=a.id
            inner join accounts_uni_productos_1_c aup on aup.accounts_uni_productos_1accounts_ida = a.id
            inner join uni_productos p on p.id = aup.accounts_uni_productos_1uni_productos_idb and p.tipo_producto = '1'
            inner join uni_productos_cstm pc on pc.id_c=p.id
            left join rel_relaciones_accounts_1_c ar on ar.rel_relaciones_accounts_1accounts_ida = a.id
            left join rel_relaciones r on r.id = ar.rel_relaciones_accounts_1rel_relaciones_idb
            left join rel_relaciones_cstm rc on rc.id_c=r.id
            left join accounts ap on ap.id = rc.account_id1_c
            left join accounts_tel_telefonos_1_c at on at.accounts_tel_telefonos_1accounts_ida = ap.id
            left join tel_telefonos t on t.id = at.accounts_tel_telefonos_1tel_telefonos_idb
            where
                ac.user_id_c = '569246c7-da62-4664-ef2a-5628f649537e' -- USUARIO 9 SIN GESTOR del producto Leasing
                and a.deleted=0
                and p.tipo_cuenta = '2' -- Tipo Prospecto
                and p.tipo_producto = '1' -- Producto Leasing
                and pc.oficina_c ='{$oficina}'
            group by a.id
            order by count(distinct ap.id) desc
            limit 5
            ) order by total DESC LIMIT 5;";
        
        $result = $db->query($query);
        $pos = 0;
        $array_leads=array();
        $array_beans_leads=array();
        while($row = $db->fetchByAssoc($result)){
            $records['records'][]=$row;
            
        }
        return $records;

    }


}

?>
