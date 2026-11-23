<?php

namespace Vendor\Settings;

use PHPMailer\PHPMailer\Exception as PHPMailerException;
use PHPMailer\PHPMailer\PHPMailer;
use RuntimeException;

class GmailMailer
{
  private string $gmailAddress;
  private string $appPassword;
  private string $fromName;

  public function __construct()
  {
    $gmailAddress = trim((string)getenv("NEWSLETTER_GMAIL_ADDRESS"));
    $appPassword = preg_replace('/\s+/', '', (string)getenv("NEWSLETTER_GMAIL_APP_PASSWORD"));

    if (!filter_var($gmailAddress, FILTER_VALIDATE_EMAIL) || $appPassword === "") {
      throw new RuntimeException(
        "Configure NEWSLETTER_GMAIL_ADDRESS and NEWSLETTER_GMAIL_APP_PASSWORD in the Apache environment."
      );
    }

    $this->gmailAddress = $gmailAddress;
    $this->appPassword = $appPassword;
    $this->fromName = trim((string)getenv("NEWSLETTER_FROM_NAME")) ?: "Trans Marques(8)";
  }

  public function send(string $recipient, string $subject, string $body, ?string $replyTo = null): void
  {
    $mailer = new PHPMailer(true);
    $mailer->isSMTP();
    $mailer->Host = "smtp.gmail.com";
    $mailer->SMTPAuth = true;
    $mailer->Username = $this->gmailAddress;
    $mailer->Password = $this->appPassword;
    $mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mailer->Port = 587;
    $mailer->Timeout = 30;
    $mailer->CharSet = PHPMailer::CHARSET_UTF8;
    $mailer->setFrom($this->gmailAddress, $this->fromName);
    $mailer->addAddress($recipient);
    if ($replyTo !== null) {
      $mailer->addReplyTo($replyTo);
    }
    $mailer->Subject = $subject;
    $mailer->Body = $body;
    $mailer->isHTML(false);
    $mailer->send();
  }
}
