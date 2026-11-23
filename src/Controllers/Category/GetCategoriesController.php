<?php

namespace Vendor\Controllers\Category;

use Vendor\Controllers\Contracts\IHandle;

use Vendor\System\Usecases\Category\GetCategoriesUseCase;

class GetCategoriesController implements IHandle
{
  private GetCategoriesUseCase $_getCategoriesUseCase;

  public function __construct()
  {
    $this->_getCategoriesUseCase = new GetCategoriesUseCase();
  }

  public function handle()
  {
    return $this->_getCategoriesUseCase->execute();
  }
}
