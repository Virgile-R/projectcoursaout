<?php

use App\Entity\Order;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OrderTest extends KernelTestCase {
  public function testOrderCreation() {
    $user = new User();
    $user->setLastName('TestLastName');
    $user->setFirstName('TestFirstName');
    $user->setEmail('test@test.com');
    $user->setPassword('Abcde123!');
    
    $order = new Order();
    $order->setNumber(3);
    $order->setTotalPrice(1200);
    $order->setUserId($user);

    $this->assertEquals(3, $order->getNumber());
    $this->assertEquals(1200, $order->getTotalPrice());
    $this->assertEquals('test@test.com', $order->getUserId()->getEmail());
    
  }
}