<?php

namespace App\Handle;

use App\Exceptions\Exception;
use App\Functions\Database;
use App\Functions\Password;

class Rabbit
{
    /**
     * @param array $admin
     * @throws Exception
     */
    public function init_admin(array $admin = [])
    {
        if (empty($admin)) {
            throw new Exception('[Error] The administrator data is not initialized.');
        }

        $date = date('Y-m-d H:i:s');
        $pwd = new Password(8, false);
        $password = $pwd->hash_password($admin['password']);

        $sql = 'INSERT INTO `tail_users` (`username`,`email`,`password`,`created_at`,`updated_at`) VALUES (?,?,?,?,?);';
        $param = [$admin['username'], $admin['email'], $password, $date, $date];

        $db = new Database();
        $result = $db->preExecute($sql, $param);

        if (!$result) {
            exit('[Error] Administrator creation failed.');
        }

        printf("The administrator created successfully:\nAccount: %s\nPassword: %s\n", $admin['username'], $admin['password']);
    }
}