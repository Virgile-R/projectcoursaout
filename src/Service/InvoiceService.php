<?php

namespace App\Service;

class InvoiceService {
  public function __construct(
    private EmailService $emailService,
) {
}

public function process($totalPriceTTC) {
  $msg = "Votre commande d’un montant de ". $totalPriceTTC . "€ est confirmée.";

  $sendEmailResult = $this->emailService->send($msg);

  return [
    'message' => $msg,
    'sendEmailResult' => $sendEmailResult,
  ];

}
}