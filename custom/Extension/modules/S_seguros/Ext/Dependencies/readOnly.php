<?php
$dependencies['S_seguros']['readOnly'] = array
(
  'hooks' => array('edit'),
  'trigger' => 'true',
  'triggerFields' => array('etapa'),
  'onload' => true,
  'actions' => array
  (
    array
		(
      'name' => 'ReadOnly',
      'params' => array
      (
        'target' => 'edit_button',
        'value' => 'or(equal($etapa,2),equal($etapa,9))',
      ),
    ),
  ),
);
