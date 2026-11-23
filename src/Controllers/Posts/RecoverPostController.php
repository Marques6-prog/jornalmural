<?php

namespace Vendor\Controllers\Posts;

use Vendor\Manager\Middleware;
use Vendor\Manager\Application;
use Vendor\Controllers\Contracts\IHandle;

use Vendor\System\Usecases\Post\RecoverPostUseCase;

class RecoverPostController implements IHandle
{
  private int $_id;
  private RecoverPostUseCase $_recoverPostUseCase;

  public function __construct(int $id)
  {
    $this->_id  = $id;
    $this->_recoverPostUseCase = new RecoverPostUseCase();
  }

  public function handle()
  {
    Middleware::authenticated();

    $statusCode = $this->_recoverPostUseCase->execute(
      $this->_id
    );

    switch ($statusCode["status"]) {
      case 403:
        Application::redirect("/recicle", "?status?danger&msg=Erro ao recuperar, tente novamente!");
        break;

      default:
        Application::redirect("/list-post", "?status?success&msg=Post recuperado com sucesso!");
        break;
    }
  }
}
