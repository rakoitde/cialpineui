<?php

namespace Rakoitde\CiAlpineUI\Cells;

class CiAlpineUiComponentTestCell extends CiAlpineUiComponent
{
    public $canAccess = false;
    public bool $boolVal;
    public int $intVal;
    public float $floatVal;
    public string $stringVal;

    public function testAsHtml()
    {
    }

    public function testAsJson()
    {
        $this->asJson();
    }

    public function testAsJsonWithProperties()
    {
        $this->asJson(['canAccess']);
    }

    public function canAccessTestNoPermission(): bool
    {
        return false;
    }

    public function testNoPermission()
    {
    }
}
