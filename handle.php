<?php

require_once __DIR__ . '/vendor/autoload.php';

$url = $_POST['url'];

$db = new \App\Functions\Database();
$next_id = $db->rawSelect("SELECT `value` FROM `tail_options` WHERE `item` = 'next_id';")[0]['value'];

$core = new \App\Functions\Core();
$short_code = $core->hexTo($next_id);

$insert = $update = 0;

if ($short_code) {
    $i_sql = "INSERT INTO `tail_link` VALUES (NULL,'{$url}','$short_code',1,NOW(),NOW(),NULL);";
    $insert = $db->rawInsert($i_sql);
    if ($insert) {
        $u_sql = "UPDATE `tail_options` SET `value` = `value`+1 WHERE item = 'next_id'";
        $update = $db->rawUpdate($u_sql);
    }
}

$server = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];

$short_url = $insert && $update ? $server . '/' . $short_code : $server;

$helper = new \App\Functions\Helper();

echo $helper::response(200, 'success', ['url' => $short_url]);