<?php
    /**
     * Created by Levementum.
     * User: jgarcia@levementum.com
     * Date: 3/22/2016
     * Time: 7:16 PM
     */
    global $sugar_config;

    $backlog_doc = $_REQUEST['backlog_doc'];
    $csvfile = $sugar_config['upload_dir'] . $backlog_doc;

    header('Content-type: text/csv');
    header('Content-disposition: attachment; filename="' . $backlog_doc . '"');
    readfile($csvfile);
    exit();