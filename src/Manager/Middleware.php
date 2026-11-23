<?php

namespace Vendor\Manager;

use Vendor\Manager\Application;

class Middleware
{
  public static function authenticated()
  {
    if (!isset($_SESSION["user"])) {
      Application::redirect("/backoffice");
    }
  }

  public static function notAuthenticated()
  {
    if (isset($_SESSION["user"])) {
      Application::redirect("/dashboard");
    }
  }
}
