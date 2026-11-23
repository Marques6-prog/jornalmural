<?php

namespace Vendor\System\Usecases\Post;

use Vendor\Repositories\PostRepository;
use Vendor\Domain\Contracts\IDomainDto;

class CreatePostUseCase
{
  private PostRepository $postRepository;

  public function __construct()
  {
    $this->postRepository = new PostRepository();
  }

  public function execute(IDomainDto $request)
  {
    $postAlreadyExists = $this->postRepository->isSavedPost(
      $request->title, $request->category->id
    );
    
    if ($postAlreadyExists) {
      return [
        "status" => 409 // Post Already Exists,
      ];
    }

    $statement = $this->postRepository->save($request);

    if ($statement) {
      return [
        "status" => 201 // Post successfully created,
      ];
    }
  }
}
