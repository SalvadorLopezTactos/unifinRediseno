<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 4/07/19
 * Time: 06:46 PM
 */

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class CuentasRelacion extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'recuperaID' => array(
                'reqType' => 'GET',
                'path' => array('DireCuenta', '?'),
                'pathVars' => array('', 'idCuenta'),
                'method' => 'RecuperaDirecciones',
                'shortHelp' => 'Realiza consulta para obtener las direcciones de las cuentas relacionadas',
                'longHelp' => '',
            ),
        );
    }

    public function RecuperaDirecciones($api, $args)
    {
            $idCuenta = $args['idCuenta'];

            //Consulta usuarios relacionados
            $consulta1 = "select distinct relCst.account_id1_c as id, acc.name as name
            from rel_relaciones_accounts_1_c relAcc 
            inner join rel_relaciones rel on rel.id = relAcc.rel_relaciones_accounts_1rel_relaciones_idb -- and rel.relaciones_activas like '%Proveedor de Recursos%'
            inner join rel_relaciones_cstm relCst on relCst.id_c = rel.id
            inner join accounts acc on acc.id = relCst.account_id1_c
            where relAcc.deleted=0
            and relAcc.rel_relaciones_accounts_1accounts_ida='".$idCuenta."';";
            $cuentasRelacionadas = [];
            $cuentasFull = [];
            $relaciones = $GLOBALS['db']->query($consulta1);
            while ($row = $GLOBALS['db']->fetchByAssoc($relaciones)) {
                $cuentasRelacionadas[] = $row['id'];

                $cuentasFull[$row['id']][]= $row['name'];
            }

            //Consulta usuarios con direccion particular
            $consulta2="select distinct relCst.account_id1_c as id, acc.name
            from rel_relaciones_accounts_1_c relAcc
            left join rel_relaciones rel on rel.id = relAcc.rel_relaciones_accounts_1rel_relaciones_idb and rel.relaciones_activas like '%Proveedor de Recursos%'
            left join rel_relaciones_cstm relCst on relCst.id_c = rel.id
            left join accounts_dire_direccion_1_c accDir on accDir.accounts_dire_direccion_1accounts_ida = relCst.account_id1_c
            left join dire_direccion dir  on dir.id = accDir.accounts_dire_direccion_1dire_direccion_idb
            inner join accounts acc on acc.id = relCst.account_id1_c
            where relAcc.deleted=0 and relAcc.rel_relaciones_accounts_1accounts_ida='" .$idCuenta."'
            and (dir.tipodedireccion like '%1%' or dir.tipodedireccion like '%3%' or dir.tipodedireccion like '%5%' or dir.tipodedireccion like '%7%');";
            $cuentasDireccion = [];
            $relaciones2 = $GLOBALS['db']->query($consulta2);
            while ($row = $GLOBALS['db']->fetchByAssoc($relaciones2)) {
                $cuentasDireccion[] = $row['id'];
            }



            //Comparar arreglos - diferencias
            $cuentasNoDireccion =array_diff($cuentasRelacionadas,$cuentasDireccion);

            //Recuperar nombres de cuentas
            $cuentasNombres = "";
            if ($cuentasNoDireccion != "") {

                //Tiene cuentas sin direccion
                $idsNoDireccion = "'" . implode("','", $cuentasNoDireccion) . "'";
                //Consulta usuarios con direccion particular
                $consulta3="select name from accounts where id in (" .$idsNoDireccion.") and deleted=0;";
                    $cuentasDireccion = [];
                    $relaciones3 = $GLOBALS['db']->query($consulta3);
                    while ($row = $GLOBALS['db']->fetchByAssoc($relaciones3)) {
                        $cuentasNombres = $cuentasNombres .'<br>'. $row['name'];
                    }
            }
            return $cuentasNombres;



    }

}