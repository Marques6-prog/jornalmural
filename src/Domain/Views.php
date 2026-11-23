<?php

namespace Vendor\Domain;

use Vendor\Domain\{
  Post,
  User
};

class Views
{
  private ?int $id;
  public Post $post;
  public User $user;

  public function __construct(
    Post $post,
    User $user,
    ?int $id = null
  ) {
    $this->id = $id;
    $this->post = $post;
    $this->user = $user;
  }

  public function getViewId()
  {
    return $this->id;
  }
}
