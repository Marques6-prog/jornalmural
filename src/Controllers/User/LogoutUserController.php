<?php

namespace Vendor\Controllers\User;

use Vendor\Manager\Middleware;
use Vendor\Manager\Application;
use Vendor\Controllers\Contracts\IHandle;

class LogoutUserController implements IHandle
{
  public function handle()
  {
    Middleware::authenticated();

    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(), '', 0, '/');
    session_regenerate_id(true);

    unset($_SESSION);

    Application::redirect("/backoffice");
  }
}
