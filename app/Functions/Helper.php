<?php

namespace App\Functions;

class Helper
{
    const VERSION = '0.0.1';

    /**
     * @param string $type
     * @return string|null
     */
    public static function version(string $type = 'app')
    {
        if ($type === 'app') {
            $version = self::VERSION;
        } else if ($type === 'mysql') {
            $pdo = new Connect();
            return $pdo->db->getAttribute(\PDO::ATTR_SERVER_VERSION);
        }

        return $version ?? null;
    }

    /**
     * @param int $number
     */
    public static function create_text_output(int $number)
    {
        $date = date('Y-m-d H:i:s');
        printf("[%s] 数据 %d 创建成功\n", $date, $number);
    }

    public static function response(int $status_code = 200, string $text = 'success', array $data = [])
    {
        $result = [
            'status_code' => $status_code,
            'text' => $text,
            'data' => $data,
        ];

        return json_encode($result);
    }

    /**
     * @return mixed|string
     */
    public static function client_ip()
    {
        if (@$_SERVER['HTTP_CLIENT_IP'] && strcasecmp($_SERVER['HTTP_CLIENT_IP'], 'unknown')) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            if (@$_SERVER['HTTP_X_FORWARDED_FOR'] && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], 'unknown')) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                if ($_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
                    $ip = $_SERVER['REMOTE_ADDR'];
                } else {
                    if (isset ($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
                        $ip = $_SERVER['REMOTE_ADDR'];
                    } else {
                        $ip = '0.0.0.0';
                    }
                }
            }
        }

        return $ip;
    }
}