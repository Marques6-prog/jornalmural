<?php

namespace Vendor\System\Usecases\User;

use Vendor\Domain\User;
use Vendor\Repositories\UserRepository;

class AuthUserUseCase
{
  private UserRepository $useRepository;

  public function __construct()
  {
    $this->useRepository = new UserRepository();
  }

  public function execute(string $email, string $password)
  {
    $user = $this->useRepository->getUserByEmail(
      $email
    );

    if (
      !User::comparePassword(
        $password,
        $user[0]["password"]
      ) &&
      $user[0]["isadmin"] !== 0
    ) {
      return [
        "status" => 401
      ];
    }

    session_regenerate_id();
    $_SESSION["user"] = $user[0];

    return [
      "status" => 200
    ];
  }
}
