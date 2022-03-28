<?php
//Insert our custom button definition into existing Buttons array before the edit button
array_splice($viewdefs['Calls']['base']['view']['record']['buttons'], -2, 0, array(
    array(
        'name' => 'add_iws',
        'type' => 'button',
        'label' => 'LBL_ADD_IWS',
        'css_class' => 'btn-success',//css class name for the button
        'events' => array(
            // custom Sidecar Event to trigger on click.  Event name can be anything you want.
            'click' => 'button:add_iws:click',
        )
    ),
));