<?php

/**en la nota esta el nombre de la cuenta
 * En campo notas bajar un texto que concatene nota generada y el nombre de la minuta bean similar a this.model
 */
class Minuta_Referencias
{
    function savereferencia($bean = null, $event = null, $args = null)
    {
        $GLOBALS['log']->fatal('Logic Hook para crear LEAD');
        $GLOBALS['log']->fatal(print_r($bean->minuta_referencias, true));
        global $current_user;
        if ($bean->minuta_referencias != null && !empty($bean->minuta_referencias)) {
            $beanLeads = $bean->id;
            $mReferencias = $bean->minuta_referencias;
            $productosPLD = json_decode($bean->tct_ref_json_c);
            for ($r = 0; $r < count($mReferencias); $r++) {
                $GLOBALS['log']->fatal('Crea LEAD a partir de Referencia');
                if ($mReferencias[$r]['regimen_fiscal'] == 'Persona Fisica') $regimen = "1";
                if ($mReferencias[$r]['regimen_fiscal'] == 'Persona Fisica con Actividad Empresarial') $regimen = "2";
                if ($mReferencias[$r]['regimen_fiscal'] == 'Persona Moral') $regimen = "3";
                if ($mReferencias[$r]['regimen_fiscal'] != 'Persona Moral') {
                    $beanLeads = BeanFactory::newBean("Leads");
                    $beanLeads->nombre_c = $mReferencias[$r]['nombres'];
                    $beanLeads->apellido_paterno_c = $mReferencias[$r]['apaterno'];
                    $beanLeads->apellido_materno_c = $mReferencias[$r]['amaterno'];
                    $beanLeads->regimen_fiscal_c = $regimen;
                    //$beanLeads->clean_name = str_replace(' ', '', $mReferencias[$r]['nombres'] . $mReferencias[$r]['apaterno'] . $mReferencias[$r]['amaterno']);
                    $beanLeads->clean_name_c = $mReferencias[$r]['clean_name'];
                    $beanLeads->phone_work = $mReferencias[$r]['telefono'];
                    $beanLeads->email1 = $mReferencias[$r]['correo'];
                    $beanLeads->tipo_registro_c = "1";
                    $beanLeads->subtipo_registro_c = "1";
                    $beanLeads->origen_c = "4";
                    $beanLeads->assigned_user_id = '569246c7-da62-4664-ef2a-5628f649537e';
                    $beanLeads->assigned_user_name = '9 - Sin Gestor';
                    $beanLeads->save();
                    $GLOBALS['log']->fatal('Guarda nuevo LEAD ok');
                } else {
                    //Condición para crear Lead de tipo Persona Moral
                    $beanLeads = BeanFactory::newBean("Leads");
                    $beanLeads->nombre_empresa_c = $mReferencias[$r]['razon_social'];
                    $beanLeads->razonsocial_c = $mReferencias[$r]['razon_social'];
                    $beanLeads->regimen_fiscal_c = $regimen;
                    //$beanLeads->clean_name = str_replace(' ', '', $mReferencias[$r]['razon_social']);
                    $beanLeads->clean_name_c = $mReferencias[$r]['clean_name_moral'];
                    $beanLeads->phone_work = $mReferencias[$r]['telefono'];
                    $beanLeads->email1 = $mReferencias[$r]['correo'];
                    $beanLeads->tipo_registro_c = "1";
                    $beanLeads->subtipo_registro_c = "1";
                    $beanLeads->origen_c = "4";
                    $beanLeads->assigned_user_id = '569246c7-da62-4664-ef2a-5628f649537e';
                    $beanLeads->assigned_user_name = '9 - Sin Gestor';
                    $beanLeads->save();
                    $idLead=$beanLeads->id;

                    if($idLead != null && $idLead != ""){
                        //$clean_name=str_replace(' ', '', $mReferencias[$r]['nombres'] . $mReferencias[$r]['apaterno'] . $mReferencias[$r]['amaterno']);
                        $clean_name = $mReferencias[$r]['clean_name'];
                        //Comprobar si la Persona relacionada existe en la bd
                        $qGetPersona="select a.id as idPersona, email_addresses.email_address, b.clean_name_c, a.phone_work
from leads a
inner join leads_cstm b on b.id_c = a.id
inner join email_addr_bean_rel on email_addr_bean_rel.bean_id = a.id and email_addr_bean_rel.bean_module='Leads'
inner join email_addresses on email_addresses.id = email_addr_bean_rel.email_address_id
where a.id = b.id_c and b.clean_name_c = '{$clean_name}'
";
/*/and (
email_addresses.email_address = '{$mReferencias[$r]['correo']}'
or accounts.phone_office = '{$mReferencias[$r]['telefono']}'
*/
                        $result=$GLOBALS['db']->query($qGetPersona);
                        $encontrados = $result->num_rows;
                        $idPersona='';
                        if($encontrados > 0){
                            while($row = $GLOBALS['db']->fetchByAssoc($result))
                            {
                                $idPersona = $row['idPersona'];
                            }
                        }
                        if($idPersona == ''){
                            //Creación de nueva Cuenta tipo Persona
                            $beanPersona = BeanFactory::newBean("Leads");
                            $beanPersona->nombre_c = $mReferencias[$r]['nombres'];
                            $beanPersona->apellido_paterno_c = $mReferencias[$r]['apaterno'];
                            $beanPersona->apellido_materno_c = $mReferencias[$r]['amaterno'];
                            $beanPersona->regimen_fiscal_c = $regimen;
                            //$beanPersona->clean_name = str_replace(' ', '', $mReferencias[$r]['nombres'] . $mReferencias[$r]['apaterno'] . $mReferencias[$r]['amaterno']);
                            $beanPersona->clean_name_c = $mReferencias[$r]['clean_name'];
                            $beanPersona->phone_work = $mReferencias[$r]['telefono'];
                            $beanPersona->email1 = $mReferencias[$r]['correo'];
                            $beanPersona->tipo_registro_c = "1";
                            $beanPersona->subtipo_registro_c = "1";
                            $beanPersona->assigned_user_id = '569246c7-da62-4664-ef2a-5628f649537e';
                            $beanPersona->assigned_user_name = '9 - Sin Gestor';
                            $beanPersona->save();
                            $idPersona=$beanPersona->id;
                        }
/*                        //Creación de registro de Relacióm
                        $beanRelacion = BeanFactory::newBean("Rel_Relaciones");
                        $beanRelacion->relaciones_activas='^Contacto^';
                        $beanRelacion->tipodecontacto='Promocion';
                        $beanRelacion->rel_relaciones_accounts_1accounts_ida=$idLead;
                        $beanRelacion->rel_relaciones_accounts_1_name=$mReferencias[$r]['razon_social'];
                        $beanRelacion->account_id1_c=$idPersona;
                        $beanRelacion->save();*/
                    }

                }//Termina condición para guardar Lead Persona Moral
            }
        }
    }
}