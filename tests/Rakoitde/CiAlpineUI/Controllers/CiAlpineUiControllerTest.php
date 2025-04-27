<?php

namespace Rakoitde\CiAlpineUI\Cells;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;

use Rakoitde\CiAlpineUI\Controllers\CiAlpineUiController;

class CiAlpineUiControllerTest extends CIUnitTestCase
{

    use ControllerTestTrait;

    public function testNoComponentFound()
    {
        
        $request = new \CodeIgniter\HTTP\IncomingRequest(
            new \Config\App(),
            new \CodeIgniter\HTTP\URI('http://example.com/component'),
            null,
            new \CodeIgniter\HTTP\UserAgent(),
        );

        $result = $this->withRequest($request)
            ->controller(CiAlpineUiController::class)
            ->execute('index');
        $json = \json_decode($result->getJSON());

        $this->assertEquals('No component found', $json->messages->error);
        $result->assertStatus(400);
        
    }
    public function testNoActionSend()
    {
        
        $request = new \CodeIgniter\HTTP\IncomingRequest(
            new \Config\App(),
            new \CodeIgniter\HTTP\URI('http://example.com/component'),
            null,
            new \CodeIgniter\HTTP\UserAgent(),
        );

        $body = json_encode([
            'component' => ['name' => 'Rakoitde\CiAlpineUI\Cells\CiAlpineUiComponentTestCell'],
        ]);

        $result = $this->withRequest($request)
            ->withBody($body)
            ->controller(CiAlpineUiController::class)
            ->execute('index');
        $json = \json_decode($result->getJSON());
            
        $this->assertEquals('no Action send', $json->messages->error);
        $result->assertStatus(400);
        
    }

    public function testActionNotFound()
    {
        
        $request = new \CodeIgniter\HTTP\IncomingRequest(
            new \Config\App(),
            new \CodeIgniter\HTTP\URI('http://example.com/component'),
            null,
            new \CodeIgniter\HTTP\UserAgent(),
        );

        $body = json_encode([
            'component' => ['name' => 'Rakoitde\CiAlpineUI\Cells\CiAlpineUiComponentTestCell'],
            'request' =>['action' => 'notFound'],
        ]);

        $result = $this->withRequest($request)
            ->withBody($body)
            ->controller(CiAlpineUiController::class)
            ->execute('index');
        $json = \json_decode($result->getJSON());
            
        $this->assertEquals("Method 'notFound' not found in component 'Rakoitde\CiAlpineUI\Cells\CiAlpineUiComponentTestCell'", $json->messages->error);
        $result->assertStatus(400);
        
    }

    public function testTestMethodNoPermission()
    {
        
        $request = new \CodeIgniter\HTTP\IncomingRequest(
            new \Config\App(),
            new \CodeIgniter\HTTP\URI('http://example.com/component'),
            null,
            new \CodeIgniter\HTTP\UserAgent(),
        );
        
        $body = json_encode([
            'component' => ['name' => 'Rakoitde\CiAlpineUI\Cells\CiAlpineUiComponentTestCell'],
            'request' =>['action' => 'testNoPermission'],
        ]);
        
        $result = $this->withRequest($request)
        ->withBody($body)
        ->controller(CiAlpineUiController::class)
        ->execute('index');

        $json = \json_decode($result->getJSON());

        $this->assertEquals("You have no permission to access 'testNoPermission' in component 'Rakoitde\CiAlpineUI\Cells\CiAlpineUiComponentTestCell'", $json->messages->error);
        $result->assertStatus(403);
    }

    public function testTestMethodHtmlResult()
    {
        
        $request = new \CodeIgniter\HTTP\IncomingRequest(
            new \Config\App(),
            new \CodeIgniter\HTTP\URI('http://example.com/component'),
            null,
            new \CodeIgniter\HTTP\UserAgent(),
        );

        $ciAlpineUiComponent = new CiAlpineUiComponentTestCell();
        $ciAlpineUiComponent->testNoPermission();
        
        $body = json_encode([
            'component' => ['name' => 'Rakoitde\CiAlpineUI\Cells\CiAlpineUiComponentTestCell'],
            'request' =>['action' => 'testAsHtml'],
        ]);
        
        $result = $this->withRequest($request)
        ->withBody($body)
        ->controller(CiAlpineUiController::class)
        ->execute('index');

        $json = \json_decode($result->getJSON());

        $this->assertEquals('<div x-data="{\'canAccess\':false}" x-component="Rakoitde\CiAlpineUI\Cells\CiAlpineUiComponentTestCell"></div>', $json->html);
        $result->assertStatus(200);
    }

    public function testTestMethodJsonResult()
    {
        
        $request = new \CodeIgniter\HTTP\IncomingRequest(
            new \Config\App(),
            new \CodeIgniter\HTTP\URI('http://example.com/component'),
            null,
            new \CodeIgniter\HTTP\UserAgent(),
        );
        
        $body = json_encode([
            'component' => ['name' => 'Rakoitde\CiAlpineUI\Cells\CiAlpineUiComponentTestCell'],
            'request' =>['action' => 'testAsJson'],
        ]);
        
        $result = $this->withRequest($request)
        ->withBody($body)
        ->controller(CiAlpineUiController::class)
        ->execute('index');

        $json = \json_decode($result->getJSON());

        $this->assertFalse($json->canAccess);
        $result->assertStatus(200);
    }

    public function testTestMethodJsonResultWithProperties()
    {
        
        $request = new \CodeIgniter\HTTP\IncomingRequest(
            new \Config\App(),
            new \CodeIgniter\HTTP\URI('http://example.com/component'),
            null,
            new \CodeIgniter\HTTP\UserAgent(),
        );
        
        $body = json_encode([
            'component' => ['name' => 'Rakoitde\CiAlpineUI\Cells\CiAlpineUiComponentTestCell'],
            'request' =>['action' => 'testAsJsonWithProperties'],
        ]);
        
        $result = $this->withRequest($request)
        ->withBody($body)
        ->controller(CiAlpineUiController::class)
        ->execute('index');

        $json = \json_decode($result->getJSON());

        $this->assertFalse($json->canAccess);
        $result->assertStatus(200);
    }

    public function testTestComponentClassNotExists()
    {
        
        $request = new \CodeIgniter\HTTP\IncomingRequest(
            new \Config\App(),
            new \CodeIgniter\HTTP\URI('http://example.com/component'),
            null,
            new \CodeIgniter\HTTP\UserAgent(),
        );
        
        $body = json_encode([
            'component' => ['name' => 'Rakoitde\CiAlpineUI\Cells\CiAlpineUiComponentNotExists'],
            'request' =>['action' => 'testAsJsonWithProperties'],
        ]);
        
        $result = $this->withRequest($request)
        ->withBody($body)
        ->controller(CiAlpineUiController::class)
        ->execute('index');

        $json = \json_decode($result->getJSON());

        $this->assertEquals('No component found', $json->messages->error);
        $result->assertStatus(400);
    }

    public function testTestComponentIsNotAnInstanceOfCiComponent()
    {
        
        $request = new \CodeIgniter\HTTP\IncomingRequest(
            new \Config\App(),
            new \CodeIgniter\HTTP\URI('http://example.com/component'),
            null,
            new \CodeIgniter\HTTP\UserAgent(),
        );
        
        $body = json_encode([
            'component' => ['name' => 'App\Controllers\Home'],
            'request' =>['action' => 'testAsJsonWithProperties'],
        ]);
        
        $this->expectException(\Exception::class);

        $result = $this->withRequest($request)
        ->withBody($body)
        ->controller(CiAlpineUiController::class)
        ->execute('index');
    }

    public function testComponentCouldRender()
    {
        $ciAlpineUiComponent = new CiAlpineUiComponentTestCell();
        $this->assertEquals('<div x-data="{\'canAccess\':false}" x-component="Rakoitde\CiAlpineUI\Cells\CiAlpineUiComponentTestCell"></div>', $ciAlpineUiComponent->render());
    }

}