<?php
/**
 * Created by PhpStorm.
 * User: Adrian Arauz
 * Date: 27/03/19
 * Time: 09:35 AM
 */

class LeadNV_hook
{
    public function saveleadnv($bean = null, $event = null, $args = null)
    {
        //
        $leadNoViale = $bean->tct_noviable;
        $GLOBALS['log']->fatal("Entra a Guardar info de Lead no Viable");
        if (!empty($leadNoViale)) {

            if ($leadNoViale['id']) {
                $GLOBALS['log']->fatal("Pregunta si hay un id");
                $beanNV = BeanFactory::retrieveBean('tct3_noviable', $leadNoViale['id']);
            } else {
                $GLOBALS['log']->fatal("No hay id, crea un nuevo bean");
                $beanNV = BeanFactory::newBean('tct3_noviable');
            }
            $GLOBALS['log']->fatal("Almacena datos");
            $GLOBALS['log']->fatal($leadNoViale);
            $beanNV->no_viable_leasing_chk_c = $leadNoViale['campo1chk'];
            $beanNV->no_viable_factoraje_chk_c = $leadNoViale['campo2chk'];
            $beanNV->no_viable_ca_chk_c = $leadNoViale['campo3chk'];
            $beanNV->razones_leasing_ddw_c = $leadNoViale['razonleasing'];
            $beanNV->razones_factoraje_ddw_c = $leadNoViale['razonfactoraje'];
            $beanNV->razones_ca_ddw_c = $leadNoViale['razonca'];
            $beanNV->fuera_perfil_l_ddw_c = $leadNoViale['fueraperfilL'];
            $beanNV->fuera_perfil_f_ddw_c = $leadNoViale['fueraperfilF'];
            $beanNV->fuera_perfil_ca_ddw_c = $leadNoViale['fueraperfilCA'];
            $beanNV->tct_competencia_quien_l_txf_c = $leadNoViale['quienl'];
            $beanNV->tct_competencia_porque_l_txf_c = $leadNoViale['porquel'];
            $beanNV->no_producto_requiere_l_ddw_c = $leadNoViale['noproducl'];
            $beanNV->tct_competencia_quien_f_txf_c = $leadNoViale['quienf'];
            $beanNV->tct_competencia_porque_f_txf_c = $leadNoViale['porquef'];
            $beanNV->no_producto_requiere_f_ddw_c = $leadNoViale['noproducf'];
            $beanNV->tct_competencia_quien_ca_txf_c = $leadNoViale['quienca'];
            $beanNV->tct_competencia_porque_ca_txf_c = $leadNoViale['porqueca'];
            $beanNV->no_producto_requiere_ca_ddw_c = $leadNoViale['noproducca'];
            $beanNV->tct_razon_cf_l_ddw_c = $leadNoViale ['razoncfl'];
            $beanNV->tct_razon_ni_l_ddw_c = $leadNoViale['razonnil'];
            $beanNV->tct_que_producto_l_txf_c = $leadNoViale['queprodl'];
            $beanNV->tct_razon_cf_f_ddw_c = $leadNoViale['razoncff'];
            $beanNV->tct_razon_ni_f_ddw_c = $leadNoViale['razonnif'];
            $beanNV->tct_que_producto_f_txf_c = $leadNoViale['queprodf'];
            $beanNV->tct_razon_cf_ca_ddw_c = $leadNoViale['razoncfca'];
            $beanNV->tct_razon_ni_ca_ddw_c = $leadNoViale['razonnica'];
            $beanNV->tct_que_producto_ca_txf_c = $leadNoViale['queprodca'];
            $beanNV->user_id_c= $leadNoViale['PromotorLeasing'];
            $beanNV->user_id1_c= $leadNoViale['PromotorFactoraje'];
            $beanNV->user_id2_c= $leadNoViale['PromotorCreditA'];
            $beanNV->name = $bean->name;
            $beanNV->save();
            $GLOBALS['log']->fatal("Termina de guardar datos de Lead no Viable");
            $bean->accounts_tct3_noviable_1->add($beanNV->id);
        }
    }


}
