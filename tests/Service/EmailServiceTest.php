<?php

use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class EmailServiceTest extends KernelTestCase {
  public function testSendEmail() {
    $emailService = new EmailService();
    $this->assertIsBool($emailService->send("dummy"));
  }
}