<?php

namespace Flooris\XelionClient;

use Flooris\XelionClient\HttpClient\XelionApiConnector;
use Flooris\XelionClient\Model\XelionApiCredentialsModel;
use Flooris\XelionClient\ModelPaginator\XelionUserPaginator;
use Flooris\XelionClient\Exceptions\XelionNotConnectedException;

class XelionService
{
    protected ?XelionApiConnector $connector = null;

    public function connect(XelionApiCredentialsModel $credentials, ?XelionApiConnector $connector = null): self
    {
        if (! $connector) {
            $this->connector = new XelionApiConnector($credentials);
        }

        if ($this->connector()->missingToken()) {
            $authenticator = $this->connector->getAuthenticator();
            $authModel     = $authenticator->getAuthModel();

            $this->connector()->setToken($authModel->authentication);
        }

        return $this;
    }

    public function connector(): ?XelionApiConnector
    {
        return $this->connector;
    }

    /**
     * @throws XelionNotConnectedException
     */
    public function userPaginator(): XelionUserPaginator
    {
        if ($this->isConnected()) {
            return new XelionUserPaginator($this->connector());
        }

        throw new XelionNotConnectedException();
    }

    public function isConnected(): bool
    {
        if ($this->connector()) {
            return true;
        }

        return false;
    }

    public function isNotConnected(): bool
    {
        return ! $this->isConnected();
    }

    public function hasValidConnection(): bool
    {
        if ($this->isNotConnected()) {
            return false;
        }

        try {
            $this->userPaginator()->getAll();

            return true;
        } catch (XelionNotConnectedException $exception) {

        }

        return false;
    }
}
