<?php
/**
 * Created by PhpStorm.
 * User: salvador.lopez@tactos.com.mx
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class AnexosVentaCruzada extends SugarApi
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
                'reqType' => 'POST',
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('anexosVentaCruzada'),
                //endpoint variables
                'pathVars' => array('method'),
                //method to call
                'method' => 'setAnexosVentaCruzada',
                //short help string to be displayed in the help documentation
                'shortHelp' => '',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),


        );

    }

    /**
     * Establece nuevo valor a campo de anexos en el módulo de referencias venta cruzada
     **
     * @param array $api
     * @param array $args Array con los parámetros enviados para su procesamiento
     * @return array $response Array con estado de la referencia actualizada
     * @throws SugarApiExceptionInvalidParameter
     */
    public function setAnexosVentaCruzada($api, $args)
    {
        $response=array();

        $idCuenta=$args['idCuenta'];
        $idCorto=$args['idCorto'];
        $idProducto=$args['idProducto'];

        if(isset($idCorto) && $idCorto !="" && empty($idCuenta)){
            //Obtener id de cuenta con el idCliente del parámetro
            $beanQuery = BeanFactory::newBean('Accounts');
            $sugarQueryAcc = new SugarQuery();
            $sugarQueryAcc->select(array('id'));
            $sugarQueryAcc->from($beanQuery);
            $sugarQueryAcc->where()->equals('idcliente_c',$idCorto);
            $sugarQueryAcc->limit(1);
            $resultAcc = $sugarQueryAcc->execute();

            $countAcc = count($resultAcc);
            if($countAcc>0){
                $idCuenta=$resultAcc[0]['id'];
            }

        }

        if(isset($idCuenta) && $idCuenta !=""){
            $beanCuenta=BeanFactory::retrieveBean('Accounts',$idCuenta);

            if(!empty($beanCuenta)){
                //producto_referenciado 1 LEASING, 2 CREDITO SIMPLE, 3 CA, 4 FACTORAJE, 5 CREDITO SIMPLE, 6 FLEET, 7 SOS, 8 UNICICK, 9 UNILEASE
                //estatus- 1 VALIDA, 2 - NO VALIDA, 3 - CANCELADA, 4 - EXITOSA, 5 - EXPIRADA

                if ($beanCuenta->load_relationship('accounts_ref_venta_cruzada_1'))
                {
                    //Fetch related beans
                    $relatedBeans = $beanCuenta->accounts_ref_venta_cruzada_1->getBeans($beanCuenta->id,array('disable_row_level_security' => true));

                    if(count($relatedBeans)>0){
                        $flagGuardar=0;
                        $idRef="";

                        foreach ($relatedBeans as $ref) {
                            if($ref->estatus==1 && $ref->producto_referenciado==$idProducto){
                                $anexosActuales=$ref->numero_anexos;
                                $nuevosAnexos=$anexosActuales+1;
                                $ref->numero_anexos=$nuevosAnexos;

                                if($ref->primer_fecha_anexo ==""){
                                    $ref->primer_fecha_anexo=date('Y-m-d');
                                    $ref->ultima_fecha_anexo=date('Y-m-d');
                                }else{
                                    $ref->ultima_fecha_anexo=date('Y-m-d');
                                }

                                $ref->save();

                                $flagGuardar=1;
                                $idRef=$ref->id;

                            }

                        }

                        if($flagGuardar==1){
                            $response['status']='200';
                            $response['message']='Se actualizó el número de anexos de forma correcta';
                            $response['idReferencia']=$idRef;

                        }else{
                            $response['status']='200';
                            $response['message']='No se encontraron Referencias válidas relacionadas a la Cuenta con el producto indicado';
                            $response['idReferencia']="";
                        }


                    }else{
                        $response['status']='200';
                        $response['message']='No se encontraron Referencias relacionadas a la Cuenta';
                        $response['idReferencia']="";
                    }

                }

            }else{
                $response['status']='200';
                $response['message']='No existe una cuenta con el id proporcionado';
                $response['idReferencia']="";
            }
        }

        return $response;

    }


}

?>
