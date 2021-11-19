<?php

require_once __DIR__ . '/vendor/autoload.php';

$url = trim($_POST['url']);
$server = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];

$helper = new \App\Functions\Helper();

$db = new \App\Functions\Database();

//Check if the URL link exists.
$exists = $db->rawSelect("SELECT `short_code` FROM `tail_link` WHERE `url` = '{$url}' AND `deleted_at` IS NULL ORDER BY `id` DESC;");

if (!empty($exists)) {
    $short_code = current($exists)['short_code'];
    $short_url = $server . '/' . $short_code;

    echo $helper::response(200, 'success', ['url' => $short_url]);

    return true;
}

//Generate a new identification code.
$next_id = $db->rawSelect("SELECT `value` FROM `tail_options` WHERE `item` = 'next_id';")[0]['value'];

$core = new \App\Functions\Core();
$short_code = $core->hexTo($next_id);

$ip = $helper::client_ip();

$insert = $update = 0;

if ($short_code) {
    $i_sql = "INSERT INTO `tail_link` VALUES (NULL,'{$url}','$short_code','$ip',1,NOW(),NOW(),NULL);";
    $insert = $db->rawInsert($i_sql);
    if ($insert) {
        $u_sql = "UPDATE `tail_options` SET `value` = `value`+1 WHERE item = 'next_id'";
        $update = $db->rawUpdate($u_sql);
    }
}

$short_url = $insert && $update ? $server . '/' . $short_code : $server;

echo $helper::response(200, 'success', ['url' => $short_url]);