<?php

class clase_UniProducto
{
    public function func_UniProducto($bean = null, $event = null, $args = null)
    {
        //Campo custom Uni Productos
        if($GLOBALS['service']->platform != 'mobile'){
            $uniProducto = $bean->account_uni_productos;
            // $GLOBALS['log']->fatal("ProductoCustom", print_r($uniProducto,true));

            if (!empty($uniProducto)) {

                foreach ($uniProducto as $key) {
                    // $GLOBALS['log']->fatal("ID_PRODUCTO", $key['id']);
                    if ($key['id'] != '') {
                        // $GLOBALS['log']->fatal("Inserta Producto");
                        $beanUP = BeanFactory::retrieveBean('uni_Productos', $key['id']);
                        $beanUP->no_viable = $key['no_viable'];
                        $beanUP->no_viable_razon = $key['no_viable_razon'];
                        $beanUP->no_viable_razon_fp = $key['no_viable_razon_fp'];
                        $beanUP->no_viable_quien = $key['no_viable_quien'];
                        $beanUP->no_viable_porque = $key['no_viable_porque'];
                        $beanUP->no_viable_producto = $key['no_viable_producto'];
                        $beanUP->no_viable_razon_cf = $key['no_viable_razon_cf'];
                        $beanUP->no_viable_razon_ni = $key['no_viable_razon_ni'];
                        $beanUP->no_viable_otro_c = $key['no_viable_otro_c'];
                        $beanUP->assigned_user_id = $key['assigned_user_id'];
                        $beanUP->save();
                        // $GLOBALS['log']->fatal("Termina de guardar datos de NV a UP");
                    }
                }
            }


        }else{
            $uniProducto = $bean->no_viable;
            // $GLOBALS['log']->fatal("ProductoCustom", print_r($uniProducto,true));

            if (!empty($uniProducto)) {

                foreach ($uniProducto as $key) {
                    // $GLOBALS['log']->fatal("ID_PRODUCTO", $key['id']);
                    if ($key['id'] != '') {
                        // $GLOBALS['log']->fatal("Inserta Producto");
                        $beanUP = BeanFactory::retrieveBean('uni_Productos', $key['id']);
                        $beanUP->no_viable = $key['no_viable'];
                        $beanUP->no_viable_razon = $key['no_viable_razon'];
                        $beanUP->no_viable_razon_fp = $key['no_viable_razon_fp'];
                        $beanUP->no_viable_quien = $key['no_viable_quien'];
                        $beanUP->no_viable_porque = $key['no_viable_porque'];
                        $beanUP->no_viable_producto = $key['no_viable_producto'];
                        $beanUP->no_viable_razon_cf = $key['no_viable_razon_cf'];
                        $beanUP->no_viable_razon_ni = $key['no_viable_razon_ni'];
                        $beanUP->no_viable_otro_c = $key['no_viable_otro_c'];
                        $beanUP->assigned_user_id = $key['assigned_user_id'];
                        $beanUP->save();
                        // $GLOBALS['log']->fatal("Termina de guardar datos de NV a UP");
                    }
                }
            }
        }

    }
}
