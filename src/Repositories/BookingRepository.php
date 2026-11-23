<?php

namespace Vendor\Repositories;

use Vendor\Sql\Sql;

class BookingRepository
{
  private Sql $sql;

  public function __construct()
  {
    $this->sql = new Sql();
    $this->sql->query(
      "CREATE TABLE IF NOT EXISTS booking (
        id INT NOT NULL AUTO_INCREMENT,
        origin VARCHAR(100) NOT NULL,
        destination VARCHAR(100) NOT NULL,
        vehicle VARCHAR(100) NOT NULL,
        seat_preference VARCHAR(100) NOT NULL,
        departure_date DATE NOT NULL,
        departure_time VARCHAR(20) NOT NULL,
        return_date DATE NULL,
        return_time VARCHAR(20) NULL,
        trip_type VARCHAR(30) NOT NULL,
        adults TINYINT NOT NULL DEFAULT 1,
        children TINYINT NOT NULL DEFAULT 0,
        full_name VARCHAR(120) NOT NULL,
        phone VARCHAR(50) NOT NULL,
        email VARCHAR(120) NOT NULL,
        payment_method VARCHAR(100) NOT NULL DEFAULT 'Dinheiro no embarque',
        message TEXT NULL,
        status VARCHAR(20) NOT NULL DEFAULT 'nova',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
      ) ENGINE=InnoDB"
    );

    $columns = $this->sql->select("SHOW COLUMNS FROM booking LIKE 'payment_method'");
    if (empty($columns)) {
      $this->sql->query("ALTER TABLE booking ADD COLUMN payment_method VARCHAR(100) NOT NULL DEFAULT 'Dinheiro no embarque' AFTER email");
    }
  }

  public function create(array $booking): bool
  {
    return $this->sql->query(
      "INSERT INTO booking
       (origin, destination, vehicle, seat_preference, departure_date, departure_time,
        return_date, return_time, trip_type, adults, children, full_name, phone, email, payment_method, message)
       VALUES
       (:origin, :destination, :vehicle, :seat_preference, :departure_date, :departure_time,
        :return_date, :return_time, :trip_type, :adults, :children, :full_name, :phone, :email, :payment_method, :message)",
      [
        ":origin" => $booking["origin"],
        ":destination" => $booking["destination"],
        ":vehicle" => $booking["vehicle"],
        ":seat_preference" => $booking["seat_preference"],
        ":departure_date" => $booking["departure_date"],
        ":departure_time" => $booking["departure_time"],
        ":return_date" => $booking["return_date"] ?: null,
        ":return_time" => $booking["return_time"] ?: null,
        ":trip_type" => $booking["trip_type"],
        ":adults" => $booking["adults"],
        ":children" => $booking["children"],
        ":full_name" => $booking["full_name"],
        ":phone" => $booking["phone"],
        ":email" => $booking["email"],
        ":payment_method" => $booking["payment_method"] ?? "Dinheiro no embarque",
        ":message" => $booking["message"]
      ]
    );
  }

  public function getAll(): array
  {
    return $this->sql->select("SELECT * FROM booking ORDER BY created_at DESC");
  }

  public function countNew(): int
  {
    $result = $this->sql->select("SELECT COUNT(*) AS total FROM booking WHERE status = 'nova'");
    return (int)($result[0]["total"] ?? 0);
  }

  public function updateStatus(int $id, string $status): bool
  {
    return $this->sql->query(
      "UPDATE booking SET status = :status WHERE id = :id",
      [":status" => $status, ":id" => $id]
    );
  }

  public function delete(int $id): bool
  {
    return $this->sql->query(
      "DELETE FROM booking WHERE id = :id",
      [":id" => $id]
    );
  }

  public function deleteAll(): bool
  {
    return $this->sql->query("DELETE FROM booking");
  }
}
