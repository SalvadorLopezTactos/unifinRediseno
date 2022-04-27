<?php
/**en la nota esta el nombre de la cuenta
* En campo notas bajar un texto que concatene nota generada y el nombre de la minuta bean similar a this.model 
*/
class Minuta_nota 
{
	
	function Hereda_datos($bean = null, $event = null, $args = null)
	{
	$GLOBALS['log']->fatal('>>>>>>>Entro al Hook de Victor: ');//------------------------------------
	$bean_notas = BeanFactory::newBean('Notes');
    $GLOBALS['log']->fatal('>>>>>>>Creo la nota: ');//------------------------------------
    $bean_notas->name = $bean->name;
    $bean_notas->parent_type="Accounts"; //Tipo
    $bean_notas->parent_id=$bean->account_id_c; //->Es similar a this.model para obtener y settear valores
    $bean_notas->description="Nota creada a partir de la: " .$bean->name;
    $bean_notas->minut_minutas_id_c=$bean->id;
    $bean_notas->assigned_user_id=$bean->assigned_user_id; 
    $bean_notas->save();
	$GLOBALS['log']->fatal('>>>>>>>Termina proceso de nota: ');//------------------------------------
	}
}