<?php

namespace App\Service;

class CalculateTax {
  public function getTotalHT($products) {
    $totalPrice = 0;
    foreach ($products as $product) {
      $totalPrice += $product["product"]->getPrice() * $product["quantity"];
    }
    return $totalPrice;
  }

  public function getTotalTTC($products, $tva) {
    $totalPrice = $this->getTotalHT($products);
    return $totalPrice + ($totalPrice * $tva); 
  }
}