<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/07/20
 * Time: 11:42 PM
 */

class Drive_docs
{
    function actualizatipoprod($bean = null, $event = null, $args = null){
        //Declara variables de Oportunidad
        $producto= "10"; //Seguros
        $etapa=$bean->etapa;
        $cliente = $bean->s_seguros_accountsaccounts_ida;
        //Evalua cambio en etapa o subetapa
        if ($bean->fetched_row['etapa']!=$etapa && $cliente) {
            //Actualiza en Solicitud Inicial y actualiza campos con valor Prospecto Interesado: 2,7
            $GLOBALS['log']->fatal('Seguros: Actualiza tipo de Cuenta para producto: '.$producto);
            if($etapa=="1"){
                $GLOBALS['log']->fatal('Actualiza a Prospecto Interesado (cuenta)');
                Drive_docs::actualizaTipoCuentaProd('2','7',$cliente,$producto);
            }
            //Actualiza cuando la solicitud es Autorizada (N) Cliente Nuevo: 3, 13
            if ($bean->etapa=="9") { //Etapa solicitud 9 GANADA
                $GLOBALS['log']->fatal('Cliente Nuevo');
                Drive_docs::actualizaTipoCuentaProd('3','13',$cliente,$producto);
            }
            //Oportunidad de Seguro NO Ganada pasa la cuenta a Prospecto Rechazado  2 :10
            if ($bean->etapa=="10") { //Etapa solicitud 9 GANADA
                $GLOBALS['log']->fatal('Op de Seguro NO Ganada');
                Drive_docs::actualizaTipoCuentaProd('2','10',$cliente,$producto);
            }
        }
    }

    function actualizaTipoCuentaProd($tipo=null, $subtipo=null, $idCuenta=null, $tipoProducto=null)
    {
        global $app_list_strings;
        //Valuda cuenta Asociada y producto
        if($idCuenta && $tipoProducto){
            //Recupera cuenta
            $beanAccount = BeanFactory::getBean('Accounts', $idCuenta,array('disable_row_level_security' => true));
            //Recupera productos y actualiza Tipo y subtipo
            if ($beanAccount->load_relationship('accounts_uni_productos_1')) {
                $relateProducts = $beanAccount->accounts_uni_productos_1->getBeans($beanAccount->id,array('disable_row_level_security' => true));
                //Recupera valores
                $tipoList = $app_list_strings['tipo_registro_cuenta_list'];
                $subtipoList = $app_list_strings['subtipo_registro_cuenta_list'];
                $tipoSubtipo = mb_strtoupper(trim($tipoList[$tipo].' '.$subtipoList[$subtipo]),'UTF-8');
                //Itera productos recuperados
                foreach ($relateProducts as $product) {
                    if ($tipoProducto == $product->tipo_producto) {
                        if ($product->tipo_cuenta != "3" && $tipo == 2) {
                            //Actualiza tipo y subtipo de producto
                            $product->tipo_cuenta = $tipo;
                            $product->subtipo_cuenta = $subtipo;
                            $product->tipo_subtipo_cuenta = $tipoSubtipo;
                            $product->save();
                        }
                        if ($product->tipo_cuenta != "3" && $tipo == 3) {
                            //Actualiza tipo y subtipo de producto
                            $product->tipo_cuenta = $tipo;
                            $product->subtipo_cuenta = $subtipo;
                            $product->tipo_subtipo_cuenta = $tipoSubtipo;
                            $product->save();
                        }
                    }
                }
                //$beanAccount->save();
                //Valita Tipo de Cuenta
                if ($tipo==2 && $beanAccount->tipo_registro_cuenta_c!=3 && $beanAccount->subtipo_registro_cuenta_c!=8 && $beanAccount->subtipo_registro_cuenta_c!=9) {
                  //Actualiza a Prospecto Interesado
                  global $db;
                  $update = "update accounts_cstm set
                    tipo_registro_cuenta_c='2', subtipo_registro_cuenta_c ='7', tct_tipo_subtipo_txf_c='PROSPECTO INTERESADO'
                    where id_c = '{$beanAccount->id}'";
                  $updateExecute = $db->query($update);
                }
                if ($tipo==3 && $beanAccount->tipo_registro_cuenta_c!=3) {
                  //Actualiza a Cliente Nuevo
                  global $db;
                  $update = "update accounts_cstm set
                    tipo_registro_cuenta_c='3', subtipo_registro_cuenta_c ='13', tct_tipo_subtipo_txf_c='CLIENTE NUEVO'
                    where id_c = '{$beanAccount->id}'";
                  $updateExecute = $db->query($update);

                }
            }
        }
    }
}
