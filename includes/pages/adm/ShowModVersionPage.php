<?php

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) {
    exit;
}

function ShowModVersionPage()
{
    global $LNG, $USER;
    $MVC    = array();
    $Files  = scandir(ROOT_PATH . 'includes/functions/mvc/');
    foreach ($Files as $File) {
        if (substr($File, 0, 4) == 'mvc_') {
            require(ROOT_PATH . 'includes/functions/mvc/' . $File);
        }
    }

    foreach ($MVC as &$Mod) {
        $Mod['description'] = $Mod['description'][$USER['lang']];
        $Update = @simplexml_load_file($Mod['update']);
        $Update = $Update->$Mod['tag'];
        if (version_compare($Mod['version'], $Update->version, '<')) {
            $Mod['update']      = colorRed($LNG['mvc_update_yes']);
            $Mod['udetails']    = array('version' => $Update->version, 'date' => $Update->date, 'download' => $Update->download, 'announcement' => $Update->announcement);
        } else {
            $Mod['update']      = colorGreen($LNG['mvc_update_no']);
            $Mod['udetails']    = false;
        }
    }

    $template   = new template();
    $template->assign_vars(array(
        'MVC'                   => $MVC,
        'mvc_title'             => $LNG['mvc_title'],
        'mvc_author'            => $LNG['mvc_author'],
        'mvc_version'           => $LNG['mvc_version'],
        'mvc_link'              => $LNG['mvc_link'],
        'mvc_update_version'    => $LNG['mvc_update_version'],
        'mvc_update_date'       => $LNG['mvc_update_date'],
        'mvc_announcement'      => $LNG['mvc_announcement'],
        'mvc_download'          => $LNG['mvc_download'],
        'mvc_desc'              => $LNG['mvc_desc'],
    ));
    $template->show('adm/ModVersionPage.tpl');
}
