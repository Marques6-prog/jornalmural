<?php

namespace Vendor\System\Usecases\User;

use Vendor\Domain\User;
use Vendor\Repositories\UserRepository;
use Vendor\Domain\Contracts\IDomainDto;

class CreateUserUsecase
{
  private UserRepository $useRepository;

  public function __construct()
  {
    $this->useRepository = new UserRepository();
  }

  public function execute(IDomainDto $request)
  {
    $userAlreadyExists = $this->useRepository->getUserByEmail(
      $request->email
    );

    if ($userAlreadyExists) {
      return [
        "status" => 409 // User Already Exists,
      ];
    }

    $request->password = User::isValid(
      $request->password
    );

    $statement = $this->useRepository->save($request);

    if ($statement) {
      return [
        "status" => 201 // User successfully created,
      ];
    }
  }
}
