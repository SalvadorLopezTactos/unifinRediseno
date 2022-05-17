<?php

/**
 * Created by Salvador Lopez
 * Email: salvador.lopez@tactos.com.mx
 * Date: 13/3/2018
 *
 */
class Account_Phones
{
    public function setAccountPhones($bean = null, $event = null, $args = null)
    {
        //Obteniendo phone_office
        $phone_office = $bean->phone_office;
        $base = "base";
        //Verificando si el telefono trae consigo el prefijo 'base', lo cual indica si el registro fue creado en web y no en plataforma móvil
        if (strlen($phone_office) > 0 && $phone_office!== "" && $phone_office!==null) {
            $base = substr($phone_office, 0, 4);
        }
        //Condición para saber que el registro NO ha sido creado en Móvil (platform=mobile)
        if ($base !== "base" && !empty($bean->phone_office)) {
            //OBTENER TELEFONOS RELACIONADOS
            if ($bean->load_relationship('accounts_tel_telefonos_1')) {
                $relatedTelefonos = $bean->accounts_tel_telefonos_1->getBeans();
                $totalTelefonos = count($relatedTelefonos);
                if ($totalTelefonos > 0) {
                    //Valida si cuenta con teléfono principal
                    $existePrincipal=false;
                    $idTelPrincipal="";
                    $idTelefonoActual = "";
                    foreach ($relatedTelefonos as $telefono) {
                        if ($telefono->principal) {
                            //Ya cuenta con un teléfono principal, actualizando
                            $existePrincipal=true;
                            $id_tel=$telefono->id;
                        }
                        if($telefono->telefono == $bean->phone_office){
                            $idTelefonoActual = $telefono->id;
                        }
                    }
                    //No Coincide principal y teléfono
                    if(!empty($id_tel) && !empty($idTelefonoActual) && $id_tel != $idTelefonoActual){
                        //Desmarca principal actual
                        $sqlA = "UPDATE tel_telefonos SET principal = 0 WHERE id = '{$id_tel}';";
            						$resultA = $GLOBALS['db']->query($sqlA);
                        //Actualiza nuevo principal
                        $sqlB = "UPDATE tel_telefonos SET principal = 1 WHERE id = '{$idTelefonoActual}';";
            						$resultB = $GLOBALS['db']->query($sqlB);

                    }
                    if(!$existePrincipal && !empty($idTelefonoActual)){
                        //Actualiza nuevo principal
                        $sqlB = "UPDATE tel_telefonos SET principal = 1 WHERE id = '{$idTelefonoActual}';";
                        $resultB = $GLOBALS['db']->query($sqlB);
                    }

                    if(empty($idTelefonoActual)){
                        //Agrega nuevo teléfono principal de trabajo Tipo 2
                        $beanTelefono = BeanFactory::newBean("Tel_Telefonos");
                        $beanTelefono->accounts_tel_telefonos_1accounts_ida=$bean->id;
                        $beanTelefono->name = $phone_office;
                        $beanTelefono->telefono = $phone_office;
                        $beanTelefono->tipotelefono = '2';
                        $beanTelefono->principal = true;
                        $beanTelefono->estatus = 'Activo';
                        $beanTelefono->pais = '2';
                        $beanTelefono->save();
                    }

                }else{
                    $beanTelefono = BeanFactory::newBean("Tel_Telefonos");
                    $beanTelefono->accounts_tel_telefonos_1accounts_ida=$bean->id;
                    $beanTelefono->name = $phone_office;
                    $beanTelefono->telefono = $phone_office;
                    $beanTelefono->tipotelefono = '2';
                    $beanTelefono->principal = true;
                    $beanTelefono->estatus = 'Activo';
                    $beanTelefono->pais = '2';
                    $beanTelefono->save();
                }
            }
        }else{
            //limpiar campo phone_office
            $phone_office_clean = substr($phone_office, 4);
            $sql = "UPDATE accounts SET phone_office='{$phone_office_clean}' WHERE id='{$bean->id}'";
            $result = $GLOBALS['db']->query($sql);
        }
    }
}
