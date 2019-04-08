<?php
/**
 * Created by PhpStorm.
 * User: tactos
 * Date: 28/01/19
 * Time: 05:20 PM
 */


class productosPLD_I_U extends SugarApi
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
                'reqType' => 'GET',
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('GetProductosPLD', '?'),
                //endpoint variables
                'pathVars' => array('module', 'id_cuenta'),
                //method to call
                'method' => 'GetProductosPLD_Account',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método GET para obtener los productos PLD asociados a una Cuenta',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),
            'SavePLD' => array(
                'reqType' => 'POST',
                'path' => array('SavePLD'),
                'pathVars' => array(''),
                'method' => 'SavePLD_Method',
                'shortHelp' => 'Guarda registros de PLD',
            ),
        );
    }

    public function GetProductosPLD_Account($api, $args)
    {
        $idCuenta = $args['id_cuenta'];

        $productosPLD = array(
            'id_cuenta' => '',
            'arrendamientoPuro' =>
                array(
                    'visible' => 'none',
                    'id_pld' => '',
                    'tipoProducto' => 'AP',
                    'campo1' => '',
                    'campo2' => '',
                    'campo2_label' => '',
                    'campo3' => '',
                    'campo3_id' => '',
                    'campo4' => '',
                    'campo4_label' => '',
                    'campo5' => '',
                    'campo5_id' => '',
                    'campo7' => '',
                    'campo7_label' => '',
                    'campo8' => '',
                    'campo9' => '',
                    'campo9_label' => '',
                    'campo10' => '',
                    'campo6' => '',
                    'campo6_label' => '',
                    'campo16' => '',
                    'campo16_label' => '',
                    'campo14' => '',
                    'campo17' => '',
                    'campo13' => '',
                    'campo25' => '',
                    'campo25_label' => '',
                    'campo26' => '',
                ),
            'factorajeFinanciero' =>
                array(
                    'visible' => 'none',
                    'id_pld' => '',
                    'tipoProducto' => 'FF',
                    'campo1' => '',
                    'campo2' => '',
                    'campo2_label' => '',
                    'campo3' => '',
                    'campo3_id' => '',
                    'campo4' => '',
                    'campo4_label' => '',
                    'campo5' => '',
                    'campo5_id' => '',
                    'campo21' => '',
                    'campo21_label' => '',
                    'campo22' => '',
                    'campo23' => '',
                    'campo16' => '',
                    'campo16_label' => '',
                    'campo17' => '',
                    'campo14' => '',
                    'campo24' => '',
                    'campo24_label' => '',
                    'campo6' => '',
                    'campo6_label' => '',
                ),
            'creditoAutomotriz' =>
                array(
                    'visible' => 'none',
                    'id_pld' => '',
                    'tipoProducto' => 'CA',
                    'campo1' => '',
                    'campo2' => '',
                    'campo2_label' => '',
                    'campo3' => '',
                    'campo3_id' => '',
                    'campo4' => '',
                    'campo4_label' => '',
                    'campo5' => '',
                    'campo5_id' => '',
                    'campo6' => '',
                    'campo6_label' => '',
                ),
            'creditoSimple' =>
                array(
                    'id_pld' => '',
                    'tipoProducto' => 'CS',
                    'campo1' => '',
                    'campo2' => '',
                    'campo2_label' => '',
                    'campo3' => '',
                    'campo3_id' => '',
                    'campo4' => '',
                    'campo4_label' => '',
                    'campo5' => '',
                    'campo5_id' => '',
                    'campo18' => '',
                    'campo18_label' => '',
                    'campo19' => '',
                    'campo14' => '',
                    'campo20' => '',
                    'campo20_label' => '',
                    'campo6' => '',
                    'campo6_label' => '',
                ),

        );

        $productosPLD['id_cuenta'] = $idCuenta;

        if ($idCuenta == '1') {
            return $productosPLD;
        }

        $beanModule = BeanFactory::getBean("Accounts", $idCuenta);

        if ($beanModule->load_relationship('accounts_tct_pld_1',array('disable_row_level_security' => true))) {
            $relatedBeans = $beanModule->accounts_tct_pld_1->getBeans();
            foreach ($relatedBeans as $value) {
                $prod = $value->description;
                switch ($prod) {
                    case "AP":
                        $productosPLD['arrendamientoPuro']['id_pld'] = $value->id;
                        $productosPLD['arrendamientoPuro']['campo1'] = $value->tct_pld_campo1_txt;
                        $productosPLD['arrendamientoPuro']['campo2'] = $value->tct_pld_campo2_ddw;
                        $productosPLD['arrendamientoPuro']['campo3'] = $value->tct_pld_campo3_rel;
                        $productosPLD['arrendamientoPuro']['campo3_id'] = $value->account_id_c;
                        $productosPLD['arrendamientoPuro']['campo4'] = $value->tct_pld_campo4_ddw;
                        $productosPLD['arrendamientoPuro']['campo5'] = $value->tct_pld_campo5_rel;
                        $productosPLD['arrendamientoPuro']['campo5_id'] = $value->account_id1_c;
                        $productosPLD['arrendamientoPuro']['campo6'] = $value->tct_pld_campo6_ddw;
                        $productosPLD['arrendamientoPuro']['campo7'] = $value->tct_pld_campo7_ddw;
                        $productosPLD['arrendamientoPuro']['campo8'] = $value->tct_pld_campo8_txt;
                        $productosPLD['arrendamientoPuro']['campo9'] = $value->tct_pld_campo9_ddw;
                        $productosPLD['arrendamientoPuro']['campo10'] = $value->tct_pld_campo10_txt;
                        $productosPLD['arrendamientoPuro']['campo11'] = $value->tct_pld_campo11_ddw;
                        $productosPLD['arrendamientoPuro']['campo13'] = $value->tct_pld_campo13_chk;
                        $productosPLD['arrendamientoPuro']['campo14'] = $value->tct_pld_campo14_chk;
                        $productosPLD['arrendamientoPuro']['campo16'] = $value->tct_pld_campo16_ddw;
                        $productosPLD['arrendamientoPuro']['campo17'] = $value->tct_pld_campo17_txt;
                        $productosPLD['arrendamientoPuro']['campo18'] = $value->tct_pld_campo18_ddw;
                        $productosPLD['arrendamientoPuro']['campo25'] = $value->tct_pld_campo25_ddw;
                        $productosPLD['arrendamientoPuro']['campo26'] = $value->tct_pld_campo26_txt;

                        break;
                    case "FF":
                        $productosPLD['factorajeFinanciero']['id_pld'] = $value->id;
                        $productosPLD['factorajeFinanciero']['campo1'] = $value->tct_pld_campo1_txt;
                        $productosPLD['factorajeFinanciero']['campo2'] = $value->tct_pld_campo2_ddw;
                        $productosPLD['factorajeFinanciero']['campo3'] = $value->tct_pld_campo3_rel;
                        $productosPLD['factorajeFinanciero']['campo3_id'] = $value->account_id_c;
                        $productosPLD['factorajeFinanciero']['campo4'] = $value->tct_pld_campo4_ddw;
                        $productosPLD['factorajeFinanciero']['campo5'] = $value->tct_pld_campo5_rel;
                        $productosPLD['factorajeFinanciero']['campo5_id'] = $value->account_id1_c;
                        $productosPLD['factorajeFinanciero']['campo21'] = $value->tct_pld_campo21_ddw;
                        $productosPLD['factorajeFinanciero']['campo22'] = $value->tct_pld_campo22_int;
                        $productosPLD['factorajeFinanciero']['campo23'] = $value->tct_pld_campo23_dec;
                        $productosPLD['factorajeFinanciero']['campo16'] = $value->tct_pld_campo16_ddw;
                        $productosPLD['factorajeFinanciero']['campo17'] = $value->tct_pld_campo17_txt;
                        $productosPLD['factorajeFinanciero']['campo14'] = $value->tct_pld_campo14_chk;
                        $productosPLD['factorajeFinanciero']['campo24'] = $value->tct_pld_campo24_ddw;
                        $productosPLD['factorajeFinanciero']['campo6'] = $value->tct_pld_campo6_ddw;

                        break;
                    case "CA":
                        $productosPLD['creditoAutomotriz']['id_pld'] = $value->id;
                        $productosPLD['creditoAutomotriz']['campo1'] = $value->tct_pld_campo1_txt;
                        $productosPLD['creditoAutomotriz']['campo2'] = $value->tct_pld_campo2_ddw;
                        $productosPLD['creditoAutomotriz']['campo3'] = $value->tct_pld_campo3_rel;
                        $productosPLD['creditoAutomotriz']['campo3_id'] = $value->account_id_c;
                        $productosPLD['creditoAutomotriz']['campo4'] = $value->tct_pld_campo4_ddw;
                        $productosPLD['creditoAutomotriz']['campo5'] = $value->tct_pld_campo5_rel;
                        $productosPLD['creditoAutomotriz']['campo5_id'] = $value->account_id1_c;
                        $productosPLD['creditoAutomotriz']['campo6'] = $value->tct_pld_campo6_ddw;

                        break;
                    case "CS":
                        $productosPLD['creditoSimple']['id_pld'] = $value->id;
                        $productosPLD['creditoSimple']['campo1'] = $value->tct_pld_campo1_txt;
                        $productosPLD['creditoSimple']['campo2'] = $value->tct_pld_campo2_ddw;
                        $productosPLD['creditoSimple']['campo3'] = $value->tct_pld_campo3_rel;
                        $productosPLD['creditoSimple']['campo3_id'] = $value->account_id_c;
                        $productosPLD['creditoSimple']['campo4'] = $value->tct_pld_campo4_ddw;
                        $productosPLD['creditoSimple']['campo5'] = $value->tct_pld_campo5_rel;
                        $productosPLD['creditoSimple']['campo5_id'] = $value->account_id1_c;
                        $productosPLD['creditoSimple']['campo18'] = $value->tct_pld_campo18_ddw;
                        $productosPLD['creditoSimple']['campo19'] = $value->tct_pld_campo19_txt;
                        $productosPLD['creditoSimple']['campo14'] = $value->tct_pld_campo14_chk;
                        $productosPLD['creditoSimple']['campo20'] = $value->tct_pld_campo20_ddw;
                        $productosPLD['creditoSimple']['campo6'] = $value->tct_pld_campo6_ddw;

                        break;

                }
            }
        }

        return $productosPLD;
    }

    public function SavePLD_Method($api, $args)
    {
        //Recuperar productosPLD
        $productosPLD = $args;
        $modulo = 'tct_PLD';
        ########################
        # Procesar productos
        ########################
        // Arrendamiento Puro: AP
        ########################
        if ($productosPLD['arrendamientoPuro']['id_pld']) {
            //Actualiza registro
            $pldAP = BeanFactory::getBEan($modulo,$productosPLD['arrendamientoPuro']['id_pld']);
        }else {
            //Inserta registro
            $pldAP = BeanFactory::newBean($modulo);
        }
        //Agregar valores a campo
        $idCuenta = $productosPLD['id_cuenta'];
        $pldAP->accounts_tct_pld_1accounts_ida = $idCuenta;
        $pldAP->tct_pld_campo1_txt = $productosPLD['arrendamientoPuro']['campo1'];
        $pldAP->tct_pld_campo2_ddw = $productosPLD['arrendamientoPuro']['campo2'];
        $pldAP->tct_pld_campo3_rel = $productosPLD['arrendamientoPuro']['campo3'];
        $pldAP->account_id_c = $productosPLD['arrendamientoPuro']['campo3_id'];
        $pldAP->tct_pld_campo4_ddw = $productosPLD['arrendamientoPuro']['campo4'];
        $pldAP->tct_pld_campo5_rel = $productosPLD['arrendamientoPuro']['campo5'];
        $pldAP->account_id1_c = $productosPLD['arrendamientoPuro']['campo5_id'];
        $pldAP->tct_pld_campo6_ddw = $productosPLD['arrendamientoPuro']['campo6'];
        $pldAP->tct_pld_campo7_ddw = $productosPLD['arrendamientoPuro']['campo7'];
        $pldAP->tct_pld_campo8_txt = $productosPLD['arrendamientoPuro']['campo8'];
        $pldAP->tct_pld_campo9_ddw = $productosPLD['arrendamientoPuro']['campo9'];
        $pldAP->tct_pld_campo10_txt = $productosPLD['arrendamientoPuro']['campo10'];
        $pldAP->tct_pld_campo11_ddw = $productosPLD['arrendamientoPuro']['campo11'];
        $pldAP->tct_pld_campo13_chk = $productosPLD['arrendamientoPuro']['campo13'];
        $pldAP->tct_pld_campo14_chk = $productosPLD['arrendamientoPuro']['campo14'];
        $pldAP->tct_pld_campo16_ddw = (!empty($productosPLD['arrendamientoPuro']['campo16']))? "^" . str_replace(",","^,^",$productosPLD['arrendamientoPuro']['campo16']) . "^" : "";
        $pldAP->tct_pld_campo17_txt = $productosPLD['arrendamientoPuro']['campo17'];
        $pldAP->tct_pld_campo18_ddw = $productosPLD['arrendamientoPuro']['campo18'];
        $pldAP->tct_pld_campo25_ddw = $productosPLD['arrendamientoPuro']['campo25'];
        $pldAP->tct_pld_campo26_txt = $productosPLD['arrendamientoPuro']['campo26'];

        $pldAP->name = "Arrendamiento Puro";
        $pldAP->description = $productosPLD['arrendamientoPuro']['tipoProducto'];

        //Guardar registro
        $pldAP->save();
        $productosPLD['arrendamientoPuro']['id_pld'] = $pldAP->id;

        ########################
        // Factoraje financiero: FF
        ########################
        if ($productosPLD['factorajeFinanciero']['id_pld']) {
            //Actualiza registro
            $pldFF = BeanFactory::getBEan($modulo,$productosPLD['factorajeFinanciero']['id_pld']);
        }else {
            //Inserta registro
            $pldFF = BeanFactory::newBean($modulo);
        }
        //Agregar valores a campo
        $idCuenta = $productosPLD['id_cuenta'];
        $pldFF->accounts_tct_pld_1accounts_ida = $idCuenta;
        $pldFF->tct_pld_campo1_txt = $productosPLD['factorajeFinanciero']['campo1'];
        $pldFF->tct_pld_campo2_ddw = $productosPLD['factorajeFinanciero']['campo2'];
        $pldFF->tct_pld_campo3_rel = $productosPLD['factorajeFinanciero']['campo3'];
        $pldFF->account_id_c = $productosPLD['factorajeFinanciero']['campo3_id'];
        $pldFF->tct_pld_campo4_ddw = $productosPLD['factorajeFinanciero']['campo4'];
        $pldFF->tct_pld_campo5_rel = $productosPLD['factorajeFinanciero']['campo5'];
        $pldFF->account_id1_c = $productosPLD['factorajeFinanciero']['campo5_id'];
        $pldFF->tct_pld_campo7_ddw = $productosPLD['factorajeFinanciero']['campo7'];
        $pldFF->tct_pld_campo21_ddw = $productosPLD['factorajeFinanciero']['campo21'];
        $pldFF->tct_pld_campo22_int = $productosPLD['factorajeFinanciero']['campo22'];
        $pldFF->tct_pld_campo23_dec = $productosPLD['factorajeFinanciero']['campo23'];
        $pldFF->tct_pld_campo16_ddw = (!empty($productosPLD['factorajeFinanciero']['campo16']))? "^" . str_replace(",","^,^",$productosPLD['factorajeFinanciero']['campo16']) . "^" : "";
        $pldFF->tct_pld_campo17_txt = $productosPLD['factorajeFinanciero']['campo17'];
        $pldFF->tct_pld_campo15_txt = $productosPLD['factorajeFinanciero']['campo15'];
        $pldFF->tct_pld_campo14_chk = $productosPLD['factorajeFinanciero']['campo14'];
        $pldFF->tct_pld_campo24_ddw = $productosPLD['factorajeFinanciero']['campo24'];
        $pldFF->tct_pld_campo6_ddw = $productosPLD['factorajeFinanciero']['campo6'];
        $pldFF->name = "Factoraje Financiero";
        $pldFF->description = $productosPLD['factorajeFinanciero']['tipoProducto'];

        //Guardar registro
        $pldFF->save();
        $productosPLD['factorajeFinanciero']['id_pld'] = $pldFF->id;


        ########################
        // Crédito Automotriz :CA
        ########################
        if ($productosPLD['creditoAutomotriz']['id_pld']) {
            //Actualiza registro
            $pldCA = BeanFactory::getBEan($modulo,$productosPLD['creditoAutomotriz']['id_pld']);
        }else {
            //Inserta registro
            $pldCA = BeanFactory::newBean($modulo);
        }
        //Agregar valores a campo
        $idCuenta = $productosPLD['id_cuenta'];
        $pldCA->accounts_tct_pld_1accounts_ida = $idCuenta;
        $pldCA->tct_pld_campo1_txt = $productosPLD['creditoAutomotriz']['campo1'];
        $pldCA->tct_pld_campo2_ddw = $productosPLD['creditoAutomotriz']['campo2'];
        $pldCA->tct_pld_campo3_rel = $productosPLD['creditoAutomotriz']['campo3'];
        $pldCA->account_id_c = $productosPLD['creditoAutomotriz']['campo3_id'];
        $pldCA->tct_pld_campo4_ddw = $productosPLD['creditoAutomotriz']['campo4'];
        $pldCA->tct_pld_campo5_rel = $productosPLD['creditoAutomotriz']['campo5'];
        $pldCA->account_id1_c = $productosPLD['creditoAutomotriz']['campo5_id'];
        $pldCA->tct_pld_campo6_ddw = $productosPLD['creditoAutomotriz']['campo6'];
        $pldCA->name = "Crédito Automotriz";
        $pldCA->description = $productosPLD['creditoAutomotriz']['tipoProducto'];

        //Guardar registro
        $pldCA->save();
        $productosPLD['creditoAutomotriz']['id_pld'] = $pldCA->id;


        ########################
        // Crédito Simple :CS
        ########################
        if ($productosPLD['creditoSimple']['id_pld']) {
            //Actualiza registro
            $pldCS = BeanFactory::getBEan($modulo,$productosPLD['creditoSimple']['id_pld']);
        }else {
            //Inserta registro
            $pldCS = BeanFactory::newBean($modulo);
        }
        //Agregar valores a campo
        $idCuenta = $productosPLD['id_cuenta'];
        $pldCS->accounts_tct_pld_1accounts_ida = $idCuenta;
        $pldCS->tct_pld_campo1_txt = $productosPLD['creditoSimple']['campo1'];
        $pldCS->tct_pld_campo2_ddw = $productosPLD['creditoSimple']['campo2'];
        $pldCS->tct_pld_campo3_rel = $productosPLD['creditoSimple']['campo3'];
        $pldCS->account_id_c = $productosPLD['creditoSimple']['campo3_id'];
        $pldCS->tct_pld_campo4_ddw = $productosPLD['creditoSimple']['campo4'];
        $pldCS->tct_pld_campo5_rel = $productosPLD['creditoSimple']['campo5'];
        $pldCS->account_id1_c = $productosPLD['creditoSimple']['campo5_id'];
        $pldCS->tct_pld_campo6_ddw = $productosPLD['creditoSimple']['campo6'];
        $pldCS->tct_pld_campo18_ddw = (!empty($productosPLD['creditoSimple']['campo18']))? "^" . str_replace(",","^,^",$productosPLD['creditoSimple']['campo18']) . "^" : "";
        $pldCS->tct_pld_campo19_txt = $productosPLD['creditoSimple']['campo19'];
        $pldCS->tct_pld_campo14_chk = $productosPLD['creditoSimple']['campo14'];
        $pldCS->tct_pld_campo20_ddw = $productosPLD['creditoSimple']['campo20'];
        $pldCS->name = "Crédito Simple";
        $pldCS->description = $productosPLD['creditoSimple']['tipoProducto'];

        //Guardar registro
        $pldCS->save();
        $productosPLD['creditoSimple']['id_pld'] = $pldCS->id;


        //Regresar respuesta
        return $productosPLD;

    }

}
