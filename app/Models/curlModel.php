<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class curlModel extends Model
{
    use HasFactory;
    public static function checkCurl()
    {
		$url = 'https://api.postmarkapp.com/email/withTemplate';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_TIMEOUT,10);
$output   = curl_exec($ch);
print_r($output);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo 'HTTP code: ' . $httpcode;
		
	}
}
