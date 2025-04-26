<?php

namespace Rakoitde\CiAlpineUI\Cells;

use CodeIgniter\Test\CIUnitTestCase;
use Rakoitde\CiAlpineUI\Cells\CiAlpineUiComponent;

class CiAlpineUiComponentTest extends CIUnitTestCase
{

    public function testReturnAsHtml()
    {
        $ciAlpineUiComponent = new CiAlpineUiComponent();

        $this->assertTrue($ciAlpineUiComponent->returnAsHtml());

        $privateMethod = $this->getPrivateMethodInvoker($ciAlpineUiComponent, 'asJson');
        $privateMethod(['test']);
        $this->assertFalse($ciAlpineUiComponent->returnAsHtml());

        $this->setPrivateProperty($ciAlpineUiComponent, 'returnAsHtml', true);
        $this->assertTrue($this->getPrivateProperty($ciAlpineUiComponent, 'returnAsHtml'));
        
        $this->setPrivateProperty($ciAlpineUiComponent, 'returnAsHtml', false);
        $this->assertFalse($this->getPrivateProperty($ciAlpineUiComponent, 'returnAsHtml'));
    }

    public function testGetOnlyPublicProperties()
    {
        $ciAlpineUiComponent = new CiAlpineUiComponent();

        $this->assertIsArray($ciAlpineUiComponent->getOnlyPublicProperties());
        $this->assertEquals([], $ciAlpineUiComponent->getOnlyPublicProperties());
    }

    public function testGetXDataTag()
    {
        $ciAlpineUiComponent = new CiAlpineUiComponent();
        $this->assertEquals('x-data="[]"', $ciAlpineUiComponent->getXDataTag());
    }

    public function testGetXComponentTag()
    {
        $ciAlpineUiComponent = new CiAlpineUiComponent();
        $this->assertEquals('x-component="Rakoitde\CiAlpineUI\Cells\CiAlpineUiComponent"', $ciAlpineUiComponent->getXComponentTag());
    }
    
    public function testGetXTags()
    {
        $ciAlpineUiComponent = new CiAlpineUiComponent();
        $this->assertEquals('x-data="[]" x-component="Rakoitde\CiAlpineUI\Cells\CiAlpineUiComponent"', $ciAlpineUiComponent->getXTags());
    }

}