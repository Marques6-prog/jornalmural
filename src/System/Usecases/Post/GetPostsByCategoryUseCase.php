<?php

namespace Vendor\System\Usecases\Post;

use Vendor\Repositories\PostRepository;

class GetPostsByCategoryUseCase
{
  private PostRepository $postRepository;

  public function __construct()
  {
    $this->postRepository = new PostRepository();
  }

  public function execute()
  {
    $post = $this->postRepository->get();    
    return $post;
  }
}
