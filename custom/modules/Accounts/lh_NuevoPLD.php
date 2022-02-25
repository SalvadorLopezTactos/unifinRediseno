<?php

/**
 * Created by Axel Flores
 * Email: axel.flores@tactos.com.mx
 * Date: 05/02/2019
 *
 */
class NuevoPLD_Class
{
    public function NuevoPLD_Method($bean = null, $event = null, $args = null)
    {
       //Se ejecuta para creación productos para nuevos registros(cuentas):
        /* Dev: Erick de JEsus 20220217
        * Tipo de cuenta = Todas
        */
      //$GLOBALS['log']->fatal("isUpdate->",$args['isUpdate']);
      //$GLOBALS['log']->fatal("isUpdate->",$bean->accounts_tct_pld);
      //$GLOBALS['log']->fatal("nuevo PLD",$productosPLD['arrendamientoPuro']['id_pld']);
      $productosPLD = $bean->accounts_tct_pld;
      $modulo = 'tct_PLD';
       
      if (!empty($productosPLD) || !$args['isUpdate']) {
       ########################
        // Arrendamiento Puro: AP
        ########################
      if (empty($productosPLD['arrendamientoPuro']['id_pld'])) {
        //Inserta registro
        //$GLOBALS['log']->fatal("nuevo PLD");
        $pldAP = BeanFactory::newBean($modulo);
      }else{
        //Actualiza registro
        $pldAP = BeanFactory::getBean($modulo,$productosPLD['arrendamientoPuro']['id_pld']);
      }
        //Agregar valores a campo
        $idCuenta = $productosPLD['id_cuenta'];
        $pldAP->accounts_tct_pld_1accounts_ida = $idCuenta;
        $pldAP->tct_pld_campo1_txt = $productosPLD['arrendamientoPuro']['campo1'];
        $pldAP->tct_pld_campo2_ddw = $productosPLD['arrendamientoPuro']['campo2'];
        $pldAP->tct_pld_campo3_rel = $productosPLD['arrendamientoPuro']['campo3'];
        $pldAP->account_id_c = $productosPLD['arrendamientoPuro']['campo3_id'];
        $pldAP->tct_pld_campo4_ddw = $productosPLD['arrendamientoPuro']['campo4'];
        //$pldAP->tct_pld_campo5_rel = $productosPLD['arrendamientoPuro']['campo5'];
        //$pldAP->account_id1_c = $productosPLD['arrendamientoPuro']['campo5_id'];
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
        $pldAP->description = "AP";

        //Guardar registro
        $pldAP->save();
        //$GLOBALS['log']->fatal("$pldAP->",$pldAP);
        
        if (!$args['isUpdate'] || empty($productosPLD['arrendamientoPuro']['id_pld'] )) {
          $bean->load_relationship('accounts_tct_pld_1');
          $bean->accounts_tct_pld_1->add($pldAP->id);
        }
        //$productosPLD['arrendamientoPuro']['id_pld'] = $pldAP->id;

        ########################
        // Factoraje financiero: FF
        ########################
        if ($productosPLD['factorajeFinanciero']['id_pld']) {
            //Actualiza registro
            $pldFF = BeanFactory::getBean($modulo,$productosPLD['factorajeFinanciero']['id_pld']);
        }else {
            //Inserta registro
            $pldFF = BeanFactory::newBean($modulo);
        }
        //$GLOBALS['log']->fatal("$pldFF->",$pldFF);
        //Agregar valores a campo
        $idCuenta = $productosPLD['id_cuenta'];
        $pldFF->accounts_tct_pld_1accounts_ida = $idCuenta;
        $pldFF->tct_pld_campo1_txt = $productosPLD['factorajeFinanciero']['campo1'];
        $pldFF->tct_pld_campo2_ddw = $productosPLD['factorajeFinanciero']['campo2'];
        $pldFF->tct_pld_campo3_rel = $productosPLD['factorajeFinanciero']['campo3'];
        $pldFF->account_id_c = $productosPLD['factorajeFinanciero']['campo3_id'];
        $pldFF->tct_pld_campo4_ddw = $productosPLD['factorajeFinanciero']['campo4'];
        //$pldFF->tct_pld_campo5_rel = $productosPLD['factorajeFinanciero']['campo5'];
        //$pldFF->account_id1_c = $productosPLD['factorajeFinanciero']['campo5_id'];
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
        $pldFF->description = "FF";

        //Guardar registro
        $pldFF->save();
        if (!$args['isUpdate'] || empty($productosPLD['factorajeFinanciero']['id_pld'])) {
          $bean->load_relationship('accounts_tct_pld_1');
          $bean->accounts_tct_pld_1->add($pldFF->id);
        }
        //$productosPLD['factorajeFinanciero']['id_pld'] = $pldFF->id;


        ########################
        // Crédito Automotriz :CA
        ########################
        if ($productosPLD['creditoAutomotriz']['id_pld']) {
            //Actualiza registro
            $pldCA = BeanFactory::getBean($modulo,$productosPLD['creditoAutomotriz']['id_pld']);
        }else {
            //Inserta registro
            $pldCA = BeanFactory::newBean($modulo);
        }
        //$GLOBALS['log']->fatal("$pldCA->",$pldCA);
        //Agregar valores a campo
        $idCuenta = $productosPLD['id_cuenta'];
        $pldCA->accounts_tct_pld_1accounts_ida = $idCuenta;
        $pldCA->tct_pld_campo1_txt = $productosPLD['creditoAutomotriz']['campo1'];
        $pldCA->tct_pld_campo2_ddw = $productosPLD['creditoAutomotriz']['campo2'];
        $pldCA->tct_pld_campo3_rel = $productosPLD['creditoAutomotriz']['campo3'];
        $pldCA->account_id_c = $productosPLD['creditoAutomotriz']['campo3_id'];
        $pldCA->tct_pld_campo4_ddw = $productosPLD['creditoAutomotriz']['campo4'];
       // $pldCA->tct_pld_campo5_rel = $productosPLD['creditoAutomotriz']['campo5'];
       // $pldCA->account_id1_c = $productosPLD['creditoAutomotriz']['campo5_id'];
        $pldCA->tct_pld_campo6_ddw = $productosPLD['creditoAutomotriz']['campo6'];
        $pldCA->name = "Crédito Automotriz";
        $pldCA->description = "CA";

        //Guardar registro
        $pldCA->save();
        if (!$args['isUpdate']) {
          $bean->load_relationship('accounts_tct_pld_1');
          $bean->accounts_tct_pld_1->add($pldCA->id);
        }
        //$productosPLD['creditoAutomotriz']['id_pld'] = $pldCA->id;


        ########################
        // Crédito Simple :CS
        ########################
        if ($productosPLD['creditoSimple']['id_pld']) {
            //Actualiza registro
            $pldCS = BeanFactory::getBean($modulo,$productosPLD['creditoSimple']['id_pld']);
        }else {
            //Inserta registro
            $pldCS = BeanFactory::newBean($modulo);
        }
        //$GLOBALS['log']->fatal("$pldCS->",$pldCS);
        //Agregar valores a campo
        $idCuenta = $productosPLD['id_cuenta'];
        $pldCS->accounts_tct_pld_1accounts_ida = $idCuenta;
        $pldCS->tct_pld_campo1_txt = $productosPLD['creditoSimple']['campo1'];
        $pldCS->tct_pld_campo2_ddw = $productosPLD['creditoSimple']['campo2'];
        $pldCS->tct_pld_campo3_rel = $productosPLD['creditoSimple']['campo3'];
        $pldCS->account_id_c = $productosPLD['creditoSimple']['campo3_id'];
        $pldCS->tct_pld_campo4_ddw = $productosPLD['creditoSimple']['campo4'];
        //$pldCS->tct_pld_campo5_rel = $productosPLD['creditoSimple']['campo5'];
        //$pldCS->account_id1_c = $productosPLD['creditoSimple']['campo5_id'];
        $pldCS->tct_pld_campo6_ddw = $productosPLD['creditoSimple']['campo6'];
        $pldCS->tct_pld_campo18_ddw = (!empty($productosPLD['creditoSimple']['campo18']))? "^" . str_replace(",","^,^",$productosPLD['creditoSimple']['campo18']) . "^" : "";
        $pldCS->tct_pld_campo19_txt = $productosPLD['creditoSimple']['campo19'];
        $pldCS->tct_pld_campo14_chk = $productosPLD['creditoSimple']['campo14'];
        $pldCS->tct_pld_campo20_ddw = $productosPLD['creditoSimple']['campo20'];
        $pldCS->name = "Crédito Simple";
        $pldCS->description = "CS";

        //Guardar registro
        $pldCS->save();
        if (!$args['isUpdate'] || empty($productosPLD['creditoAutomotriz']['id_pld'])) {
          $bean->load_relationship('accounts_tct_pld_1');
          $bean->accounts_tct_pld_1->add($pldCS->id);
        }
        //$productosPLD['creditoSimple']['id_pld'] = $pldCS->id;

        ########################
        // Crédito Envolvente :CE
        ########################
        if ($productosPLD['creditoRevolvente']['id_pld']) {
            //Actualiza registro
            $pldCE = BeanFactory::getBean($modulo,$productosPLD['creditoRevolvente']['id_pld']);
        }else {
            //Inserta registro
            $pldCE = BeanFactory::newBean($modulo);
        }
        //$GLOBALS['log']->fatal("$pldCE->",$pldCE);
        //Agregar valores a campo
        $idCuenta = $productosPLD['id_cuenta'];
        $pldCE->accounts_tct_pld_1accounts_ida = $idCuenta;
        $pldCE->tct_pld_campo22_int = $productosPLD['creditoRevolvente']['campo1'];
        $pldCE->tct_pld_campo23_dec = $productosPLD['creditoRevolvente']['campo2'];
        $pldCE->tct_pld_campo16_ddw = (!empty($productosPLD['creditoRevolvente']['campo3']))? "^" . str_replace(",","^,^",$productosPLD['creditoRevolvente']['campo3']) . "^" : "";
        $pldCE->tct_pld_campo29_ddw_c = (!empty($productosPLD['creditoRevolvente']['campo5']))? "^" . str_replace(",","^,^",$productosPLD['creditoRevolvente']['campo5']) . "^" : "";
        $pldCE->tct_pld_campo6_ddw = $productosPLD['creditoRevolvente']['campo6'];
        $pldCE->tct_pld_campo28_ddw_c = (!empty($productosPLD['creditoRevolvente']['campo7']))? "^" . str_replace(",","^,^",$productosPLD['creditoRevolvente']['campo7']) . "^" : "";
        $pldCE->tct_pld_campo2_ddw = $productosPLD['creditoRevolvente']['campo8'];
        $pldCE->tct_pld_campo3_rel = $productosPLD['creditoRevolvente']['campo9'];
        $pldCE->account_id_c = $productosPLD['creditoRevolvente']['campo9_id'];
        $pldCE->tct_pld_campo4_ddw = $productosPLD['creditoRevolvente']['campo10'];
        $pldCE->name = "Crédito Revolvente";
        $pldCE->description = "CR";

        //Guardar registro
        $pldCE->save();
        if (!$args['isUpdate'] || empty($productosPLD['creditoRevolvente']['id_pld'])) {
          $bean->load_relationship('accounts_tct_pld_1');
          $bean->accounts_tct_pld_1->add($pldCE->id);
        }
        //$productosPLD['creditoRevolvente']['id_pld'] = $pldCE->id;
        }
        $GLOBALS['log']->fatal("terminoPLD");
        
    }
}
