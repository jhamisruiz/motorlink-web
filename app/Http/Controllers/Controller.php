<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function getPath($path)
    {
        $base = env('EXTERNAL_API_URL');
        return  $base . $path;
    }
}
