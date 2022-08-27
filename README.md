
# Getting started
Install package using composer
```bash
composer require flooris/laravel-xelion
```

# Example script
Get Xelion Users as a Collection

```php
use Illuminate\Support\Facades\App;
use Flooris\XelionClient\XelionService;
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

/** @var XelionService $service */
$service = App::make(XelionService::class);

$userCollection =  $service->connect($credentials)
    ->userPaginator()
    ->getAll();

```
