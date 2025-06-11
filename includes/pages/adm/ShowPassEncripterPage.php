<?php

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) {
    exit;
}

function ShowPassEncripterPage()
{
    global $LNG;
    $Password   = request_var('md5q', '', true);

    $template   = new template();

    $template->assign_vars(array(
        'md5_md5'           => $Password,
        'md5_enc'           => md5($Password),
        'et_md5_encripter'  => $LNG['et_md5_encripter'],
        'et_encript'        => $LNG['et_encript'],
        'et_result'         => $LNG['et_result'],
        'et_pass'           => $LNG['et_pass'],
    ));

    $template->show('adm/PassEncripterPage.tpl');
}
