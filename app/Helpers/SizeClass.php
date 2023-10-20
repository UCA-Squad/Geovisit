<?php

namespace App\Helpers;

class SizeClass
{
    public static function bytesToHuman($bytes)
    {
        $units = ['o', 'Ko', 'Mo', 'Go', 'To', 'Po'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}