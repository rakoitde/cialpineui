<?php

namespace Rakoitde\CiAlpineUI\Cells;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\View\Cells\Cell;

class CiAlpineUiComponent extends Cell
{
    use ResponseTrait;

    protected $response;
    protected bool $returnAsHtml = true;
    protected ?array $propertiesOnly;

    protected function asJson(?array $propertiesOnly = null): self
    {
        if ($propertiesOnly) {
            $this->propertiesOnly = $propertiesOnly;
        }
        $this->returnAsHtml = false;

        return $this;
    }

    public function returnAsHtml(): bool
    {
        return $this->returnAsHtml;
    }

    public function getXDataTag()
    {
        return 'x-data="' . str_replace('"', "'", json_encode($this->getPublicProperties())) . '"';
    }

    public function getXComponentTag()
    {
        return 'x-component="' . \str_replace('App\Cells\\', '', $this::class) . '"';
    }

    public function getXTags()
    {
        return $this->getXDataTag() . ' ' . $this->getXComponentTag();
    }

    public function getOnlyPublicProperties()
    {
        if (! isset($this->propertiesOnly)) {
            return $this->getPublicProperties();
        }

        $publicProperties = [];

        foreach ($this->getPublicProperties() as $property => $value) {
            if (in_array($property, $this->propertiesOnly, true)) {
                $publicProperties[$property] = $value;
            }
        }

        return $publicProperties;
    }

    public function __construct()
    {
        $this->response = response();
    }
}
