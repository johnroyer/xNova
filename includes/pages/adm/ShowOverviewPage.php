<?php

function ShowOverviewPage()
{
    global $LNG, $USER, $CONF;

    $Message    = array();

    if ($USER['authlevel'] >= AUTH_ADM) {
        if (file_exists(ROOT_PATH . 'install.php')) {
            $Message[]  = sprintf($LNG['ow_file_detected'], 'install.php');
        }

        if (file_exists(ROOT_PATH . 'install.sql')) {
            $Message[]  = sprintf($LNG['ow_file_detected'], 'install.sql');
        }

        if (is_writable(ROOT_PATH . 'includes/config.php')) {
            $Message[]  = $LNG['ow_config_file_writable'];
        }

        if (!is_writable(ROOT_PATH . 'includes')) {
            $Message[]  = sprintf($LNG['ow_dir_not_writable'], 'includes');
        }

        if (!is_writable(ROOT_PATH . 'raports')) {
            $Message[]  = sprintf($LNG['ow_dir_not_writable'], 'raports');
        }

        if ($CONF['user_valid'] == 1 && (empty($CONF['smtp_host']) || empty($CONF['smtp_port']) || empty($CONF['smtp_user']) || empty($CONF['smtp_pass']))) {
            $Message[]  = $LNG['ow_smtp_errors'];
        }
    }

    $template   = new template();

    $template->assign_vars(array(
        'ow_none'           => $LNG['ow_none'],
        'ow_overview'       => $LNG['ow_overview'],
        'ow_welcome_text'   => $LNG['ow_welcome_text'],
        'ow_credits'        => $LNG['ow_credits'],
        'ow_special_thanks' => $LNG['ow_special_thanks'],
        'ow_translator'     => $LNG['ow_translator'],
        'ow_proyect_leader' => $LNG['ow_proyect_leader'],
        'ow_support'        => $LNG['ow_support'],
        'ow_title'          => $LNG['ow_title'],
        'ow_forum'          => $LNG['ow_forum'],
        'ow_donate'         => $LNG['ow_donate'],
        'Messages'          => $Message,
        'date'              => date('m\_Y', TIMESTAMP),
    ));

    $template->show('adm/OverviewBody.tpl');
}
