<?php

require __DIR__ . '/../vendor/autoload.php';

use Twilio\Rest\Client;
use Dotenv\Dotenv;
// Load environment variables from .env file
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

// Check if the variables are set correctly
$account_sid = $_ENV['TWILIO_ACCOUNT_SID'];
$auth_token = $_ENV['TWILIO_AUTH_TOKEN'];
$twilio_number = $_ENV['TWILIO_PHONE_NUMBER'];

if (!$account_sid || !$auth_token) {
    die('Twilio Account SID and Auth Token are not set.');
}

if (!$account_sid || !$auth_token) {
    die('Twilio Account SID and Auth Token are not set.');
}

$client = new Client($account_sid, $auth_token);
$client->messages->create(
    "+639569260774",
    array(
        'from' => $twilio_number,
        'body' => 'You are scheduled for tomorrows consultation at Barangay Bulua Health Center. 
        To verify your information please bring the following.
        - Zone Certificate or Valid ID.'
    )
);
