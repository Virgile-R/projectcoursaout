<?php

use App\Service\CalculateTax;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CalculateTaxTest extends KernelTestCase {
  public function testCalculateTaxService() {
    $product1 = new Product();
    $product1->setName('TV Samsung 40"');
    $product1->setPrice(400);
    
    $product2 = new Product();
    $product2->setName('Samsung Galaxy 9');
    $product2->setPrice(900);
    
    $product3 = new Product();
    $product3->setName('Apple Iphone 9');
    $product3->setPrice(1200);
    
    $productArray = [$product1, $product2, $product3];
    $tva = 0.15;


    $calculateTax = new CalculateTax();

    $this->assertEquals(2500, $calculateTax->getTotalHT($productArray));
    $this->assertEquals(2875, $calculateTax->getTotalTTC($productArray, $tva));

  }
}

