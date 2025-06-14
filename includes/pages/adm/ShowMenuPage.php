<?php

function ShowMenuPage()
{
    global $USER, $LNG, $db;
    $template   = new template();
    $template->assign_vars(array(
        'mu_game_info'              => $LNG['mu_game_info'],
        'mu_settings'               => $LNG['mu_settings'],
        'mu_ts_options'             => $LNG['mu_ts_options'],
        'mu_fb_options'             => $LNG['mu_fb_options'],
        'mu_module'                 => $LNG['mu_module'],
        'mu_user_logs'              => $LNG['mu_user_logs'],
        'mu_optimize_db'            => $LNG['mu_optimize_db'],
        'mu_stats_options'          => $LNG['mu_stats_options'],
        'mu_chat'                   => $LNG['mu_chat'],
        'mu_update'                 => $LNG['mu_update'],
        'mu_general'                => $LNG['mu_general'],
        'new_creator_title'         => $LNG['new_creator_title'],
        'mu_add_delete_resources'   => $LNG['mu_add_delete_resources'],
        'mu_ban_options'            => $LNG['mu_ban_options'],
        'mu_users_settings'         => $LNG['mu_users_settings'],
        'mu_tools'                  => $LNG['mu_tools'],
        'mu_manual_points_update'   => $LNG['mu_manual_points_update'],
        'mu_global_message'         => $LNG['mu_global_message'],
        'mu_md5_encripter'          => $LNG['mu_md5_encripter'],
        'mu_mpu_confirmation'       => $LNG['mu_mpu_confirmation'],
        'mu_observation'            => $LNG['mu_observation'],
        'mu_connected'              => $LNG['mu_connected'],
        'mu_support'                => $LNG['mu_support'],
        'mu_vaild_users'            => $LNG['mu_vaild_users'],
        'mu_active_planets'         => $LNG['mu_active_planets'],
        'mu_flying_fleets'          => $LNG['mu_flying_fleets'],
        'mu_news'                   => $LNG['mu_news'],
        'mu_user_list'              => $LNG['mu_user_list'],
        'mu_planet_list'            => $LNG['mu_planet_list'],
        'mu_moon_list'              => $LNG['mu_moon_list'],
        'mu_mess_list'              => $LNG['mu_mess_list'],
        'mu_info_account_page'      => $LNG['mu_info_account_page'],
        'mu_multiip_page'           => $LNG['mu_multiip'],
        'mu_search_page'            => $LNG['mu_search_page'],
        'mu_mod_update'             => $LNG['mu_mod_update'],
        'mu_clear_cache'            => $LNG['mu_clear_cache'],
        'supportticks'              => $db->countquery("SELECT COUNT(*) FROM " . SUPP . " WHERE `universe` = '" . $_SESSION['adminuni'] . "' AND (`status` = '1' OR `status` = '3');"),
    ));
    $template->show('adm/ShowMenuPage.tpl');
}
