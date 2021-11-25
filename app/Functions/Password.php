<?php

namespace App\Functions;

class Password
{

    /**
     * @var string
     */
    public $itoa64;

    /**
     * @var int
     */
    public $iteration_count_log2;

    /**
     * @var
     */
    public $portable_hashes;

    /**
     * @var string
     */
    public $random_state;

    /**
     * @param $iteration_count_log2
     * @param $portable_hashes
     */
    public function __construct($iteration_count_log2, $portable_hashes)
    {
        $this->itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        if ($iteration_count_log2 < 4 || $iteration_count_log2 > 31) {
            $iteration_count_log2 = 8;
        }

        $this->iteration_count_log2 = $iteration_count_log2;

        $this->portable_hashes = $portable_hashes;

        $this->random_state = microtime();

        if (function_exists('getmypid')) {
            $this->random_state .= getmypid();
        }
    }

    /**
     * @param $iteration_count_log2
     * @param $portable_hashes
     */
    public function password_hash($iteration_count_log2, $portable_hashes)
    {
        self::__construct($iteration_count_log2, $portable_hashes);
    }

    /**
     * @param $password
     * @return string|null
     */
    public function hash_password($password)
    {
        $random = '';

        if (CRYPT_BLOWFISH === 1 && !$this->portable_hashes) {
            $random = $this->get_random_bytes(16);
            $hash = crypt($password, $this->generate_salt_blowfish($random));
            if (strlen($hash) === 60) {
                return $hash;
            }
        }

        if (strlen($random) < 6) {
            $random = $this->get_random_bytes(6);
        }
        $hash = $this->crypt_private($password, $this->generate_salt_private($random));
        if (strlen($hash) === 34) {
            return $hash;
        }

        return '*';
    }

    /**
     * @param $password
     * @param $stored_hash
     * @return bool
     */
    public function check_password($password, $stored_hash)
    {
        $hash = $this->crypt_private($password, $stored_hash);

        if ($hash[0] === '*') {
            $hash = crypt($password, $stored_hash);
        }

        return $hash === $stored_hash;
    }

    /**
     * @param $count
     * @return false|string
     */
    private function get_random_bytes($count)
    {
        $output = '';

        if (@is_readable('/dev/urandom') && ($fh = @fopen('/dev/urandom', 'rb'))) {
            $output = fread($fh, $count);
            fclose($fh);
        }

        if (strlen($output) < $count) {
            $output = '';
            for ($i = 0; $i < $count; $i += 16) {
                $this->random_state = md5(microtime() . $this->random_state);
                $output .= md5($this->random_state, true);
            }

            $output = substr($output, 0, $count);
        }

        return $output;
    }

    /**
     * @param $input
     * @return string
     */
    private function generate_salt_blowfish($input)
    {

        $itoa64 = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

        $output = '$2a$';
        $output .= chr(ord('0') + $this->iteration_count_log2 / 10);
        $output .= chr(ord('0') + $this->iteration_count_log2 % 10);
        $output .= '$';

        $i = 0;
        do {
            $c1 = ord($input[$i++]);
            $output .= $itoa64[$c1 >> 2];
            $c1 = ($c1 & 0x03) << 4;
            if ($i >= 16) {
                $output .= $itoa64[$c1];
                break;
            }

            $c2 = ord($input[$i++]);
            $c1 |= $c2 >> 4;
            $output .= $itoa64[$c1];
            $c1 = ($c2 & 0x0f) << 2;

            $c2 = ord($input[$i++]);
            $c1 |= $c2 >> 6;
            $output .= $itoa64[$c1];
            $output .= $itoa64[$c2 & 0x3f];
        } while (1);

        return $output;
    }

    /**
     * @param $input
     * @return string
     */
    private function generate_salt_private($input)
    {
        $output = '$P$';
        $output .= $this->itoa64[min($this->iteration_count_log2 + ((PHP_VERSION >= '5') ? 5 : 3), 30)];
        $output .= $this->encode64($input, 6);

        return $output;
    }

    /**
     * @param $input
     * @param $count
     * @return string
     */
    private function encode64($input, $count)
    {
        $output = '';
        $i = 0;
        do {
            $value = ord($input[$i++]);
            $output .= $this->itoa64[$value & 0x3f];
            if ($i < $count) $value |= ord($input[$i]) << 8;
            $output .= $this->itoa64[($value >> 6) & 0x3f];
            if ($i++ >= $count) break;
            if ($i < $count) $value |= ord($input[$i]) << 16;
            $output .= $this->itoa64[($value >> 12) & 0x3f];
            if ($i++ >= $count) break;
            $output .= $this->itoa64[($value >> 18) & 0x3f];
        } while ($i < $count);

        return $output;
    }

    /**
     * @param $password
     * @param $setting
     * @return string
     */
    private function crypt_private($password, $setting)
    {
        $output = '*0';

        if (substr($setting, 0, 2) === $output) {
            $output = '*1';
        }

        $id = substr($setting, 0, 3);

        if ($id !== '$P$' && $id !== '$H$') {
            return $output;
        }

        $count_log2 = strpos($this->itoa64, $setting[3]);

        if ($count_log2 < 7 || $count_log2 > 30) {
            return $output;
        }

        $count = 1 << $count_log2;

        $salt = substr($setting, 4, 8);

        if (strlen($salt) !== 8) {
            return $output;
        }

        $hash = md5($salt . $password, true);
        do {
            $hash = md5($hash . $password, true);
        } while (--$count);

        $output = substr($setting, 0, 12);
        $output .= $this->encode64($hash, 16);

        return $output;
    }
}