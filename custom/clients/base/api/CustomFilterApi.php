<?php
/**
 * Created by Levementum.
 * User: jgarcia@levementum.com
 * Date: 3/23/2017
 * Time: 11:10 AM
 */

require_once('clients/base/api/FilterApi.php');
class CustomFilterApi extends FilterApi
{
    public function registerApiRest()
    {
        //in case we want to add additional endpoints
        return parent::registerApiRest();
    }

    public function filterListSetup(ServiceBase $api, array $args, $acl = 'list')
    {

        if ($args['module'] != "Accounts") {
            return parent::filterListSetup($api,  $args, $acl);
        }

        $seed = BeanFactory::newBean($args['module']);

        if (!$seed->ACLAccess($acl)) {
            throw new SugarApiExceptionNotAuthorized('No access to view records for module: ' . $args['module']);
        }

        $options = $this->parseArguments($api, $args, $seed);

        // In case the view parameter is set, reflect those fields in the
        // fields argument as well so formatBean only takes those fields
        // into account instead of every bean property.
        if (!empty($args['view'])) {
            $args['fields'] = $options['select'];
        }

        $q = self::getQueryObject($seed, $options);

        // return $args['filter'];
        if (!isset($args['filter']) || !is_array($args['filter'])) {
            $args['filter'] = array();
        }
        static::addFilters($args['filter'], $q->where(), $q);

        if (!empty($args['my_items'])) {
            static::addOwnerFilter($q, $q->where(), '_this');
        }

        if (!empty($args['favorites'])) {
            self::$isFavorite = true;
            static::addFavoriteFilter($q, $q->where(), '_this', 'INNER');
        }


        return array($args, $q, $options, $seed);
    }

    protected static function addFilters(array $filterDefs, SugarQuery_Builder_Where $where, SugarQuery $q) {
        static $sfh;
        if (!isset($sfh)) {
            $sfh = new SugarFieldHandler();
        }

        foreach ($filterDefs as $filterDef) {
            if (!is_array($filterDef)) {
                throw new SugarApiExceptionInvalidParameter(
                    sprintf(
                        'Did not recognize the definition: %s',
                        print_r($filterDef, true)
                    )
                );
            }


            foreach ($filterDef as $field => $filter) {

                if ($field == '$or') {
                    static::addFilters($filter, $where->queryOr(), $q);
                } elseif ($field == '$and') {
                    static::addFilters($filter, $where->queryAnd(), $q);
                } elseif ($field == '$favorite') {
                    static::addFavoriteFilter($q, $where, $filter);
                } elseif ($field == '$owner') {
                    static::addOwnerFilter($q, $where, $filter);
                } elseif ($field == '$creator') {
                    static::addCreatorFilter($q, $where, $filter);
                } elseif ($field == '$tracker') {
                    static::addTrackerFilter($q, $where, $filter);
                } elseif ($field == '$following') {
                    static::addFollowFilter($q, $where, $filter);
                }elseif ($field == 'unifin_team') {
                    static::unifinTeam($q, $where, $filterDefs);
                } else {
                    // Looks like just a normal field, parse it's options
                    $fieldInfo = self::verifyField($q, $field);

                    //If the field was a related field and we added a join, we need to adjust the table name used
                    //to get the right join table alias
                    if (!empty($fieldInfo['field'])) {
                        $field = $fieldInfo['field'];
                    }
                    $fieldType = !empty($fieldInfo['def']['custom_type']) ? $fieldInfo['def']['custom_type'] : $fieldInfo['def']['type'];
                    $sugarField = $sfh->getSugarField($fieldType);
                    if (!is_array($filter)) {
                        $value = $filter;
                        $filter = array();
                        $filter['$equals'] = $value;
                    }

                    foreach ($filter as $op => $value) {
                        /*
                         * occasionally fields may need to be fixed up for the Filter, for instance if you are
                         * doing an operation on a datetime field and only send in a date, we need to fix that field to
                         * be a dateTime then unFormat it so that its in GMT ready for DB use
                         */
                        if ($sugarField->fixForFilter($value, $field, $fieldInfo['bean'], $q, $where, $op) == false) {
                            continue;
                        }

                        if (is_array($value)) {
                            foreach ($value as $i => $val) {
                                // TODO: apiUnformat() is deprecated, this will change to apiUnformatField() in next API version
                                $value[$i] = $sugarField->apiUnformat($val);
                            }
                        } else {
                            // TODO: apiUnformat() is deprecated, this will change to apiUnformatField() in next API version
                            $value = $sugarField->apiUnformat($value);
                        }

                        switch ($op) {
                            case '$equals':
                                $where->equals($field, $value);
                                break;
                            case '$not_equals':
                                $where->notEquals($field, $value);
                                break;
                            case '$starts':
                                $where->starts($field, $value);
                                break;
                            case '$ends':
                                $where->ends($field, $value);
                                break;
                            case '$contains':
                                $where->contains($field, $value);
                                break;
                            case '$not_contains':
                                $where->notContains($field, $value);
                                break;
                            case '$in':
                                if (!is_array($value)) {
                                    throw new SugarApiExceptionInvalidParameter('$in requires an array');
                                }
                                $where->in($field, $value);
                                break;
                            case '$not_in':
                                if (!is_array($value)) {
                                    throw new SugarApiExceptionInvalidParameter('$not_in requires an array');
                                }
                                $where->notIn($field, $value);
                                break;
                            case '$dateBetween':
                            case '$between':
                                if (!is_array($value) || count($value) != 2) {
                                    throw new SugarApiExceptionInvalidParameter(
                                        '$between requires an array with two values.'
                                    );
                                }
                                $where->between($field, $value[0], $value[1]);
                                break;
                            case '$is_null':
                                $where->isNull($field);
                                break;
                            case '$not_null':
                                $where->notNull($field);
                                break;
                            case '$empty':
                                $where->isEmpty($field);
                                break;
                            case '$not_empty':
                                $where->isNotEmpty($field);
                                break;
                            case '$lt':
                                $where->lt($field, $value);
                                break;
                            case '$lte':
                                $where->lte($field, $value);
                                break;
                            case '$gt':
                                $where->gt($field, $value);
                                break;
                            case '$gte':
                                $where->gte($field, $value);
                                break;
                            case '$dateRange':
                                $where->dateRange($field, $value, $fieldInfo['bean']);
                                break;
                            default:
                                throw new SugarApiExceptionInvalidParameter("Did not recognize the operand: " . $op);
                        }
                    }
                }
            }
        }
    }

    protected static  function unifinTeam(SugarQuery $q, SugarQuery_Builder_Where $where, $filter){

        global $db;
        $opciones = "";
        foreach($filter[0][unifin_team] as $key => $values){
            foreach($values as $index => $value){
                if($index == 0){
                    $opciones = "equipos_c LIKE " . "'%".$value."%'";
                }else{
                    $opciones .= " OR equipos_c LIKE " . "'%".$value."%'";
                }
            }
        }

        $query = <<<SQL
SELECT id FROM users_cstm uc
INNER JOIN users u ON u.id = uc.id_c AND u.deleted = 0
WHERE {$opciones}
SQL;

        $queryResult = $db->query($query);
        while($row = $db->fetchByAssoc($queryResult))
        {
            $usuarios_en_equipo[] = $row['id'];
        }

        if(count($usuarios_en_equipo) <= 1){
            $usuarios_en_equipo = "'" . implode("", $usuarios_en_equipo). "'";
        }else{
            $usuarios_en_equipo = "'" . implode("','", $usuarios_en_equipo). "'";
        }

        if (get_class($q->from) == 'Account')
        {
            $fromAlias = $q->getFromAlias();
            $str = "( accounts_cstm.user_id_c IN ({$usuarios_en_equipo}) OR accounts_cstm.user_id1_c IN ({$usuarios_en_equipo}) OR accounts_cstm.user_id2_c IN ({$usuarios_en_equipo}) )";

            if(isset($filter[1]['name']['$starts'])){
                $str .= " and {$fromAlias}.name LIKE " . "'%" . $filter[1]['name']['$starts'] . "%'";
            }

            $q->where()->addRaw($str);
        }
    }
}