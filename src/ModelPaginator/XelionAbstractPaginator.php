<?php

namespace Flooris\XelionClient\ModelPaginator;

use Illuminate\Support\Collection;
use Flooris\XelionClient\XelionApi;
use Flooris\XelionClient\Endpoint\AbstractEndpoint;
use Flooris\XelionClient\Model\XelionAbstractModel;
use Flooris\XelionClient\HttpClient\XelionApiConnector;
use Flooris\XelionClient\Model\XelionApiAddressableModel;

abstract class XelionAbstractPaginator
{
    protected XelionApi $client;
    protected Collection $itemCollection;
    protected int $currentPage = 1;
    protected int $currentPageItemCounter = 0;
    protected ?int $lastObjectId = null;
    protected string $modelClass;
    protected AbstractEndpoint $endpoint;

    public function __construct(
        private readonly XelionApiConnector $connector,
        private readonly int                $pageSize = 100,
    )
    {
        $this->client         = new XelionApi($this->connector);
        $this->itemCollection = collect();
    }

    public function getAll(bool $full = false): Collection
    {
        while ($this->isFirstPage() ||
               $this->hasMore()
        ) {
            $this->getPage($full)->each(function ($item) {
                $this->itemCollection->push($item);
            });
        }

        return $this->itemCollection;
    }

    public function getAllFull(): Collection
    {
        return $this->getAll(true);
    }

    public function getItem(string $objectId): XelionAbstractModel
    {
        $response = $this->endpoint->getSingleObjectAsResponse($objectId);

        $dataAsJson = $response->getBody()->getContents();

        $item = json_decode($dataAsJson, true);

        return new $this->modelClass($item);
    }

    public function getPageItems(): array
    {
        $response = $this->endpoint->getObjectListAsResponse(
            $this->pageSize,
            $this->lastObjectId
        );

        $dataAsJson = $response->getBody()->getContents();

        return json_decode($dataAsJson, true);
    }

    public function getPage(bool $full = false): Collection
    {
        $itemCollection = collect();

        // ToDo: Make Object Class (helper) for $result (evaluate if it has data and getting the lastObjectId)
        $result = $this->getPageItems();

        if (count($result['data'])) {
            foreach ($result['data'] as $item) {
                $itemModel = new $this->modelClass($item);

                if ($full) {
                    $itemModel = $this->getItem($itemModel->objectId);
                }

                $itemCollection->push($itemModel);
            }

            $this->lastObjectId = $result['meta']['paging']['nextId'];
        }

        $this->currentPage++;
        $this->currentPageItemCounter = $itemCollection->count();

        return $itemCollection;
    }

    public function isFirstPage(): bool
    {
        return $this->currentPage === 1;
    }

    public function hasMore(): bool
    {
        return $this->currentPageItemCounter === $this->pageSize;
    }
}
