<?php

namespace Vendor\Manager;

use Exception;

class Application
{
  /**
   *
   * Folder alias
   *
   * @var string $alias
   * @var string $path
   */
  protected static $alias = [];

  /**
   * @var array|null
   */
  protected static $config;

  public static function setAlias(string $alias, string $path)
  {
    self::$alias[$alias] = $path;
  }

  /**
   * Returns path
   *
   * @param string $alias
   * @return string
   * @throws Exception
   */
  public static function getAlias(string $alias)
  {
    if (!isset(self::$alias[$alias])) {
      throw new Exception("Path to \"$alias\" not found.", 500);
    }

    return self::$alias[$alias];
  }

  public static function redirect($url, $args = "")
  {
    header('Location: http://localhost/jornalmural' . $url . $args);
    die;
  }

  /**
   * Returns system config
   *
   * @return array
   */
  public static function getConfig(): array
  {
    if (self::$config === null) {
      self::$config = require self::getAlias('@config') . '/main.php';
    }

    return self::$config;
  }
}
