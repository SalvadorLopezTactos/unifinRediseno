<?php
/*
 * Created on Aug 27, 2012
 *
 * Jeff Bickart
 * @bickart
 * NEPO Systems, LLC
 *
 * custom/metadata/custom_indexes.php
 */
/* $repairedTables is a variable that gets defined in the repairDatabase.php program */
if (isset($repairedTables)) {
    /* We have to tell the repairDatabases.php that we have not yet repaired our custom table
       so that it can find custom indexes */
    if (isset($repairedTables['module_cstm'])) {
        unset($repairedTables['module_cstm']);
    }
}
/* Define the index */
$dictionary["Rel_Relaciones"] = array(
    'table' => 'rel_relaciones',
    'indices' => // our custom indexes go here
        array(
            0 =>
                array(
                    'name' => 'custom_name_index_idx',
                    'type' => 'index',
                    'fields' =>
                        array(
                            0 => 'name',
                            1 => 'relaciones_activas',
                        ),
                ),
        ),
);
?>