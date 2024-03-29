<?php

function ShowBannedPage()
{
    global $USER, $PLANET, $LNG, $db;

    $PlanetRess = new ResourceUpdate();
    $PlanetRess->CalcResource();
    $PlanetRess->SavePlanetToDB();

    $template   = new template();
    $query          = $db->query("SELECT * FROM " . BANNED . " ORDER BY `id`;");
    $PrangerList    = array();

    while ($u = $db->fetch_array($query)) {
        $PrangerList[]  = array(
            'player'    => $u['who'],
            'theme'     => $u['theme'],
            'from'      => date(TDFORMAT, $u['time']),
            'to'        => date(TDFORMAT, $u['longer']),
            'admin'     => $u['author'],
            'mail'      => $u['email'],
            'info'      => sprintf($LNG['bn_writemail'], $u['author']),
        );
    }

    $db->free_result($query);

    $template->assign_vars(array(
        'PrangerList'               => $PrangerList,
        'bn_no_players_banned'      => $LNG['bn_no_players_banned'],
        'bn_exists'                 => $LNG['bn_exists'],
        'bn_players_banned'         => $LNG['bn_players_banned'],
        'bn_players_banned_list'    => $LNG['bn_players_banned_list'],
        'bn_player'                 => $LNG['bn_player'],
        'bn_reason'                 => $LNG['bn_reason'],
        'bn_from'                   => $LNG['bn_from'],
        'bn_until'                  => $LNG['bn_until'],
        'bn_by'                     => $LNG['bn_by'],
    ));

    $template->show("banned_overview.tpl");
}
