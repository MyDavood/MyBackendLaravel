<?php namespace Backend\Laravel\Resources;

use Backend\Laravel\Builders\DataTableSearchField;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\CollectsResources;

abstract class DataTableResource implements Arrayable
{
    use CollectsResources;

    public string $collects;
    public string $path;
    public string $defaultSort = "created_at";
    protected array $allowedParams = [];

    public function __construct(
        public LengthAwarePaginator $items
    )
    {
    }

    abstract public function headers(): array;

    /**
     * @return DataTableSearchField[]
     */
    public function searchFields(): array
    {
        return [];
    }

    private function getVisibleHeaders(): array
    {
        return array_filter($this->headers(), function ($item) {
            return $item->show;
        });
    }

    private function filterParams(): array
    {
        $request = request();
        $params = [];
        $filtersParams = $request->input('filter');

        foreach ($this->searchFields() as $field) {
            if (isset($filtersParams[$field->name])) {
                $params[$field->name] = urldecode($filtersParams[$field->name]);
                if ($field->isNumber) {
                    $params[$field->name] = intval($params[$field->name]);
                }
            } else if($field->defaultValue != null) {
                $params[$field->name] = urldecode($field->defaultValue);
                if ($field->isNumber) {
                    $params[$field->name] = intval($params[$field->name]);
                }
            }
        }

        return $params;
    }

    private function params(): array
    {
        $request = request();
        $params = [];

        foreach ($this->allowedParams as $key => $value) {
            if ($request->has($key)) {
                $v = $request->input($key);

                if ($v != $value) {
                    $params[$key] = urldecode($v);
                }
            }
        }
        return $params;
    }

    public function toArray(): array
    {
        $this->collectResource($this->items);

        return [
            'path' => $this->path,
            'headers' => $this->getVisibleHeaders(),
            'items' => $this->collection,
            'filterParams' => $this->filterParams(),
            'params' => $this->params(),
            'meta' => [
                'sort' => request()->input('sort', $this->defaultSort),
                'defaultSort' => $this->defaultSort,
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
