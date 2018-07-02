<?php
/**
 * @author: CVV
 * @date: 21/04/2017
 * @comments: Rest API to display Beneficiarios list
 */

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class BeneficiariosAPI extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'BaneficiariosAPI' => array(
                'reqType' => 'GET',
                'path' => array('BeneficiariosAPI','getBeneficiarios','?'),
                'pathVars' => array('', '', 'id'),
                'method' => 'getBeneficiariosList',
                'shortHelp' => 'Obtiene la lista de Beneficiarios del cliente',
            ),
        );
    }

    public function getBeneficiariosList($api, $args)
    {
        global $db, $current_user;
        $idCliente = $args['id'];
        try
        {
            $query = <<<SQL
            SELECT relacionado.id GUID, relacionado.name Relacionado
            FROM rel_relaciones_accounts_c rel
              inner join accounts cliente on rel.rel_relaciones_accountsaccounts_ida = cliente.id
              inner join rel_relaciones_cstm rel2 on rel2.id_c=rel.rel_relaciones_accountsrel_relaciones_idb
              INNER JOIN rel_relaciones r ON r.id = rel2.id_c AND r.relaciones_activas LIKE '%^Beneficiario^%'
              inner join accounts relacionado on rel2.account_id1_c = relacionado.id
            where rel.deleted = 0
            and cliente.id = '{$idCliente}';
SQL;

            $Relacionados = $db->query($query);

            while ($row = $db->fetchByAssoc($Relacionados)) {
                $Relacionados_list[] = $row;
            }

            return $Relacionados_list;

        }catch (Exception $e){
            error_log(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error: ".$e->getMessage());
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error ".$e->getMessage());
        }

    }
}