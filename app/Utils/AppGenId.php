<?php
namespace App\Utils;

use Hidehalo\Nanoid\Client;

class AppGenId
{

    static function alphaNumeric($size = 15)
    {
        $client = new Client();
        return $client->formattedId($alphabet = '0123456789abcdefg', $size);

    }
}