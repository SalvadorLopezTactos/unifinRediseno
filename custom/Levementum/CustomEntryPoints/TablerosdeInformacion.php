<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 6/24/2015
 * Time: 11:34 AM
 */

if(isset($_REQUEST['tablero'])) {
    if ($_REQUEST['tablero'] == 'L1') {
        $L1 = <<<HTML
<h1>L1</h1>
HTML;
    echo $L1;
    }

    if ($_REQUEST['tablero'] == 'L2') {
        $L2 = <<<HTML
<h1>L2</h1>
HTML;
        echo $L2;
    }

    if ($_REQUEST['tablero'] == 'L3') {
        $L3 = <<<HTML
<h1>L3</h1>
HTML;
        echo $L3;
    }

    if ($_REQUEST['tablero'] == 'C1') {
        $C1 = <<<HTML
<h1>C1</h1>
HTML;
        echo $C1;
    }

    if ($_REQUEST['tablero'] == 'C2') {
        $C2 = <<<HTML
<h1>C2</h1>
HTML;
        echo $C2;
    }

    if ($_REQUEST['tablero'] == 'R1') {
        $R1 = <<<HTML
<h1>R1</h1>
HTML;
        echo $R1;
    }

    if ($_REQUEST['tablero'] == 'R2') {
        $R2 = <<<HTML
<h1>R2</h1>
HTML;
        echo $R2;
    }

    if ($_REQUEST['tablero'] == 'R3') {
        $R3 = <<<HTML
<h1>R3</h1>
HTML;
        echo $R3;
    }
}
