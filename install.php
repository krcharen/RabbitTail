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
$total = count($db_data_file);

echo PHP_EOL . 'Start to install:' . PHP_EOL . PHP_EOL;

foreach ($db_data_file as $key => $sql) {
    if ($sql_string = trim(str_replace(["\r", "\n", "\t"], '', $sql))) {
        $sql = str_replace('{@}', $prefix, $sql_string);
        $db->rawCreate($sql);
        echo $helper::cli_progress_bar(round((($key + 1) / $total) * 100, 2), 100);
    }
}

$done = file_put_contents('./install/install.lock', '[' . date('Y-m-d H:i:s') . '] Created At.');

if ($done) {
    echo PHP_EOL . PHP_EOL;
    $location = $helper::app_config('app_url');
    $admin = new \App\Handle\Rabbit();
    $admin->init_admin($helper::app_config('admin'));
    printf("\nWelcome to the Rabbit Tail Short URL platform.\nHome  Page: $location \nAdmin Page: $location/admin\n\n");
} else {
    printf("\nSystem installation failed.No permission to create files.\n\n");
}