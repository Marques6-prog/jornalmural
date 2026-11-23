<?php

namespace Vendor\Controllers\Category;

use Vendor\Manager\Middleware;
use Vendor\Controllers\Contracts\IHandle;

use Vendor\System\Usecases\Category\GetCategoryByIdUseCase;

class GetCategoryByIdController implements IHandle
{
  private int $_id;
  private GetCategoryByIdUseCase $_getCategoryByIdUseCase;

  public function __construct(int $id)
  {
    $this->_id = $id;
    $this->_getCategoryByIdUseCase = new GetCategoryByIdUseCase();
  }

  public function handle()
  {
    Middleware::authenticated();

    return $this->_getCategoryByIdUseCase->execute($this->_id);
  }
}
