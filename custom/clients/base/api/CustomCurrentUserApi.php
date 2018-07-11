<?php
        
/* 
    AF - 23/04/2018 
    Extensión de output(campos custom) para CurrentUserApi

*/
require_once 'clients/base/api/CurrentUserApi.php';

class CustomCurrentUserApi extends CurrentUserApi
{

    /**
     * Retrieves the current user info
     *
     * @param $api
     * @param $args
     * @return array
     */
    public function retrieveCurrentUser($api, $args)
    {
        $current_user = $this->getUserBean();

        $userArray = parent::retrieveCurrentUser($api, $args);
        $userArray['current_user']['cac_c'] = $current_user->cac_c;
        $userArray['current_user']['empresa_c'] = $current_user->empresa_c;
        $userArray['current_user']['equipo_c'] = $current_user->equipo_c;
        $userArray['current_user']['esexterno_c'] = $current_user->esexterno_c;
        $userArray['current_user']['iniciales_c'] = $current_user->iniciales_c;
        $userArray['current_user']['producto_c'] = $current_user->producto_c;
        $userArray['current_user']['puesto_c'] = $current_user->puesto_c;
        $userArray['current_user']['puestousuario_c'] = $current_user->puestousuario_c;
        $userArray['current_user']['region_c'] = $current_user->region_c;
        $userArray['current_user']['tipodeproducto_c'] = $current_user->tipodeproducto_c;
        // agregar deficnicion campo nuevo
        $userArray['current_user']['tct_altaproveedor_chk_c'] = $current_user->tct_altaproveedor_chk_c;

        return $userArray;
    }

}