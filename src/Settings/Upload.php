<?php

namespace Vendor\Settings;

class Upload
{
  public const MAX_VIDEO_SIZE_MB = 50;

  private string $targetDir;
  private string $targetFilePath;
  private string $fileName;
  private string $fileType;

  public function __construct()
  {
    $this->targetDir = $this->getPathLocation("Resources");
    $originalFileName = basename((string)($_FILES["photo"]["name"] ?? ""));
    $this->fileType = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));
    $this->fileName = $this->fileType === "" ? "" : bin2hex(random_bytes(16)) . "." . $this->fileType;
    $this->targetFilePath = $this->targetDir . $this->fileName;
  }

  public function uploadMedia(bool $allowVideo = false): string
  {
    $file = $_FILES["photo"] ?? [];
    if (empty($file["name"])) {
      return "empty.png";
    }

    $uploadError = $file["error"] ?? UPLOAD_ERR_NO_FILE;
    if ($uploadError !== UPLOAD_ERR_OK) {
      if (in_array($uploadError, [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE], true)) {
        throw new \InvalidArgumentException("The uploaded file exceeds the permitted size.");
      }

      throw new \RuntimeException("PHP reported a media upload error.");
    }

    $allowedMimeTypes = [
      "jpg" => "image/jpeg",
      "jpeg" => "image/jpeg",
      "png" => "image/png"
    ];
    if ($allowVideo) {
      $allowedMimeTypes["mp4"] = "video/mp4";
      $allowedMimeTypes["webm"] = "video/webm";
    }

    if (!isset($allowedMimeTypes[$this->fileType])) {
      throw new \InvalidArgumentException("The uploaded media format is not supported.");
    }

    $isVideo = in_array($this->fileType, ["mp4", "webm"], true);
    if (
      $isVideo &&
      (int)($file["size"] ?? 0) > self::MAX_VIDEO_SIZE_MB * 1024 * 1024
    ) {
      throw new \InvalidArgumentException("The uploaded video exceeds the permitted size.");
    }

    $temporaryPath = $file["tmp_name"] ?? "";
    if (!is_string($temporaryPath) || !is_uploaded_file($temporaryPath)) {
      throw new \RuntimeException("The uploaded media temporary file is not valid.");
    }

    $fileInfo = new \finfo(FILEINFO_MIME_TYPE);
    if ($fileInfo->file($temporaryPath) !== $allowedMimeTypes[$this->fileType]) {
      throw new \InvalidArgumentException("The uploaded media content does not match its format.");
    }

    if (!move_uploaded_file($temporaryPath, $this->targetFilePath)) {
      throw new \RuntimeException("The uploaded media could not be moved to the media directory.");
    }

    return $this->fileName;
  }

  private function getPathLocation($dir)
  {
    return $_SERVER["DOCUMENT_ROOT"]
      . DIRECTORY_SEPARATOR . "jornalmural"
      . DIRECTORY_SEPARATOR . "src"      
      . DIRECTORY_SEPARATOR . $dir
      . DIRECTORY_SEPARATOR;
  }
}
