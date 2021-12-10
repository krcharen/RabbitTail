<?php

namespace App\Functions;

class Core
{
    /**
     * decimal to 62 base
     *
     * @param $hex10
     * @return string
     */
    public function hexTo($hex10)
    {
        $number = strval($hex10);
        $map = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $base62 = '';

        do {
            $base62 = $map[bcmod($number, 62) ?? 0] . $base62;
            $number = bcdiv($number, 62);
        } while ($number > 0);

        return $base62;
    }

    /**
     * 62 base to decimal
     *
     * @param $base62
     * @return int|string
     */
    public function toHex($base62)
    {
        $number = strval($base62);
        $map = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $length = strlen($number);
        $decimal = 0;

        for ($i = 0; $i < $length; $i++) {
            $position = strpos($map, $number[$i]);
            $decimal = bcadd(bcmul(bcpow(62, $length - $i - 1), $position), $decimal);
        }

        return $decimal;
    }

    /**
     * @return string
     */
    public function token()
    {
        $hash_str = '';

        for ($i = 0; $i < mt_rand(1000, 2000); ++$i) {
            $hash_str .= md5(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ+/') . microtime(true));
        }

        if (strlen($hash_str) > 1024) {
            $hash = md5(substr($hash_str, 0, 1023));
        } else {
            $this->token();
        }

        return $hash;
    }
}