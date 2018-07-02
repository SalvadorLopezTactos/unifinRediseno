<?php
/**
 * Created by Levementum.
 * User: jgarcia@levementum.com
 * Date: 3/31/2016
 * Time: 3:33 PM
 */

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/Sugarpdf/sugarpdf/sugarpdf.pdfmanager.php');
class OpportunitiesSugarpdfPdfmanager extends SugarpdfPdfmanager
{
    public function preDisplay()
    {
        parent::preDisplay();
        $this->getContactosdelCliente();
        $this->getAvalObligadoSolidario();
        $this->getCondicionesFinancieras();
        $this->getCheckBoxesInfo();
    }

    protected function getContactosdelCliente()
    {
         global $db;
        $query = <<<SQL
SELECT rel.id, relaciones.rel_relaciones_accountsaccounts_ida, rel_c.account_id1_c, 'Cobranza' tipodecontacto, rel.puesto FROM rel_relaciones rel
INNER JOIN rel_relaciones_accounts_c relaciones ON relaciones.rel_relaciones_accountsrel_relaciones_idb = rel.id AND relaciones.deleted = 0
INNER JOIN accounts a ON a.id = relaciones.rel_relaciones_accountsaccounts_ida AND a.deleted = 0
INNER JOIN rel_relaciones_cstm rel_c ON rel_c.id_c = rel.id
WHERE a.id = '{$this->bean->account_id}'
AND rel.tipodecontacto LIKE '%Cobranza%'
AND rel.deleted = 0
UNION
SELECT rel.id, relaciones.rel_relaciones_accountsaccounts_ida, rel_c.account_id1_c, 'Promocion' tipodecontacto, rel.puesto FROM rel_relaciones rel
INNER JOIN rel_relaciones_accounts_c relaciones ON relaciones.rel_relaciones_accountsrel_relaciones_idb = rel.id AND relaciones.deleted = 0
INNER JOIN accounts a ON a.id = relaciones.rel_relaciones_accountsaccounts_ida AND a.deleted = 0
INNER JOIN rel_relaciones_cstm rel_c ON rel_c.id_c = rel.id
WHERE a.id = '{$this->bean->account_id}'
AND (rel.tipodecontacto LIKE '%Promocion%'  OR rel.tipodecontacto = '')
AND rel.deleted = 0
Order by tipodecontacto desc
SQL;
        $queryResult = $db->query($query);
        $contactos_promocion = array();
        //$contactos_cobranza = array();
        while($row = $db->fetchByAssoc($queryResult))
        {
            $contacto = BeanFactory::retrieveBean('Accounts', $row['account_id1_c']);
            //$telefono = $db->getOne($query);
            $telefono = $this->getTelefonos($row['account_id1_c']);
            $contacto->fetched_row['telefono'] = $telefono;
            $contacto->fetched_row['puesto'] = $row['puesto'];
            $contacto->fetched_row['tipodecontacto'] = $row['tipodecontacto'];
            $contactos_promocion[] = $contacto->fetched_row;
        }
        /*
         $query = <<<SQL
SELECT rel.id, relaciones.rel_relaciones_accountsaccounts_ida, rel_c.account_id1_c, rel.tipodecontacto, rel.puesto FROM rel_relaciones rel
INNER JOIN rel_relaciones_accounts_c relaciones ON relaciones.rel_relaciones_accountsrel_relaciones_idb = rel.id AND relaciones.deleted = 0
INNER JOIN accounts a ON a.id = relaciones.rel_relaciones_accountsaccounts_ida AND a.deleted = 0
INNER JOIN rel_relaciones_cstm rel_c ON rel_c.id_c = rel.id
WHERE a.id = '{$this->bean->account_id}'
AND (rel.tipodecontacto LIKE '%Promocion%' OR rel.tipodecontacto LIKE '%Cobranza%' OR rel.tipodecontacto = '')
AND rel.deleted = 0
SQL;
        $queryResult = $db->query($query);
        $contactos_promocion = array();
        $contactos_cobranza = array();
         while($row = $db->fetchByAssoc($queryResult))
         {
             $contacto = BeanFactory::retrieveBean('Accounts', $row['account_id1_c']);
             $telefono = $db->getOne($query);
             $telefono = $this->getTelefonos($row['account_id1_c']);
             //$contactoFields = PdfManagerHelper::parseBeanFields($contacto, true);
             $contacto->fetched_row['telefono'] = $telefono;
             $contacto->fetched_row['puesto'] = $row['puesto'];

             $row['tipodecontacto'] = str_replace("^","",$row['tipodecontacto']);
             $tipos = explode(",", $row['tipodecontacto']);

             foreach($tipos as $index => $value){
                 if($value == 'Promocion' || $value == ''){
                     $contactos_promocion[] = $contacto->fetched_row;
                 }

                 if($value == 'Cobranza'){
                     $contactos_cobranza[] = $contacto->fetched_row;
                 }
             }
         }
*/
        $this->ss->assign('contactos_promocion', $contactos_promocion);
        //$this->ss->assign('contactos_cobranza', $contactos_cobranza);
    }

    protected function getAvalObligadoSolidario()
    {
        global $db;
        $query = <<<SQL
SELECT rel.id, relaciones.rel_relaciones_accountsaccounts_ida, rel_c.account_id1_c, rel.relaciones_activas FROM rel_relaciones rel
INNER JOIN rel_relaciones_accounts_c relaciones ON relaciones.rel_relaciones_accountsrel_relaciones_idb = rel.id AND relaciones.deleted = 0
INNER JOIN accounts a ON a.id = relaciones.rel_relaciones_accountsaccounts_ida AND a.deleted = 0
INNER JOIN rel_relaciones_cstm rel_c ON rel_c.id_c = rel.id
WHERE a.id = '{$this->bean->account_id}'
AND (rel.relaciones_activas LIKE '%Aval%' OR rel.relaciones_activas LIKE '%Obligado solidario%')
AND rel.deleted = 0
SQL;
        $queryResult = $db->query($query);
        $contactos_aval = array();
        while($row = $db->fetchByAssoc($queryResult))
        {
            $contacto = BeanFactory::retrieveBean('Accounts', $row['account_id1_c']);
            $telefono = $this->getTelefonos($row['account_id1_c']);
            $contacto->fetched_row['telefono'] = $telefono;

            $row['relaciones_activas'] = str_replace("^","",$row['relaciones_activas']);
            $contacto->fetched_row['relaciones_activas'] = $row['relaciones_activas'];

            if($contacto->fetched_row['tipodepersona_c'] == 'Persona Fisica'){
                $contacto->fetched_row['Tipo_Fisica'] = '<img src="./custom/themes/default/images/PDF-Check.jpg" alt="Check" />';
            }else{
                $contacto->fetched_row['Tipo_Fisica'] = '<img src="./custom/themes/default/images/PDF-Uncheck.jpg" alt="Uncheck" />';
            }

            if($contacto->fetched_row['tipodepersona_c'] != 'Persona Fisica'){
                $contacto->fetched_row['Tipo_Moral'] = '<img src="./custom/themes/default/images/PDF-Check.jpg" alt="Check" />';
            }else{
                $contacto->fetched_row['Tipo_Moral'] = '<img src="./custom/themes/default/images/PDF-Uncheck.jpg" alt="Uncheck" />';
            }
            $contactos_aval[] = $contacto->fetched_row;
        }
        
        $this->ss->assign('contactos_aval', $contactos_aval);
    }

    public function getCondicionesFinancieras(){

         global $db;
         $query = <<<SQL
SELECT * FROM lev_condicionesfinancieras cf
INNER JOIN lev_condicionesfinancieras_opportunities_c co ON co.lev_condic7ff1ncieras_idb = cf.id AND co.deleted = 0
INNER JOIN opportunities o ON o.id = co.lev_condicionesfinancieras_opportunitiesopportunities_ida AND o.deleted = 0
WHERE o.id = '{$this->bean->id}' AND cf.deleted = 0
SQL;

         $queryResult = $db->query($query);
        $condiciones_f = array();
         while($row = $db->fetchByAssoc($queryResult))
         {
             $row['activo_name'] = $this->matchListLabel($row['idactivo'], "idactivo_list");

             if($row['deposito_en_garantia'] == 1){
                 $row['deposito'] = 'YES';
             }else{
                 $row['deposito'] = 'NO';
             }

             if($row['uso_particular'] == 1){
                 $row['particular'] = 'X';
             }else{
                 $row['particular'] = '';
             }

             if($row['uso_empresarial'] == 1){
                 $row['empresarial'] = 'X';
             }else{
                 $row['empresarial'] = '';
             }

             $condiciones_f[] = $row;
         }

        $this->ss->assign('condiciones', $condiciones_f);
    }

    public function getCheckBoxesInfo(){

         global $db;
         $query = <<<SQL
SELECT origendelprospecto_c FROM accounts_cstm ac
INNER JOIN accounts a ON a.id = ac.id_c AND a.deleted = 0
INNER JOIN accounts_opportunities ao ON ao.account_id = a.id AND ao.deleted = 0
INNER JOIN opportunities o ON o.id = ao.opportunity_id AND o.deleted = 0
WHERE ao.opportunity_id = '{$this->bean->id}'
SQL;

         $queryResult = $db->query($query);

        $agencia_distribuidor = '<img src="./custom/themes/default/images/PDF-Uncheck.jpg" alt="Uncheck" />';
        $referenciador = '<img src="./custom/themes/default/images/PDF-Uncheck.jpg" alt="Uncheck" />';
        $prospeccion_propia = '<img src="./custom/themes/default/images/PDF-Uncheck.jpg" alt="Uncheck" />';
        $mercadotecnia = '<img src="./custom/themes/default/images/PDF-Uncheck.jpg" alt="Uncheck" />';
        $director = '<img src="./custom/themes/default/images/PDF-Uncheck.jpg" alt="Uncheck" />';
        $estrategia_planeacion = '<img src="./custom/themes/default/images/PDF-Uncheck.jpg" alt="Uncheck" />';
        $otro = '<img src="./custom/themes/default/images/PDF-Uncheck.jpg" alt="Uncheck" />';

         while($row = $db->fetchByAssoc($queryResult))
         {
             if($row['origendelprospecto_c'] == 'Agencia Distribuidor'){
                 $agencia_distribuidor = '<img src="./custom/themes/default/images/PDF-Check.jpg" alt="Check" />';
             }
             elseif ($row['origendelprospecto_c'] == 'Referenciador'){
                 $referenciador = '<img src="./custom/themes/default/images/PDF-Check.jpg" alt="Check" />';
             }
             elseif($row['origendelprospecto_c'] == 'Prospeccion propia'){
                 $prospeccion_propia = '<img src="./custom/themes/default/images/PDF-Check.jpg" alt="Check" />';
             }
             elseif($row['origendelprospecto_c'] == 'Mercadotecnia'){
                 $mercadotecnia = '<img src="./custom/themes/default/images/PDF-Check.jpg" alt="Check" />';
             }
             elseif($row['origendelprospecto_c'] == 'Director'){
                 $director = '<img src="./custom/themes/default/images/PDF-Check.jpg" alt="Check" />';
             }
             elseif($row['origendelprospecto_c'] == 'Estrategia y planeacion'){
                 $estrategia_planeacion = '<img src="./custom/themes/default/images/PDF-Check.jpg" alt="Check" />';
             }
             else{
                 $otro = '<img src="./custom/themes/default/images/PDF-Check.jpg" alt="Check" />';
             }
         }

        $this->ss->assign('agencia_distribuidor', $agencia_distribuidor);
        $this->ss->assign('referenciador', $referenciador);
        $this->ss->assign('prospeccion_propia', $prospeccion_propia);
        $this->ss->assign('mercadotecnia', $mercadotecnia);
        $this->ss->assign('director', $director);
        $this->ss->assign('estrategia_planeacion', $estrategia_planeacion);
        $this->ss->assign('otro', $otro);


        $query = <<<SQL
SELECT garantia_adicional_c, seguro_contado_c, seguro_financiado_c, pago_referenciador_c
FROM opportunities_cstm
WHERE id_c = '{$this->bean->id}'
SQL;

         $queryResult = $db->query($query);

        $garantia_adicional = '<img src="./custom/themes/default/images/PDF-Uncheck.jpg" alt="Uncheck" />';
        $seguro_contado = '<img src="./custom/themes/default/images/PDF-Uncheck.jpg" alt="Uncheck" />';
        $seguro_financiado = '<img src="./custom/themes/default/images/PDF-Uncheck.jpg" alt="Uncheck" />';

        $no_garantia_adicional = '<img src="./custom/themes/default/images/PDF-Uncheck.jpg" alt="Uncheck" />';

        while ($row = $db->fetchByAssoc($queryResult)) {
            if ($row['garantia_adicional_c'] == 1) {
                $garantia_adicional = '<img src="./custom/themes/default/images/PDF-Check.jpg" alt="Check" />';
            }
            if ($row['seguro_contado_c'] == 1) {
                $seguro_contado = '<img src="./custom/themes/default/images/PDF-Check.jpg" alt="Check" />';
            }
            if ($row['seguro_financiado_c'] == 1) {
                $seguro_financiado = '<img src="./custom/themes/default/images/PDF-Check.jpg" alt="Check" />';
            }

            if ($row['garantia_adicional_c'] == 0) {
                $no_garantia_adicional = '<img src="./custom/themes/default/images/PDF-Check.jpg" alt="Check" />';
            }

            $pago_empresa = '<img src="./custom/themes/default/images/PDF-Uncheck.jpg" alt="Uncheck" />';
            $pago_vendedor = '<img src="./custom/themes/default/images/PDF-Uncheck.jpg" alt="Uncheck" />';

            if ($row['pago_referenciador_c'] == 1) {
                $pago_empresa = '<img src="./custom/themes/default/images/PDF-Check.jpg" alt="Check" />';
            }
            if ($row['pago_referenciador_c'] == 2) {
                $pago_vendedor = '<img src="./custom/themes/default/images/PDF-Check.jpg" alt="Check" />';
            }
        }

        $this->ss->assign('garantia_adicional', $garantia_adicional);
        $this->ss->assign('seguro_contado', $seguro_contado);
        $this->ss->assign('seguro_financiado', $seguro_financiado);

        $this->ss->assign('no_garantia_adicional', $no_garantia_adicional);

        $this->ss->assign('pago_empresa', $pago_empresa);
        $this->ss->assign('pago_vendedor', $pago_vendedor);

        $cliente_nuevo = '<img src="./custom/themes/default/images/PDF-Check.jpg" alt="Check" />';
        $cliente_recurrente = '<img src="./custom/themes/default/images/PDF-Uncheck.jpg" alt="Uncheck" />';
        $query = <<<SQL
SELECT tipo_operacion_c, o.name FROM opportunities_cstm oc
INNER JOIN opportunities o ON o.id = oc.id_c AND o.deleted = 0
INNER JOIN accounts_opportunities ao ON ao.opportunity_id = o.id AND ao.deleted = 0
INNER JOIN accounts a ON a.id = ao.account_id AND a.deleted = 0
WHERE a.id = '{$this->bean->account_id}'
SQL;

        $queryResult = $db->query($query);
        while($row = $db->fetchByAssoc($queryResult))
        {
            if($row['tipo_operacion_c'] == 4){

                $cliente_nuevo = '<img src="./custom/themes/default/images/PDF-Uncheck.jpg" alt="Uncheck" />';
                $cliente_recurrente = '<img src="./custom/themes/default/images/PDF-Check.jpg" alt="Check" />';
            }
        }

        $this->ss->assign('cliente_nuevo', $cliente_nuevo);
        $this->ss->assign('cliente_recurrente', $cliente_recurrente);
    }

    public function  getTelefonos($relatedAcct){

         global $db;
         $query = $query = <<<SQL
SELECT telefono FROM tel_telefonos
INNER JOIN accounts_tel_telefonos_1_c atel ON atel.accounts_tel_telefonos_1tel_telefonos_idb = tel_telefonos.id AND atel.deleted = 0
INNER JOIN accounts a ON a.id = atel.accounts_tel_telefonos_1accounts_ida AND a.deleted = 0
WHERE a.id = "{$relatedAcct}" AND principal = 1 AND tel_telefonos.deleted = 0
SQL;
        $telefono = $db->getOne($query);

        return $telefono;
    }

    public function matchListLabel($db_val, $lista){
        global $app_list_strings;

        $list = array();
        if (isset($app_list_strings[$lista]))
        {
            $list = $app_list_strings[$lista];
        }

        foreach($list as $key=>$value){
            if($key == $db_val){
                $match_val = $value;
            }
        }
        if($match_val != ''){
            return $match_val;
        }else{
            return $db_val;
        }
    }
}
