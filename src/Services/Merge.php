<?php

namespace App\Services;

use Doctrine\Common\Collections\ArrayCollection;

class Merge
{
    public function mergeAction($a, $b, $c)
    {
        // Great.
        return new ArrayCollection(
            array_merge(
                $a,
                $b,
                $c
            )
        );
    }
}
