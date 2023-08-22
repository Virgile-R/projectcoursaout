<?php

namespace App\Service;

class CalculateTax {
  public function getTotalHT($products) {
    $totalPrice = 0;
    foreach ($products as $product) {
      $totalPrice += $product->getPrice();
    }
    return $totalPrice;
  }

  public function getTotalTTC($products, $tva) {
    $totalPrice = 0;
    foreach ($products as $product) {
      $totalPrice += ($product->getPrice() + $product->getPrice() * $tva);
    }
    return $totalPrice; 
  }
}