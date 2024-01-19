<?php

namespace App\Tests\Entity;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductTest extends KernelTestCase
{
    public function testValidationProduit(): void
    {
        $kernel = self::bootKernel();
        $container = static::getContainer();
        $validator = $container->get("validator");

        $produit = (new Product())
                        ->setName("N231321321")                        
                        ->setPrice(30);
        $erros = $validator->validate($produit);

        $expected = 0;
        
        $this->assertCount($expected,$erros);

        //$this->assertSame('test', $kernel->getEnvironment());
        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);
    }
}
