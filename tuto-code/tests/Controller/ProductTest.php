<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductTest extends WebTestCase
{

    private string $pathRoute = "/product/" ;
    private KernelBrowser $client;

    public function setUp():void{
        //$kernel = self::bootKernel();
        $this->client = static::createClient();
    }


    public function testListeProduits(): void
    {
        $crawler = $this->client->request('GET', $this->pathRoute);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Liste de produits');
    }


    public function testAjoutProduit():void{

        $this->client->request("GET",$this->pathRoute."new");
        $this->assertResponseStatusCodeSame(200);
        $this->client->submitForm("Save",[
            "product[name]"=> "Nokia 3310",
            "product[description]"=>"ablbalablaba",
            "product[price]"=>1200
        ]);
        
        $this->assertResponseRedirects($this->pathRoute);
        $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.alert-success', 'Produit bien ajouté');

    }

}
