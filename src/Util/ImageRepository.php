<?php

function getPathLocation(string $dir): string
{
  return dirname(__DIR__) . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR;
}


function imageRepository(?string $image): string
{
    if ($image === null || $image === "" || !file_exists(getPathLocation("Resources") . $image)) {
        return "/jornalmural/src/Resources/empty.png";
    }

    return "/jornalmural/src/Resources/{$image}";
}

function isVideoMedia(?string $media): bool
{
    return in_array(
        strtolower(pathinfo($media ?? "", PATHINFO_EXTENSION)),
        ["mp4", "webm"],
        true
    );
}
