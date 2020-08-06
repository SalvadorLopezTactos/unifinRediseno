<?php

/**
 * Created by Tactos.
 * User: AF
 * Date: 15/07/2020
 *
 */
class Origen_Class
{
    public function Origen_Method($bean = null, $event = null, $args = null)
    {
        //Obteniendo valor para Vía Comunicación
        $id_origen = '';
        switch ($bean->via_comunicacion) {
            case 'WHATSAPP': //WhatsApp
                $id_origen = '25';
                break;
            case 'WEBCHAT': //Chatbot
                $id_origen = '26';
                break;
            case 'MESSENGER': //Messenger
                $id_origen = '27';
                break;
        }

        //Evalua Lead asociado
        if (!empty($bean->leads_c5515_uni_chattigo_1leads_ida) && !empty($id_origen)) {
            //Recupera Lead
            $beanLead = BeanFactory::retrieveBean('Leads',$bean->leads_c5515_uni_chattigo_1leads_ida,array('disable_row_level_security' => true));
            //Valida origen
            if (!empty($beanLead) && empty($beanLead->origen_c)) {
                //Actualiza origen
                $beanLead->origen_c = '1';
                $beanLead->detalle_origen_c = '3';
                $beanLead->medio_digital_c = $id_origen;
                $beanLead->save();
            }
        }
    }

}
