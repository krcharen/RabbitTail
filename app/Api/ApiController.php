<?php

namespace App\Api;

use App\Functions\Core;
use App\Functions\Database;
use App\Functions\Helper;

class ApiController
{
    /**
     * @var string
     */
    private string $fuc_prefix = 'api';

    /**
     * @var string
     */
    private string $host;

    /**
     * @var array
     */
    private array $parameters;

    /**
     * ApiController constructor.
     */
    public function __construct()
    {
        $this->host = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
    }

    /**
     * @param string $api
     * @param array $parameter
     * @return mixed
     */
    public function call(string $api, array $parameter = [])
    {
        $this->parameters = $parameter;

        $func = $this->apiSupported($api);

        return $this->$func();
    }

    /**
     * @return array
     */
    private function apiShorter()
    {
        $url = $this->parameters['url'] ?? '';

        if (empty($url)) {
            return ['staus' => 405, 'message' => 'Parameter Error[1].'];
        }
        $helper = new Helper();
        $db = new Database();
        $exists = $db->rawSelect("SELECT `short_code` FROM `tail_links` WHERE `url` = '{$url}' AND `deleted_at` IS NULL ORDER BY `id` DESC;");

        if (!empty($exists)) {
            $short_code = current($exists)['short_code'];
            $short_url = $this->host . '/' . $short_code;
            return ['staus' => 200, 'message' => 'success', 'data' => ['url' => $short_url]];
        }

        $next_id = $db->rawSelect("SELECT `value` FROM `tail_options` WHERE `item` = 'next_id';")[0]['value'];

        $core = new Core();
        $short_code = $core->hexTo($next_id);
        $ip = $helper::client_ip();
        $insert = $update = 0;

        if ($short_code) {
            $i_sql = "INSERT INTO `tail_links` VALUES (NULL,'{$url}','$short_code','$ip',1,NOW(),NOW(),NULL);";
            $insert = $db->rawInsert($i_sql);
            if ($insert) {
                $u_sql = "UPDATE `tail_options` SET `value` = `value`+1 WHERE item = 'next_id'";
                $update = $db->rawUpdate($u_sql);
            }
        }

        $short_url = $insert && $update ? $this->host . '/' . $short_code : $this->host;

        return ['staus' => 200, 'message' => 'success', 'data' => ['url' => $short_url]];
    }

    /**
     * @param string $api
     * @return array|string
     */
    private function apiSupported(string $api)
    {
        $supported = ['shorter'];

        if (!in_array($api, $supported)) {
            return ['staus' => 405, 'message' => 'Invalid API.'];
        }

        return $this->fuc_prefix . ucfirst($api);
    }
}