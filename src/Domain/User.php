<?php

namespace Vendor\Domain;

use Vendor\Domain\Contracts\IDomainDto;

class User implements IDomainDto
{
  private ?int $id;
  public string $name;
  public string $email;
  public string $image;
  public string $password;
  public bool $isAdmin;

  public function __construct(
    string $name,
    string $email,
    string $password,
    int $isAdmin = 0,
    ?int $id = null
  ) {
    $this->id = $id;
    $this->name = $name;
    $this->email = $email;
    $this->password = $password;
    $this->isAdmin = $isAdmin;
  }

  public function validate()
  {
    if (
      $this->name == "" ||
      $this->email == "" ||
      $this->password == ""
    ) {
      return false;
    }

    return true;
  }

  public function upload($image)
  {
    $this->image = $image;
  }

  public function getUserId()
  {
    return $this->id;
  }

  public static function isValidEmail($email)
  {
    // Check valid email address example
    // osvaldo@gmail.com || osvaldo@gmail.com.br

    return (!preg_match(
      "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix",
      $email
    )) ? false : true;
  }

  public static function isValid($password)
  {

    if (preg_match(
      "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/ix",
      $password
    )) {

      return self::encrypt($password);
    }

    return false;
    die;
  }

  public static function checkPass($password)
  {
    return (!preg_match(
      "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/ix",
      $password
    )) ? false : true;
  }

  private static function encrypt($password)
  {
    return password_hash($password, PASSWORD_DEFAULT);
  }

  public static function comparePassword($pass, $hash)
  {
    return password_verify($pass, $hash);
  }
}
