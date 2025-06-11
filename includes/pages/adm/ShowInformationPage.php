<?php

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) {
    exit;
}

function ShowInformationPage()
{
    global $db, $LNG, $CONF, $USER;
    if (file_exists(ini_get('error_log'))) {
        $Lines  = count(file(ini_get('error_log')));
    } else {
        $Lines  = 0;
    }

    $template   = new template();
    $template->assign_vars(array(
        'info_information'  => $LNG['info_information'],
        'info'              => $_SERVER['SERVER_SOFTWARE'],
        'vPHP'              => PHP_VERSION,
        'vAPI'              => PHP_SAPI,
        'vGame'             => $CONF['VERSION'],
        'vMySQLc'           => $db->getVersion(),
        'vMySQLs'           => $db->getServerVersion(),
        'root'              => $_SERVER['SERVER_NAME'],
        'gameroot'          => $_SERVER['SERVER_NAME'] . str_replace('/admin.php', '', $_SERVER['PHP_SELF']),
        'json'              => function_exists('json_encode') ? 'Si' : 'No',
        'bcmath'            => extension_loaded('bcmath') ? 'Si' : 'No',
        'curl'              => extension_loaded('curl') ? 'Si' : 'No',
        'browser'           => $_SERVER['HTTP_USER_AGENT'],
        'errorloglines'     => $Lines,
        'safemode'          => ini_get('safe_mode') ? 'Si' : 'No',
        'memory'            => ini_get('memory_limit'),
    ));

    $template->show('adm/ShowInformationPage.tpl');
}
