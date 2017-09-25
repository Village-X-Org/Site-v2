<?php
require_once("utilities.php");
require_once __DIR__ . '/vendor/autoload.php';


define('APPLICATION_NAME', 'VillageX');
define('CLIENT_ID', 'fresh-generator-179618');
define('CREDENTIALS_PATH', __DIR__ . '/.credentials/sheets.googleapis.com-php-quickstart.json');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');
define('SCOPES', implode(' ', array(
  Google_Service_Sheets::SPREADSHEETS_READONLY)
));

if (php_sapi_name() != 'cli') {
  throw new Exception('This application must be run on the command line.');
}

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient() {
  $client = new Google_Client();
  $client->setApplicationName(APPLICATION_NAME);
  $client->setClientId(CLIENT_ID);
  $client->setScopes(SCOPES);
  $client->setAuthConfig(CLIENT_SECRET_PATH);
  $client->setAccessType('offline');

    // Request authorization from the user.
    $authUrl = $client->createAuthUrl();
    printf("Open the following link in your browser:\n%s\n", $authUrl);
    print 'Enter verification code: ';
    $authCode = trim(fgets(STDIN));
    
    // Exchange authorization code for an access token.
    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
    
    // Store the credentials to disk.
    if(!file_exists(dirname(CREDENTIALS_PATH))) {
        mkdir(dirname(CREDENTIALS_PATH), 0700, true);
    }
    file_put_contents(CREDENTIALS_PATH, json_encode($accessToken));
    printf("Credentials saved to %s\n", CREDENTIALS_PATH);
  $client->setAccessToken($accessToken);

  // Refresh the token if it's expired.
  if ($client->isAccessTokenExpired()) {
    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
    file_put_contents(CREDENTIALS_PATH, json_encode($client->getAccessToken()));
  }
  return $client;
}

// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Sheets($client);