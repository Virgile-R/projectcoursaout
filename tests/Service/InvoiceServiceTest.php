<?php

use App\Service\EmailService;
use App\Service\CalculateTax;
use App\Service\InvoiceService;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class InvoiceServiceTest extends KernelTestCase {
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
    $totalPriceTTC = $calculateTax->getTotalTTC($productArray, $tva);
    return ["productArray" => [$totalPriceTTC]];
  }
  /**
   * @dataProvider generateProductArray
   */
  public function testEditAndSendInvoice($totalPriceTTC) {
    $mockEmailService = $this->createMock(EmailService::class);
    $mockEmailService
      ->expects($this->once())
      ->method('send')
      ->willReturn(true);
    $invoiceService = new InvoiceService($mockEmailService);
    $processResult = $invoiceService->process($totalPriceTTC);
    $this->assertEquals('Votre commande d’un montant de 6095€ est confirmée.', $processResult['message']);
    $this->assertTrue($processResult['sendEmailResult']);

  }
}
