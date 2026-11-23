<?php

namespace Vendor\Repositories;

use Vendor\Sql\Sql;

class VisitRepository
{
  private Sql $sql;

  public function __construct()
  {
    $this->sql = new Sql();
    $this->sql->query(
      "CREATE TABLE IF NOT EXISTS site_visit (
        id INT NOT NULL AUTO_INCREMENT,
        visitor_key VARCHAR(64) NOT NULL,
        visited_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY unique_visitor (visitor_key)
      ) ENGINE=InnoDB"
    );
  }

  public function record(string $visitorKey): void
  {
    $this->sql->query(
      "INSERT IGNORE INTO site_visit (visitor_key) VALUES (:visitor_key)",
      [":visitor_key" => $visitorKey]
    );
  }

  public function countUnique(): int
  {
    $result = $this->sql->select("SELECT COUNT(*) AS total FROM site_visit");
    return (int)($result[0]["total"] ?? 0);
  }
}
