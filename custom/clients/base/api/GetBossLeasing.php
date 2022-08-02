<?php
/**
 * Created by PhpStorm.
 * User: salvadorlopez
 * Date: 07/08/18
 * Time: 10:07
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetBossLeasing extends SugarApi
{

    /**
     * Registro de todas las rutas para consumir los servicios del API
     *
     */
    public function registerApiRest()
    {
        return array(
            //GET
            'retrieve' => array(
                //request type
                'reqType' => 'GET',
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('GetBossLeasing', '?'),
                //endpoint variables
                'pathVars' => array('method', 'id_user'),
                //method to call
                'method' => 'getBossLeasingMethod',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método que obtiene usuarios con jerarquia de Director con base a un id de usuario',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),


        );

    }


    public function getBossLeasingMethod($api, $args)
    {
        global $app_list_strings;
        //id de usuario ejemplo cdf63b76-233b-11e8-a1ec-00155d967307 alvaro.alonso
        $id_usuario=$args['id_user'];

        $beanUsuario = BeanFactory::getBean('Users', $id_usuario,array('disable_row_level_security' => true));
        $array_users=array();
        $bandera=true;

        if(!empty($beanUsuario)){

            //Comprobar que el usuario tenga el permiso especial de Responsable de oficina
            if($beanUsuario->responsable_oficina_chk_c==1){
                array_push($array_users,array('id'=>$beanUsuario->id,'name'=>$beanUsuario->full_name));
            }

            while ($bandera){
                $id_reporta=$beanUsuario->reports_to_id;
                if($id_reporta!=null && $id_reporta!=""){
                    //Obteniendo el Jefe Director Leasing
                    $beanUsuarioJefe = BeanFactory::getBean('Users', $id_reporta,array('disable_row_level_security' => true));
                    if (!empty($beanUsuarioJefe)){
                        //if($beanUsuarioJefe->puestousuario_c=='2'){ //Puesto 2= Director Leasing
                        if($beanUsuarioJefe->responsable_oficina_chk_c==1){ //Jefe cuenta con privilegio de Responsable de Oficina
                            array_push($array_users,array('id'=>$beanUsuarioJefe->id,'name'=>$beanUsuarioJefe->full_name));

                            //Obteniendo jefe inmediato del Director Leasing
                            $jefeDirectorLeasing=$beanUsuarioJefe->reports_to_id;
                            if($jefeDirectorLeasing!=null && $jefeDirectorLeasing!=""){
                                $beanJefeDirector = BeanFactory::getBean('Users', $jefeDirectorLeasing,array('disable_row_level_security' => true));
                                array_push($array_users,array('id'=>$beanJefeDirector->id,'name'=>$beanJefeDirector->full_name));
                                $bandera=false;
                            }else{
                                $bandera=false;
                            }

                        }else{
                            $beanUsuario=$beanUsuarioJefe;

                        }
                    }else{
                        $bandera=false;
                    }
                }else{
                    $bandera=false;
                }

            }

        }

        //Obteniendo valores de lista de Responsables de oficina
        $lista_responsables=$app_list_strings['responsables_leasing_list'];
        foreach ($lista_responsables as $key=>$value) {
            $beanUsuarioLista = BeanFactory::getBean('Users', $value,array('disable_row_level_security' => true));
            if (!empty($beanUsuarioLista)){
                if($beanUsuarioLista->status=='Active'){
                    //Antes de agregar el usuario, comprobar que no exista en la lista, para evitar duplicados en valores mostrados en lista desplegable
                    $existe=$this->existeUsuario($beanUsuarioLista->id, $array_users);
                    if($existe==false){
                        array_push($array_users,array('id'=>$beanUsuarioLista->id,'name'=>$beanUsuarioLista->full_name));
                    }
                }

            }

        }

        return $array_users;

    }

    public function existeUsuario($clave,$arreglo){
        $existe=false;
        $num_elementos=count($arreglo);
        if(count($arreglo)>0){
            for ($i=0;$i<$num_elementos;$i++){
                if($arreglo[$i]['id']==$clave){
                    $existe=true;
                    $num_elementos=count($arreglo);
                }
            }

        }

        return $existe;
    }


}

?>
