<?php

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) {
    exit;
}

function ShowClearCachePage()
{
    global $LNG;
    ClearCache();
    $template = new template();
    $template->cache = true;
    $template->message($LNG['cc_cache_clear']);
}
