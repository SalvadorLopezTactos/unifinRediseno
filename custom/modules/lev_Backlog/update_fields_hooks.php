<?php

/**
 * Created by TACTOS.
 * User: JG
 * Date: 17/06/20
 * Time: 05:40 PM
 */
class update_fields_hooks
{

    public function actualizaCamposBacklog($bean = null, $event = null, $args = null)
    {

        // Producto
        switch ($bean->producto_c) {
            case 1:
                $bean->producto = "Leasing";
                break;
            case 4:
                $bean->producto = "Factoraje";
                break;
            case 3:
                $bean->producto = "Credito Automotriz";
                break;
            case 10:
                $bean->producto = "Seguros";
                break;
        }

        // Etapa
        switch ($bean->etapa_c) {
            case 1:
                $bean->etapa = "Autorizada";
                break;
            case 2:
                $bean->etapa = "Rechazada";
                break;
            case 3:
                $bean->etapa = "Prospecto";
                break;
            case 4:
                $bean->etapa = "Credito";
                break;
        }

        // Etapa inicio mes
        switch ($bean->etapa_preliminar_c) {
            case 1:
                $bean->etapa_preliminar = "Autorizada";
                break;
            case 2:
                $bean->etapa_preliminar = "Rechazada";
                break;
            case 3:
                $bean->etapa_preliminar = "Prospecto";
                break;
            case 4:
                $bean->etapa_preliminar = "Credito";
                break;
        }

        // Tipo de operacion
        switch ($bean->tipo_operacion_c) {
            case 1:
                $bean->tipo_de_operacion = "Carga General";
                break;
            case 2:
                $bean->tipo_de_operacion = "Original";
                break;
            case 3:
                $bean->tipo_de_operacion = "Adicional";
                break;

        }

        // Tipo
        switch ($bean->tipo_c) {
            case 1:
                $bean->tipo = "Cliente";
                break;
            case 2:
                $bean->tipo = "Prospecto";
                break;
            case 3:
                $bean->tipo = "Persona";
                break;
        }

        // Region
        /*    switch ($bean->backlog_region_c) {
                case 0:
                    $bean->region = "Region 0";
                    break;
                case 1:
                    $bean->region = "CASA";
                    break;
                case 2:
                    $bean->region = "METRO 1";
                    break;
                case 3:
                    $bean->region = "METRO 2";
                    break;
                case 4:
                    $bean->region = "METRO 8";
                    break;
                case 5:
                    $bean->region = "NORTE";
                    break;
                case 6:
                    $bean->region = "NOROESTE";
                    break;
                case 7:
                    $bean->region = "BAJIO";
                    break;
                case 8:
                    $bean->region = "SUR";
                    break;
                case 9:
                    $bean->region = "EXPRESS";
                    break;
                case 10:
                    $bean->region = "METROPOLITANA";
                    break;
                case 11:
                    $bean->region = "OCCIDENTE";
                    break;
            }*/

        // Motivo de Cancelacion
        switch ($bean->motivo_cancelacion_c) {
            case 1:
                $bean->motivo_de_cancelacion = "Precio Condiciones";
                break;
            case 2:
                $bean->motivo_de_cancelacion = "Competencia";
                break;
            case 3:
                $bean->motivo_de_cancelacion = "Rechazado por Credito";
                break;
            case 4:
                $bean->motivo_de_cancelacion = "Decision Interna UNIFIN";
                break;
            case 5:
                $bean->motivo_de_cancelacion = "Decision del cliente";
                break;
            case 6:
                $bean->motivo_de_cancelacion = "Causas atribuibles al cliente";
                break;
            case 7:
                $bean->motivo_de_cancelacion = "Activos no Financiables";
                break;
            case 8:
                $bean->motivo_de_cancelacion = "Duplicado";
                break;
            case 9:
                $bean->motivo_de_cancelacion = "Otro";
                break;
            case 10:
                $bean->motivo_de_cancelacion = "Mes posterior";
                break;

        }

        // Estatus de la operacion
        switch ($bean->estatus_operacion_c) {
            case 1:
                $bean->estatus_de_la_operacion = "Cancelada";
                break;
            case 2:
                $bean->estatus_de_la_operacion = "Comprometida";
                break;

        }

    }
}