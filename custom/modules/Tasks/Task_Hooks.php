<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 6/26/2015
 * Time: 8:07 PM
 */
class Task_Hooks
{
    public function afterWorkflow($bean=null,$event=null,$args=null)
	{
        if($bean->parent_type == 'Accounts' && $bean->estatus_c == 'No Interesado'){
            $account = BeanFactory::getBean('Accounts', $bean->parent_id);
            $bean->name = 'Prospecto No Interesado ' . $account->name . ' - ' . $account->tipodemotivo_c;
            $bean->description = $account->motivo_c;
            $bean->date_start = $bean->date_entered;
        }
    }

    function InfoTasks($bean = null, $event = null, $args = null)
    {
        if (!$args['isUpdate']) {
            global $db ,$current_user;
            $GLOBALS['log']->fatal("InfoTasks: Inicio");
            //Realiza consulta para obtener info del usuario asignado
            $query="SELECT cstm.region_c,cstm.equipos_c,cstm.tipodeproducto_c,cstm.puestousuario_c from users as u
                INNER JOIN users_cstm as cstm
                ON u.id=cstm.id_c
                WHERE id='{$bean->assigned_user_id}'";
            $GLOBALS['log']->fatal("InfoTasks: consulta : ".$query);
            $queryResult = $db->query($query);
            $GLOBALS['log']->fatal("InfoTasks: Consulta para usuario asignado " .print_r($queryResult, true));
            while ($row = $db->fetchByAssoc($queryResult)) {
                //Setea valores usuario ASIGNADO
                $bean->asignado_region_c=$row['region_c'];
                $bean->asignado_equipo_promocion_c=$row['equipos_c'];
                $bean->asignado_producto_c=$row['tipodeproducto_c'];
                $bean->asignado_puesto_c=$row['puestousuario_c'];
            }
            $GLOBALS['log']->fatal("InfoTasks: Setea valores usuario logueado");
            //Setea valores usuario LOGUEADO/Creador del registro
            $bean->creado_region_c= $current_user->region_c;
            $bean->creado_equipo_promocion_c =$current_user->equipos_c;
            $bean->creado_producto_c= $current_user->tipodeproducto_c;
            $bean->creado_puesto_c=$current_user->puestousuario_c;
            $GLOBALS['log']->fatal("InfoTasks: Finaliza");
        }
    }

    public function sendEmail($bean=null,$event=null,$args=null)
	{
        $bean->fecha_vacia_c = $bean->fecha_calificacion_c;
		if($bean->potencial_negocio_c) $bean->status = 'Completed';
		if(empty($bean->fetched_row['id']) && $bean->puesto_c == 61 && $bean->parent_type == 'Accounts') {
			$account = BeanFactory::getBean('Accounts', $bean->parent_id);
			$user = BeanFactory::getBean('Users', $account->user_id_c);
			if(!empty($user->email1)) {
				$correo = $user->email1;
				$nombre = $user->nombre_completo_c;
				$fechas = new DateTime($bean->date_due);
				$fecha = $fechas->format('d/m/Y');
				$users = BeanFactory::getBean('Users', $bean->created_by);
				$creador = $users->nombre_completo_c;
				require_once 'include/SugarPHPMailer.php';
				require_once 'modules/Administration/Administration.php';
				$linkTarea=$GLOBALS['sugar_config']['site_url'].'/#Tasks/'.$bean->id;
				if($account->user_id_c == $bean->assigned_user_id) {
					$mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">Se le informa que se le ha asignado una nueva tarea con la siguiente información:
					<br><br>Asunto: <b><a id="linkTarea" href="'.$linkTarea.'">'.$bean->name.'</a></b>
					<br><br>Asesor creador del registro: <b>'.$creador.'</b>
					<br><br>Descripción: <b>'.$bean->description.'</b>
					<br><br>Es importante que atienda esta tarea ya que representa una oportunidad de negocio para UNIFIN, la fecha de vencimiento de la tarea es <b>'.$fecha.'</b>
					<br><br>Atentamente Unifin</font></p>
					<br><p class="imagen"><img border="0" id="bannerUnifin" src="https://www.unifin.com.mx/ri/front/img/logo.png"></span></p>
					<p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
					Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
					Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
					No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
					Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/aviso-de-privacidad.php" target="_blank" rel="noopener"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank" rel="noopener"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a></span><u></u><u></u></p>';
				} else {
					$mailHTML = '<p align="justify"><font face="verdana" color="#635f5f">Se le informa que se le ha asignado una nueva tarea con la siguiente información:
					<br><br>Asunto: <b><a id="linkTarea" href="'.$linkTarea.'">'.$bean->name.'</a></b>
					<br><br>Asesor creador del registro: <b>'.$creador.'</b>
					<br><br>Descripción: <b>'.$bean->description.'</b>
					<br><br>Atentamente Unifin</font></p>
					<br><p class="imagen"><img border="0" id="bannerUnifin" src="https://www.unifin.com.mx/ri/front/img/logo.png"></span></p>
					<p class="MsoNormal" style="text-align: justify;"><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">
					Este correo electrónico y sus anexos pueden contener información CONFIDENCIAL para uso exclusivo de su destinatario. Si ha recibido este correo por error, por favor, notifíquelo al remitente y bórrelo de su sistema.
					Las opiniones expresadas en este correo son las de su autor y no son necesariamente compartidas o apoyadas por UNIFIN, quien no asume aquí obligaciones ni se responsabiliza del contenido de este correo, a menos que dicha información sea confirmada por escrito por un representante legal autorizado.
					No se garantiza que la transmisión de este correo sea segura o libre de errores, podría haber sido viciada, perdida, destruida, haber llegado tarde, de forma incompleta o contener VIRUS.
					Asimismo, los datos personales, que en su caso UNIFIN pudiera recibir a través de este medio, mantendrán la seguridad y privacidad en los términos de la Ley Federal de Protección de Datos Personales; para más información consulte nuestro &nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #2f96fb;"><a href="https://www.unifin.com.mx/aviso-de-privacidad.php" target="_blank" rel="noopener"><span style="color: #2f96fb; text-decoration: none;">Aviso de Privacidad</span></a></span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #212121;">&nbsp; publicado en&nbsp;</span><span style="font-size: 7.5pt; font-family: \'Arial\',sans-serif; color: #0b5195;"><a href="http://www.unifin.com.mx/" target="_blank" rel="noopener"><span style="color: #0b5195; text-decoration: none;">www.unifin.com.mx</span></a></span><u></u><u></u></p>';
				}
				$mailer = MailerFactory::getSystemDefaultMailer();
				$mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();
				$mailer->setSubject('Nueva Tarea CAC: '.$bean->name);
				$body = trim($mailHTML);
				$mailer->setHtmlBody($body);
				$mailer->clearRecipients();
				$mailer->addRecipientsTo(new EmailIdentity($correo, $nombre));
				$result = $mailer->send();
			}
		}
    }
}
