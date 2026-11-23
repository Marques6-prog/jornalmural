<?php

namespace Vendor\Repositories;

use Vendor\Sql\Sql;

class NewsletterRepository
{
  private Sql $sql;

  public function __construct()
  {
    $this->sql = new Sql();
    $this->sql->query(
      "CREATE TABLE IF NOT EXISTS newsletter_subscriber (
        id INT NOT NULL AUTO_INCREMENT,
        email VARCHAR(254) NOT NULL,
        unsubscribe_token CHAR(64) NOT NULL,
        active TINYINT NOT NULL DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY unique_newsletter_email (email),
        UNIQUE KEY unique_unsubscribe_token (unsubscribe_token)
      ) ENGINE=InnoDB"
    );
  }

  public function subscribe(string $email): bool
  {
    return $this->sql->query(
      "INSERT INTO newsletter_subscriber (email, unsubscribe_token, active)
       VALUES (:email, :unsubscribe_token, 1)
       ON DUPLICATE KEY UPDATE active = 1",
      [
        ":email" => $email,
        ":unsubscribe_token" => bin2hex(random_bytes(32))
      ]
    );
  }

  public function getActiveSubscribers(): array
  {
    return $this->sql->select(
      "SELECT email, unsubscribe_token
       FROM newsletter_subscriber
       WHERE active = 1
       ORDER BY id"
    );
  }

  public function countActive(): int
  {
    $result = $this->sql->select(
      "SELECT COUNT(*) AS total FROM newsletter_subscriber WHERE active = 1"
    );

    return (int)$result[0]["total"];
  }

  public function unsubscribe(string $token): bool
  {
    return $this->sql->query(
      "UPDATE newsletter_subscriber SET active = 0
       WHERE unsubscribe_token = :token AND active = 1",
      [":token" => $token]
    );
  }
}
