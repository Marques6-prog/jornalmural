<?php

namespace Vendor\System\Usecases\Post;

use Vendor\Repositories\PostRepository;

class DeletePostUseCase
{
  private PostRepository $postRepository;

  public function __construct()
  {
    $this->postRepository = new PostRepository();
  }

  public function execute(int $id)
  {    
    $statement = $this->postRepository->delete($id);

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
