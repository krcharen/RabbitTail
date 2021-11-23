<?php

namespace App\Functions;

class Helper
{
    const VERSION = '0.0.3';

    /**
     * @param string $type
     * @return string|null
     */
    public static function version(string $type = 'app')
    {
        if ($type === 'app') {
            $version = self::VERSION;
        } else if ($type === 'mysql') {
            return (new Database())->version();
        }

        return $version ?? null;
    }

    /**
     * Text output.
     */
    public static function create_text_output()
    {
        $date = date('Y-m-d H:i:s');
        printf("[%s] ✔ Created Successfully.\n", $date);
    }

    /**
     * @param int $status_code
     * @param string $text
     * @param array $data
     * @return false|string
     */
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
     * Check the environment.
     */
    public static function check_environment()
    {
        if (!version_compare(PHP_VERSION, '7.4.0', '>=')) {
            exit('✘ PHP version is not supported.' . PHP_EOL);
        }

        if (file_exists(__DIR__ . '/../../install/install.lock')) {
            exit('✘ The program has already been installed. To reinstall, please delete the relevant files and execute it again.' . PHP_EOL);
        }

        if (floatval(self::version('mysql')) < 5.6) {
            exit('✘ MySQL version is too low.' . PHP_EOL);
        }
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