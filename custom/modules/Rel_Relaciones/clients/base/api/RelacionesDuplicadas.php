<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
deprecated
 */
class RelacionesDuplicadas extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'POST_obtieneRelacionesDuplicadas' => array(
                'reqType' => 'POST',
                'path' => array('obtieneRelacionesDuplicadas'),
                'pathVars' => array('',''),
                'method' => 'getRelDuplicate',
                'shortHelp' => 'Verifica si tiene relaciones duplicadas',
            ),
        );
    }

    public function getRelDuplicate($api, $args)
    {
        global $current_user;
        try
        {
            global $db, $current_user;
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : ARGS " . print_r($args,true));
            $cliente  = $args['guid_cliente'];
            $relacionado = $args['guid_relacion'];
            $relacion = $args['relacion'];
            $idRel = isset($args['idRel']) ? $args['idRel'] : "";
            $relaciones_previas = $args['previas'];
            $query = <<<SQL
SELECT rl.relaciones_activas
FROM rel_relaciones_accounts_c rel
  inner join accounts_cstm acc on rel.rel_relaciones_accountsaccounts_ida = acc.id_c
  inner join rel_relaciones_cstm Relcontact on Relcontact.id_c = rel.rel_relaciones_accountsrel_relaciones_idb
  INNER JOIN rel_relaciones rl on rl.id = Relcontact.id_c
  inner join accounts_cstm contact on contact.id_c = Relcontact.account_id1_c
where contact.id_c = '{$relacionado}' and acc.id_c = '{$cliente}' and rel.deleted = 0 and rl.id not in ('{$idRel}');

SQL;
            //iteramos sobre el resultado
            $encontrado = [];
            $queryResult = $db->query($query);
            $i=0;
            $j=0;
            while($row = $db->fetchByAssoc($queryResult)){
                $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : ". $i++);
                $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : relaciones activas ".$row['relaciones_activas']);
                $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : relacion  ".$relacion);
                $relaciones = str_replace('^','', $row['relaciones_activas']);
                $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : relaciones ".$relaciones);
                $relaciones = explode(",", $relaciones);
                $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : relaciones ".$relaciones);
                foreach($relaciones as $field => $value){
                    $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : ". $j++);
                    $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : campo a comparar ".$value);
                    if(strstr($relacion,$value)){
                        $encontrado[] = $value;
                    }
                }

            }

            return $encontrado;


        }catch (Exception $e){
            error_log(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error: ".$e->getMessage());
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error ".$e->getMessage());
        }
    }
}
