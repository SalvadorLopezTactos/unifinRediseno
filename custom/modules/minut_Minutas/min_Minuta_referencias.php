<?php
/**en la nota esta el nombre de la cuenta
* En campo notas bajar un texto que concatene nota generada y el nombre de la minuta bean similar a this.model 
*/
class Minuta_Referencias
{
    function savereferencia ($bean = null, $event = null, $args = null)
    {
        $GLOBALS['log']->fatal('Logic Hook para crear cuenta LEAD');
        $GLOBALS['log']->fatal(print_r($bean->minuta_referencias,true));
        global $current_user;

        if($bean->minuta_referencias !=null && !empty($bean->minuta_referencias)) {

            $beanCuentas = $bean->id;
            $mReferencias = $bean->minuta_referencias;
            $productosPLD = json_decode($bean->tct_ref_json_c);

            for ($r = 0; $r < count($mReferencias); $r++) {
                $GLOBALS['log']->fatal('Crea cuenta LEAD a partir de Referencia');
                $beanCuentas = BeanFactory::newBean("Accounts");
                $beanCuentas->primernombre_c = $mReferencias[$r]['nombres'];
                $beanCuentas->apellidopaterno_c = $mReferencias[$r]['apaterno'];
                $beanCuentas->apellidomaterno_c = $mReferencias[$r]['amaterno'];
                $beanCuentas->clean_name= str_replace(' ','', $mReferencias[$r]['nombres'].$mReferencias[$r]['apaterno'].$mReferencias[$r]['amaterno']);
                $beanCuentas->phone_office = $mReferencias[$r]['telefono'];
                $beanCuentas->email1 = $mReferencias[$r]['correo'];
                $beanCuentas->tipo_registro_c="Lead";
                $beanCuentas->subtipo_cuenta_c="En Calificacion";
                $beanCuentas->origendelprospecto_c="Referido Cliente";
                $beanCuentas->account_id1_c=$mReferencias[$r]['id_cuenta'];

                $beanCuentas->user_id_c='569246c7-da62-4664-ef2a-5628f649537e';
                $beanCuentas->promotorleasing_c='9 - Sin Gestor';
                $beanCuentas->user_id1_c='569246c7-da62-4664-ef2a-5628f649537e';
                $beanCuentas->promotorfactoraje_c='9 - Sin Gestor';
                $beanCuentas->user_id2_c='569246c7-da62-4664-ef2a-5628f649537e';
                $beanCuentas->promotorcredit_c='9 - Sin Gestor';

                if (strpos($current_user->productos_c, '1') !=false){
                    $beanCuentas->user_id_c=$current_user->id;
                    $beanCuentas->promotorleasing_c='name';
                }
                if (strpos($current_user->productos_c,'4') !=false){
                    $beanCuentas->user_id1_c=$current_user->id;
                    $beanCuentas->promotorfactoraje_c='name';
                }
                if (strpos($current_user->productos_c, '3') !=false){
                    $beanCuentas->user_id2_c=$current_user->id;
                    $beanCuentas->promotorcredit_c='name';
                }

                try {
                    $GLOBALS['log']->fatal('Guarda nueva Cuenta de tipo LEAD ok');
                    $beanCuentas->save();
                } catch (Exception $e) {
                    $GLOBALS['log']->fatal("Error: " . $e);
                }

            }
        }

    }

}