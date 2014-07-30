<?php

require_once('lib/Stripe.php');
require_once('wp-blog-header.php');



// Set your secret key: remember to change this to your live secret key in production
// See your keys here https://dashboard.stripe.com/account
Stripe::setApiKey("sk_test_j4r5kcbgYgtkYvtfpn74pxYv");

// Retrieve the request's body and parse it as JSON
$input = @file_get_contents("php://input");
$event_json = json_decode($input);

// Do something with $event_json
print_r($event_json);
http_response_code(200); // PHP 5.4 or greater

//echo site_url();
$to = 'cralberto11@gmail.com';
$subject = 'test';
$message = $event_json;
 
 
 
 wp_mail( $to, $subject, $message, $headers, $attachments ); 


?>