<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class OperationsTest extends TestCase
{
    public function mult(float $a,float $b): float{
        return $a*$b;
    }

    public function testMultOperation(): void
    {
        $acutal = $this->mult(4,3);
        $expected = 12;

        $this->assertEquals($expected,$acutal);
    }
}
