<?php

namespace Backend\Laravel\Resources;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\CollectsResources;

class PaginatedData implements Arrayable
{
    use CollectsResources;

    public function __construct(
        public LengthAwarePaginator $items,
        public string $collects,
    ) {
    }

    public function toArray(): array
    {
        $this->collectResource($this->items);

        return [
            'items' => $this->collection,
            'meta' => [
                'currentPage' => $this->items->currentPage(),
                'totalPage' => $this->items->lastPage(),
                'from' => $this->items->firstItem(),
                'to' => $this->items->lastItem(),
                'total' => $this->items->total(),
                'perPage' => $this->items->perPage(),
            ],
        ];
    }
}
