<?php

namespace Vendor\Domain;

use \DateTime;

use Vendor\Domain\Post;

use Vendor\Domain\Contracts\IDomainDto;

class Comments implements IDomainDto
{
  private ?int $id;
  public string $username;
  public string $description;
  public Post $post;
  public ?DateTime $createdAt;
  public ?DateTime $updatedAt;

  public function __construct(
    string $username,
    string $description,
    Post $post,
    ?DateTime $createdAt = null,
    ?DateTime $updatedAt = null,
    ?int $id = null
  ) {
    $this->id = $id;
    $this->post = $post;
    $this->username = $username;
    $this->createdAt = $createdAt;
    $this->updatedAt = $updatedAt;
    $this->description = $description;
  }

  public function validate()
  {
    if (
      $this->username == "" ||
      $this->description == ""
    ) {
      return false;
    }

    return true;
  }
}
