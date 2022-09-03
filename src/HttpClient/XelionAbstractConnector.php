<?php

namespace Flooris\XelionClient\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Flooris\XelionClient\Model\XelionApiCredentialsModel;

abstract class XelionAbstractConnector
{
    public const USER_AGENT = 'flooris-XelionClient';

    private Client $guzzleClient;

    protected readonly string $baseUrl;
    protected readonly string $baseUri;
    protected readonly string $version;
    protected readonly string $tenant;
    private ?string $token = null;

    public function __construct(
        private readonly XelionApiCredentialsModel $credentials
    )
    {
        if ($this->credentials->token) {
            $this->token = $this->credentials->token;
        }

        $this->baseUrl = $this->credentials->baseUrl;
        $this->version = $this->credentials->version;
        $this->tenant  = $this->credentials->tenant;
        $this->baseUri = "{$this->baseUrl}/api/{$this->version}/{$this->tenant}/";

        $this->guzzleClient = new Client([
            'base_uri' => $this->baseUri,
        ]);
    }

    public function getAuthenticator(): XelionApiAuthenticator
    {
        return new XelionApiAuthenticator($this->credentials, $this);
    }

    public function hasToken(): bool
    {
        return (bool)$this->token;
    }

    public function missingToken(): bool
    {
        return ! $this->hasToken();
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @throws GuzzleException
     */
    public function get($uri, $query = []): ResponseInterface
    {
        return $this->send('GET', $uri, null, $query);
    }

    /**
     * @throws GuzzleException
     */
    public function post($uri, $bodyData): ResponseInterface
    {
        return $this->send('POST', $uri, $bodyData);
    }

    /**
     * @throws GuzzleException
     */
    public function patch($uri, $bodyData): ResponseInterface
    {
        return $this->send('PATCH', $uri, $bodyData);
    }

    /**
     * @throws GuzzleException
     */
    public function delete($uri): ResponseInterface
    {
        return $this->send('DELETE', $uri);
    }

    /**
     * @throws GuzzleException
     */
    private function send(string $method, string $uri, mixed $bodyData = null, array $query = []): ResponseInterface
    {
        $options = [
            RequestOptions::HEADERS => [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
                'User-Agent'   => XelionAbstractConnector::USER_AGENT,
            ],
            RequestOptions::QUERY   => $query,
        ];

        if ($this->token) {
            $options[RequestOptions::HEADERS]['Authorization'] = "xelion " . $this->token;
        }

        if ($bodyData) {
            $options[RequestOptions::JSON] = $bodyData;
        }

        return $this->guzzleClient->request($method, $uri, $options);
    }
}
