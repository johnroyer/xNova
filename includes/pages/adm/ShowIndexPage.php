<?php

function ShowIndexPage()
{
    global $CONF, $LNG;
    $template   = new template();

    $template->assign_vars(array(
        'game_name'     => $CONF['game_name'],
        'adm_cp_title'  => $LNG['adm_cp_title'],
    ));

    $template->display('adm/ShowIndexPage.tpl');
}
