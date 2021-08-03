<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vonage\Client\Exception\Exception;

class MessageController extends Controller
{
    public function sendMessage($message, $numero){
        try {
            $basic  = new \Vonage\Client\Credentials\Basic("955fc9c6", "mAWAdKoZ6Emoe6QU");
            $client = new \Vonage\Client($basic);
            $response = $client->sms()->send(
                new \Vonage\SMS\Message\SMS(
                    $numero,
                    'GETEL',
                    $message,
                )
            );
            $message1 = $response->current();

            if ($message1->getStatus() == 0) {
                $message_con = $message1->getStatus();
            }
        } catch (Exception $e) {
            $message_con = "Error: ". $e->getMessage();
        }
        return $message_con;
    }
}
