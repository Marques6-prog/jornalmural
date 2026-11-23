<?php

namespace Vendor\Controllers\User;

use Vendor\Domain\User;
use Vendor\Models\Model;
use Vendor\Settings\Upload;
use Vendor\Manager\Middleware;
use Vendor\Manager\Application;
use Vendor\Controllers\Contracts\IHandle;

use Vendor\System\Usecases\User\CreateUserUsecase;

class CreateUserController extends Model implements IHandle
{
  private Upload $_handle;
  private CreateUserUsecase $_createUserUseCase;

  public function __construct()
  {
    $this->setData($_POST);
    $this->_handle = new Upload();
    $this->_createUserUseCase = new CreateUserUsecase();
  }

  public function handle()
  {
    Middleware::notAuthenticated();

    $user = new User(
      $this->getname(), $this->getemail(), $this->getpassword(),
      1
    );

    if (!$user->validate()) {
      Application::redirect("/backoffice/create", "?status=danger&msg=Preencha devidamente os campos");
    }

    if (!$user->isValidEmail($user->email)) {
      Application::redirect("/backoffice/create", "?status=danger&msg=Email inválido");
    }

    if (
      !$user->isValid($user->password) &&
      $this->getpassword() !== $this->getconfirmPass()
    ) {
      Application::redirect("/backoffice/create", "?status=danger&msg=Password diferente ou inválida");
    }

    $user->upload(
      $this->_handle->uploadPhoto()
    );

    $statucCode = $this->_createUserUseCase->execute(
      $user
    );

    switch ($statucCode["status"]) {
      case 409:
        Application::redirect("/backoffice/create", "?status=danger&msg=Usuário já existe");
        break;

      default:
        Application::redirect("/backoffice");
        break;
    }    
  }
}
