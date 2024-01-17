<?php 

namespace App\Service;

class Operations {

    public function add(float $a, float $b): float{
        return $a+$b;
    }
    public function mult(float $a, float $b): float{
        return $a*$b;
    }
    public function div(float $a, float $b): float{
        return $a/$b;
    }
    public function sub(float $a, float $b): float{
        return $a-$b;
    }
    public function mod(float $a, float $b): float{
        return $a % $b;
    }

}