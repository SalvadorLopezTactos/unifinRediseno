<?php
class Doc_Class
{
  function Doc_Method($bean, $event, $arguments)
  {
    if($arguments['related_module'] == "Documents")
    {
	$bean->load_relationship('minut_minutas_documents_1');
        $relatedDocumentos = $bean->minut_minutas_documents_1->getBeans();
        $totalDocumentos = count($relatedDocumentos);
        if($totalDocumentos >= 3)
	{
	  sugar_die('No puede agregar mas de 3 documentos a la misma minuta');
        }
    }
  }
}
?>