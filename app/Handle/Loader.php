<?php

namespace App\Handle;

use App\Functions\Database;

class Loader extends Database
{

    public function load(string $uri)
    {
        $prase_uri = explode('/', trim($uri, '/'));

        if (strlen($prase_uri[0]) > 7 || count($prase_uri) > 1 || strpos($prase_uri[0], '.') !== false) {
            Header("Location:/");
        }

        if (strlen($prase_uri[0]) === 7) {
            $short_code = trim($prase_uri[0]);
            $url_sql = "SELECT `url` FROM `tail_links` WHERE `short_code` = '{$short_code}' AND `deleted_at` IS NULL;";
            $select = $this->rawSelect($url_sql);
            $url = current($select)['url'];
            $redirect_to = $url ?: '/';

            Header("Location: $redirect_to");
        }
    }
}