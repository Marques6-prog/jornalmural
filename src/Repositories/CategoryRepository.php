<?php

namespace Vendor\Repositories;

use Vendor\Sql\Sql;

use Vendor\Domain\Contracts\IDomainDto;

class CategoryRepository
{
  private Sql $sql;

  public function __construct()
  {
    $this->sql = new Sql();
  }

  public function save(
    IDomainDto $request
  ) {
    $statement = $this->sql->query(
      "INSERT INTO category (name) VALUES (:name)",
      [
        ":name" => $request->name
      ]
    );

    return $statement;
  }

  public function getUserByName(string $name)
  {
    return $this->sql->select(
      "SELECT *FROM category WHERE name = :name",
      [
        ":name" => $name
      ]
    );
  }

  public function get()
  {
    return $this->sql->select(
      "SELECT *FROM category"
    );
  }

  public function getById(int $id)
  {
    return $this->sql->select(
      "SELECT *FROM category WHERE id = :id",
      [
        ":id" => $id
      ]
    );
  }

  public function find($name)
  {
    $search = "%{$name}%";

    return $this->sql->select(
      "SELECT *FROM category WHERE name LIKE :search",
      [
        ":search" => $search
      ]
    );
  }

  public function update(
    IDomainDto $request
  ) {
    $statement = $this->sql->query(
      "UPDATE category SET name = :name WHERE id = :id",
      [
        ":id" => $request->id,
        ":name" => $request->name
      ]
    );

    return $statement;
  }

  public function delete($id)
  {
    $statement = $this->sql->query(
      "DELETE FROM category WHERE id = :id",
      [
        ":id" => $id
      ]
    );

    return $statement;
  }
}
