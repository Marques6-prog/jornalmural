<?php

namespace Vendor\Domain;

use \DateTime;

use Vendor\Domain\Category;
use Vendor\Domain\Contracts\IDomainDto;

class Post implements IDomainDto
{
  public ?int $id;
  public string $title;
  public string $description;
  public string $image;
  public ?Category $category;
  public ?DateTime $createdAt;
  public ?DateTime $updatedAt;

  public function __construct(
    string $title,
    string $description,    
    ?Category $category = null,
    ?DateTime $createdAt = null,
    ?DateTime $updatedAt = null,
    ?int $id = null
  ) {
    $this->id = $id;
    $this->title = $title;
    $this->description = $description;    
    $this->category = $category;
    $this->createdAt = $createdAt;
    $this->updatedAt = $updatedAt;
  }

  public function validate()
  {
    if (
      $this->title == "" ||
      $this->description == ""
    ) {
      return false;
    }

    return true;
  }

  public function upload($image)
  {
    $this->image = $image;
  }
}
