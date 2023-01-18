<?php namespace Backend\Laravel\Builders;

use JsonSerializable;

class DataTableSearchField implements JsonSerializable
{
    private string $label;
    private array $items;
    public bool $isNumber = false;
    private bool $isDropDown = false;
    public mixed $defaultValue = null;

    private function __construct(
        public string $name
    )
    {
    }

    public static function make(string $name): DataTableSearchField
    {
        return new static($name);
    }

    public function label(string $label): DataTableSearchField
    {
        $this->label = $label;

        return $this;
    }

    public function isNumber(): DataTableSearchField
    {
        $this->isNumber = true;

        return $this;
    }

    public function input(): DataTableSearchField
    {
        $this->isDropDown = false;

        return $this;
    }

    public function dropDown(array $items): DataTableSearchField
    {
        $this->items = $items;
        $this->isDropDown = true;

        return $this;
    }

    public function defaultValue($value): DataTableSearchField {
        $this->defaultValue = $value;

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        $result = [
            'name' => $this->name,
            'label' => $this->label,
            'number' => $this->isNumber,
        ];

        if ($this->isDropDown) {
            $result['items'] = $this->items;
        }

        return $result;
    }
}
