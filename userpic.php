<?php

define('INSIDE', true);
define('LOGIN', false);
define('IN_CRON', true);

define('ROOT_PATH', './');

if (!extension_loaded('gd')) {
    redirectTo('index.php?action=keepalive');
}

require ROOT_PATH . 'includes/common.php';
error_reporting(E_ALL);
$id = request_var('id', 0);

if (CheckModule(37) || $id == 0) {
    exit();
}

$LANG->GetLangFromBrowser();
$LANG->includeLang(array('BANNER'));

require_once ROOT_PATH . "includes/classes/class.StatBanner.php";

if (!isset($_GET['debug'])) {
    header("Content-type: image/png");
}

$banner = new StatBanner();
$Data    = $banner->GetData($id);
if (!isset($Data) || !is_array($Data)) {
    exit;
}

$ETag    = md5(implode('', $Data));
header('ETag: ' . $ETag);
if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] == $ETag) {
    header('HTTP/1.0 304 Not Modified');
    exit;
}
if (in_array($LANG->getUser(), array('ru'))) { //Find a Way to fix Chinese now.
    $banner->CreateUTF8Banner($Data);
} else {
    $banner->CreateBanner($Data);
}
