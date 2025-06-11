<?php

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) {
    exit;
}

function ShowModulePage()
{
    global $CONF, $LNG;
    if ($_GET['mode']) {
        $CONF['moduls'][request_var('id', 0)]   = ($_GET['mode'] == 'aktiv') ? 1 : 0;
        update_config(array('moduls' => implode(";", $CONF['moduls']), false, $_SESSION['adminuni']));
        $CONF['moduls']     = explode(";", $CONF['moduls']);
    }
    $IDs    = range(0, 40);
    foreach ($IDs as $ID => $Name) {
        $Modules[$ID]   = array(
            'name'  => $LNG['modul'][$ID],
            'state' => isset($CONF['moduls'][$ID]) ? $CONF['moduls'][$ID] : 1,
        );
    }

    asort($Modules);
    $template   = new template();
    $template->assign_vars(array(
        'Modules'               => $Modules,
        'mod_module'            => $LNG['mod_module'],
        'mod_info'              => $LNG['mod_info'],
        'mod_active'            => $LNG['mod_active'],
        'mod_deactive'          => $LNG['mod_deactive'],
        'mod_change_active'     => $LNG['mod_change_active'],
        'mod_change_deactive'   => $LNG['mod_change_deactive'],
    ));

    $template->show('adm/ModulePage.tpl');
}
