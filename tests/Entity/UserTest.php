<?php

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase {
  public function testUserCreation() {
    $user = new User();
    $user->setLastName('TestLastName');
    $user->setFirstName('TestFirstName');
    $user->setEmail('test@test.com');
    $user->setPassword('Abcde123!');

    $this->assertEquals('TestLastName', $user->getLastName(), "user last name does not match");
    $this->assertEquals('TestFirstName', $user->getFirstName(), "user first name does not match");
    $this->assertEquals('test@test.com', $user->getEmail(), "user email does not match");
    $this->assertTrue(in_array('ROLE_USER', $user->getRoles()), "user doesn't have a role");
    $this->assertNotNull($user->getPassword(), "user has password");
    $this->assertTrue(password_verify('Abcde123!', $user->getPassword()), "user password doesn't match hash");
    $this->assertEquals('test@test.com', $user->getUserIdentifier(), "user identifier isn't an email");
  }
}