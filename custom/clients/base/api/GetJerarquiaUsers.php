<?php
/**
 * Created by PhpStorm.
 * User: salvadorlopez
 * Date: 07/08/18
 * Time: 10:07
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetJerarquiaUsers extends SugarApi
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
                'path' => array('GetEstructuraUsuarios', '?'),
                //endpoint variables
                'pathVars' => array('method', 'id_user'),
                //method to call
                'method' => 'getEstructuraUsuarios',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Obtener estructura jerárquica de un usuario',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),


        );

    }

    /**
     * Obtener estructura jerárquica de un usuario
     *
     * Método que regresa la estructura jerárquica de un Usuario con base al Usuario "Reporta a" de su registro
     *
     * @param array $api
     * @param array $args Array con los parámetros enviados para su procesamiento
     * @return array $arr_user Array con lista de los usuarios ordenados jerarquicamente del usuario pasado como parámetro
     * @throws SugarApiExceptionInvalidParameter
     */
    public function getEstructuraUsuarios($api, $args)
    {
        global $app_list_strings;

        $id_user=$args['id_user'];
        $arr_user=array();
        $cont=0;

        //Obteniendo direccion de email
        $user=BeanFactory::getBean('Users',$id_user);
        $primary_email=$user->emailAddress->getPrimaryAddress($user);

        $query="SELECT u.first_name,u.last_name,u.reports_to_id,uc.puestousuario_c FROM users u,users_cstm uc WHERE u.id=uc.id_c AND id='{$id_user}'";

        $result=$GLOBALS['db']->query($query);

        if($result->num_rows > 0){

            while($row = $GLOBALS['db']->fetchByAssoc($result))
            {
                $full_name=$row['first_name']." ".$row['last_name'];
                $nombre=$row['first_name'];
                $apellidos=$row['last_name'];
                $puesto=$row['puestousuario_c'];
                $informa=$row['reports_to_id'];

                //Obteniendo etiqueta de lista de puesto del usuario
                $label_puesto=$app_list_strings['puestousuario_c_list'][$puesto];

                $array_user=array(
                    'id'=>$id_user,
                    'full_name'=>$full_name,
                    'nombre'=>$nombre,
                    'apellidos'=>$apellidos,
                    "puesto_id"=>$puesto,
                    "puesto_label"=>$label_puesto,
                    "email"=>$primary_email,
                    "id_informa"=>$informa
                );

                array_push($arr_user,$array_user);

                if($informa != ""){
                    $bandera=true;

                    while($bandera){
                        //Limpiando array
                        $array_jefe=array();

                        $cont++;
                        //Validación únicamente para el primer jefe
                        if($cont==1){
                            $array_jefe=$this->getBossStructure($informa);
                            $informa=$array_jefe['id_informa'];
                        }else{
                            //Obtener id de usuario correspondiente "Reporta a"
                            //$id_reporta=$this->getIdReporta($informa);
                            //if($id_reporta!="NULL" && $id_reporta!=null){
                            $array_jefe=$this->getBossStructure($informa);
                            $informa=$array_jefe['id_informa'];
                            //}
                        }

                        if($informa != null ){
                            $bandera=true;
                        }else{
                            $bandera=false;
                        }

                        //Agregar al arreglo solo cuando el array no es nulo
                        if($array_jefe!=null){
                            array_push($arr_user,$array_jefe);

                        }

                    }

                }

            }

        }else{
            $arr_user['ERROR']="El usuario con el id {$id_user} NO existe, favor de verificar";
        }


        return $arr_user;

    }

    public function getIdReporta($idUser){

        $query="SELECT reports_to_id FROM users WHERE id='{$idUser}'";

        $res=$GLOBALS['db']->query($query);
        $id='';
        while($row = $GLOBALS['db']->fetchByAssoc($res)){
            $id=$row['reports_to_id'];
        }

        return $id;

    }

    public function getBossStructure($idUser){

        global $app_list_strings;

        $queryBoss1="SELECT u.id,u.first_name,u.last_name,u.reports_to_id,uc.puestousuario_c FROM users u,users_cstm uc WHERE u.id=uc.id_c AND id='{$idUser}'";
        $resultBoss=$GLOBALS['db']->query($queryBoss1);

        while($rowBoss = $GLOBALS['db']->fetchByAssoc($resultBoss))
        {
            $userBoss=BeanFactory::getBean('Users',$idUser);
            $primary_emailBoss=$userBoss->emailAddress->getPrimaryAddress($userBoss);

            $full_nameBoss=$rowBoss['first_name']." ".$rowBoss['last_name'];
            $nombreBoss=$rowBoss['first_name'];
            $apellidosBoss=$rowBoss['last_name'];
            $puestoBoss=$rowBoss['puestousuario_c'];
            $informaBoss=$rowBoss['reports_to_id'];


            //Obteniendo etiqueta de lista de puesto del usuario
            $label_puestoBoss=$app_list_strings['puestousuario_c_list'][$puestoBoss];
            $arr_jefe=array(
                'id'=>$idUser,
                'full_name'=>$full_nameBoss,
                'nombre'=>$nombreBoss,
                'apellidos'=>$apellidosBoss,
                "puesto_id"=>$puestoBoss,
                "puesto_label"=>$label_puestoBoss,
                "email"=>$primary_emailBoss,
                "id_informa"=>$informaBoss
            );
        }

        return $arr_jefe;


    }


}

?>
