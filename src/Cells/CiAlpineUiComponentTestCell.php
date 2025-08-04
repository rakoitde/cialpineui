<?php

namespace Rakoitde\CiAlpineUI\Cells;

class CiAlpineUiComponentTestCell extends CiAlpineUiComponent
{
    public $canAccess        = false;
    public bool $boolVal     = false;
    public int $intVal       = 0;
    public float $floatVal   = 0.00;
    public string $stringVal = '';
    public array $arrayVal   = [];

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
