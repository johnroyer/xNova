<?php

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) {
    exit;
}

function ShowFacebookPage()
{
    global $CONF, $LNG;
    if ($_POST) {
        $CONF['fb_on']      = isset($_POST['fb_on']) && $_POST['fb_on'] == 'on' && !empty($_POST['fb_skey']) && !empty($_POST['fb_apikey']) ? 1 : 0;
        $CONF['fb_apikey']  = request_var('fb_apikey', '');
        $CONF['fb_skey']    = request_var('fb_skey', '');

        update_config(array(
            'fb_on'     => $CONF['fb_on'],
            'fb_apikey' => $CONF['fb_apikey'],
            'fb_skey'   => $CONF['fb_skey']
        ), true);
    }

    $template   = new template();


    $template->assign_vars(array(
        'se_save_parameters'    => $LNG['se_save_parameters'],
        'fb_info'               => $LNG['fb_info'],
        'fb_secrectkey'         => $LNG['fb_secrectkey'],
        'fb_api_key'            => $LNG['fb_api_key'],
        'fb_active'             => $LNG['fb_active'],
        'fb_settings'           => $LNG['fb_settings'],
        'fb_on'                 => $CONF['fb_on'],
        'fb_apikey'             => $CONF['fb_apikey'],
        'fb_skey'               => $CONF['fb_skey'],
        'fb_curl'               => function_exists('curl_init') ? 1 : 0,
        'fb_curl_info'          => function_exists('curl_init') ? $LNG['fb_curl_yes'] : $LNG['fb_curl_no'],
    ));
    $template->show('adm/FacebookPage.tpl');
}
