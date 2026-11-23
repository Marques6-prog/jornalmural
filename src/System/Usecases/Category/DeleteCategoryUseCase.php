<?php

namespace Vendor\System\Usecases\Category;

use Vendor\Repositories\CategoryRepository;

class DeleteCategoryUseCase
{
  private CategoryRepository $categoryRepository;

  public function __construct()
  {
    $this->categoryRepository = new CategoryRepository();
  }

  public function execute(int $id)
  {
    $statement = $this->categoryRepository->delete($id);

    if ($statement) {
      return [
        "status" => 200,
      ];
    }

    return [
      "status" => 403
    ];
  }
}
