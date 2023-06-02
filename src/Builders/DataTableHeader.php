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
        public int $width = 0,
        public int $minWidth = 0,
        public Dir $dir = Dir::RTL,
        public Alignment $alignment = Alignment::CENTER,
        public bool $sortable = false,
        public bool $show = true,
    ) {
    }

    public static function make(
        string $name,
        string $label,
        int $width = 0,
        int $minWidth = 0,
        string $dir = 'rtl',
        string $alignment = 'center',
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
