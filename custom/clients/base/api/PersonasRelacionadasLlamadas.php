<?php
/**
 * Created by PhpStorm.
 * User: salvadorlopez
 * Date: 01/04/18
 * Time: 16:46
 */

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class PersonasRelacionadasLlamadas extends SugarApi
{
    /**
     * Registro de todas las rutas para consumir los servicios del API
     *
     */
    public function registerApiRest()
    {
        return array(
            'retrieve' => array(
                //request type
                'reqType' => 'GET',
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('PersonasRelacionadas', '?'),
                //endpoint variables
                'pathVars' => array('module', 'record'),
                //method to call
                'method' => 'getRelatedPersonsCall',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método GET para obtener personas relacionadas (Personas-Rel_Relaciones)',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),
        );
    }

    /**
     * Obtiene Personas relacionadas a la Persona relacionada a una llamada
     *
     * Método que obtiene los registros de Personas que cuentan con un registro de Tipo Rel_Relaciones con la Persona
     * asignada a una llamada
     *
     * @param array $api
     * @param array $args Array con los par�metros enviados para su procesamiento
     * @return array Personas Relacionadas
     * @throws SugarApiExceptionInvalidParameter
     */
    public function getRelatedPersonsCall($api, $args)
    {
        //Obtiene id de persona
        $idPersona=$args['record'];

        //Define arreglo de salida
        $records_in= array('records'=>array());

        if (!empty($idPersona) && $idPersona!=""){
            //Recupera Relaciones-Personas
            $query = "select distinct rel.rel_relaciones_accounts_1accounts_ida as idPersonaPrincipal from rel_relaciones_accounts_1_c rel
                where rel.rel_relaciones_accounts_1rel_relaciones_idb in (
                            select rc.id_c from rel_relaciones_cstm rc
                            join rel_relaciones r on rc.id_c = r.id
                            where rc.account_id1_c='{$idPersona}'
                            and r.deleted=0
                          )
                and rel.deleted = 0
                order by rel.date_modified desc
                ;";

            $resultQ = $GLOBALS['db']->query($query);
            $personaProcesada = false;

            //Recupera detalle de Personas
            while ($row = $GLOBALS['db']->fetchByAssoc($resultQ)) {
                //Recupera Relacione y procesa
                $beanPersona = BeanFactory::getBean("Accounts", $row['idPersonaPrincipal']);

                //Genera arreglo de salida
                $account = array(
                    "name"=>$beanPersona->name,
                    "id"=>$beanPersona->id,
                    "apellidopaterno_c"=>$beanPersona->apellidopaterno_c,
                    "tipo_registro_c"=>$beanPersona->tipo_registro_c
                );

                $records_in['records'][]=$account;

                //Valida personaProcesada
                if($idPersona == $beanPersona->id){
                    $personaProcesada = true;
                }
            }

            if(count($records_in['records']) >= 1 && $personaProcesada == false){
                $beanPersona = BeanFactory::getBean("Accounts", $idPersona);
                //Agrega persona original al arreglo de salida
                $account = array(
                    "name"=>$beanPersona->name,
                    "id"=>$beanPersona->id,
                    "apellidopaterno_c"=>$beanPersona->apellidopaterno_c,
                    "tipo_registro_c"=>$beanPersona->tipo_registro_c
                );

                $records_in['records'][]=$account;
            }

        }

        //Regresa resultado
        return $records_in;
    }

}
?>