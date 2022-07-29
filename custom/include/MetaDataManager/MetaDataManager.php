<?php
/**
 * @author bdekoning@levementum.com
 * @date 10/29/14
 * @brief Custom metadata manager class
 */

require_once('include/MetaDataManager/MetaDataManager.php');

class CustomMetaDataManager extends MetaDataManager {
    const MM_COUNTRIES          = 'countries'; // new metadata
    const MM_STATES             = 'states'; // new metadata
    const MM_MUNICIPALITIES     = 'municipalities'; // new metadata
    const MM_CITIES             = 'cities'; // new metadata
    const MM_POSTALCODES        = 'postalcodes'; // new metadata
    const MM_COLONIAS           = 'colonias'; // new metadata



    /**
     * Mapping of metadata sections to the methods that get the data for that
     * section. If the value of the section index is false, the method will be
     * rebuild{section}Section() and will require the current metadata array as an argument.
     *
     * @var array
     */
    protected $sectionMap = array(
        self::MM_MODULES        => false,
        self::MM_FULLMODULELIST => 'getModuleList',
        self::MM_MODULESINFO    => 'getModulesInfo',
        self::MM_FIELDS         => 'getSugarFields',
        self::MM_LABELS         => 'getStringUrls',
        self::MM_ORDEREDLABELS  => 'getOrderedStringUrls',
        self::MM_VIEWS          => 'getSugarViews',
        self::MM_LAYOUTS        => 'getSugarLayouts',
        self::MM_DATA           => 'getSugarData',
        self::MM_RELATIONSHIPS  => 'getRelationshipData',
        self::MM_CURRENCIES     => 'getSystemCurrencies',
        self::MM_JSSOURCE       => false,
        self::MM_SERVERINFO     => 'getServerInfo',
        self::MM_CONFIG         => 'getConfigs',
        self::MM_LANGUAGES      => 'getAllLanguages',
        self::MM_HIDDENSUBPANELS => 'getHiddenSubpanels',
        self::MM_MODULETABMAP   => 'getModuleTabMap',
        self::MM_LOGOURL        => 'getLogoUrl',
        self::MM_FILTERS        => 'getSugarFilters',

        // new metadata:
        self::MM_COUNTRIES      => 'getSystemCountries',
        self::MM_STATES         => 'getSystemStates',
        self::MM_MUNICIPALITIES => 'getSystemMunicipalities',
        self::MM_CITIES         => 'getSystemCities',
        self::MM_POSTALCODES    => 'getSystemPostalCodes',
        self::MM_COLONIAS       => 'getSystemColonias',

    );

    /**
     * @var array List of metadata keys for values that should be overriden rather than
     * merged client side with existing metadata .
     */
    protected static $defaultOverrides = array(
        'fields',
        'module_list',
        'relationships',
        'currencies',
        'server_info',
        'module_tab_map',
        'hidden_subpanels',
        'config',
        // new metadata
        'countries',
        'states',
        'municipalities',
        'cities',
        'postalcodes',
        'colonias',
    );

    /**
     * Loads the standard private metadata sections. This can be overridden.
     */
    protected function getPrivateSections() {
        return array(
            self::MM_MODULES,
            self::MM_FULLMODULELIST,
            self::MM_MODULESINFO,
            self::MM_HIDDENSUBPANELS,
            self::MM_CURRENCIES,
            self::MM_MODULETABMAP,
            self::MM_FIELDS,
            self::MM_FILTERS,
            self::MM_VIEWS,
            self::MM_LAYOUTS,
            self::MM_DATA,
            self::MM_LABELS,
            self::MM_ORDEREDLABELS,
            self::MM_CONFIG,
            self::MM_RELATIONSHIPS,
            self::MM_JSSOURCE,
            self::MM_SERVERINFO,
            self::MM_LOGOURL,
            self::MM_LANGUAGES,
            self::MM_COUNTRIES,
            self::MM_STATES,
            self::MM_MUNICIPALITIES,
            self::MM_CITIES,
            self::MM_POSTALCODES,
            self::MM_COLONIAS,
            self::MM_OVERRIDEVALUES,
        );
    }

    /**
     * @brief Custom method that retrieves countries on the system.
     * @author bdekoning@levementum.com
     * @return array
     */
    public function getSystemCountries()
    {
        global $db, $current_user;

        $sql_countries = <<<SQL
SELECT id, name, lada, nacionalidad, paraisofiscal,jurisdiccionnocooperativa,codigodelpais,altoriesgo
FROM dire_pais
WHERE deleted = 0
SQL;
        $countries = array();

        $countries_result = $db->query($sql_countries);

        if(!$countries_result) {
            $GLOBALS['log']->fatal(__FILE__ . ':' . __FUNCTION__ . ':' . __LINE__ . " <".$current_user->user_name."> :\n"
            . $db->lastDbError());
        }

        while($country = $db->fetchRow($countries_result)) {
            $countries[$country['id']] = $country;
        }
        return $countries;
    }

    /**
     * @brief Custom method that retrieves geographical states on the system.
     * @author bdekoning@levementum.com
     * @return array
     */
    public function getSystemStates()
    {
        global $db, $current_user;

        $sql_states = <<<SQL
SELECT
  e.id,
  e.name,
  e_p.dire_estado_dire_paisdire_pais_ida pais_id
FROM dire_estado e
LEFT JOIN dire_estado_dire_pais_c e_p ON e.id = e_p.dire_estado_dire_paisdire_estado_idb AND e_p.deleted = 0
WHERE e.deleted = 0
SQL;
        $states = array();

        $states_result = $db->query($sql_states);

        if(!$states_result) {
            $GLOBALS['log']->fatal(__FILE__ . ':' . __FUNCTION__ . ':' . __LINE__ . " <".$current_user->user_name."> :\n"
                . $db->lastDbError());
        }

        while($state = $db->fetchRow($states_result)) {
            $states[$state['id']] = $state;
        }
        return $states;
    }

    /**
     * @brief Custom method that retrieves municipalities in the system.
     * @author bdekoning@levementum.com
     * @return array
     */
    public function getSystemMunicipalities()
    {
        global $db, $current_user;

        $sql_municipalities = <<<SQL
SELECT
  m.id,
  m.name,
  m_e.dire_municipio_dire_estadodire_estado_ida estado_id,
  e_p.dire_estado_dire_paisdire_pais_ida pais_id
FROM
  dire_municipio m
LEFT JOIN dire_municipio_dire_estado_c m_e
  ON m.id = m_e.dire_municipio_dire_estadodire_municipio_idb AND m_e.deleted = 0
LEFT JOIN dire_estado_dire_pais_c e_p
  ON m_e.dire_municipio_dire_estadodire_estado_ida = e_p.dire_estado_dire_paisdire_estado_idb AND e_p.deleted = 0
WHERE m.deleted = 0
SQL;
        $municipalities = array();

        $municipalities_result = $db->query($sql_municipalities);

        if(!$municipalities_result) {
            $GLOBALS['log']->fatal(__FILE__ . ':' . __FUNCTION__ . ':' . __LINE__ . " <".$current_user->user_name."> :\n"
                . $db->lastDbError());
        }

        while($municipality = $db->fetchRow($municipalities_result)) {
            $municipalities[$municipality['id']] = $municipality;
        }
        return $municipalities;
    }

    /**
     * @brief Custom method that retrieves cities in the system.
     * @author bdekoning@levementum.com
     * @return array
     */
    public function getSystemCities()
    {
        global $db, $current_user;

        $sql_cities = <<<SQL
SELECT
	dire_ciudad.id
	, name
	, dire_ciudad_dire_estadodire_estado_ida AS estado_id
	, dire_estado_dire_pais_c.dire_estado_dire_paisdire_pais_ida AS pais_id
FROM
    dire_ciudad_dire_estado_c
INNER JOIN dire_ciudad
        ON (dire_ciudad_dire_estado_c.dire_ciudad_dire_estadodire_ciudad_idb = dire_ciudad.id)
INNER JOIN dire_estado_dire_pais_c
        ON (dire_estado_dire_pais_c.dire_estado_dire_paisdire_estado_idb = dire_ciudad_dire_estado_c.dire_ciudad_dire_estadodire_estado_ida)
 WHERE dire_ciudad.deleted = 0
SQL;
        $cities = array();

        $cities_result = $db->query($sql_cities);

        if(!$cities_result) {
            $GLOBALS['log']->fatal(__FILE__ . ':' . __FUNCTION__ . ':' . __LINE__ . " <".$current_user->user_name."> :\n"
                . $db->lastDbError());
        }

        while($city = $db->fetchRow($cities_result)) {
            $cities[$city['id']] = $city;
        }
        return $cities;
    }

    /**
     * @brief Custom method that retrieves postal codes on the system with associated countries.
     * @author bdekoning@levementum.com
     * @return array
     */
    public function getSystemPostalCodes()
    {
        global $db, $current_user;

        $sql_postalcodes = <<<SQL
               select cp.id, cp.name, dm.id as id_municipio from dire_codigopostal cp
inner join dire_codigopostal_dire_municipio_c cpm
on cpm.dire_codigopostal_dire_municipiodire_codigopostal_idb = cp.id
  inner join dire_municipio dm
  on dm.id = substr(cp.id,1,9)
                WHERE cp.deleted = 0
SQL;
//        $sql_postalcodes = <<<SQL
//                SELECT
//                  id,
//                  name
//                FROM
//                  dire_codigopostal
//                WHERE deleted = 0
//SQL;
        $postalcodes = array();

        $postalcodes_result = $db->query($sql_postalcodes);

        if(!$postalcodes_result) {
            $GLOBALS['log']->fatal(__FILE__ . ':' . __FUNCTION__ . ':' . __LINE__ . " <".$current_user->user_name."> :\n"
                . $db->lastDbError());
        }

        while($postalcode = $db->fetchRow($postalcodes_result)) {
            if(isset($postalcodes[$postalcode['id']])) {
                $postalcode['is_duplicate'] = 1; // flag duplicate records, but still allow them to overwrite existing data
            }
            $postalcodes[$postalcode['id']] = $postalcode;
        }
        return $postalcodes;
    }

    /**
     * @brief Custom method that retrieves Colonias on the system with associated countries.
     * @author bdekoning@levementum.com
     * @return array
     */
    public function getSystemColonias(){
//
//        global $db;
//
//        $sql_records = <<<SQL
//                SELECT
//                      id,
//                      name,
//                      codigo_postal
//                    FROM
//                      dire_colonia
//                    WHERE deleted = 0
//SQL;
//
//        $records_result = $db->query($sql_records);
//
//        if(!$records_result) {
//            $GLOBALS['log']->fatal(__FILE__ . ':' . __FUNCTION__ . ':' . __LINE__ . "\n"
//                    . $db->lastDbError());
//        }
//
//        $records = array();
//        while($row = $db->fetchRow($records_result)) {
//            if(isset($records[$row['id']])) {
//                $row['is_duplicate'] = 1; // flag duplicate records, but still allow them to overwrite existing data
//            }
//            $records[$row['id']] = $row;
//        }
//        return $records;
    }
}