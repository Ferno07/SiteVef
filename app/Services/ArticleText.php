<?php

namespace App\Services;

class ArticleText
{
    public static function line(string $line): string
    {
        return preg_replace_callback('/\[([^\]]+)\]\((\/(?!\/)[^\s)]*)\)/u', function ($m) {
            // Restrict links to same-site paths; reject backslashes and control characters.
            if (str_contains($m[2], '\\') || preg_match('/[\x00-\x20]/', $m[2])) {
                return e($m[0]);
            }

            return '<a class="text-blue-700 underline" href="'.e($m[2]).'">'.e($m[1]).'</a>';
        }, e($line));
    }
}
