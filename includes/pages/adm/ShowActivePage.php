<?php

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) {
    exit;
}

function ShowActivePage()
{
    global $LNG, $db, $USER;
    $id = request_var('id', 0);
    if ($_GET['action'] == 'delete' && !empty($id)) {
        $db->query("DELETE FROM " . USERS_VALID . " WHERE `id` = '" . $id . "';");
    }

    $query = $db->query("SELECT * FROM " . USERS_VALID . " ORDER BY id ASC");

    $Users  = array();
    while ($User = $db->fetch_array($query)) {
        $Users[]    = array(
            'id'        => $User['id'],
            'name'      => $User['username'],
            'date'      => date(TDFORMAT, $User['date']),
            'email'     => $User['email'],
            'ip'        => $User['ip'],
            'password'  => $User['password'],
            'cle'       => $User['cle']
        );
    }

    $template   = new template();
    $template->assign_vars(array(
        'Users'             => $Users,
        'UserLang'          => $USER['lang'],
        'id'                => $LNG['ap_id'],
        'username'          => $LNG['ap_username'],
        'datum'             => $LNG['ap_datum'],
        'email'             => $LNG['ap_email'],
        'ip'                => $LNG['ap_ip'],
        'aktivieren'        => $LNG['ap_aktivieren'],
        'del'               => $LNG['ap_del'],
        'sicher'            => $LNG['ap_sicher'],
        'entfernen'         => $LNG['ap_entfernen'],
        'insgesamt'         => $LNG['ap_insgesamt'],
        'nicht_aktivierte'  => $LNG['ap_nicht_aktivierte'],
        'nicht_aktivierte_u' => $LNG['ap_nicht_aktivierte_user'],
    ));

    $template->show('adm/ActivePage.tpl');
}
