<html>
<head>
    <title>Lista para Oficial De Cumplimiento</title>
</head>
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
    global $db, $sugar_config, $current_user, $timedate;

    $query = " SELECT * FROM accounts a
                INNER JOIN accounts_cstm ac ON a.id = ac.id_c AND a.deleted = 0
                AND(lista_negra_c = 1 OR pep_c = 1) AND name != ''";
    $queryResult = $db->query($query);

    $coinciRows = '';

    while ($row = $db->fetchByAssoc($queryResult)) {
        if ($row['pep_c'] == 1) {
            $pep_checked = "checked='checked'";
        } else {
            $pep_checked = '';
        }

        if ($row['lista_negra_c'] == 1) {
            $lista_negra_checked = "checked='checked'";
        } else {
            $lista_negra_checked = '';
        }


        $coinciRows .= "
           <tr class='single'>
               <td>
                  <span sfuuid='880' class='list'>
                      <div class='ellipsis_inline' data-placement='bottom'>
                          <img src='include/images/university.png' width='10' height='10' />
                          <a href='{$sugar_config['site_url']}/index.php?entryPoint=oficialCumplimientoConsulta&primerNombre={$row['primernombre_c']}&segundoNombre={$row['segundonombre_c']}&apellidoPaterno={$row['apellidopaterno_c']}&apellidoMaterno={$row['apellidomaterno_c']}&sugarId={$row['id']}&idTarea={$row['id_process_c']}'><span style='font-family: Helvetica, Arial, sans-serif; font-size: 12px;'>{$row['name']}</span></a>
                      </div>
                  </span>
               </td>
               <td>
                  <span sfuuid='880' class='list'>
                      <div class='ellipsis_inline' data-placement='bottom'>
                          <span style='font-family: Helvetica, Arial, sans-serif; font-size: 12px;'><input type='checkbox' readonly disabled {$pep_checked} /> </span>
                      </div>
                  </span>
               </td>
               <td>
                  <span sfuuid='880' class='list'>
                      <div class='ellipsis_inline' data-placement='bottom'>
                          <span style='font-family: Helvetica, Arial, sans-serif; font-size: 12px;'><input type='checkbox' readonly disabled {$lista_negra_checked} /></span>
                      </div>
                  </span>
               </td>

               <td>
                  <span sfuuid='880' class='list'>
                      <div class='ellipsis_inline' data-placement='bottom'>
                          <span style='font-family: Helvetica, Arial, sans-serif; font-size: 12px;'>{$row['assigned_user_name']}</span>
                      </div>
                  </span>
               </td>

               <td>
                  <span sfuuid='880' class='list'>
                      <div class='ellipsis_inline' data-placement='bottom'>
                          <span style='font-family: Helvetica, Arial, sans-serif; font-size: 12px;'>{$timedate->to_display_date_time($row['date_entered'])}</span>
                      </div>
                  </span>
               </td>
           </tr>";
    }

    $coincidenciasTable = "

       <table class='table table-striped dataTable'>
            <thead>
                <tr>
                    <th data-fieldname='name' data-orderby='' tabindex='-1' colspan='4'>
                        <span style='text-align: center; font-size: larger;font-weight: bold'>Lista para Oficial De Cumplimiento</span>
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

                         <th data-fieldname='name' data-orderby='' tabindex='-1'>
                            <span>Promotor</span>
                        </th>

                        <th data-fieldname='name' data-orderby='' tabindex='-1'>
                            <span>Fecha de Creacion</span>
                        </th>

                </tr>
            </thead>
            <tbody>
                    {$coinciRows}
            </tbody>
        </table>
   ";

    echo $coincidenciasTable;
?>
<link rel="stylesheet" href="styleguide/assets/css/bootstrap.css">
<link rel="stylesheet" href="styleguide/assets/css/sugar.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).attr("title", "New Title");
    });

</script>
</html>


