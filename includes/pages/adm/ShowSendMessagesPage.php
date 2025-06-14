<?php

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) {
    exit;
}

function ShowSendMessagesPage()
{
    global $USER, $LNG, $db;

    if ($_GET['mode'] == 'send') {
        switch ($USER['authlevel']) {
            case AUTH_MOD:
                $color = 'yellow';
                break;
            case AUTH_OPS:
                $color = 'skyblue';
                break;
            case AUTH_ADM:
                $color = 'red';
                break;
        }

        $Subject    = request_var('subject', '', true);
        $Message    = makebr(request_var('text', '', true));

        if (!empty($Message) && !empty($Subject)) {
            require_once(ROOT_PATH . 'includes/functions/BBCode.php');
            $Time       = TIMESTAMP;
            $From       = '<span style="color:' . $color . ';">' . $LNG['user_level'][$USER['authlevel']] . ' ' . $USER['username'] . '</span>';
            $Subject    = '<span style="color:' . $color . ';">' . $Subject . '</span>';
            $Message    = '<span style="color:' . $color . ';font-weight:bold;">' . bbcode($Message) . '</span>';

            SendSimpleMessage(0, $USER['id'], TIMESTAMP, 50, $From, $Subject, $Message, 0, $_SESSION['adminuni']);
            $db->query("UPDATE " . USERS . " SET `new_gmessage` = `new_gmessage` + '1', `new_message` = `new_message` + '1' WHERE `universe` = '" . $_SESSION['adminuni'] . "';");
            exit($LNG['ma_message_sended']);
        } else {
            exit($LNG['ma_subject_needed']);
        }
    }

    $template   = new template();

    $template->assign_vars(array(
        'mg_empty_text'             => $LNG['mg_empty_text'],
        'ma_subject'                => $LNG['ma_subject'],
        'ma_none'                   => $LNG['ma_none'],
        'ma_message'                => $LNG['ma_message'],
        'ma_send_global_message'    => $LNG['ma_send_global_message'],
        'ma_characters'             => $LNG['ma_characters'],
        'button_submit'             => $LNG['button_submit'],
    ));

    $template->show('adm/SendMessagesPage.tpl');
}
