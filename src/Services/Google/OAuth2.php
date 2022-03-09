<?php

namespace OMT\Services\Google;

use Exception;
use Google\Client;

class OAuth2
{
    protected $credentialsPath = '/credentials/google-oauth2.json';

    /**
     * Returns an authorized API client.
     * @return Client the authorized client object
     */
    public function getClient(string $scope, string $redirectUri)
    {
        $client = new Client();
        $client->setAuthConfig(get_template_directory() . $this->credentialsPath);
        $client->setApplicationName(get_bloginfo());
        $client->setScopes($scope);
        $client->setRedirectUri($this->getRedirectUri($redirectUri));
        $client->setAccessType('offline');

        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first time.
        $tokenPath = $this->getTokenPath();

        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }

        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                // Request authorization from the user.
                if (!isset($_GET['code'])) {
                    wp_redirect($client->createAuthUrl());
                    exit;
                }

                // The authorization code is sent to the callback URL as a GET parameter.
                // We use this "authorization code" to generate an "access token". The
                // "access token" is what's effectively used as a private API key.

                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($_GET['code']);
                $client->setAccessToken($accessToken);

                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
            }

            // Save the token to a file.
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }

            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }

        return $client;
    }

    protected function getTokenPath()
    {
        return get_template_directory() . '/credentials/google-oauth2-token-' . md5(get_current_user_id()) . '.json';
    }

    protected function getRedirectUri($redirectUri)
    {
        return WP_ENV === 'development'
            ? str_replace(site_url(), 'http://localhost', $redirectUri)
            : $redirectUri;
    }
}
