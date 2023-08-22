<?php

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductTest extends KernelTestCase {
  public function testCreateProduct() {
    $product = new Product();

    $product->setName('TV Samsung 40"');
    $product->setPrice(400);

    $this->assertEquals('TV Samsung 40"', $product->getName());
    $this->assertEquals(400, $product->getPrice());
  }
}