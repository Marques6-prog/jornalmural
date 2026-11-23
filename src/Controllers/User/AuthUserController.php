<?php

namespace Vendor\Controllers\User;

use Vendor\Models\Model;
use Vendor\Manager\Middleware;
use Vendor\Manager\Application;
use Vendor\Controllers\Contracts\IHandle;

use Vendor\System\Usecases\User\AuthUserUseCase;

class AuthUserController extends Model implements IHandle
{
  private AuthUserUseCase $_authUserUseCase;

  public function __construct()
  {
    $this->setData($_POST);
    $this->_authUserUseCase = new AuthUserUseCase();
  }

  public function handle()
  {
    Middleware::notAuthenticated();

    if (
      $this->getemail() == "" ||
      $this->getpassword() == ""
    ) {
      Application::redirect("/backoffice","?status=danger&msg=Preencha devidamente os campos");
    }

    $isAuthenticated = $this->_authUserUseCase->execute(
      $this->getemail(), $this->getpassword()
    );
    
    switch ($isAuthenticated["status"]) {
      case 401:
        Application::redirect("/backoffice","?status=danger&msg=Usuário ou pass inválida");
        break;
      
      default:
        Application::redirect("/dashboard");
        break;
    }
  }
}
