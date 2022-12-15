<?php
$hook_array['before_save'][] = Array(
    12,
    'Genera vacaciones del usuario',
    'custom/modules/Users/HolidaysUser.php',
    'HolidaysUser',
    'createHolidayUser'
);