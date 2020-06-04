<?php

require_once 'include/api/SugarApiException.php';
require_once 'include/SugarQuery/SugarQuery.php';

class CBduplicados
{

    function duplicadosCB($bean = null, $event = null, $args = null)
    {
    	if( !$bean ) {
            return;
        }
        $accountId = $bean->cta_cuentas_bancarias_accountsaccounts_ida;
        $duplicateAccountMessage = 'Error: La cuenta bancaria a ingresar ya existe.';
        $accountCB = BeanFactory::getBean('cta_cuentas_bancarias');
        //Ejecuta nuevo Sugarquery
        $sq = new SugarQuery();
        $sq->from($accountCB, array('team_security' => false));
        $sq->where()->equals('cta_cuentas_bancarias_accountsaccounts_ida',$accountId);
        $res = $sq->execute();
        //Itera respuesta para definir mensaje de error (Cuenta duplicada)
        foreach($res as $index=>$cuenta_bancaria) {
            if($cuenta_bancaria['id']!== $bean->id && $cuenta_bancaria['banco'] === $bean->banco && $cuenta_bancaria['cuenta']===$bean->cuenta && $cuenta_bancaria['clabe']===$bean->clabe) {
                throw new SugarApiExceptionInvalidParameter($duplicateAccountMessage);
            }
        }

    }
}