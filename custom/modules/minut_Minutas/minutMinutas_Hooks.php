<?php
/**
 * @author F. Javier G. Solar
 * Date: 25/10/2018
 * Time: 11:50 AM
 *
 */
require_once('include/SugarQuery/SugarQuery.php');

class minutMinutas_Hooks
{
    public function createParticipantes($bean = null, $event = null, $args = null)
    {
        $idMinuta = $bean->id;
        $objParticipantes = $bean->minuta_participantes;
        $objIdReunion = $objParticipantes['idReunion'];
        $objIdCuentaPadre = $objParticipantes['idCuenta'];
        $objArrParticipnates = $objParticipantes['participantes'];
        // Creamos la Relación entre Minuta y Participantes
        if ($objArrParticipnates != "" && isset($objArrParticipnates))
        {
          for ($i = 0; $i < count($objArrParticipnates); $i++) {
              $beanParticipante = BeanFactory::newBean("minut_Participantes");
              $beanParticipante->name = $objArrParticipnates[$i]['nombres'];
              $beanParticipante->tct_apellido_paterno_c = $objArrParticipnates[$i]['apaterno'];
              $beanParticipante->tct_apellido_materno_c = $objArrParticipnates[$i]['amaterno'];
              $beanParticipante->tct_nombre_completo_c = $objArrParticipnates[$i]['nombres'] . " " . $objArrParticipnates[$i]['apaterno'] . " " . $objArrParticipnates[$i]['amaterno'];
              $beanParticipante->tct_correo_c = $objArrParticipnates[$i]['correo'];
              $beanParticipante->tct_telefono_c = $objArrParticipnates[$i]['telefono'];
              $beanParticipante->tct_asistencia_c = $objArrParticipnates[$i]['asistencia'];
              $beanParticipante->tct_tipo_registro_c = $objArrParticipnates[$i]['tipo_contacto'];
              //$beanParticipante->tct_id_registro_c=$objArrParticipnates[$i]['nombres'];
              $beanParticipante->minut_minutas_minut_participantesminut_minutas_ida = $idMinuta;
              $beanParticipante->description = $objArrParticipnates[$i]['unifin'];
              $beanParticipante->save();
          }
          // Creamos la Relación entre cuentas y nuevos participantes
          $nueva = 0;
          for ($j = 0; $j < count($objArrParticipnates); $j++) {
              if ($objArrParticipnates[$j]['origen'] == "N") {
                  // creo cuenta
                  $beanCuentas = BeanFactory::newBean("Accounts");
                  $beanCuentas->primernombre_c = $objArrParticipnates[$j]['nombres'];
                  $beanCuentas->apellidopaterno_c = $objArrParticipnates[$j]['apaterno'];
                  $beanCuentas->apellidomaterno_c = $objArrParticipnates[$j]['amaterno'];
                  $beanCuentas->phone_office = $objArrParticipnates[$j]['telefono'];
                  $beanCuentas->email1 = $objArrParticipnates[$j]['correo'];
                  $beanCuentas->tipo_registro_c = "Persona";
                  try {
                      $beanCuentas->save();
                      $cuenta = $beanCuentas->id;
                      $nueva = 1;
                  } catch (Exception $e) {
                      $GLOBALS['log']->fatal("Error: ".$e);
                  }
              }
              // Busca relacion
              if($objArrParticipnates[$j]['origen'] == "E")
              {
                $conta = 0;
         	      $beanPersona = BeanFactory::getBean('Accounts', $objIdCuentaPadre);
                $beanPersona->load_relationship('rel_relaciones_accounts_1');
                $relatedRelaciones = $beanPersona->rel_relaciones_accounts_1->getBeans();
                $totalRelaciones = count($relatedRelaciones);
                if($totalRelaciones > 0)
                {
                  foreach($relatedRelaciones as $relacion)
                  {
                    if($relacion->account_id1_c == $objArrParticipnates[$j]['id'])
                    {
                      if(strpos($relacion->relaciones_activas, "Contacto") == TRUE)
                      {
                        if($relacion->tipodecontacto != $objArrParticipnates[$j]['tipo_contacto'])
                        {
                          $beanRelated = BeanFactory::getBean('Rel_Relaciones', $relacion->id);
                          $beanRelated->tipodecontacto = $objArrParticipnates[$j]['tipo_contacto'];
                          $beanRelated->save();
                        }
                      }
                      else
                      {
                        $beanRelated = BeanFactory::getBean('Rel_Relaciones', $relacion->id);
                        $beanRelated->relaciones_activas = $beanRelated->relaciones_activas.',^Contacto^';
                        $beanRelated->tipodecontacto = $objArrParticipnates[$j]['tipo_contacto'];
                        $beanRelated->save();
                      }
                    }
                    else
                    {
                      $conta = $conta + 1;
                    }
                  }
                  if($conta == $totalRelaciones)
                  {
                    $nueva = 1;
                    $cuenta = $objArrParticipnates[$j]['id'];
                  }
                }
                else
                {
                  $nueva = 1;
                  $cuenta = $objArrParticipnates[$j]['id'];
                }
              }
              if($nueva)
              {
                // genero relacion
                $beanRelacion = BeanFactory::newBean("Rel_Relaciones");
                $beanRelacion->tipodecontacto = $objArrParticipnates[$j]['tipo_contacto'];
                $beanRelacion->relaciones_activas = "Contacto";
                $beanRelacion->rel_relaciones_accounts_1accounts_ida = $objIdCuentaPadre;
                $beanRelacion->account_id1_c = $cuenta;
                $beanRelacion->rel_relaciones_accountsaccounts_ida = $beanRelacion->rel_relaciones_accounts_1accounts_ida;
                try {
                    $beanRelacion->save();
                    $nueva = 0;
                } catch (Exception $e) {
                    $GLOBALS['log']->fatal("Error: ".$e);
                }
              }
              // Actualiza telefono y correo de cuentas existentes
              if($objArrParticipnates[$j]['id'] && $objArrParticipnates[$j]['origen']=="C")
              {
                $beanCuenta = BeanFactory::getBean('Accounts', $objArrParticipnates[$j]['id']);
                $beanCuenta->phone_office = $objArrParticipnates[$j]['telefono'];
                $beanCuenta->email1 = $objArrParticipnates[$j]['correo'];
                $beanCuenta->save();
              }
          }
        }
    }
}
