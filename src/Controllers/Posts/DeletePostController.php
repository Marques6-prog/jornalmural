<?php

namespace Vendor\Controllers\Posts;

use Vendor\Manager\Middleware;
use Vendor\Manager\Application;
use Vendor\Controllers\Contracts\IHandle;

use Vendor\System\Usecases\Post\DeletePostUseCase;

class DeletePostController implements IHandle
{
  private int $_id;
  private DeletePostUseCase $_deletePostUseCase;

  public function __construct(int $id)
  {
    $this->_id  = $id;
    $this->_deletePostUseCase = new DeletePostUseCase();
  }

  public function handle()
  {
    Middleware::authenticated();

    $statusCode = $this->_deletePostUseCase->execute(
      $this->_id
    );

    switch ($statusCode["status"]) {
      case 403:
        Application::redirect("/list-post", "?status?danger&msg=Post não eliminado!");
        break;

      default:
        Application::redirect("/list-post", "?status?success&msg=Post eliminada!");
        break;
    }
  }
}
