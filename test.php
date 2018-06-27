<?php

include("vendor/autoload.php");
use Zendesk\API\HttpClient as ZendeskAPI;
/**
 * Replace the following with your own.
 */

$subdomain = "dev";
$username  = "admin@zendesk.com"; // replace this with your registered email
$token     = $_ENV["ZENDESK_API_TOKEN"]; // replace this with your token

$client = new ZendeskAPI($subdomain, "", "https", "zd-dev.com");
$client->setAuth('basic', ['username' => $username, 'token' => $token]);

// Upload files in images

$files = scandir('./images');

foreach ($files as $file) {
  list($name, $ext) = explode(".", $file);

  // Get rid of inodes and weird files...
  if (strlen($name) < 4) {
    continue;
  }

  echo $file;

  print_r(
    $client->attachments()->upload([
      'file' => getcwd().'/images/'.$file,
      'type' => 'image/'.$ext,
      'name' => $file
    ])
  );
}
