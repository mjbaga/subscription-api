<?php

namespace SuscriberAPI;

use \PalePurple\RateLimit\RateLimit;
use \PalePurple\RateLimit\Adapter\Predis as PredisAdapter;

class AppFunctions {

    public static function addRateLimiter(\Predis\Client $client, string $name, int $requestsPerHour = 1000): void
    {

        $adapter = new PredisAdapter($client);

        $rateLimiter = new RateLimit(
            $name, 
            $requestsPerHour, 
            60, 
            $adapter
        ); // set 1000 requests per hour by default

        $clientIP = $_SERVER['REMOTE_ADDR'];

        // check if user with ip has exceeded request limit
        if (!$rateLimiter->check($clientIP)) {
            header('HTTP/1.1 429 Too many requests');
            echo json_encode(['error' => 'You have exceeded the amount of requests.']);
            exit();
        }
    }
}