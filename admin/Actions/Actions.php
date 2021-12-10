<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$action = trim($_GET['action'] ?? '');

switch ($action) {
    case 'token':
        $from = $_POST['start_date'] ?? NULL;
        $to = $_POST['end_date'] ?? NULL;

        $login = new \Admin\Controllers\Login();
        $result = $login->generate($from, $to);

        if ($result) {
            exit(json_encode(['staus' => 200, 'message' => 'success']));
        } else {
            exit(json_encode(['staus' => 400, 'message' => 'failure']));
        }

        break;

    case 'reload.json':
        $login = new \Admin\Controllers\Login();
        $result = $login->reload();

        exit(json_encode([$result]));

        break;
}