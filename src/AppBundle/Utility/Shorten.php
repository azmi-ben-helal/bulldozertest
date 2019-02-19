<?php
namespace AppBundle\Utility;

class Shorten
{
    public static function hash($count)
    {
        return base_convert((string)($count + 1), 10, 36);
    }

}
