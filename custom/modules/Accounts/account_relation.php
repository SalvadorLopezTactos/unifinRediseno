<?php

class class_account_relation
{
    public function add_gpo_empresarial($bean = null, $event = null, $args = null)
    {
        if($args['module'] == 'Accounts' && $args['related_module'] == 'Accounts'){
            $GLOBALS['log']->fatal("LH Grupo Empresarial en Relacion");
            /*$GLOBALS['log']->fatal("related_id: ".$args['related_id']);
            $GLOBALS['log']->fatal("id: ".$args['id']);
            $GLOBALS['log']->fatal("bean: ".$bean->id);
            $GLOBALS['log']->fatal("bean->parent: ".$bean->parent_id);*/
            //Guarda bean relacionado
            if($args['related_id'] == $bean->parent_id){
                $beanrel = BeanFactory::retrieveBean('Accounts', $args['related_id']);
                if($beanrel->parent_id == $args['id']){
                    //Error: No puede ser padre e hijo de la misma cuenta
                    require_once 'include/api/SugarApiException.php';
                    throw new SugarApiExceptionError("No puede ser cuenta padre e hija de la misma cuenta dentro del grupo empresarial");

                }else{
                    $beanrel->save();
                }
            }
        }
    }

    public function update_gpo_empresarial($bean = null, $event = null, $args = null)
    {
        //Actualiza parent
        if(!empty($bean->parent_id_previo)){
            //Actualiza previo
            $GLOBALS['log']->fatal("Id Padre previo: ". $bean->parent_id_previo);
            $this->updateParent($bean->parent_id_previo);
        }
        if(!empty($bean->parent_id)){
            //Actualiza padre
            $GLOBALS['log']->fatal("Id Padre actual: ". $bean->parent_id);
            $this->updateParent($bean->parent_id);
        }
    }

    public function updateParent($parent_id)
    {
        //Función utilizada para actualizar información de grupo empresarial de cuenta padre
        //$GLOBALS['log']->fatal("Id Padre por procesar: ". $parent_id);
        if(!empty($parent_id)){
            //Recupera información de cuenta padre
            global $db;
            $cuentaPadre = BeanFactory::retrieveBean('Accounts', $parent_id, array('disable_row_level_security' => true));
            if($cuentaPadre!=null){
                $GLOBALS['log']->fatal("LH Grupo Empresarial Padre");
                //Establece variables
                $idPadre = $cuentaPadre->parent_id;
                $situacionGE = $cuentaPadre->situacion_gpo_empresarial_c;
                $totalHijos = 0;
                $nombrePadre ='';
                $listaSituacionGE = [];
                $listaTextoSGE = [];
                //Consulta cuentas hijas
                $sql = "Select id,name from accounts a where parent_id = '{$cuentaPadre->id}' and deleted = 0";
                $result = $db->query($sql);
                $totalHijos = $result->num_rows;

                //Validar relación padre
                if( !empty($idPadre) ) {
                    $listaSituacionGE[] = "^2^";
                    //Recupera cuenta padre
                    $cuentaPadrePadre = BeanFactory::retrieveBean('Accounts', $cuentaPadre->parent_id, array('disable_row_level_security' => true));
                    $nombrePadre = $cuentaPadrePadre->name;
                }
                //Validar relación hijos
                if( $totalHijos>0 ) {
                    $listaSituacionGE[] = "^1^";
                }
                //Validar Sin grupo empresaril
                if( $totalHijos==0 && empty($idPadre) && strpos($situacionGE, "3") ) {
                    $listaSituacionGE[] = "^3^";
                }
                //No tiene información establece valor default
                if(count($listaSituacionGE)==0){
                    $listaSituacionGE[] = "^4^";
                }

                //Armar arreglo de texto SGE
                if ( in_array("^1^", $listaSituacionGE ) ){
                    $listaTextoSGE[] = 'Cuenta primaria del grupo ' . $cuentaPadre->name ;
                }
                if ( in_array("^2^" , $listaSituacionGE )){
                    $listaTextoSGE[] = 'Cuenta secundaria del grupo ' . $nombrePadre;
                }
                if ( in_array( "^3^" , $listaSituacionGE )){
                    $listaTextoSGE[] = 'No pertenece a ningún grupo empresarial';
                }
                if ( in_array( "^4^" ,$listaSituacionGE) ){
                    $listaTextoSGE[] = 'Sin Grupo Empresarial Verificado';
                }

                //Compara valores
                $situacion_gpo_empresarial_c = (count($listaSituacionGE)>0) ? implode(",",$listaSituacionGE) : $bean->situacion_gpo_empresarial_c;
                $situacion_gpo_empresa_txt_c = (count($listaTextoSGE)>0) ? implode("\n",$listaTextoSGE) : $bean->situacion_gpo_empresa_txt_c;
                if($situacion_gpo_empresarial_c!= $cuentaPadre->situacion_gpo_empresarial_c || $situacion_gpo_empresa_txt_c!=$cuentaPadre->situacion_gpo_empresa_txt_c){
                    //$GLOBALS['log']->fatal("LH Grupo Empresarial Padre - Guarda padre: ". $cuentaPadre->id);
                    $updatePadre = "update accounts_cstm
                      set situacion_gpo_empresarial_c='{$situacion_gpo_empresarial_c}', situacion_gpo_empresa_txt_c='{$situacion_gpo_empresa_txt_c}'
                      where id_c = '{$cuentaPadre->id}';";
                    //$GLOBALS['log']->fatal("Update: ".$updatePadre);
                    $resultU = $db->query($updatePadre);

                }
            }
        }
    }

}
