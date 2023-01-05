<?php
// Made with SugarFuel v3.5.0

$manifest = array(
    "license" => "SugarCRM MSA",
    "version" => "1.1",
    "acceptable_sugar_versions" => array(
        "exact_matches" => array("11.0.5", "11.0.4", "11.0.3", "11.0.2", "11.0.1", "11.0.0"),
        "regex_matches" => array()
    ),
    "type" => "module",
    "bugs" => array(),
    "acceptable_sugar_flavors" => array("ENT", "ULT"),
    "name" => "Hotfix 91155 11.0.0-11.0.5 (Ent+Ult)",
    "description" => "",
    "author" => "SugarCRM",
    "is_uninstallable" => false,
    "published_date" => "Wed, 04 Jan 2023 19:21:40 GMT"
);

$installdefs = array(
    "copy" => array(
        array(
            "from" => "<basepath>/files/install/install_utils.php",
            "to" => "install/install_utils.php"
        ),
        array(
            "from" => "<basepath>/files/modules/EmailTemplates/AttachFiles.php",
            "to" => "modules/EmailTemplates/AttachFiles.php"
        ),
        array(
            "from" => "<basepath>/files/include/MVC/SugarApplication.php",
            "to" => "include/MVC/SugarApplication.php"
        )
    ),
    "id" => "efaeacdd-099a-4314-b85a-30a04e2edb89",
    "post_execute" => array("<basepath>/scripts/post_execute/rhf.php")
);

