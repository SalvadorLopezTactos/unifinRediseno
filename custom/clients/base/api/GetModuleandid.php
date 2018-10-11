<?php  

/**Victor Martinez Lopez 10-10-2018
* Obtiene el modulo el id del elemento de una lista y su etiqueta
*/
class GetModuleandid extends SugarApi
{
  public function registerApiRest()
  {
       return array(
           //GET
           'retrieve' => array(
               //request type
               'reqType' => 'GET',
               'noLoginRequired' => false,
               //endpoint path
               'path' => array('<module>', '?', '?'),
               //endpoint variables
               'pathVars' => array('module','field', 'id'),
               //method to call
               'method' => 'GetModuleAndID',
               //short help string to be displayed in the help documentation
               'shortHelp' => 'Api para obtener el id de un elemento de la lista y la etiqueta',
               //long help to be displayed in the help documentation
               'longHelp' => '',
           ),

       );

  }

  public function GetModuleAndID($api, $args){
    //Recuperar variables
    $modulo = $args['module'];
    $campo = $args['field'];
    $id = $args['id'];
    $etiqueta = 'valor';

    //Recuperar valores de lista
    $bean = BeanFactory::newBean($modulo);
    $vardef = $bean->field_defs[$campo];
    $value = getOptionsFromVardef($vardef);

    //Recuperar etiqueta
    $etiqueta = $value[$id];


    // //Regresar resultado
    $resultado = array($id=>$etiqueta);

    return $resultado;

  }
}