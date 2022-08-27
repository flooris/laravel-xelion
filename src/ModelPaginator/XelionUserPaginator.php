<?php

namespace Flooris\XelionClient\ModelPaginator;

use App\Models\XelionToken;
use Illuminate\Support\Collection;
use App\Models\XelionApiCredential;
use Illuminate\Support\Facades\Crypt;
use Flooris\XelionClient\XelionApi;
use Flooris\XelionClient\Model\XelionApiUserModel;
use Flooris\XelionClient\HttpClient\XelionApiConnector;

class XelionUserPaginator
{
    protected XelionApi $client;
    protected Collection $users;
    protected int $currentPage = 1;
    protected ?int $lastObjectId = null;

    public function __construct(
        private readonly XelionApiConnector $connector,
        private readonly int $pageSize = 100,
    )
    {
        $this->client    = new XelionApi($this->connector);
        $this->users     = collect();
    }

    public function getAll(): Collection
    {
        $items = [];

        while ($this->isFirstPage() ||
               $this->hasMore($items)
        ) {
            // ToDo: Make Object Class (helper) for $result (evaluate if it has data and getting the lastObjectId)
            $result = $this->getPageItems();

            if (count($result['data'])) {
                foreach ($result['data'] as $item) {
                    $this->users->push(new XelionApiUserModel($item));
                }

                $this->lastObjectId = $result['meta']['paging']['nextId'];
            }

            $this->currentPage++;
        }

        return $this->users;
    }

    public function getItem(string $objectId): XelionApiUserModel
    {
        $response = $this->client
            ->user()
            ->getUserAsResponse($objectId);

        $dataAsJson = $response->getBody()->getContents();

        $item = json_decode($dataAsJson, true);

        return new XelionApiUserModel($item);
    }

    private function getPageItems(): array
    {
        $response = $this->client
            ->user()
            ->getUsersAsResponse(
                $this->pageSize,
                $this->lastObjectId
            );

        $dataAsJson = $response->getBody()->getContents();

        return json_decode($dataAsJson, true);
    }

    private function isFirstPage(): bool
    {
        return $this->currentPage === 1;
    }

    private function hasMore(array $items): bool
    {
        return count($items) === $this->pageSize;
    }
}
