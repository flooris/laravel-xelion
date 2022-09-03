<?php

namespace Flooris\XelionClient\ModelPaginator;

use Illuminate\Support\Collection;
use Flooris\XelionClient\XelionApi;
use Flooris\XelionClient\Model\XelionApiUserModel;
use Flooris\XelionClient\HttpClient\XelionApiConnector;
use Flooris\XelionClient\Model\XelionApiPhoneLineModel;

class XelionPhoneLinePaginator
{
    protected XelionApi $client;
    protected Collection $phoneLines;
    protected int $currentPage = 1;
    protected ?int $lastObjectId = null;

    public function __construct(
        private readonly XelionApiConnector $connector,
        private readonly int                $pageSize = 100,
    )
    {
        $this->client     = new XelionApi($this->connector);
        $this->phoneLines = collect();
    }

    public function getAll(bool $full = false): Collection
    {
        $items = [];

        while ($this->isFirstPage() ||
               $this->hasMore($items)
        ) {
            // ToDo: Make Object Class (helper) for $result (evaluate if it has data and getting the lastObjectId)
            $result = $this->getPageItems();

            if (count($result['data'])) {
                foreach ($result['data'] as $item) {
                    $xelionApiPhoneLineModel = new XelionApiPhoneLineModel($item);

                    if ($full) {
                        $xelionApiPhoneLineModel = $this->getItem($xelionApiPhoneLineModel->objectId);
                    }

                    $this->phoneLines->push($xelionApiPhoneLineModel);
                }

                $this->lastObjectId = $result['meta']['paging']['nextId'];
            }

            $this->currentPage++;
        }

        return $this->phoneLines;
    }

    public function getAllFull(): Collection
    {
        return $this->getAll(true);
    }

    public function getItem(string $objectId): XelionApiPhoneLineModel
    {
        $response = $this->client
            ->phoneLine()
            ->getPhoneLineAsResponse($objectId);

        $dataAsJson = $response->getBody()->getContents();

        $item = json_decode($dataAsJson, true);

        return new XelionApiPhoneLineModel($item);
    }

    private function getPageItems(): array
    {
        $response = $this->client
            ->phoneLine()
            ->getPhoneLinesAsResponse(
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
