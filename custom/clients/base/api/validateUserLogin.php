<?php
/**
 * Created by PhpStorm.
 * User: AF
 * Date: 2023/02/10
 */

class validateUserLogin extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            //Valida situación de login
            'validateLoginPageAPI' => array(
                //request type
                'reqType' => 'POST',
                //set authentication
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('validateLoginPage'),
                //endpoint variables
                'pathVars' => array(''),
                //method to call
                'method' => 'validateLoginPageMethod',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Valida situación de login',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),
            //Valida situación de usuario para definir login
            'validateUserLoginAPI' => array(
                //request type
                'reqType' => 'POST',
                //set authentication
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('validateUserLogin'),
                //endpoint variables
                'pathVars' => array(''),
                //method to call
                'method' => 'validateUserLoginMethod',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Valida existencia de usuario en AD y Sugar',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),
            //Valida código MFA
            'validateCodeMFAAPI' => array(
                //request type
                'reqType' => 'POST',
                //set authentication
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('validateCodeMFA'),
                //endpoint variables
                'pathVars' => array('',''),
                //method to call
                'method' => 'validateCodeMFAMethod',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Valida código de verificación MFA',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),
        );
    }

    public function validateLoginPageMethod($api, $args)
    {
        $result = array(
            "status"=>"200",
            "message"=>"",
            "situation"=>"", // Situation values: 1- Inicia con login, 2- Inicia con Código validación
            "valid_secs"=>"0"
        );
        try{
            //Recupera parámetros
            $userData = isset($args['userData']) ? json_decode(base64_decode($args['userData']),true) : array();  //userData.user || userData.password -- error_log(print_r($userData,true));
            error_log('Userdata - u:'.$userData['user']);
            //Validaciones en caso de existir usuario cargado
            if(isset($userData['user'])){
                $getLogin = $this->getLastLogin($userData);
                $result['valid_secs'] = isset($getLogin['valid_secs']) ? $getLogin['valid_secs'] : 0;
            }
            
            //Define escenarios
            if($result['valid_secs'] > 0){
                $result['situation']='2';
            }else{
                $result['situation']='1';
            }
            
        }catch(Exception $e) {
            $result['status']='500';
            $result['message']='Erro de sistema: '. $e;
        }
        
        //Regresa respuesta de validación
        return $result;
    }
    
    public function validateUserLoginMethod($api, $args)
    {        
        $result = array(
            "status"=>"",
            "message"=>"",
            "valid_secs"=>"0",
            "mfa_enable"=>false
        );
                
        try {
            //Recupera parámetros
            $userData = isset($args['userData']) ? json_decode(base64_decode($args['userData']),true) : array();
            error_log('Userdata - u:'.$userData['user']);
            //userData.user || userData.password -- error_log(print_r($userData,true));
            global $sugar_config;
            $mfa_enable =  isset($sugar_config['mfa_enable']) ? $sugar_config['mfa_enable'] : false;
            $mfa_expiration_time =  isset($sugar_config['mfa_expiration_time']) ? $sugar_config['mfa_expiration_time'] : 0;
            $mfa_valid_mistakes =  isset($sugar_config['mfa_valid_mistakes']) ? $sugar_config['mfa_valid_mistakes'] : 0;
                        
            //Valida existencia LDAP
            $resultLDAP = $this->validateLDAP($userData);
            $existeAD = ($resultLDAP['status']=='200') ? true : false;
            //$GLOBALS['log']->fatal('existeAD_',print_r($resultLDAP,true));
            //Valida existencia local
            $existeCRM = false;
            $emailCRM = '';
            $queryUser = "select u.id, concat(u.first_name, ' ', u.last_name) name ,e.email_address email 
            from users u 
            inner join email_addr_bean_rel eb on eb.bean_id=u.id and eb.bean_module='Users' and eb.primary_address = true and eb.deleted=0
            inner join email_addresses e on e.id = eb.email_address_id and e.deleted=0
            where u.user_name='".$userData['user']."' and u.status='Active' and u.deleted=0 and u.is_group=0
            limit 1;";
            $resultQ = $GLOBALS['db']->query($queryUser);
            while ($row = $GLOBALS['db']->fetchByAssoc($resultQ)) {
              $existeCRM = true;
              $emailCRMCode = isset($row['email']) ? substr_replace($row['email'],"****",2,strpos($row['email'],"@")-2) : '';
              $emailCRM = isset($row['email']) ? $row['email'] : '';
              $userCRM = array(
                 "email" => $emailCRM = isset($row['email']) ? $row['email'] : '',
                 "name" => $emailCRM = isset($row['name']) ? $row['name'] : '',
                 "id" => $emailCRM = isset($row['id']) ? $row['id'] : '',
                 "code"=>""
              );
            }
            
            //Interpreta validación de usuario
            if ($existeAD && $existeCRM) {
                //Valida registro en unifin_mfa_login
                $getLogin = $this->getLastLogin($userData);
                $result['valid_secs'] = isset($getLogin['valid_secs']) ? $getLogin['valid_secs'] : 0;
                $result['mfa_enable'] = isset($getLogin['enable_mfa']) ? $getLogin['enable_mfa'] : true;
                if($result['mfa_enable']){
                    if($result['valid_secs']<=0){
                        //Inserta registro
                        $codeResult = $this->insertMFALogin($userData); // Output; valid_secs, code, status, message
                        if($codeResult['status'] == '200'){
                            //Envía correo de notificación
                            $userCRM['code']=$codeResult['code'];
                            $emailResult = $this->sendMFAMail($userCRM);
                            if($emailResult['status']=='200'){
                                $result['status']='200';
                                $result['message']='Por su seguridad se enviará un código de verificación de identidad a su correo electrónico: '. $emailCRMCode;
                                $result['valid_secs'] = $codeResult['valid_secs'];
                            }else {
                                $result['status']='500';
                                $result['message']='No se ha podido generar el envío de correo. Pongase en contacto con el equipo de Sistemas: '. $emailResult['message'];
                            }
                            
                        }else{
                            $result['status']=$codeResult['status'];
                            $result['message']=$codeResult['message'];
                        }
                    }else{
                        $result['status']='200';
                        $result['message']='Actualmente tiene un código de verificación activo. Valide su correo electrónico: '. $emailCRMCode;
                    }
                }else{
                    $result['status']='201';
                    $result['message']='MFA no habilitado';
                    $result['valid_secs'] = 0;
                }
            }else{
                $result['status']='400';
                $result['message']='Usuario o contraseña no válidos';
            }
        } catch(Exception $e) {
            $result['status']='500';
            $result['message']='Erro de sistema: '. $e;
        }
        
        //Regresa respuesta de validación
        return $result;
    }
    
    public function validateCodeMFAMethod($api, $args)
    {
        $result = array(
            "status"=>"",
            "message"=>""
        );
                
        try {
            //Recupera parámetros
            $userData = isset($args['userData']) ? json_decode(base64_decode($args['userData']),true) : array(); //userData.user || userData.password -- error_log(print_r($userData,true));
            $codeMFA = isset($args['code']) ? $args['code'] : 0;
            error_log('Userdata - u:'.$userData['user']);
            error_log('Userdata - c:'.$userData['code']);
            global $sugar_config;
            $mfa_valid_mistakes =  isset($sugar_config['mfa_valid_mistakes']) ? $sugar_config['mfa_valid_mistakes'] : 0;
            $validCode = false;
            //Valida última solicitud de acceso de usuario
            $queryCurrentLogin= "select mfa.id, mfa.validation_mistakes, mfa.code ,mfa.time_expiration, mfa.time_expiration - unix_timestamp() valid_secs
            from unifin_mfa_login mfa
            where mfa.user_name='".$userData['user']."' and time_expiration >= unix_timestamp() order by mfa.id desc
            limit 1;";
            $resultCL = $GLOBALS['db']->query($queryCurrentLogin);
            $complement_message = '';
            while ($row = $GLOBALS['db']->fetchByAssoc($resultCL)) {
                if($row['code']==$codeMFA){
                    if($row['validation_mistakes'] < $mfa_valid_mistakes){
                        $validCode = true;
                    }else{
                        $complement_message = 'Este código ha sido bloqueado ya que has superado el número de intentos permitidos. Espera que concluya el timer para solicitar un nuevo código de verificación.';
                    }
                }else{
                    if($row['validation_mistakes'] +1 >= $mfa_valid_mistakes){
                        $complement_message = 'Has excedido el número de intentos permitidos. Espera que concluya el timer para solicitar un nuevo código de verificación.';
                    }else{
                        $complement_message = 'Te quedan ' .$mfa_valid_mistakes - $row['validation_mistakes'] -1  . ' intentos.';
                    }
                    $updateS = "update unifin_mfa_login set validation_mistakes=validation_mistakes+1 where id='".$row['id']."'";
                    $resultUpdate = $GLOBALS['db']->query($updateS);
                }
                
            }
            if($validCode){
                $result['status'] = '200';
                $result['message'] = 'Código válido';
            }else{
                $result['status'] = '400';
                $result['message'] = 'Código no válido. '.$complement_message;
            }
            
        } catch(Exception $e) {
            $result['status']='500';
            $result['message']='Erro de sistema: '. $e;
        }
        
        //Regresa respuesta de validación
        return $result;
    }

    public function getLastLogin($userData)
    {
        $result = array(
            "enable_mfa"=>false,
            "valid_secs"=>0
        );
        //Recupera parámetros
        //$userData - userData.user || userData.password
        global $sugar_config;
        //Valida configuración MFA global
        $mfa_enable =  isset($sugar_config['mfa_enable']) ? $sugar_config['mfa_enable'] : false;
        $mfa_expiration_time =  isset($sugar_config['mfa_expiration_time']) ? $sugar_config['mfa_expiration_time'] : 0;
        $mfa_valid_mistakes =  isset($sugar_config['mfa_valid_mistakes']) ? $sugar_config['mfa_valid_mistakes'] : 1;
        $user_mfa_enable = false;
        
        //Validaciones en caso de existir usuario cargado
        if(isset($userData['user'])){
            //Valida configuración MFA Usuario
            $queryUser = "select u.id, mfa_enable_c
            from users u 
            inner join users_cstm uc on uc.id_c=u.id
            where u.user_name='".$userData['user']."' and u.status='Active' and u.deleted=0 and u.is_group=0
            limit 1;";
            $resultQ = $GLOBALS['db']->query($queryUser);
            while ($row = $GLOBALS['db']->fetchByAssoc($resultQ)) {
              $user_mfa_enable = $row['mfa_enable_c'];
            }
            $result['enable_mfa'] = ($mfa_enable && $user_mfa_enable) ? true : false;
            
            //Valida última solicitud de acceso de usuario
            $queryCurrentLogin= "select mfa.id, mfa.validation_mistakes, mfa.time_expiration, mfa.time_expiration - unix_timestamp() valid_secs
            from unifin_mfa_login mfa
            where mfa.user_name='".$userData['user']."' and time_expiration >= unix_timestamp() order by mfa.id desc
            limit 1;";
            $resultCL = $GLOBALS['db']->query($queryCurrentLogin);
            while ($row = $GLOBALS['db']->fetchByAssoc($resultCL)) {
              $result['valid_secs'] = $row['valid_secs'];
            }
        }
        //Regresa resultado
        return $result;
    }

    public function insertMFALogin($userData)
    {
        $result = array(
            "valid_secs"=>"0",
            "code"=>"0",
            "status"=>"0",
            "message"=>""
        );
        try {
            //Recupera parámetros
            //$userData - userData.user || userData.password
            global $sugar_config;
            //Valida configuración MFA global
            $mfa_enable =  isset($sugar_config['mfa_enable']) ? $sugar_config['mfa_enable'] : false;
            $mfa_expiration_time =  isset($sugar_config['mfa_expiration_time']) ? $sugar_config['mfa_expiration_time'] : 0;
            $mfa_valid_mistakes =  isset($sugar_config['mfa_valid_mistakes']) ? $sugar_config['mfa_valid_mistakes'] : 1;
            $user_mfa_enable = false;
            
            //Genera insert en unifin_mfa_login
            if(isset($userData['user'])){
                //Valida última solicitud de acceso de usuario
                $queryCurrentLogin= "select mfa.id, mfa.code, mfa.validation_mistakes, mfa.time_expiration, mfa.time_expiration - unix_timestamp() valid_secs
                from unifin_mfa_login mfa
                where mfa.user_name='".$userData['user']."' and time_expiration >= unix_timestamp() order by mfa.id desc
                limit 1;";
                $resultCL = $GLOBALS['db']->query($queryCurrentLogin);
                while ($row = $GLOBALS['db']->fetchByAssoc($resultCL)) {
                    $result['valid_secs'] = isset($row['valid_secs']) ? $row['valid_secs'] : 0;
                    $result['code'] = isset($row['code']) ? $row['code'] : 0;
                    $result['status'] = '200';
                    $result['message'] = 'Código recuperado de registro existente';
                }
                
                if($result['valid_secs']<=0){
                    $codeMFA = random_int(100000, 999999);
                    $insertS = "INSERT INTO unifin_mfa_login (user_name, code, time_set, time_expiration) VALUES ('".$userData['user']."', '".$codeMFA."', unix_timestamp(), unix_timestamp()+{$mfa_expiration_time});";
                    $resultInser = $GLOBALS['db']->query($insertS);
                    $result['code'] = $codeMFA;
                    $result['status'] = '200';
                    $result['message'] = 'Código generado';
                    $result['valid_secs'] = $mfa_expiration_time;
                }
            }else{
                $result['status'] = '400';
                $result['message'] = 'No se tiene información de usuario';
            }
        } catch (\Exception $e) {
            $result['status'] = '500';
            $result['message'] = $e;
        }
        //Regresa resultado
        return $result;
    }
    
    public function sendMFAMail($userData)
    {
        $result = array(
            "status"=>"0",
            "message"=>""
        );
        try {
            //Recupera parámetros
            //$userData - UserData.name | userData.email | userData.code | userData.id
            global $sugar_config;
            
            //Envía correo
            require_once("include/SugarPHPMailer.php");
            require_once("modules/EmailTemplates/EmailTemplate.php");
            require_once("modules/Administration/Administration.php");
            $emailtemplate = new EmailTemplate();
            $emailtemplate->retrieve_by_string_fields(array('name'=>'MFA User Email','type'=>'email'));
            $body_html = $emailtemplate->body_html;
            $body_html = str_replace('user_name', $userData["name"], $body_html);
            $body_html = str_replace('code', $userData["code"], $body_html);
            $emailtemplate->body_html = $body_html;
            $mailer = MailerFactory::getSystemDefaultMailer();
            $mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
            $mailer->setSubject($emailtemplate->subject);
            $body = trim($emailtemplate->body_html);
            $mailer->setHtmlBody($body);
            $mailer->clearRecipients();
            $mailer->addRecipientsTo(new EmailIdentity($userData["email"], $userData["name"]));
            $hoy = date("Y-m-d H:i:s");
            $mail = $userData["email"];
            try {
                $resultEmail = $mailer->send();
                $insert = "INSERT INTO user_email_log (id, user_id, related_id, date_entered, name_email, subject, type, related_type, status, description)
                  VALUES (uuid(), '{$userData['email']}', '', '{$hoy}', '{$mail}', '{$emailtemplate->subject}', 'TO', 'MFA Notification', 'OK', 'Correo exitosamente enviado')";
                $GLOBALS['db']->query($insert);
                $result['status']='200';
                $result['message']='Correo envíado exitosamente';
            } catch (Exception $e) {
                $insert = "INSERT INTO user_email_log (id, user_id, related_id, date_entered, name_email, subject, type, related_type, status, error_code, description)
                  VALUES (uuid(), '{$userData['email']}', '', '{$hoy}', '{$mail}', '{$emailtemplate->subject}', 'TO', 'MFA Notification', 'ERROR', '01', '{$e->getMessage()}')";
                $GLOBALS['db']->query($insert);
                $result['status']='500';
                $result['message']=$e->getMessage();
            }
        
        } catch(Exception $e) {
            $result['status'] = '500';
            $result['message'] = $e->getMessage();
        }
        //Regresa resultado
        return $result;
    }

    public function validateLDAP($userData)
    {
        $result = array(
            "status"=>"0",
            "message"=>""
        );
        try {
            $ldaprdn  = isset($userData['user']) ? $userData['user'].'@unifin.com.mx' : 'x';
            $ldappass = isset($userData['password']) ? $userData['password'] : 'x';
            $queryConfigLDAP="SELECT value from config where category='ldap' and name='hostname' limit 1;";
            $connection_string = $GLOBALS['db']->getOne($queryConfigLDAP);
            // $GLOBALS['log']->fatal('ldaprdn:'. $ldaprdn);
            // $GLOBALS['log']->fatal('ldappass:'. $ldappass);
            // $GLOBALS['log']->fatal('connection_string:'. $connection_string);
            
            $ldapconn = ldap_connect($connection_string) or die("Could not connect to LDAP server.");
            if ($ldapconn){ 
                $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);
                if ($ldapbind) 
                {
                    $result['status'] = '200';
                    $result['message'] = 'LDAP bind successful';
                }
                else 
                {
                    $result['status'] = '400';
                    $result['message'] = 'LDAP bind failed';
                }
            }
        } catch(Exception $e) {
            $result['status'] = '500';
            $result['message'] = $e;
        }
        
        return $result;
    }
}

?>
