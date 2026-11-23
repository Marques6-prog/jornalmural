<?php

namespace Vendor\Repositories;

use Vendor\Sql\Sql;

class ContactRepository
{
  private Sql $sql;

  public function __construct()
  {
    $this->sql = new Sql();
    $this->sql->query(
      "CREATE TABLE IF NOT EXISTS contact_message (
        id INT NOT NULL AUTO_INCREMENT,
        full_name VARCHAR(120) NOT NULL,
        email VARCHAR(120) NOT NULL,
        subject VARCHAR(180) NOT NULL,
        message TEXT NOT NULL,
        email_sent TINYINT NOT NULL DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
      ) ENGINE=InnoDB"
    );
  }

  public function create(array $message): bool
  {
    return $this->sql->query(
      "INSERT INTO contact_message (full_name, email, subject, message, email_sent)
       VALUES (:full_name, :email, :subject, :message, :email_sent)",
      [
        ":full_name" => $message["full_name"],
        ":email" => $message["email"],
        ":subject" => $message["subject"],
        ":message" => $message["message"],
        ":email_sent" => $message["email_sent"]
      ]
    );
  }

  public function getAll(): array
  {
    return $this->sql->select("SELECT * FROM contact_message ORDER BY created_at DESC");
  }

  public function delete(int $id): bool
  {
    return $this->sql->query(
      "DELETE FROM contact_message WHERE id = :id",
      [":id" => $id]
    );
  }

  public function deleteAll(): bool
  {
    return $this->sql->query("DELETE FROM contact_message");
  }
}
