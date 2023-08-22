<?php

use App\Service\CalculateTax;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CalculateTaxTest extends KernelTestCase {

  public function generateProductArray() {
    $product1 = new Product();
    $product1->setName('TV Samsung 40"');
    $product1->setPrice(400);
    
    $product2 = new Product();
    $product2->setName('Samsung Galaxy 9');
    $product2->setPrice(900);
    
    $product3 = new Product();
    $product3->setName('Apple Iphone 9');
    $product3->setPrice(1200);
    
    $productArray = [
      ["product"=>$product1, "quantity"=>2], 
      ["product"=>$product2, "quantity"=>1], 
      ["product"=>$product3, "quantity"=>3]
    ];
    $tva = 0.15;


    $calculateTax = new CalculateTax();
    return ["productArray" => [$productArray, $calculateTax, $tva]];
  }
  /**
   * @dataProvider generateProductArray
   */
  public function testCalculateTaxServiceHT($productArray,  $calculateTax, $tva) {

    $this->assertEquals(5300, $calculateTax->getTotalHT($productArray));

  }

  /**
   * @dataProvider generateProductArray
   */
  public function testCalculateTaxServiceTTC($productArray,  $calculateTax, $tva) {
    
    $this->assertEquals(6095, $calculateTax->getTotalTTC($productArray, $tva));

  }
}

