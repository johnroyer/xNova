<?php

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) {
    exit;
}

function ShowMultiIPPage()
{
    global $LNG, $db;
    $Query  = $db->query("SELECT id, username, user_lastip FROM " . USERS . " WHERE `universe` = '" . $_SESSION['adminuni'] . "' AND user_lastip IN (SELECT user_lastip FROM " . USERS . " WHERE `universe` = '" . $_SESSION['adminuni'] . "' GROUP BY user_lastip HAVING COUNT(*)>1) ORDER BY user_lastip, id ASC;");
    $IPs    = array();
    while ($Data = $db->fetch_array($Query)) {
        if (!isset($IPs[$Data['user_lastip']])) {
            $IPs[$Data['user_lastip']]  = array();
        }

        $IPs[$Data['user_lastip']][$Data['id']] = $Data['username'];
    }
    $template   = new template();
    $template->assign_vars(array(
        'IPs'       => $IPs,
        'mip_ip'    => $LNG['mip_ip'],
        'mip_user'  => $LNG['mip_user'],
    ));
    $template->show('adm/MultiIPs.tpl');
}
