<?php

function ShowTopnavPage()
{
    global $LNG, $USER, $db, $UNI, $CONF;
    $template   = new template();
    $AvailableUnis[$CONF['uni']]    = $CONF['game_name'] . ' (ID: ' . $CONF['uni'] . ')';
    $Query  = $db->query("SELECT `uni`, `game_name` FROM " . CONFIG . " WHERE `uni` != '" . $UNI . "' ORDER BY `uni` DESC;");
    while ($Unis = $db->fetch_array($Query)) {
        $AvailableUnis[$Unis['uni']]    = $Unis['game_name'] . ' (ID: ' . $Unis['uni'] . ')';
    }
    ksort($AvailableUnis);
    $template->assign_vars(array(
        'ad_authlevel_title'    => $LNG['ad_authlevel_title'],
        're_reset_universe'     => $LNG['re_reset_universe'],
        'mu_universe'           => $LNG['mu_universe'],
        'mu_moderation_page'    => $LNG['mu_moderation_page'],
        'adm_cp_title'          => $LNG['adm_cp_title'],
        'adm_cp_index'          => $LNG['adm_cp_index'],
        'adm_cp_logout'         => $LNG['adm_cp_logout'],
        'sid'                   => session_id(),
        'id'                    => $USER['id'],
        'authlevel'             => $USER['authlevel'],
        'AvailableUnis'         => $AvailableUnis,
        'UNI'                   => $_SESSION['adminuni'],
    ));

    $template->show('adm/ShowTopnavPage.tpl');
}
