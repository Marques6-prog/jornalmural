<?php

namespace Vendor\Manager;

use Exception;

class View
{
  /**
   * Returns view's content
   *
   * @param string $folder
   * @param string $view
   * @return string
   * @throws Exception
   */
  public static function render($folder, $view, $vars = [])
  {
    $file = Application::getAlias('@src') . "/Views/$folder/$view.php";

    if (file_exists($file)) {
      echo self::renderFile($file, $vars);
    } else {
      throw new Exception("'$file' not found.");
    }
  }

  protected static function renderFile($path, $vars = [])
  {
    ob_start();
    extract($vars);

    include_once $path;
    return ob_get_clean();
  }
}
