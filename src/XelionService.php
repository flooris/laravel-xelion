<?php

namespace Flooris\XelionClient;

use Flooris\XelionClient\HttpClient\XelionApiConnector;
use Flooris\XelionClient\Model\XelionApiCredentialsModel;
use Flooris\XelionClient\ModelPaginator\XelionUserPaginator;

class XelionService
{
    protected ?XelionApiConnector $connector = null;

    public function connect(XelionApiCredentialsModel $credentials): self
    {
        $this->connector = new XelionApiConnector($credentials);

        if ($this->connector->missingToken()) {
            $authenticator = $this->connector->getAuthenticator();
            $authModel     = $authenticator->getAuthModel();

            $this->connector->setToken($authModel->authentication);
        }

        return $this;
    }

    public function connector(): ?XelionApiConnector
    {
        return $this->connector;
    }

    public function userPaginator(): XelionUserPaginator
    {
        return new XelionUserPaginator($this->connector);
    }
}
