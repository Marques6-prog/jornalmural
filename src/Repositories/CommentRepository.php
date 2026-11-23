<?php

namespace Vendor\Repositories;

use Vendor\Sql\Sql;

use Vendor\Domain\Contracts\IDomainDto;

class CommentRepository
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
      "INSERT INTO comments (post_id, username, description) 
       VALUES (:post_id, :username, :description)",
      [
        ":post_id" => $request->post->id,
        ":username" => $request->username,
        ":description" => $request->description
      ]
    );

    return $statement;
  }

  public function getById(int $postId)
  {
    return $this->sql->select(
      "SELECT 
        c.id, c.username, c.description, c.created_at
       FROM comments c
       INNER JOIN post p ON c.post_id  = p.id
       AND p.state = 1 AND p.id = :postId",
      [
        ":postId" => $postId
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
}
