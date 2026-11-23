<?php

namespace Vendor\Controllers\Category;

use Vendor\Manager\Middleware;
use Vendor\Controllers\Contracts\IHandle;

use Vendor\System\Usecases\Category\FindCategoryUseCase;

class FindCategoryController implements IHandle
{
  private string $_name;
  private FindCategoryUseCase $_findCategoryByName;

  public function __construct(string $name)
  {
    $this->_name = $name;
    $this->_findCategoryByName = new FindCategoryUseCase();
  }

  public function handle()
  {
    Middleware::authenticated();

    return $this->_findCategoryByName->execute($this->_name);
  }
}
