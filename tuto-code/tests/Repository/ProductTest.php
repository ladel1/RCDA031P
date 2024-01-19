<?php

namespace App\Tests\Repository;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductTest extends KernelTestCase
{

    private EntityManagerInterface $em;
    private EntityRepository $repository;

    public function setUp():void{
        // inject EntityManagerInterface & ProductRepository
        $this->em = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->em->getRepository(Product::class);
        // reset la bdd
        foreach($this->repository->findAll() as $product){
            $this->em->remove($product);
        }

        $this->em->flush();

    }

    public function testFindOneByName(): void
    {
        $kernel = self::bootKernel();

        /**
         * @var Product
         */
        $product = (new Product())
                        ->setName("Samsung s7")
                        ->setDescription("balbalablalab")
                        ->setPrice(150);
        
        $this->em->persist($product);
        $this->em->flush();

        $input = "Samsung s7";
        $expectedName = "Samsung s7";
        $expectedDescription = "balbalablalab";
        $expectedPrice = floatval(150);
        /**
         * @var Product
         */
        $actualProduct = $this->repository->findOneByName($input);

        $this->assertNotNull($actualProduct);

        $this->assertEquals($expectedName,$actualProduct->getName());
        $this->assertEquals($expectedDescription,$actualProduct->getDescription());
        $this->assertEquals($expectedPrice,$actualProduct->getPrice());

        //$this->assertSame('test', $kernel->getEnvironment());
        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);
    }
}
