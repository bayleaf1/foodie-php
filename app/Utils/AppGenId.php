<?php
namespace App\Utils;

use Hidehalo\Nanoid\Client;

class AppGenId
{

    static function numeric($size = 10)
    {
        $client = new Client();
        return $client->formattedId($alphabet = '0123456789', $size);

    }
}