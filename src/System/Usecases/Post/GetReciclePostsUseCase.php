<?php

namespace Vendor\System\Usecases\Post;

use Vendor\Repositories\PostRepository;

class GetReciclePostsUseCase
{
  private PostRepository $postRepository;

  public function __construct()
  {
    $this->postRepository = new PostRepository();
  }

  public function execute()
  {
    $post = $this->postRepository->getReciclePosts();
    return $post;
  }
}
