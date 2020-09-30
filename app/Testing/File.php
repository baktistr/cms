<?php

namespace App\Testing;

class File
{
    /**
     * Create a new fake image.
     *
     * @param  string      $name
     * @param  int         $width
     * @param  int         $height
     * @param  string|null $color
     *
     * @return \Illuminate\Http\Testing\File
     */
    public static function image($name, $width = 10, $height = 10, $color = null)
    {
        return (new FileFactory)->image($name, $width, $height, $color);
    }
}
