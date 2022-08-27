
# Getting started
Install package using composer
```bash
composer require flooris/laravel-xelion
```

# Example script
Get Xelion Users as a Collection

```php
use Flooris\XelionClient\Model\XelionApiCredentialsModel;
use Flooris\XelionClient\HttpClient\XelionApiConnector;
use Flooris\XelionClient\ModelPaginator\XelionUserPaginator;

$baseUrl = "https://xelion01.example.com";
$username = "some-api-user";
$password = "super-secret";
$version = "v1";
$tenant = "tenant01";
$token = null;

$credentials = new XelionApiCredentialsModel(
  $baseUrl,
  $username,
  $password,
  $version,
  $tenant,
  $token
);

$connector = new XelionApiConnector($credentials);

if ($connector->missingToken()) {
  $authenticator = $connector->getAuthenticator();
  $authModel = $authenticator->getAuthModel();

  $connector->setToken($authModel->authentication);
}

$userPaginator = new XelionUserPaginator($connector);
$userCollection = $userPaginator->getAll();
```
