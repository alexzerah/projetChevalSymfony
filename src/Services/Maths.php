<?php
/**
 * Created by PhpStorm.
 * User: luisramos
 * Date: 01/03/2018
 * Time: 16:17
 */

namespace App\Services;


class Maths extends Calculator
{

    public function calc($a, $b)
    {
        return $calc = $this->add($a, $b);
    }
}