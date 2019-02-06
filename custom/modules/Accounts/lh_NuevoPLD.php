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
          if (!empty($bean->tct_nuevo_pld_c) && $bean->tct_nuevo_pld_c != "") {
              $productosPLD = json_decode($bean->tct_nuevo_pld_c);
              $modulo = 'tct_PLD';
              ########################
              # Procesar productos
              ########################
              // Arrendamiento Puro: AP
              ########################
              $pldAP = BeanFactory::newBean($modulo);
              //Agregar valores a campo
              $idCuenta = $bean->id;
              $pldAP->accounts_tct_pld_1accounts_ida = $idCuenta;
              $pldAP->tct_pld_campo1_txt = $productosPLD->arrendamientoPuro->campo1;
              $pldAP->tct_pld_campo2_ddw = $productosPLD->arrendamientoPuro->campo2;
              $pldAP->tct_pld_campo3_rel = $productosPLD->arrendamientoPuro->campo3;
              $pldAP->account_id_c = $productosPLD->arrendamientoPuro->campo3_id;
              $pldAP->tct_pld_campo4_ddw = $productosPLD->arrendamientoPuro->campo4;
              $pldAP->tct_pld_campo5_rel = $productosPLD->arrendamientoPuro->campo5;
              $pldAP->account_id1_c = $productosPLD->arrendamientoPuro->campo5_id;
              $pldAP->tct_pld_campo6_ddw = $productosPLD->arrendamientoPuro->campo6;
              $pldAP->tct_pld_campo7_ddw = $productosPLD->arrendamientoPuro->campo7;
              $pldAP->tct_pld_campo8_txt = $productosPLD->arrendamientoPuro->campo8;
              $pldAP->tct_pld_campo9_ddw = $productosPLD->arrendamientoPuro->campo9;
              $pldAP->tct_pld_campo10_txt = $productosPLD->arrendamientoPuro->campo10;
              $pldAP->tct_pld_campo11_ddw = $productosPLD->arrendamientoPuro->campo11;
              $pldAP->tct_pld_campo13_chk = $productosPLD->arrendamientoPuro->campo13;
              $pldAP->tct_pld_campo14_chk = $productosPLD->arrendamientoPuro->campo14;
              $pldAP->tct_pld_campo16_ddw = "^" . str_replace(",","^,^",$productosPLD->arrendamientoPuro->campo16) . "^";
              $pldAP->tct_pld_campo17_txt = $productosPLD->arrendamientoPuro->campo17;
              $pldAP->tct_pld_campo18_ddw = $productosPLD->arrendamientoPuro->campo18;
              $pldAP->tct_pld_campo25_ddw = $productosPLD->arrendamientoPuro->campo25;
              $pldAP->tct_pld_campo26_txt = $productosPLD->arrendamientoPuro->campo26;
              $pldAP->name = "Arrendamiento Puro";
              $pldAP->description = "AP";
              //Guardar registro
              $pldAP->save();

              ########################
              // Factoraje financiero: FF
              ########################
              $pldFF = BeanFactory::newBean($modulo);
              //Agregar valores a campo
              $idCuenta = $bean->id;
              $pldFF->accounts_tct_pld_1accounts_ida = $idCuenta;
              $pldFF->tct_pld_campo1_txt = $productosPLD->factorajeFinanciero->campo1;
              $pldFF->tct_pld_campo2_ddw = $productosPLD->factorajeFinanciero->campo2;
              $pldFF->tct_pld_campo3_rel = $productosPLD->factorajeFinanciero->campo3;
              $pldFF->account_id_c = $productosPLD->factorajeFinanciero->campo3_id;
              $pldFF->tct_pld_campo4_ddw = $productosPLD->factorajeFinanciero->campo4;
              $pldFF->tct_pld_campo5_rel = $productosPLD->factorajeFinanciero->campo5;
              $pldFF->account_id1_c = $productosPLD->factorajeFinanciero->campo5_id;
              $pldFF->tct_pld_campo7_ddw = $productosPLD->factorajeFinanciero->campo7;
              $pldFF->tct_pld_campo21_ddw = $productosPLD->factorajeFinanciero->campo21;
              $pldFF->tct_pld_campo22_int = $productosPLD->factorajeFinanciero->campo22;
              $pldFF->tct_pld_campo23_dec = $productosPLD->factorajeFinanciero->campo23;
              $pldFF->tct_pld_campo16_ddw = "^" . str_replace(",","^,^",$productosPLD->factorajeFinanciero->campo16) . "^";
              $pldFF->tct_pld_campo17_txt = $productosPLD->factorajeFinanciero->campo17;
              $pldFF->tct_pld_campo15_txt = $productosPLD->factorajeFinanciero->campo15;
              $pldFF->tct_pld_campo14_chk = $productosPLD->factorajeFinanciero->campo14;
              $pldFF->tct_pld_campo24_ddw = $productosPLD->factorajeFinanciero->campo24;
              $pldFF->tct_pld_campo6_ddw = $productosPLD->factorajeFinanciero->campo6;
              $pldFF->name = "Factoraje Financiero";
              $pldFF->description = "FF";
              //Guardar registro
              $pldFF->save();


              ########################
              // Crédito Automotriz :CA
              ########################
              $pldCA = BeanFactory::newBean($modulo);
              //Agregar valores a campo
              $idCuenta = $bean->id;
              $pldCA->accounts_tct_pld_1accounts_ida = $idCuenta;
              $pldCA->tct_pld_campo1_txt = $productosPLD->creditoAutomotriz->campo1;
              $pldCA->tct_pld_campo2_ddw = $productosPLD->creditoAutomotriz->campo2;
              $pldCA->tct_pld_campo3_rel = $productosPLD->creditoAutomotriz->campo3;
              $pldCA->account_id_c = $productosPLD->creditoAutomotriz->campo3_id;
              $pldCA->tct_pld_campo4_ddw = $productosPLD->creditoAutomotriz->campo4;
              $pldCA->tct_pld_campo5_rel = $productosPLD->creditoAutomotriz->campo5;
              $pldCA->account_id1_c = $productosPLD->creditoAutomotriz->campo5_id;
              $pldCA->tct_pld_campo6_ddw = $productosPLD->creditoAutomotriz->campo6;
              $pldCA->name = "Crédito Automotriz";
              $pldCA->description = "CA";
              //Guardar registro
              $pldCA->save();

              ########################
              // Crédito Simple :CS
              ########################
              $pldCS = BeanFactory::newBean($modulo);
              //Agregar valores a campo
              $idCuenta = $bean->id;
              $pldCS->accounts_tct_pld_1accounts_ida = $idCuenta;
              $pldCS->tct_pld_campo1_txt = $productosPLD->creditoSimple->campo1;
              $pldCS->tct_pld_campo2_ddw = $productosPLD->creditoSimple->campo2;
              $pldCS->tct_pld_campo3_rel = $productosPLD->creditoSimple->campo3;
              $pldCS->account_id_c = $productosPLD->creditoSimple->campo3_id;
              $pldCS->tct_pld_campo4_ddw = $productosPLD->creditoSimple->campo4;
              $pldCS->tct_pld_campo5_rel = $productosPLD->creditoSimple->campo5;
              $pldCS->account_id1_c = $productosPLD->creditoSimple->campo5_id;
              $pldCS->tct_pld_campo6_ddw = $productosPLD->creditoSimple->campo6;
              $pldCS->tct_pld_campo18_ddw = "^" . str_replace(",","^,^",$productosPLD->creditoSimple->campo18) . "^";
              $pldCS->tct_pld_campo19_txt = $productosPLD->creditoSimple->campo19;
              $pldCS->tct_pld_campo14_chk = $productosPLD->creditoSimple->campo14;
              $pldCS->tct_pld_campo20_ddw = $productosPLD->creditoSimple->campo20;
              $pldCS->name = "Crédito Simple";
              $pldCS->description = "CS";
              //Guardar registro
              $pldCS->save();

              //Limpia campo tct_nuevo_pld_c
              $update = "update accounts_cstm set tct_nuevo_pld_c='' where id_c='{$bean->id}'";
              $GLOBALS['db']->query($update);
          }

    }
}
