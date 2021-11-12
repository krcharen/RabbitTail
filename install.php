<?php

require_once __DIR__ . '/vendor/autoload.php';

if (!version_compare(PHP_VERSION, '7.4.0', '>=')) {
    exit('PHP版本不支持');
}

if (PHP_SAPI !== 'cli') {
    Header("Location:/");
}

if (file_exists('./install/install.lock')) {
    exit('已执行过安装, 要重新安装请删除相关文件后再执行');
}

$helper = new \App\Functions\Helper();

if (floatval($helper::version('mysql')) < 5.6) {
    exit('MySQL版本太低');
}

$db = new \App\Functions\Database();
$db_table_data = explode(";\r", file_get_contents('./install/db/mysql.sql'));

foreach ($db_table_data as $key => $sql) {
    if ($sql_string = trim(str_replace(["\r", "\n", "\t"], '', $sql))) {
        $db->rawCreate($sql_string);
        $helper::create_text_output($key + 1);
    }
}

file_put_contents('./install/install.lock', '[' . date('Y-m-d H:i:s') . '] Created At.');