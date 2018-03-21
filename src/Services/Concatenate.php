<?php

namespace App\Services;


use Doctrine\Common\Collections\ArrayCollection;

class Concatenate
{
    public function doConcatenate($a, $b, $c)
    {
        // Concatenate arrays into a single array
        return new ArrayCollection(
            array_merge(
                $a,
                $b,
                $c
            )
        );
    }
}