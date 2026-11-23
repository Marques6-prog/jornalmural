<?php

namespace Vendor\Domain;

use \DateTime;
use Vendor\Domain\Contracts\IDomainDto;

class Category implements IDomainDto
{
  public ?int $id;
  public string $name;
  public ?DateTime $createdAt;
  public ?DateTime $updatedAt;

  public function __construct(
    string $name,
    ?DateTime $createdAt = null,
    ?DateTime $updatedAt = null,
    ?int $id = null
  ) {
    $this->id = $id;
    $this->name = $name;
    $this->createdAt = $createdAt;
    $this->updatedAt = $updatedAt;
  }

  public function validate()
  {
    if (
      $this->name == ""
    ) {
      return false;
    }

    return true;
  }
}
