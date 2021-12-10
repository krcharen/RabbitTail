<?php

namespace Admin\Controllers;

use App\Functions\Core;
use App\Functions\Database;
use App\Functions\Password;

class Login
{

    /**
     * @var string
     */
    private string $username;

    /**
     * @var string
     */
    private string $password;

    /**
     * Login constructor.
     * @param string $username
     * @param string $password
     */
    public function __construct(string $username = '', string $password = '')
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return bool
     */
    public function handle()
    {
        $db = new Database();
        $sql = "SELECT `password` FROM `tail_users` WHERE `username` = '{$this->username}' AND `deleted_at` IS NULL";
        $users = $db->rawSelect($sql);
        $ueser_password = current($users)['password'] ?? '';
        $password = new Password(8, false);

        return $password->check_password($this->password, $ueser_password);
    }

    /**
     * @param string|null $from
     * @param string|null $to
     * @return mixed
     */
    public function generate(string $from = NULL, string $to = NULL)
    {
        $core = new Core();
        $user_id = 1;
        $token = $core->token();
        $created_at = $from ? date('Y-m-d H:i:s', strtotime($from)) : NULL;
        $valid_at = $to ? date('Y-m-d H:i:s', strtotime($to)) : NULL;

        $sql = 'INSERT INTO `tail_keys` (`user_id`,`token`,`created_at`,`valid_at`) VALUES (?,?,?,?);';
        $param = [$user_id, $token, $created_at, $valid_at];

        $db = new Database();
        $result = $db->preExecute($sql, $param);

        if (!$result) {
            exit('[Error] Token creation failed.');
        }

        return $result;
    }

    /**
     * @return array
     */
    public function reload()
    {
        $sql = 'SELECT * FROM `tail_keys`';
        $db = new Database();
        $result = $db->rawSelect($sql);
        $tokens = [];

        foreach ($result as $key => $value) {
            $tokens[$key]['id'] = $key+1;
            $tokens[$key]['token'] = $value['token'];
            $tokens[$key]['start_date'] = $value['created_at'];
            $tokens[$key]['end_date'] = $value['valid_at'];
            $tokens[$key]['is_deleted'] = boolval($value['deleted_at']) ? 1 : 0;
        }

        return $tokens;
    }
}