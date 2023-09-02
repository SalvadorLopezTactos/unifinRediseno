<?php
/**
 * User: AF
 * Date: 31/09/2023
 * Time: 18:30
 */

class ProspectsCustom extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            //GET
            'POSTProspectsCustom' => array(
                //request type
                'reqType' => 'POST',
                //endpoint path
                'path' => array('ProspectsCustom'),
                //endpoint variables
                'pathVars' => array(''),
                //method to call
                'method' => 'customProspectInsert',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'custom endpoint para extender valdiación sobre servicio nativo Prospects',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),
        );
    }

    /**
     * Method to be used for my customSurvey endpoint
     */
    public function customProspectInsert($api, $args)
    {
        $GLOBALS['log']->fatal('Prospects Custom Endpoint');
        
        //Recupera email
        $email = isset($args['email1']) ? $args['email1'] : '';
        if (empty($email)) {
            require_once 'include/api/SugarApiException.php';
            throw new SugarApiExceptionInvalidParameter("Es necesario enviar un Email");
        }
        
        //Consulta existencia de PO con mismo Email
        $idProspect = '';
        global $db;
        $query="select p.id, e.email_address
          from prospects p
          inner join prospects_cstm pc on pc.id_c=p.id
          inner join email_addr_bean_rel eb on eb.bean_id=p.id and eb.deleted=0
          inner join email_addresses e on e.id = eb.email_address_id and e.deleted=0
          where 
          p.deleted=0 and pc.excluye_campana_c=0 -- Exluye campana sirve para descartar registros cargados por importación masiva para campañas
          and e.email_address='{$email}'
          order by p.date_entered asc
          limit 1;";
        $queryResult = $db->query($query);
        while($row = $db->fetchByAssoc($queryResult)){
             $idProspect = $row['id'];
         }
        
        //Valida existenticia
        if(empty($idProspect)){
            //Genera nuevo bean para Prospects
            $beanProspect = BeanFactory::newBean("Prospects");
            //Generar objeto para respuesta
            $beanResult = [];
            
            //Iterar $args obtenidos y setea bean
            foreach ($args as $clave => $valor) {
                if (!empty($valor)) {
                    $beanProspect->$clave = $valor;
                }
            }
            //Guarda bean y devuelve estructura
            $beanProspect->save();
        }else{
            //Recupera bean existente
            $beanProspect = BeanFactory::retrieveBean('Prospects', $idProspect, array('disable_row_level_security' => true));
        }
        
        //Setear objeto de resultado con valores guardados
        foreach ($beanProspect->column_fields as $elemento) {
            $beanResult[$elemento] = $beanProspect->$elemento;
        }
        
        //Regresa estructura de bean
        return $beanResult;

    }

}

?>
