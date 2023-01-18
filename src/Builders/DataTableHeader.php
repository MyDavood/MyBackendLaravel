<?php namespace Backend\Laravel\Builders;

use JsonSerializable;

class DataTableHeader implements JsonSerializable
{
    private string $label;
    private int $width = 0;
    private int $minWidth = 0;
    private string $dir = "rtl";
    private string $alignment = "center";
    private bool $sortable = false;

    private function __construct(
        public string $name
    ){}

    public static function make(string $name): DataTableHeader
    {
        return new static($name);
    }

    public function label(string $label): DataTableHeader
    {
        $this->label = $label;

        return $this;
    }

    public function width(int $width): DataTableHeader
    {
        $this->width = $width;

        return $this;
    }

    public function minWidth(int $minWidth): DataTableHeader
    {
        $this->minWidth = $minWidth;

        return $this;
    }

    public function isLTR(): DataTableHeader
    {
        $this->dir = "ltr";

        return $this;
    }

    public function isLeftAlign(): DataTableHeader
    {
        $this->alignment = "left";

        return $this;
    }

    public function isRightAlign(): DataTableHeader
    {
        $this->alignment = "right";

        return $this;
    }

    public function sortable(): DataTableHeader
    {
        $this->sortable = true;

        return $this;
    }


    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'label' => $this->label,
            'sortable' => $this->sortable,
            'minWidth' => $this->minWidth,
            'width' => $this->width,
            'dir' => $this->dir,
            'align' => $this->alignment,
        ];
    }
}
