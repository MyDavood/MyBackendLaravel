<?php

namespace Backend\Laravel\Builders;

use JsonSerializable;

class DataTableSearchField implements JsonSerializable
{
    private function __construct(
        public string $name,
        public string $label,
        public bool $isNumber,
        public array $dropDownItems,
        public mixed $defaultValue,
    ) {
    }

    public static function make(
        string $name,
        string $label,
        bool $isNumber = false,
        array $dropDownItems = [],
        mixed $defaultValue = null,
    ): DataTableSearchField {
        return new static(
            name: $name,
            label: $label,
            isNumber: $isNumber,
            dropDownItems: $dropDownItems,
            defaultValue: $defaultValue,
        );
    }

    public function jsonSerialize(): mixed
    {
        $result = [
            'name' => $this->name,
            'label' => $this->label,
            'number' => $this->isNumber,
        ];

        if (count($this->dropDownItems) > 0) {
            $result['items'] = $this->dropDownItems;
        }

        return $result;
    }
}
