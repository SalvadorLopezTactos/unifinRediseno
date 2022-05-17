<?php
/**
 * Created by JG.
 * User: tactos
 * Date: 3/03/21
 * Time: 05:19 PM
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class validaAccountsPLD extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'POST_validaPLD' => array(
                'reqType' => 'POST',
                'noLoginRequired' => false,
                'path' => array('Accounts', 'validaPLD'),
                'pathVars' => array('', ''),
                'method' => 'secuencia_validaPLD',
                'shortHelp' => 'Alta de Lead a través de diferentes servicios',
            ),
        );
    }

    public function secuencia_validaPLD($api, $args)
    {
        $prod_disponible = [39, 48, 51];
        $idCuenta = $args['idCuentaCRM'];
        $producto = $args['productos'][0]['producto'];
        $beanCuenta = BeanFactory::getBean('Accounts', $idCuenta, array('disable_row_level_security' => true));
        if (!empty($beanCuenta->id)) {
            if (in_array($producto, $prod_disponible)) {
                if ($beanCuenta->tipodepersona_c == 'Persona Fisica') {
                    $tipodePersona = 'PF';
                }
                if ($beanCuenta->tipodepersona_c == 'Persona Fisica con Actividad Empresarial') {
                    $tipodePersona = 'PFAE';
                }
                if ($beanCuenta->tipodepersona_c == 'Persona Moral') {
                    $tipodePersona = 'PM';
                }
                $nacionalidad = $beanCuenta->nacionalidad_c == '2' ? 'Nacional' : 'Extranjera'; # 2 Mexicana
                $faltantes = [];
                $respuesta = [];
                /** Secuencia para Persona Física y Física con Actividad Empresarial */
                if ($tipodePersona != 'PM') {
                    $CamposCuenta = $this->validaDatosCuenta($beanCuenta, $nacionalidad, $producto, $tipodePersona);
                    $CamposPldCS = $this->validaPldCS($beanCuenta, $nacionalidad, $producto, $tipodePersona);
                    $CamposPldCR = $this->validaPldCR($beanCuenta, $nacionalidad, $producto, $tipodePersona);
                    $CamposPepsPFP = $this->validaPepsPFP($beanCuenta, $nacionalidad, $producto, $tipodePersona);
                    $CamposPepsPFF = $this->validaPepsPFF($beanCuenta, $nacionalidad, $producto, $tipodePersona);

                    if (!empty($CamposCuenta)) {
                        $faltantes = array_merge($faltantes, $CamposCuenta);
                    };
                    if (!empty($CamposPldCS)) {
                        $faltantes = array_merge($faltantes, $CamposPldCS);
                    }
                    if (!empty($CamposPldCR)) {
                        $faltantes = array_merge($faltantes, $CamposPldCR);
                    }
                    if (!empty($CamposPepsPFP)) {
                        $faltantes = array_merge($faltantes, $CamposPepsPFP);
                    }
                    if (!empty($CamposPepsPFF)) {
                        $faltantes = array_merge($faltantes, $CamposPepsPFF);
                    }

                } /** Secuencia para Persona Moral */
                else {
                    $CamposCuenta = $this->validaDatosCuenta($beanCuenta, $nacionalidad, $producto, $tipodePersona);
                    $CamposPldCS = $this->validaPldCS($beanCuenta, $nacionalidad, $producto, $tipodePersona);
                    $CamposPldCR = $this->validaPldCR($beanCuenta, $nacionalidad, $producto, $tipodePersona);
                    $CamposPepsPMF = $this->validaPepsPMF($beanCuenta, $nacionalidad, $producto, $tipodePersona);
                    $CamposPepsPMP = $this->validaPepsPMP($beanCuenta, $nacionalidad, $producto, $tipodePersona);

                    if (!empty($CamposCuenta)) {
                        $faltantes = array_merge($faltantes, $CamposCuenta);
                    }
                    if (!empty($CamposPldCS)) {
                        $faltantes = array_merge($faltantes, $CamposPldCS);
                    }
                    if (!empty($CamposPldCR)) {
                        $faltantes = array_merge($faltantes, $CamposPldCR);
                    }
                    if (!empty($CamposPepsPMF)) {
                        $faltantes = array_merge($faltantes, $CamposPepsPMF);
                    }
                    if (!empty($CamposPepsPMP)) {
                        $faltantes = array_merge($faltantes, $CamposPepsPMP);
                    }
                }

                $estado = count($faltantes) == 0 ? "Completo" : "Incompleto";
                $respuesta = [
                    "idCuentaCRM" => "{$idCuenta}",
                    "nombreCuenta" => "$beanCuenta->name",
                    "productos" => [
                        "producto" => "{$producto}",
                        "estadoPLD" => "{$estado}",
                        "faltantes" => $faltantes
                    ]
                ];
            } else {
                $respuesta = ["error" => "511",
                    "error_message" => "No existe el producto o no esta soportado"];
            }
        } else {
            $respuesta = ["error" => "510",
                "error_message" => "No existe la Cuenta"];
        }
        return $respuesta;
    }

    public function validaDatosCuenta($beanAccount, $nacionalidad, $producto, $tipodePersona)
    {
        global $db;
        if ($tipodePersona != 'PM') {
            $qorder = "ORDER BY id_pf_pfae ASC";
        } else {
            $qorder = "ORDER BY id_pm ASC";

        }

        $query = "SELECT * from require_pld_service
WHERE seccion='CUENTA'
AND residencia like '%{$nacionalidad}%'
AND producto like '%{$producto}%'
AND tipo_persona LIKE '%{$tipodePersona}%'
AND deleted=0 ".$qorder;


        $result_cuenta = $db->query($query);
        $faltantes = [];
        $requeridos = $result_cuenta->num_rows;
        if ($requeridos > 0) {
            while ($row = $db->fetchByAssoc($result_cuenta)) {
                $campo = $row['campo_db'];
                $numCriterio = $tipodePersona != 'PM' ? $row['id_pf_pfae'] : $row['id_pm'];
                $descripcion = $row['campo_descripcion'];

                if ($campo == 'telefono') {
                    $tel_respuesta = $this->validaTelefonos($beanAccount->id);
                    if (!$tel_respuesta) {
                        array_push($faltantes, array("criterio" => "{$numCriterio}", "descripcion" => "{$descripcion}"));
                    }
                } elseif ($campo == 'direccion') {
                    $dir_respuesta = $this->validaDireccion($beanAccount->id);
                    if (!$dir_respuesta) {
                        array_push($faltantes, array("criterio" => "{$numCriterio}", "descripcion" => "{$descripcion}"));
                    }
                } elseif ($campo == 'relacion') {
                    $rel_respuesta = $this->validaApoderadoLegal($beanAccount->id);
                    if (!$rel_respuesta) {
                        array_push($faltantes, array("criterio" => "{$numCriterio}", "descripcion" => "{$descripcion}"));
                    }
                } else {
                    if (empty($beanAccount->{$campo})) {
                        array_push($faltantes, array("criterio" => "{$numCriterio}", "descripcion" => "{$descripcion}"));
                    }
                }
            }
        }
        //$GLOBALS['log']->fatal("faltantes  " . print_r($faltantes, true));
        return $faltantes;
    }

    public function validaTelefonos($idCuenta)
    {
        global $db;
        $queryTel = "SELECT count(*) as numregistro from accounts_tel_telefonos_1_c rel
INNER JOIN tel_telefonos telefono
ON telefono.id=rel.accounts_tel_telefonos_1tel_telefonos_idb
WHERE rel.accounts_tel_telefonos_1accounts_ida='{$idCuenta}'
AND telefono.estatus='Activo'
AND rel.deleted=0
AND telefono.deleted=0";
        $result_tel = $db->query($queryTel);
        $row = $db->fetchByAssoc($result_tel);
        $countTel = $row['numregistro'];

        return $countTel > 0 ? true : false;

    }

    public function validaDireccion($idcuenta)
    {
        global $db;
        $queryDir = "SELECT count(*) numregistro from accounts_dire_direccion_1_c rel
  INNER JOIN dire_direccion direccion
    ON direccion.id=rel.accounts_dire_direccion_1dire_direccion_idb
WHERE rel.accounts_dire_direccion_1accounts_ida='{$idcuenta}'
     AND direccion.tipodedireccion IN ('^1^','^3^','^5^','^7^')
    AND rel.deleted=0
    AND direccion.deleted=0;";
        $result_dir = $db->query($queryDir);
        $row = $db->fetchByAssoc($result_dir);
        $countDir = $row['numregistro'];

        return $countDir > 0 ? true : false;
    }

    public function validaApoderadoLegal($idCuenta)
    {
        global $db;

        $query = "select cstm.account_id1_c,relacion.name from rel_relaciones_accounts_1_c rel
  INNER JOIN rel_relaciones relacion
  ON relacion.id=rel.rel_relaciones_accounts_1rel_relaciones_idb
  INNER JOIN rel_relaciones_cstm cstm
  ON cstm.id_c=relacion.id
  where rel.rel_relaciones_accounts_1accounts_ida='{$idCuenta}'
  AND relacion.relaciones_activas LIKE '%^Representante^%'";
        $result_cuenta = $db->query($query);
        $completo = false;
        $registros = $result_cuenta->num_rows;
        if ($registros > 0) {
            while ($row = $db->fetchByAssoc($result_cuenta)) {
                $beanCuenta = BeanFactory::getBean('Accounts', $row['account_id1_c'], array('disable_row_level_security' => true));
                if (!empty($beanCuenta->primernombre_c) && !empty($beanCuenta->apellidopaterno_c) && !empty($beanCuenta->apellidomaterno_c)) {
                    $completo = true;
                }
            }
        }
        return $completo;
    }

    /* PLD - Crédito Simple */
    public function validaPldCS($beanAccount, $nacionalidad, $producto, $tipodePersona)
    {
        global $db;
        if ($tipodePersona != 'PM') {
            $qorder = "ORDER BY id_pf_pfae ASC";
        } else {
            $qorder = "ORDER BY id_pm ASC";

        }

        $qIdPLD="select pld.id as idpld FROM  accounts_tct_pld_1_c rel
INNER join  tct_pld pld
  ON pld.id=rel.accounts_tct_pld_1tct_pld_idb
WHERE rel.accounts_tct_pld_1accounts_ida='{$beanAccount->id}'
AND description='CS'
AND pld.deleted=0";
        $result_idpld = $db->query($qIdPLD);
        $row = $db->fetchByAssoc($result_idpld);
        $pld_id = $row['idpld'];
        $beanPLD = BeanFactory::getBean('tct_PLD', $pld_id, array('disable_row_level_security' => true));

        $query = "SELECT * from require_pld_service
WHERE seccion='PLD - Crédito Simple'
      AND residencia like '%{$nacionalidad}%'
      AND producto like '%{$producto}%'
      AND tipo_persona LIKE '%{$tipodePersona}%'
      AND deleted=0 ".$qorder;

        $result_cuenta = $db->query($query);
        $faltantes = [];
        $requeridos = $result_cuenta->num_rows;
        if ($requeridos > 0) {
            while ($row = $db->fetchByAssoc($result_cuenta)) {
                $campo = $row['campo_db'];
                $numCriterio = $tipodePersona != 'PM' ? $row['id_pf_pfae'] : $row['id_pm'];
                $descripcion = $row['campo_descripcion'];
                if (empty($beanPLD->{$campo})) {
                    array_push($faltantes, array("criterio" => "{$numCriterio}", "descripcion" => "{$descripcion}"));
                }
            }
        }
        return $faltantes;
    }

    /* PLD - Crédito Revolvente (Unirevolving/Unicard) */
    public function validaPldCR($beanAccount, $nacionalidad, $producto, $tipodePersona)
    {
        global $db;
        if ($tipodePersona != 'PM') {
            $qorder = "ORDER BY id_pf_pfae ASC";
        } else {
            $qorder = "ORDER BY id_pm ASC";

        }
        $qIdPLD="select pld.id as idpld FROM  accounts_tct_pld_1_c rel
INNER join  tct_pld pld
  ON pld.id=rel.accounts_tct_pld_1tct_pld_idb
WHERE rel.accounts_tct_pld_1accounts_ida='{$beanAccount->id}'
AND description='CR'
AND pld.deleted=0";
        $result_idpld = $db->query($qIdPLD);
        $row = $db->fetchByAssoc($result_idpld);
        $pld_id = $row['idpld'];
        $beanPLD = BeanFactory::getBean('tct_PLD', $pld_id, array('disable_row_level_security' => true));

        $query = "SELECT * from require_pld_service
WHERE seccion='PLD - Crédito Revolvente (Unirevolving/Unicard)'
      AND residencia like '%{$nacionalidad}%'
      AND producto like '%{$producto}%'
      AND tipo_persona LIKE '%{$tipodePersona}%'
      AND deleted=0 ".$qorder;
        $result_cuenta = $db->query($query);
        $faltantes = [];
        $requeridos = $result_cuenta->num_rows;
        if ($requeridos > 0) {
            while ($row = $db->fetchByAssoc($result_cuenta)) {
                $campo = $row['campo_db'];
                $numCriterio = $tipodePersona != 'PM' ? $row['id_pf_pfae'] : $row['id_pm'];
                $descripcion = $row['campo_descripcion'];
                if (empty($beanPLD->{$campo})) {
                    array_push($faltantes, array("criterio" => "{$numCriterio}", "descripcion" => "{$descripcion}"));
                }
            }
        }
        return $faltantes;
    }

    /* Pep´s Persona Física Personal */
    public function validaPepsPFP($beanAccount, $nacionalidad, $producto, $tipodePersona)
    {
        global $db;

        $query = "SELECT * from require_pld_service
WHERE seccion='Pep´s Persona Física Personal'
      AND residencia like '%{$nacionalidad}%'
      AND producto like '%{$producto}%'
      AND tipo_persona LIKE '%{$tipodePersona}%'
      AND deleted=0";
        $result_cuenta = $db->query($query);
        $faltantes = [];
        $requeridos = $result_cuenta->num_rows;
        $checkMarcado = false;
        if ($requeridos > 0) {
            while ($row = $db->fetchByAssoc($result_cuenta)) {
                $campo = $row['campo_db'];
                $numCriterio = $tipodePersona != 'PM' ? $row['id_pf_pfae'] : $row['id_pm'];
                $descripcion = $row['campo_descripcion'];
                if ($campo == 'ctpldfuncionespublicas_c' && $beanAccount->{$campo}) {
                    $checkMarcado = true;
                    // array_push($faltantes, array("criterio" => "{$numCriterio}", "descripcion" => "{$descripcion}"));
                }
                if (empty($beanAccount->{$campo})) {
                    array_push($faltantes, array("criterio" => "{$numCriterio}", "descripcion" => "{$descripcion}"));
                }
            }
        }
        return $checkMarcado ? $faltantes : [];
    }

    /* Pep´s Persona Física Familiar */
    public function validaPepsPFF($beanAccount, $nacionalidad, $producto, $tipodePersona)
    {
        global $db;

        $query = "SELECT * from require_pld_service
WHERE seccion='Pep´s Persona Física Familiar'
      AND residencia like '%{$nacionalidad}%'
      AND producto like '%{$producto}%'
      AND tipo_persona LIKE '%{$tipodePersona}%'
      AND deleted=0";
        $result_cuenta = $db->query($query);
        $faltantes = [];
        $requeridos = $result_cuenta->num_rows;
        $checkMarcado = false;
        if ($requeridos > 0) {
            while ($row = $db->fetchByAssoc($result_cuenta)) {
                $campo = $row['campo_db'];
                $numCriterio = $tipodePersona != 'PM' ? $row['id_pf_pfae'] : $row['id_pm'];
                $descripcion = $row['campo_descripcion'];
                if ($campo == 'ctpldconyuge_c' && $beanAccount->{$campo}) {
                    $checkMarcado = true;
                    // array_push($faltantes, array("criterio" => "{$numCriterio}", "descripcion" => "{$descripcion}"));
                }
                if (empty($beanAccount->{$campo})) {
                    array_push($faltantes, array("criterio" => "{$numCriterio}", "descripcion" => "{$descripcion}"));
                }
            }
        }
        return $checkMarcado ? $faltantes : [];
    }

    /* Pep´s Persona Moral Familiar */
    public function validaPepsPMF($beanAccount, $nacionalidad, $producto, $tipodePersona)
    {
        global $db;

        $query = "SELECT * from require_pld_service
WHERE seccion='Pep´s Persona Moral Familiar'
      AND residencia like '%{$nacionalidad}%'
      AND producto like '%{$producto}%'
      AND tipo_persona LIKE '%{$tipodePersona}%'
      AND deleted=0";
        $result_cuenta = $db->query($query);
        $faltantes = [];
        $requeridos = $result_cuenta->num_rows;
        $checkMarcado = false;
        if ($requeridos > 0) {
            while ($row = $db->fetchByAssoc($result_cuenta)) {
                $campo = $row['campo_db'];
                $numCriterio = $tipodePersona != 'PM' ? $row['id_pf_pfae'] : $row['id_pm'];
                $descripcion = $row['campo_descripcion'];
                if ($campo == 'ctpldaccionistasconyuge_c' && $beanAccount->{$campo}) {
                    $checkMarcado = true;
                    // array_push($faltantes, array("criterio" => "{$numCriterio}", "descripcion" => "{$descripcion}"));
                }
                if (empty($beanAccount->{$campo})) {
                    array_push($faltantes, array("criterio" => "{$numCriterio}", "descripcion" => "{$descripcion}"));
                }
            }
        }
        return $checkMarcado ? $faltantes : [];
    }

    /* Pep´s Persona Moral Personal */
    public function validaPepsPMP($beanAccount, $nacionalidad, $producto, $tipodePersona)
    {
        global $db;

        $query = "SELECT * from require_pld_service
WHERE seccion='Pep´s Persona Moral Personal'
      AND residencia like '%{$nacionalidad}%'
      AND producto like '%{$producto}%'
      AND tipo_persona LIKE '%{$tipodePersona}%'
      AND deleted=0";
        $result_cuenta = $db->query($query);
        $faltantes = [];
        $requeridos = $result_cuenta->num_rows;
        $checkMarcado = false;
        if ($requeridos > 0) {
            while ($row = $db->fetchByAssoc($result_cuenta)) {
                $campo = $row['campo_db'];
                $numCriterio = $tipodePersona != 'PM' ? $row['id_pf_pfae'] : $row['id_pm'];
                $descripcion = $row['campo_descripcion'];
                if ($campo == 'ctpldaccionistas_c' && $beanAccount->{$campo}) {
                    $checkMarcado = true;
                    // array_push($faltantes, array("criterio" => "{$numCriterio}", "descripcion" => "{$descripcion}"));
                }
                if (empty($beanAccount->{$campo})) {
                    array_push($faltantes, array("criterio" => "{$numCriterio}", "descripcion" => "{$descripcion}"));
                }
            }
        }
        return $checkMarcado ? $faltantes : [];
    }


}