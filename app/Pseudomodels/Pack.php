<?php

namespace App\Pseudomodels;
class Pack
{
    public $packSize;
    public $count;
    public function __construct(int $packSize, int $count = 0)
    {
        $this->packSize = $packSize;
        $this->count = $count;
    }
}
