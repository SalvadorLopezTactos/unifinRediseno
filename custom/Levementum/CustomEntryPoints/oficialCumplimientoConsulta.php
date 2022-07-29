<?php
    ini_set('error_reporting', E_ERROR);
    ini_set('display_errors', TRUE);
    ini_set('log_errors', TRUE);

    /**
     * @namespace Levementum
     * @file workList.php
     * @author jescamilla@levementum.com
     * @date 6/11/2015 1:11 PM
     * @brief Ventana de Oficial de Cumplimiento
     * @details
     */

    global $db, $sugar_config, $current_user;
    require_once("custom/Levementum/UnifinAPI.php");
    $callApi = new UnifinAPI();

    //Usaremos llamadas recursivas para poder disparar el API desde Javascript, si la llamada que carga este archivo es una llamada de web service, procesa y responde.
    if ($_REQUEST['wsLlamada'] == 'true') {
        if ($_REQUEST['wsTipo'] == 'listaNegraDetalle') { //Lista Negra Detalle
            if (!empty($_REQUEST['IdPersona'])) {
                die(json_encode($callApi->listaNegraDetalle($_REQUEST['IdPersona']), 1));
            } else {
                die(json_encode('unknown parameter idPersona'));
            }
        }

        if ($_REQUEST['wsTipo'] == 'ratificarPersona') {

            $idTarea = $_REQUEST['idTarea'];
            $usuarioAutenticado = $_REQUEST['primerNombre'];
            $idCliente = $_REQUEST['IdPersona'];

            if ($_REQUEST['radioPep'] == 'Ratificado') {
                $radioPep = 2;
            }else{
                $radioPep = 0;
            }

            if ($_REQUEST['radioLista'] == 'Ratificado') {
                $radioLista = 2;
            }else{
                $radioLista = 0;
            }

            /** BEGIN CUSTOMIZATION: jgarcia@levementum.com 6/23/2015 Description: Servicio Completar Tarea en BPM*/
            if(!empty($idTarea)){
		global $current_user;
		$usuarioProceso = $current_user->user_name;
                $callApi->completarTarea($usuarioProceso, $idTarea, $idCliente, $radioLista, $radioPep, $_REQUEST['txtOficialCommentario']);
            }
            /* END CUSTOMIZATION */

            if (!empty($_REQUEST['sugarId'])) {
                $account = new Account();
                $account->retrieve($_REQUEST['sugarId']);

                if ($_REQUEST['radioPep'] == 'Ratificado') {
                    $account->pep_c = 2;
                    $account->riesgo_c = 'Alto';
                } else {
                    $account->pep_c = 0;
                    $account->riesgo_c = 'Bajo';
                }

                if ($_REQUEST['radioLista'] == 'Ratificado') {
                    $account->lista_negra_c = 2;
                    $account->riesgo_c = 'Alto';
                } else {
                    $account->lista_negra_c = 0;
                    $account->riesgo_c = 'Bajo';
                }

                $account->oficial_comentario_c = $_REQUEST['txtOficialCommentario'];

                global $db;
                try {
                    $query = "UPDATE accounts_cstm
                              SET lista_negra_c= '$account->lista_negra_c', pep_c = '$account->pep_c', riesgo_c = '$account->riesgo_c',  oficial_comentario_c = '$account->oficial_comentario_c'
                              WHERE id_c = '{$account->id}'";
                    $queryResult = $db->query($query);
                } catch (Exception $e) {
                    error_log(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : Error: " . $e->getMessage());
                    $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : Error " . $e->getMessage());
                    die(json_encode($e));
                }


                $tipodePersona = '';
                if ($account->estatus_c == 'Interesado') {
                    $tipodePersona = 'C';
                } elseif ($account->estatus_c == 'En Proceso') {
                    $tipodePersona = 'P';
                } else {
                    $tipodePersona = 'R';
                }

                if ($account->lista_negra_c == 2 || $account->pep_c == 2) {
                  //  $liberacion = $callApi->liberacionLista($account->id, $account->lista_negra_c, $account->pep_c, $account->idcliente_c, $tipodePersona);
                    $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <".$current_user->user_name."> : Inicia OFICIAL DE CUMPLIMIENTO -Carlos- quitamos liberacion  " . ": $liberacion ");
                }


                //todo: redireccionar a la lista de oficial de cumplimiento.

                die(json_encode(print_r($_REQUEST, 1)));
            } else {

                die(json_encode(print_r($_REQUEST, 1)));
            }
        }
    }

    if (!empty($_REQUEST['sugarId'])) {
        $account = new Account();
        $account->retrieve($_REQUEST['sugarId']);
    }

    $coincidencias = $callApi->listaNegraCoincidencias($_GET['primerNombre'], $_GET['segundoNombre'], $_GET['apellidoPaterno'], $_GET['apellidoMaterno'], "{$account->tipodepersona_c}");

    $coinciRows = '';

    foreach ($coincidencias['UNI2_CTE_011_PEP_ListaNegraResult']['ListaNegra'] as $index => $coincidencia) {
        if ($coincidencia['ListaNegra'] == 'S') {
            $escondeListaNegra = '$.muestraListaNegra();';
            $listaNegra = 'Posible coincidencia';
        } else {
            $escondeListaNegra = '$.escondeListaNegra();';
            $listaNegra = 'No encontrado';
        }

        if ($coincidencia['Pep'] == 'S') {
            $escondePEP = '$.muestraPep();';
            $pep = 'Posible coincidencia';
        } else {
            $escondePEP = '$.escondePep();';
            $pep = 'No encontrado';
        }
        $coinciRows .= "
                    <tr class='single'>
                        <td>
                           <span sfuuid='880' class='list'>
                               <div class='ellipsis_inline' data-placement='bottom'>
                                   <img src='include/images/university.png' width='10' height='10' />
                                   <span style='font-family: Helvetica, Arial, sans-serif; font-size: 12px;'>{$coincidencia['Nombre']}</span>

                               </div>
                           </span>
                        </td>
                        <td>
                           <span sfuuid='880' class='list'>
                               <div class='ellipsis_inline' data-placement='bottom'>
                                   <span style='font-family: Helvetica, Arial, sans-serif; font-size: 12px;'>{$pep}</span>
                               </div>
                           </span>
                        </td>
                        <td>
                           <span sfuuid='880' class='list'>
                               <div class='ellipsis_inline' data-placement='bottom'>
                                   <span style='font-family: Helvetica, Arial, sans-serif; font-size: 12px;'>{$listaNegra}</span>
                               </div>
                           </span>
                        </td>

                        <td>
                           <span sfuuid='880' class='list'>
                               <div class='ellipsis_inline' data-placement='bottom'>
                                   <a class='rowaction btn btn - primary' href='javascript:void(0);' id='detalle_button' onclick='$.poblarDetalle(\"{$coincidencia['IdEntities']}\"); {$escondeListaNegra} {$escondePEP}'>Detalle</a>
                               </div>
                           </span>
                        </td>

                    </tr>";

    }


    $coincidenciasTable = "

       <table class='table table-striped dataTable' style='width:700px;' >
            <thead>
                <tr>
                    <th data-fieldname='name' data-orderby='' tabindex='-1' colspan='4'>
                        <span style='text-align: center; font-size: larger;font-weight: bold'>Coincidencias</span>
                    </th>
                </tr>
                <tr>

                        <th data-fieldname='name' data-orderby='' tabindex='-1'>
                            <span>Nombre</span>
                        </th>

                        <th data-fieldname='name' data-orderby='' tabindex='-1'>
                            <span>PEP</span>
                        </th>

                        <th data-fieldname='name' data-orderby='' tabindex='-1'>
                            <span>Lista Negra</span>
                        </th>

                        <th data-fieldname='status' data-orderby='' tabindex='-1'>
                            <span>Detalle</span>
                        </th>

                </tr>
            </thead>
            <tbody>
                    {$coinciRows}
            </tbody>
        </table>
   ";
?>
<style>
    .tableText {
        font-family: Helvetica, Arial, sans-serif;
        font-size: 12px;
    }
</style>
<table cellspacing="10" cellpadding="10">
    <tr>
        <td valign="top" colspan="2">
            <!-- DETALLE DEL RECORD DE SUGAR -->
            <form id="frmSugarRecord">
                <table class='table table-striped dataTable'>
                    <thead>
                    <tr>
                        <th data-fieldname='name' data-orderby='' tabindex='-1' colspan="4">
                            <span style="text-align: center; font-size: larger;font-weight: bold">Detalles de la Persona</span>
                            <input type="hidden" name="sugarId" value="<?php echo $account->id ?>">
                            <input type="hidden" name="idTarea" value="<?php echo $_REQUEST['idTarea'] ?>">
                            <input type="hidden" name="primerNombre" value="<?php echo $_REQUEST['primerNombre'] ?>">
                            <input type="hidden" name="IdPersona" value="<?php echo $_REQUEST['IdPersona'] ?>">
                        </th>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <span sfuuid='880' class='list'>
                                <div class='ellipsis_inline' data-placement='bottom'>
                                    <span class='tableText'>Nombre: </span>
                                </div>
                            </span>
                        </td>

                        <td>
                            <span sfuuid='880' class='list'>
                                <div class='ellipsis_inline' data-placement='bottom'>
                                    <span class='tableText'><a
                                            href="<?php echo $sugar_config['site_url'] . "/#Accounts/" . $account->id ?>"
                                            target="_blank"><?php echo $account->name ?></a></span>
                                </div>
                            </span>
                        </td>
                        <td>
                            <span sfuuid='880' class='list'>
                                <div class='ellipsis_inline' data-placement='bottom'>
                                    <span class='tableText'>Fecha Ingreso: </span>
                                </div>
                            </span>
                        </td>

                        <td>
                            <span sfuuid='880' class='list'>
                                <div class='ellipsis_inline' data-placement='bottom'>
                                    <span class='tableText'><?php echo $account->date_entered ?></span>
                                </div>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span sfuuid='880' class='list'>
                                <div class='ellipsis_inline' data-placement='bottom'>
                                    <span class='tableText'>Promotor: </span>
                                </div>
                            </span>
                        </td>

                        <td colspan="3">
                            <span sfuuid='880' class='list'>
                                <div class='ellipsis_inline' data-placement='bottom'>
                                    <span class='tableText'><?php echo $account->assigned_user_name ?></span>
                                </div>
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <span id="renglonPep">
                                <span sfuuid='880' class='list'>
                                    <div class='ellipsis_inline' data-placement='bottom'>
                                        <span class='tableText'>¿Es Políticamente Expuesto? </span>
                                        <span id="detNombre" class='tableText'>
                                                <input type="radio" id="radioPep" name="radioPep"
                                                       value="Ratificado">Si<input style="margin-left: 15px;"
                                                                                   type="radio" name="radioPep"
                                                                                   value="No Encontrado">No
                                        </span>
                                    </div>
                                </span>
                            </span>
                        </td>
                        <td colspan="2">
                            <span id="renglonListaNegra">
                                <span sfuuid='880' class='list'>
                                    <div class='ellipsis_inline' data-placement='bottom'>
                                        <span class='tableText'>¿Está en Lista Negra?</span>
                                        <span id="detNombre" class='tableText'>
                                                  <input type="radio" id="radioLista" name="radioLista"
                                                         value="Ratificado">Si<input style="margin-left: 15px;"
                                                                                     type="radio" name="radioLista"
                                                                                     value="No Encontrado">No
                                        </span>
                                    </div>
                                </span>
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <span sfuuid='880' class='list'>
                                <div class='ellipsis_inline' data-placement='bottom'>
                                    <span class='tableText'>Comentario de Oficial de Cumplimiento: </span>
                                </div>
                            </span>
                            <span sfuuid='880' class='list'>
                                <div class='ellipsis_inline' data-placement='bottom'>
                                    <span id="detNombre" class='tableText'>
                                        <textarea name="txtOficialCommentario" style="width: 100%;"></textarea>
                                    </span>
                                </div>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <!--  SI, NO BOTONES  -->

                        <td align="right" colspan="4">
                        <span sfuuid="85" class="detail" style="text-align: right;">
                        <a class="rowaction btn btn-primary" id="btnEnviar" href="javascript:void(0);" name="add_button"
                           track="click:add_button">
                            Enviar </a>
                        </span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </td>
        </td>
    </tr>
    <tr>
        <!-- TABLA DE COINCIDENCIAS -->
        <td valign="top"><?php echo $coincidenciasTable ?></td>
        <!-- DETALLES DE LA COINCIDENCIA -->
        <td valign="top">
            <table class='table table-striped dataTable' style='width:500px;'>
                <thead>
                <tr>
                    <th data-fieldname='name' data-orderby='' tabindex='-1' colspan="2">
                        <span style="text-align: center; font-size: larger;font-weight: bold">Detalles de la Coincidencia</span>
                    </th>
                </thead>
                <tbody>
                <tr>
                    <td>
                            <span sfuuid='880' class='list'>
                                <div class='ellipsis_inline' data-placement='bottom'>
                                    <span class='tableText'>Nombre: </span>
                                </div>
                            </span>
                    </td>

                    <td>
                            <span sfuuid='880' class='list'>
                                <div class='ellipsis_inline' data-placement='bottom'>
                                    <span id="_nombre" class='tableText'></span>
                                </div>
                            </span>
                    </td>
                </tr>
                <tr>
                    <td>
                            <span sfuuid='880' class='list'>
                                <div class='ellipsis_inline' data-placement='bottom'>
                                    <span class='tableText'>Alias: </span>
                                </div>
                            </span>
                    </td>

                    <td>
                            <span sfuuid='880' class='list'>
                                <div class='ellipsis_inline' data-placement='bottom'>
                                    <span id="_alias" class='tableText'></span>
                                </div>
                            </span>
                    </td>
                </tr>
                <tr>
                    <td>
                            <span sfuuid='880' class='list'>
                                <div class='ellipsis_inline' data-placement='bottom'>
                                    <span class='tableText'>País : </span>
                                </div>
                            </span>
                    </td>

                    <td>
                            <span sfuuid='880' class='list'>
                                <div class='ellipsis_inline' data-placement='bottom'>
                                    <span id="_pais" class='tableText'></span>
                                </div>
                            </span>
                    </td>
                </tr>
                <tr>
                    <td>
                            <span sfuuid='880' class='list'>
                                <div class='ellipsis_inline' data-placement='bottom'>
                                    <span class='tableText'>Categoría: </span>
                                </div>
                            </span>
                    </td>
                    <td>
                            <span sfuuid='880' class='list'>
                                <div class='ellipsis_inline' data-placement='bottom'>
                                    <span id="_categoria" class='tableText'></span>
                                </div>
                            </span>
                    </td>
                </tr>
                <tr>
                    <td>
                            <span sfuuid='880' class='list'>
                                <div class='ellipsis_inline' data-placement='bottom'>
                                    <span class='tableText'>SubCategoría: </span>
                                </div>
                            </span>
                    </td>
                    <td>
                            <span sfuuid='880' class='list'>
                                <div class='ellipsis_inline' data-placement='bottom'>
                                    <span id="_subCategoria" class='tableText'></span>
                                </div>
                            </span>
                    </td>
                </tr>
                <tr>
                    <td>
                            <span sfuuid='880' class='list'>
                                <div class='ellipsis_inline' data-placement='bottom'>
                                    <span class='tableText'>Situación : </span>
                                </div>
                            </span>
                    </td>
                    <td>
                            <span sfuuid='880' class='list'>
                                <div class='ellipsis_inline' data-placement='bottom'>
                                    <span id="_situacion" class='tableText'></span>
                                </div>
                            </span>
                    </td>
                </tr>
                <tr>
                    <td>
                            <span sfuuid='880' class='list'>
                                <div class='ellipsis_inline' data-placement='bottom'>
                                    <span class='tableText'>Fecha Ingreso: </span>
                                </div>
                            </span>
                    </td>

                    <td>
                            <span sfuuid='880' class='list'>
                                <div class='ellipsis_inline' data-placement='bottom'>
                                    <span id="_fechaIngreso" class='tableText'></span>
                                </div>
                            </span>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                            <span sfuuid='880' class='list'>
                                <div class='ellipsis_inline' data-placement='bottom'>
                                    <span class='tableText'>Fuente: </span>
                                </div>
                            </span>
                        <br/>
                            <span sfuuid='880' class='list'>
                                <div class='ellipsis_inline' data-placement='bottom'>
                                    <span id="detNombre" class='tableText'>
                                        <textarea id="_fuente" cols="35" rows="10" style="width: 100%;"></textarea>
                                    </span>
                                </div>
                            </span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                            <span sfuuid='880' class='list'>
                                <div class='ellipsis_inline' data-placement='bottom'>
                                    <span class='tableText'>Observaciones: </span>
                                </div>
                            </span>
                        <br/>
                            <span sfuuid='880' class='list'>
                                <div class='ellipsis_inline' data-placement='bottom'>
                                    <span id="detNombre" class='tableText'>
                                        <textarea id="_observaciones" cols="35" rows="10"
                                                  style="width: 100%;"></textarea>
                                    </span>
                                </div>
                            </span>
                    </td>
                </tr>
                <tr>
                    <br/>
                    <table id="tablaRelaciones" class='table table-striped dataTable'>
                        <tr>
                            <td>
                                <span sfuuid='880' class='list'>
                                    <div class='ellipsis_inline' data-placement='bottom'>
                                        <span class='tableText'>Relaciones </span>
                                    </div>
                                 </span>
                            </td>

                        </tr>
                    </table>
                </tr>
                </tbody>
            </table>
        </td>


    </tr>
    <tr>

        <td></td>
    </tr>

</table>


<link rel="stylesheet" href="styleguide/assets/css/bootstrap.css">
<link rel="stylesheet" href="styleguide/assets/css/sugar.css">
<style>
    .relacionStyle {
        font-size: x-small;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#btnEnviar').click(function () {
            var enviar;
            if (($('input[name=radioPep]:checked').val() == undefined && $('input[name=radioLista]:checked').val() != undefined) || ($('input[name=radioPep]:checked').val() != undefined && $('input[name=radioLista]:checked').val() == undefined)) {
                var formData = $('#frmSugarRecord').serialize();
                console.log('formData Serialized: ');
                console.log(formData)
                $.get("index.php?entryPoint=oficialCumplimientoConsulta&wsLlamada=true&wsTipo=ratificarPersona&" + formData, function (request_data) {
                    var detalle = jQuery.parseJSON(request_data);
                    console.log(detalle);
                    alert('Informacion Enviada');
                    parent.window.close();
                    parent.location.reload(true);
                });
            } else {
                alert('Debes seleccionar los datos antes de enviar.');
            }
        });


        $.escondeListaNegra = function () {
            $('#renglonListaNegra').hide();
        }

        $.muestraListaNegra = function () {
            $('#renglonListaNegra').show();
        }

        $.escondePep = function () {
            $('#renglonPep').hide();
        }

        $.muestraPep = function () {
            $('#renglonPep').show();
        }

        $.poblarDetalle = function (data) {
            $.get("index.php?entryPoint=oficialCumplimientoConsulta&wsLlamada=true&wsTipo=listaNegraDetalle&IdPersona=" + data, function (request_data) {
                var detalle = jQuery.parseJSON(request_data);
                if(detalle.UNI2_CTE_028_DetallePersonaPLDResult._detallePersona != null) {
                    $('#_alias').html(detalle.UNI2_CTE_028_DetallePersonaPLDResult._detallePersona._alias);
                    $('#_categoria').html(detalle.UNI2_CTE_028_DetallePersonaPLDResult._detallePersona._categoria);
                    $('#_subCategoria').html(detalle.UNI2_CTE_028_DetallePersonaPLDResult._detallePersona._subCategoria);
                    $('#_fechaIngreso').html(detalle.UNI2_CTE_028_DetallePersonaPLDResult._detallePersona._fechaIngreso);
                    $('#_fuente').html(detalle.UNI2_CTE_028_DetallePersonaPLDResult._detallePersona._fuente);
                    $('#_idPersona').html(detalle.UNI2_CTE_028_DetallePersonaPLDResult._detallePersona._idPersona);
                    $('#_nombre').html(detalle.UNI2_CTE_028_DetallePersonaPLDResult._detallePersona._nombre);
                    $('#_observaciones').html(detalle.UNI2_CTE_028_DetallePersonaPLDResult._detallePersona._observaciones);
                    $('#_pais').html(detalle.UNI2_CTE_028_DetallePersonaPLDResult._detallePersona._pais);
                    $('#_situacion').html(detalle.UNI2_CTE_028_DetallePersonaPLDResult._detallePersona._situacion);
                    console.log(detalle.UNI2_CTE_028_DetallePersonaPLDResult._detallePersona); //remove in production
                }

                $(detalle.UNI2_CTE_028_DetallePersonaPLDResult._listaRelacionesPersona).each(function () {
                    $('#tablaRelaciones tr:last').after('<tr>' +
                        '  <td class="relacionStyle">' + this._categoria + '</br><span><span style="font-weight: bold; color: #040404">' + this._nombre + '</span> - (' + this._tipoRelacion + ')</span>' + '<br/>' + this._subCategoria + '</td>' +
                        '</tr>');
                });

                $('#btnEnviar').show();
            });

        };

        //Esconde PEP y Lista por default y en preparacion para detalle
        $.escondePep();
        $.escondeListaNegra();
        $('#btnEnviar').hide();
    });

</script>