<?php

namespace Junges\Pix\Api\Features\PayloadLocation;

use Junges\Pix\Api\Api;
use Junges\Pix\Api\Contracts\ApplyApiFilters;
use Junges\Pix\Api\Contracts\ConsumesPayloadLocationEndpoints;
use Junges\Pix\Api\Contracts\FilterApiRequests;
use Junges\Pix\Support\Endpoints;

class PayloadLocation extends Api implements ConsumesPayloadLocationEndpoints, FilterApiRequests
{
    private array $filters;

    public function withFilters($filters): PayloadLocation
    {
        $this->filters = $filters instanceof ApplyApiFilters
            ? $filters->toArray()
            : $filters;

        return $this;
    }

    public function create(string $loc): array
    {
        $endpoint = $this->baseUrl . Endpoints::CREATE_PAYLOAD_LOCATION;

        return $this->request()->post($endpoint, ['tipoCob' => $loc])->json();
    }

    public function getById(string $id): array
    {
        $endpoint = $this->baseUrl . Endpoints::GET_PAYLOAD_LOCATION . $id;

        return $this->request()->get($endpoint)->json();
    }

    public function detachChargeFromLocation(string $id): array
    {
        $endpoint = $this->baseUrl . Endpoints::DETACH_CHARGE_FROM_LOCATION . $id . Endpoints::PAYLOAD_LOCATION_TXID;

        return $this->request()->delete($endpoint)->json();
    }

    public function all(): array
    {
        $endpoint = $this->baseUrl . Endpoints::GET_PAYLOAD_LOCATION;

        return $this->request()
            ->get($endpoint, $this->getFilters($this->filters ?? []))
            ->json();
    }
}