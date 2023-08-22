<?php

namespace App\Service;

class EmailService {
  public function send($msg) {
    return rand(0, 100) >= 50;
  }
}