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
}