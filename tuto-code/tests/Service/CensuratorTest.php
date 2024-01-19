<?php

namespace App\Tests\Service;

use App\Service\Censurator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CensuratorTest extends KernelTestCase
{
    public function testPurify(): void
    {
        $kernel = self::bootKernel();
        $container = static::getContainer();
        /**
         * @var Censurator
         */
        $censuratorService = $container->get(Censurator::class);  
        $input = "contraire";
        $actual = $censuratorService->purify($input);    
        $excpected = "contraire";

        $this->assertEquals($excpected,$actual) ;   
        //$this->assertSame('test', $kernel->getEnvironment());
        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);
    }
}
