<?php
require_once '../vendor/autoload.php';

// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
  ->setUsername('uocdemoallocationsystem@gmail.com')
  ->setPassword('miniprojectg10');

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);


function sendRegistationEmail($userEmail, $body)
{
  global $mailer;

  // Create a message
  $message = (new Swift_Message('Your account was successfully created.'))
    ->setFrom('uocdemoallocationsystem@gmail.com', 'Allocation System')
    ->setTo($userEmail)
    ->setBody($body, 'text/html');

  // Send the message
  $result = $mailer->send($message);

  if ($result > 0) {
    return true;
  } else {
    return false;
  }
}


function sendResetEmail($userEmail, $body)
{
  global $mailer;

  // Create a message
  $message = (new Swift_Message('Reset your  Password'))
    ->setFrom('uocdemoallocationsystem@gmail.com', 'Allocation System')
    ->setTo($userEmail)
    ->setBody($body, 'text/html');

  // Send the message
  $result = $mailer->send($message);

  if ($result > 0) {
    return true;
  } else {
    return false;
  }
}
