<?php

namespace App\Handle;

use App\Functions\Database;
use App\Functions\Helper;

class Loader extends Database
{

    public function load(string $uri)
    {
        $prase_uri = explode('/', trim($uri, '/'));

        if (strlen($prase_uri[0]) > 8 || count($prase_uri) > 1 || strpos($prase_uri[0], '.') !== false) {
            Header("Location:/");
        }

        if (strlen($prase_uri[0]) === 8) {
            $short_code = trim($prase_uri[0]);
            $url = $this->url($short_code);
            $redirect_to = $url ?: '/';

            if (!headers_sent()) {
                $protocol = $_SERVER['SERVER_PROTOCOL'];

                if ('HTTP/1.1' != $protocol && 'HTTP/1.0' != $protocol) {
                    $protocol = 'HTTP/1.0';
                }

                $status_desc = (new Helper())::get_http_status(302);

                Header("$protocol 302 $status_desc");
                Header("Location: $redirect_to");
            }

            if (PHP_SAPI !== 'cli') {
                $this->redirect_by_javascript($redirect_to);
            }
        }
    }

    /**
     * @param string $code
     * @return mixed
     */
    private function url(string $code = '')
    {
        $sql = "SELECT `url` FROM `tail_links` WHERE BINARY `short_code` = '{$code}' AND `deleted_at` IS NULL;";
        $select = $this->rawSelect($sql);

        return current($select)['url'];
    }

    /**
     * @param string $redirect_to
     */
    private function redirect_by_javascript(string $redirect_to)
    {
        echo "<script type='text/javascript'>window.location='{$redirect_to}'</script>";
    }
}