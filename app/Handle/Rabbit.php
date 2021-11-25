<?php

namespace App\Handle;

use App\Exceptions\Exception;

class Rabbit
{
    /**
     * @param array $admin
     * @throws Exception
     */
    public function init_admin(array $admin = [])
    {
        if (empty($admin)) {
            throw new Exception('The administrator data is not initialized.');
        }
    }
}