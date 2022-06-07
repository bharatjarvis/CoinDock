<?php

namespace App\Http\Controllers\V1\Auth;

use App\Exceptions\Api\ApiException;
use GuzzleHttp\Psr7\ServerRequest;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

trait BuildPassportTokens
{

    protected function requestPasswordGrant($request)
    {

        $response = $this->buildServerRequest('POST', [
            'grant_type' => 'password',
            'client_id' => config('passport.client.id'),
            'client_secret' => config('passport.client.secret'),
            'username' => $request->email,
            'password' => $request->password,
            'scope' => implode(' ', config('passport.client.scopes')),
        ]);

        return $this->makeRequest($response);
    }

    /**
     * @param ServerRequestInterface $serverRequest
     * @return array
     * @throws ApiException|Throwable
     */
    protected function makeRequest(ServerRequestInterface $serverRequest): array
    {
        try {

            return json_decode(parent::issueToken($serverRequest)->getContent(), true);
        } catch (OAuthServerException $e) {

            throw new OAuthServerException('OAuth server error', ['token' => $e->getMessage()], 'Auth');
        } catch (Throwable $e) {
            throw $e;
        }
    }

    protected function requestRefreshGrant($request)
    {

        $response = $this->buildServerRequest('POST', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->header('Refresh-Token'),
            'client_id' => config('passport.client.id'),
            'client_secret' => config('passport.client.secret'),
            'scope' => implode(' ', config('passport.client.scopes')),
        ]);

        return $this->makeRequest($response);
    }

    /**
     * @param string $method
     * @param array $body
     * @return ServerRequestInterface
     */
    protected function buildServerRequest(string $method, array $body): ServerRequestInterface
    {
        $serverRequest = new ServerRequest($method, request()->path());

        return $serverRequest->withParsedBody($body);
    }
}