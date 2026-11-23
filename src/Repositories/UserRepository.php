<?php

namespace Vendor\Repositories;

use Vendor\Sql\Sql;

use Vendor\Domain\Contracts\IDomainDto;

class UserRepository
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
      "INSERT INTO user (name, email, password, image, isadmin) VALUES 
        (:name, :email, :password, :image, :isadmin)",
      [
        ":name" => $request->name,
        ":email" => $request->email,
        ":password" => $request->password,
        ":image" => $request->image,
        ":isadmin" => ($request->isadmin ? 0 : 1)
      ]
    );

    return $statement;
  }

  public function getUserByEmail(string $email)
  {
    return $this->sql->select(
      "SELECT *FROM user WHERE email = :email",
      [
        ":email" => $email
      ]
    );
  }
}
