<?php

namespace Vendor\Controllers\Category;

use Vendor\Manager\Middleware;
use Vendor\Manager\Application;
use Vendor\Controllers\Contracts\IHandle;

use Vendor\System\Usecases\Category\DeleteCategoryUseCase;

class DeleteCategoryController implements IHandle
{
  private int $_id;
  private DeleteCategoryUseCase $_deleteCategoryUseCase;

  public function __construct(int $id)
  {
    $this->_id  = $id;
    $this->_deleteCategoryUseCase = new DeleteCategoryUseCase();
  }

  public function handle()
  {
    Middleware::authenticated();

    $statusCode = $this->_deleteCategoryUseCase->execute(
      $this->_id
    );

    switch ($statusCode["status"]) {
      case 403:
        Application::redirect("/list-category", "?status?danger&msg=Categoria não eliminado!");
        break;

      default:
        Application::redirect("/list-category", "?status?success&msg=Categoria eliminada!");
        break;
    }
  }
}
