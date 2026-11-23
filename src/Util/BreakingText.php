<?php

function breakingText(string $text, int $break) {
    $fullText = strip_tags($text);

    if(strlen($fullText) > $break) {
        
        // Truncate string
        $fullTextSplit = substr($fullText, 0, $break);

        $textBreaking = substr_replace($fullTextSplit, "...", $break);

        return $textBreaking;
    }
}