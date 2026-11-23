<?php

namespace Vendor\Repositories;

use Vendor\Sql\Sql;

use Vendor\Domain\Contracts\IDomainDto;

class PostRepository
{
  private Sql $sql;

  public function __construct()
  {
    $this->sql = new Sql();
  }

  public function save(
    IDomainDto $request
  ) {
    $statement = $this->sql->query(
      "INSERT INTO post (category_id, title, description, created_at, updated_at, image) 
       VALUES (:category_id, :title, :description, default, default, :image)",
      [
        ":category_id" => $request->category->id,
        ":title" => $request->title,
        ":description" => $request->description,
        ":image" => $request->image
      ]
    );

    return $statement;
  }

  public function getPostByTitle(string $title)
  {
    return $this->sql->select(
      "SELECT *FROM post WHERE title = :title",
      [
        ":title" => $title
      ]
    );
  }

  public function isSavedPost(
    string $title,
    int $category
  ) {
    return $this->sql->select(
      "SELECT *FROM post WHERE title = :title AND category_id = :category_id",
      [
        ":title" => $title,
        ":category_id" => $category
      ]
    );
  }

  public function get()
  {
    return $this->sql->select(
      "SELECT 
       p.id, p.image, 
       p.title, 
       c.name, 
       p.description, 
       p.created_at,
       c.category_id
       FROM post p
       INNER JOIN category c ON p.category_id = c.id
       AND p.state = 1"
    );
  }

  public function getReciclePosts()
  {
    return $this->sql->select(
      "SELECT 
       p.id, p.image, 
       p.title, 
       c.name, 
       p.description, 
       p.created_at
       FROM post p
       INNER JOIN category c ON p.category_id = c.id
       AND p.state = 0"
    );
  }

  public function getById(int $id)
  {
    return $this->sql->select(
      "SELECT 
      p.id, p.image, 
      p.title, 
      c.name, 
      p.description, 
      p.created_at
      FROM post p
      INNER JOIN category c ON p.category_id = c.id
      WHERE p.state = 1 AND p.id = :id",
      [
        ":id" => $id
      ]
    );
  }

  public function getPostsByCategoryId( $id)
  {  
    return $this->sql->select(
      "SELECT 
       p.id, p.image, 
       p.title, 
       c.name, 
       p.description, 
       p.created_at
       FROM post p
       INNER JOIN category c ON p.category_id = c.id
       WHERE p.state = 1 AND p.id = :id",
      [
        ":id" => $id
      ]
    );
  }

  public function find($title)
  {
    $search = "%{$title}%";

    return $this->sql->select(
      "SELECT 
       p.id, p.image, 
       p.title, 
       c.name, 
       p.description, 
       p.created_at
       FROM post p 
       INNER JOIN category c
       ON p.id = c.id
       WHERE p.title LIKE :search AND state = 1",
      [
        ":search" => $search
      ]
    );
  }

  public function update(
    IDomainDto $request
  ) {
    $statement = $this->sql->query(
      "UPDATE post SET title = :title, category_id = :category_id, 
       description = :description, image = :image  WHERE id = :id",
      [
        ":id" => $request->id,
        ":title" => $request->title,
        ":category_id" => $request->category->id,
        ":description" => $request->description,
        ":image" => $request->image
      ]
    );

    return $statement;
  }

  public function delete($id)
  {
    $statement = $this->sql->query(
      "UPDATE post SET state = 0 WHERE id = :id",
      [
        ":id" => $id
      ]
    );

    return $statement;
  }

  public function recover($id)
  {
    $statement = $this->sql->query(
      "UPDATE post SET state = 1 WHERE id = :id",
      [
        ":id" => $id
      ]
    );

    return $statement;
  }
}
