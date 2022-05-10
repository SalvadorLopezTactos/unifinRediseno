<?php
array_push($job_strings, 'job_employee_status');

function job_employee_status()
{
    try {

        $GLOBALS['log']->fatal('Entra Job de Actualización Estatus de Empleado Activo');       

        /**********Leer tabla USERS para validar si el estatus de empleados esta vacio o null***********/
        $query = "SELECT id, first_name, last_name, employee_status from users 
        where employee_status is null or employee_status = ''";        
        $queryResult = $GLOBALS['db']->query($query);
        $contador=0;

        while($row = $GLOBALS['db']->fetchByAssoc($queryResult))
        {   
            $contador++;
            /*******Iterar registros de Usuarios a actualizar******/
            $idUserEmployee = $row['id'];
            $firstName = $row['first_name'];
            $lastName = $row['last_name'];
            $statusEmployee = $row['employee_status'];

            $GLOBALS['log']->fatal('Actualiza: '.$idUserEmployee.' - Nombre Empleado: '.$firstName.' '.$lastName);
            
            if ($statusEmployee == '' || $statusEmployee == null){

                $GLOBALS['log']->fatal('Actualizando Estatus de Empleado... ');
                /************Actualizar tabla USERS agregando el valor Active en el Estatus de Empleados*********/
                $updateEE = "UPDATE users SET employee_status = 'Active' WHERE id = '{$idUserEmployee}'";
                $updateResult = $GLOBALS['db']->query($updateEE);
            }
        }
        
        $GLOBALS['log']->fatal('Actualización de Estatus finalizada de '.$contador.' Empleado (s).');
        return true;

    } catch (Exception $e) {
        $GLOBALS['log']->fatal("Error: " . $e->getMessage());
    }
}