<?php

namespace Vendor\System\Usecases\Category;

use Vendor\Repositories\CategoryRepository;
use Vendor\Domain\Contracts\IDomainDto;

class UpdateCategoryUseCase
{
  private CategoryRepository $categoryRepository;

  public function __construct()
  {
    $this->categoryRepository = new CategoryRepository();
  }

  public function execute(IDomainDto $request)
  {
    $statement = $this->categoryRepository->update($request);

    if ($statement) {
      return [
        "status" => 201 // Category successfully created,
      ];
    }

    return [
      "status" => 400 // Bad Request
    ];
  }
}
