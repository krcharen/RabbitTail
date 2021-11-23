<?php

require_once __DIR__ . '/vendor/autoload.php';

if (PHP_SAPI !== 'cli') {
    Header("Location:/");
}

$helper = new \App\Functions\Helper();
$helper::check_environment();

$db = new \App\Functions\Database();
$prefix = $db->readConfig('prefix');

$db_data_file = explode(";\r", file_get_contents('./install/db/mysql.sql'));

foreach ($db_data_file as $key => $sql) {
    if ($sql_string = trim(str_replace(["\r", "\n", "\t"], '', $sql))) {
        $sql = str_replace('{@}', $prefix, $sql_string);
        $db->rawCreate($sql);
        $helper::create_text_output();
    }
}

file_put_contents('./install/install.lock', '[' . date('Y-m-d H:i:s') . '] Created At.');