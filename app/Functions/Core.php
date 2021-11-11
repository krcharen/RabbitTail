<?php

namespace App\Functions;

class Core
{
    /**
     * 10进制转换成62进制
     *
     * @param $hex10
     * @return string
     */
    protected function hexTo($hex10)
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
     * 62进制10进制
     *
     * @param $base62
     * @return int|string
     */
    protected function toHex($base62)
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
}