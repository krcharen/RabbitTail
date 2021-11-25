<?php

namespace App\Functions;

use App\Exceptions\Exception;

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
     * @param string $key
     * @return mixed|string
     */
    public static function app_config(string $key = '')
    {
        $app_config = require __DIR__ . '/../../config/app.php';

        return $app_config[$key] ?? '';
    }

    /**
     * @param string $database
     * @param string $key
     * @return mixed
     * @throws Exception
     */
    public static function db_config(string $database = 'mysql', string $key = '')
    {
        $db_config = require __DIR__ . '/../../config/database.php';

        if (empty($key)) {
            throw new Exception('Undefined the key.');
        }

        return $db_config[$database][$key] ?? '';
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

    /**
     * @param $code
     * @return string
     */
    public static function get_http_status($code)
    {
        $code = intval($code);
        $headers_desc = [
            100 => 'Continue',
            101 => 'Switching Protocols',
            102 => 'Processing',

            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            207 => 'Multi-Status',
            226 => 'IM Used',

            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => 'Reserved',
            307 => 'Temporary Redirect',

            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            422 => 'Unprocessable Entity',
            423 => 'Locked',
            424 => 'Failed Dependency',
            426 => 'Upgrade Required',

            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            506 => 'Variant Also Negotiates',
            507 => 'Insufficient Storage',
            510 => 'Not Extended'
        ];

        return isset($headers_desc[$code]) ? $headers_desc[$code] : '';
    }
}