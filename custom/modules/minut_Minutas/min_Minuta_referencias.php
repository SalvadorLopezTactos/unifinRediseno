<?php

/**en la nota esta el nombre de la cuenta
 * En campo notas bajar un texto que concatene nota generada y el nombre de la minuta bean similar a this.model
 */
class Minuta_Referencias
{
    function savereferencia($bean = null, $event = null, $args = null)
    {
        $GLOBALS['log']->fatal('Logic Hook para crear cuenta LEAD');
        $GLOBALS['log']->fatal(print_r($bean->minuta_referencias, true));
        global $current_user;

        if ($bean->minuta_referencias != null && !empty($bean->minuta_referencias)) {

            $beanCuentas = $bean->id;
            $mReferencias = $bean->minuta_referencias;
            $productosPLD = json_decode($bean->tct_ref_json_c);

            for ($r = 0; $r < count($mReferencias); $r++) {
                $GLOBALS['log']->fatal('Crea cuenta LEAD a partir de Referencia');
                if ($mReferencias[$r]['regimen_fiscal'] != 'Persona Moral') {

                    $beanCuentas = BeanFactory::newBean("Accounts");
                    $beanCuentas->primernombre_c = $mReferencias[$r]['nombres'];
                    $beanCuentas->apellidopaterno_c = $mReferencias[$r]['apaterno'];
                    $beanCuentas->apellidomaterno_c = $mReferencias[$r]['amaterno'];
                    $beanCuentas->tipodepersona_c = $mReferencias[$r]['regimen_fiscal'];
                    //$beanCuentas->clean_name = str_replace(' ', '', $mReferencias[$r]['nombres'] . $mReferencias[$r]['apaterno'] . $mReferencias[$r]['amaterno']);
                    $beanCuentas->clean_name= $mReferencias[$r]['clean_name'];
                    $beanCuentas->phone_office = $mReferencias[$r]['telefono'];
                    $beanCuentas->email1 = $mReferencias[$r]['correo'];
                    $beanCuentas->tipo_registro_cuenta_c = "1";
                    $beanCuentas->subtipo_registro_cuenta_c = "5";
                    $beanCuentas->origendelprospecto_c = "Referido Cliente";
                    $beanCuentas->account_id1_c = $mReferencias[$r]['id_cuenta'];

                    $beanCuentas->user_id_c = '569246c7-da62-4664-ef2a-5628f649537e';
                    $beanCuentas->promotorleasing_c = '9 - Sin Gestor';
                    $beanCuentas->user_id1_c = '569246c7-da62-4664-ef2a-5628f649537e';
                    $beanCuentas->promotorfactoraje_c = '9 - Sin Gestor';
                    $beanCuentas->user_id2_c = '569246c7-da62-4664-ef2a-5628f649537e';
                    $beanCuentas->promotorcredit_c = '9 - Sin Gestor';
                    $beanCuentas->user_id6_c = '569246c7-da62-4664-ef2a-5628f649537e';
                    $beanCuentas->promotorfleet_c = '9 - Sin Gestor';

                    if (strpos($current_user->productos_c, '1') != false) {
                        $beanCuentas->user_id_c = $current_user->id;
                        $beanCuentas->promotorleasing_c = 'name';
                    }
                    if (strpos($current_user->productos_c, '4') != false) {
                        $beanCuentas->user_id1_c = $current_user->id;
                        $beanCuentas->promotorfactoraje_c = 'name';
                    }
                    if (strpos($current_user->productos_c, '3') != false) {
                        $beanCuentas->user_id2_c = $current_user->id;
                        $beanCuentas->promotorcredit_c = 'name';
                    }
                    if (strpos($current_user->productos_c, '6') != false) {
                        $beanCuentas->user_id6_c = $current_user->id;
                        $beanCuentas->promotorfleet_c = 'name';
                    }

                    $beanCuentas->save();
                    $GLOBALS['log']->fatal('Guarda nueva Cuenta de tipo LEAD ok');


                } else {
                    //Condición para crear Cuenta de tipo Persona Moral (Lead) y Cuenta tipo Persona
                    $beanCuentas = BeanFactory::newBean("Accounts");
                    $beanCuentas->razonsocial_c=$mReferencias[$r]['razon_social'];
                    $beanCuentas->nombre_comercial_c=$mReferencias[$r]['razon_social'];
                    $beanCuentas->tipodepersona_c = $mReferencias[$r]['regimen_fiscal'];
                    //$beanCuentas->clean_name = str_replace(' ', '', $mReferencias[$r]['razon_social']);
                    $beanCuentas->clean_name= $mReferencias[$r]['clean_name_moral'];
                    $beanCuentas->phone_office = $mReferencias[$r]['telefono'];
                    $beanCuentas->email1 = $mReferencias[$r]['correo'];
                    $beanCuentas->tipo_registro_cuenta_c = "1";
                    $beanCuentas->subtipo_registro_cuenta_c = "5";
                    $beanCuentas->origendelprospecto_c = "Referido Cliente";
                    $beanCuentas->account_id1_c = $mReferencias[$r]['id_cuenta'];

                    $beanCuentas->user_id_c = '569246c7-da62-4664-ef2a-5628f649537e';
                    $beanCuentas->promotorleasing_c = '9 - Sin Gestor';
                    $beanCuentas->user_id1_c = '569246c7-da62-4664-ef2a-5628f649537e';
                    $beanCuentas->promotorfactoraje_c = '9 - Sin Gestor';
                    $beanCuentas->user_id2_c = '569246c7-da62-4664-ef2a-5628f649537e';
                    $beanCuentas->promotorcredit_c = '9 - Sin Gestor';
                    $beanCuentas->user_id6_c = '569246c7-da62-4664-ef2a-5628f649537e';
                    $beanCuentas->promotorfleet_c = '9 - Sin Gestor';

                    if (strpos($current_user->productos_c, '1') != false) {
                        $beanCuentas->user_id_c = $current_user->id;
                        $beanCuentas->promotorleasing_c = 'name';
                    }
                    if (strpos($current_user->productos_c, '4') != false) {
                        $beanCuentas->user_id1_c = $current_user->id;
                        $beanCuentas->promotorfactoraje_c = 'name';
                    }
                    if (strpos($current_user->productos_c, '3') != false) {
                        $beanCuentas->user_id2_c = $current_user->id;
                        $beanCuentas->promotorcredit_c = 'name';
                    }
                    if (strpos($current_user->productos_c, '3') != false) {
                        $beanCuentas->user_id6_c = $current_user->id;
                        $beanCuentas->promotorfleet_c = 'name';
                    }

                    $beanCuentas->save();
                    $idLead=$beanCuentas->id;

                    if($idLead != null && $idLead != ""){
                        //$clean_name=str_replace(' ', '', $mReferencias[$r]['nombres'] . $mReferencias[$r]['apaterno'] . $mReferencias[$r]['amaterno']);
                        $clean_name = $mReferencias[$r]['clean_name'];
                        //Comprobar si la Persona relacionada existe en la bd
                        $qGetPersona="select accounts.id as idPersona, email_addresses.email_address, accounts.clean_name, accounts.phone_office
from accounts
inner join email_addr_bean_rel on email_addr_bean_rel.bean_id = accounts.id and email_addr_bean_rel.bean_module='Accounts'
inner join email_addresses on email_addresses.id = email_addr_bean_rel.email_address_id
where 
accounts.clean_name = '{$clean_name}
";
/*/and (
email_addresses.email_address = '{$mReferencias[$r]['correo']}'
or accounts.phone_office = '{$mReferencias[$r]['telefono']}'
*/

                        $result=$GLOBALS['db']->query($qGetPersona);

                        $encontrados = $result->num_rows;
                        $idPersona='';
                        if($encontrados >0){

                            while($row = $GLOBALS['db']->fetchByAssoc($result))
                            {
                                $idPersona = $row['idPersona'];
                            }

                        }

                        if($idPersona == ''){

                            //Creación de nueva Cuenta tipo Persona
                            $beanPersona = BeanFactory::newBean("Accounts");
                            $beanPersona->primernombre_c = $mReferencias[$r]['nombres'];
                            $beanPersona->apellidopaterno_c = $mReferencias[$r]['apaterno'];
                            $beanPersona->apellidomaterno_c = $mReferencias[$r]['amaterno'];
                            //$beanPersona->clean_name = str_replace(' ', '', $mReferencias[$r]['nombres'] . $mReferencias[$r]['apaterno'] . $mReferencias[$r]['amaterno']);
                            $beanCuentas->clean_name= $mReferencias[$r]['clean_name'];
                            $beanPersona->phone_office = $mReferencias[$r]['telefono'];
                            $beanPersona->email1 = $mReferencias[$r]['correo'];
                            $beanPersona->tipo_registro_cuenta_c = "4";
                            $beanPersona->tipo_relacion_c = "^Contacto^";
                            $beanPersona->account_id1_c = $mReferencias[$r]['id_cuenta'];

                            $beanPersona->user_id_c = '569246c7-da62-4664-ef2a-5628f649537e';
                            $beanPersona->promotorleasing_c = '9 - Sin Gestor';
                            $beanPersona->user_id1_c = '569246c7-da62-4664-ef2a-5628f649537e';
                            $beanPersona->promotorfactoraje_c = '9 - Sin Gestor';
                            $beanPersona->user_id2_c = '569246c7-da62-4664-ef2a-5628f649537e';
                            $beanPersona->promotorcredit_c = '9 - Sin Gestor';
                            $beanPersona->user_id6_c = '569246c7-da62-4664-ef2a-5628f649537e';
                            $beanPersona->promotorfleet_c = '9 - Sin Gestor';

                            if (strpos($current_user->productos_c, '1') != false) {
                                $beanPersona->user_id_c = $current_user->id;
                                $beanPersona->promotorleasing_c = 'name';
                            }
                            if (strpos($current_user->productos_c, '4') != false) {
                                $beanPersona->user_id1_c = $current_user->id;
                                $beanPersona->promotorfactoraje_c = 'name';
                            }
                            if (strpos($current_user->productos_c, '3') != false) {
                                $beanPersona->user_id2_c = $current_user->id;
                                $beanPersona->promotorcredit_c = 'name';
                            }
                            if (strpos($current_user->productos_c, '6') != false) {
                                $beanPersona->user_id6_c = $current_user->id;
                                $beanPersona->promotorfleet_c = 'name';
                            }

                            $beanPersona->save();
                            $idPersona=$beanPersona->id;


                        }
                        //Creación de registro de Relacióm
                        $beanRelacion = BeanFactory::newBean("Rel_Relaciones");
                        $beanRelacion->relaciones_activas='^Contacto^';
                        $beanRelacion->tipodecontacto='Promocion';
                        $beanRelacion->rel_relaciones_accounts_1accounts_ida=$idLead;
                        $beanRelacion->rel_relaciones_accounts_1_name=$mReferencias[$r]['razon_social'];
                        $beanRelacion->account_id1_c=$idPersona;
                        $beanRelacion->save();

                    }


                }//Termina condición para guardar Lead Persona Moral y Cuenta tipo Persona

            }
        }

    }
}