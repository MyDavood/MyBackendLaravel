<?php

namespace Backend\Laravel\Builders;

use Backend\Laravel\Enum\Alignment;
use Backend\Laravel\Enum\Dir;
use JsonSerializable;

class DataTableHeader implements JsonSerializable
{
    private function __construct(
        public string $name,
        public string $label,
        public int $width,
        public int $minWidth,
        public Dir $dir,
        public Alignment $alignment,
        public bool $sortable,
        public bool $show,
    ) {
    }

    public static function make(
        string $name,
        string $label,
        int $width = 0,
        int $minWidth = 0,
        Dir $dir = Dir::RTL,
        Alignment $alignment = Alignment::CENTER,
        bool $sortable = false,
        bool $show = true,
    ): DataTableHeader {
        return new static(
            name: $name,
            label: $label,
            width: $width,
            minWidth: $minWidth,
            dir: $dir,
            alignment: $alignment,
            sortable: $sortable,
            show: $show,
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'label' => $this->label,
            'sortable' => $this->sortable,
            'minWidth' => $this->minWidth,
            'width' => $this->width,
            'dir' => $this->dir->value,
            'align' => $this->alignment->value,
        ];
    }
}
