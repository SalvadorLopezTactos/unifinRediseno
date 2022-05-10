<?php
/**
 * Created by Tactos.
 * User: AF
 * Date: 15/02/2018
 */

/*
Definición de LH para asociación de contacto generico a una cuenta de tipo=Proveedor
Definition for LH to associate a generc contact to an acccount when type=Proveedor
*/

/*
1.- Al guardar Proveedor;
*/
$hook_array['after_save'][] = Array(
    9,
    'Associate a generic contact to Account(Type = Proveedor)',
    'custom/modules/Accounts/lh_ContactoGenerico.php',
    'CG_Class',
    'CG_Method'
);

/*
1.- Al agregar relación;
*/
$hook_array['after_relationship_add'][] = Array(
    1,
    'Validate that exist a generic contact to Account(Type = Proveedor)',
    'custom/modules/Accounts/lh_ContactoGenerico.php',
    'CG_Class',
    'CG_Method_AfterAdd'
);

/*
2.- Al eliminar relación
*/
$hook_array['before_relationship_delete'][] = Array(
    1,
    'Validate that exist a generic contact to Account(Type = Proveedor)',
    'custom/modules/Accounts/lh_ContactoGenerico.php',
    'CG_Class',
    'CG_Method_BeforeDelete'
);

