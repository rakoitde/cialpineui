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
            'component' => ['name' => \Rakoitde\CiAlpineUI\Cells\CiAlpineUiComponentTestCell::class],
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
            'component' => ['name' => \Rakoitde\CiAlpineUI\Cells\CiAlpineUiComponentTestCell::class],
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
            'component' => ['name' => \Rakoitde\CiAlpineUI\Cells\CiAlpineUiComponentTestCell::class],
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

        $ciAlpineUiComponent = (new CiAlpineUiComponentTestCell())->testNoPermission();
        
        $body = json_encode([
            'component' => ['name' => \Rakoitde\CiAlpineUI\Cells\CiAlpineUiComponentTestCell::class],
            'request' =>['action' => 'testAsHtml'],
        ]);
        
        $result = $this->withRequest($request)
        ->withBody($body)
        ->controller(CiAlpineUiController::class)
        ->execute('index');

        $json = \json_decode($result->getJSON());

        $this->assertEquals('<div x-data="{\'canAccess\':false,\'boolVal\':false,\'intVal\':0,\'floatVal\':0,\'stringVal\':\'\',\'arrayVal\':[]}" x-component="Rakoitde\CiAlpineUI\Cells\CiAlpineUiComponentTestCell"></div>', $json->html);
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
            'component' => ['name' => \Rakoitde\CiAlpineUI\Cells\CiAlpineUiComponentTestCell::class],
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
            'component' => ['name' => \Rakoitde\CiAlpineUI\Cells\CiAlpineUiComponentTestCell::class],
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

    public function testTestDataFormat()
    {

        $request = new \CodeIgniter\HTTP\IncomingRequest(
            new \Config\App(),
            new \CodeIgniter\HTTP\URI('http://example.com/component'),
            null,
            new \CodeIgniter\HTTP\UserAgent(),
        );

        $body = [
            'component' => ['name' => \Rakoitde\CiAlpineUI\Cells\CiAlpineUiComponentTestCell::class],
            'data'      => [
                'boolVal'   => true,
                'intVal'    => 1,
                'doubleVal' => 1.234,
                'floatVal'  => 1.123,
                'stringVal' => 'String',
                'arrayVal'  => ['Array'],
            ],
            'request'   => ['action' => 'testAsHtml'],
        ];

        $ciAlpineUiComponent = new CiAlpineUiComponentTestCell();
        $ciAlpineUiComponent->render();

        $result = $this  #->withRequest($request)
        ->withBody(json_encode($body))
        ->controller(CiAlpineUiController::class)
        ->execute('index');

        $json = json_decode($result->response()->getJSON());

        $this->assertEquals('<div x-data="{\'canAccess\':false,\'boolVal\':true,\'intVal\':1,\'floatVal\':1.123,\'stringVal\':\'String\',\'arrayVal\':[\'Array\']}" x-component="Rakoitde\CiAlpineUI\Cells\CiAlpineUiComponentTestCell"></div>', $json->html);
        $result->assertStatus(200);
    }

    public function testComponentCouldRender()
    {
        $ciAlpineUiComponent = new CiAlpineUiComponentTestCell();
        $this->assertEquals('<div x-data="{\'canAccess\':false,\'boolVal\':false,\'intVal\':0,\'floatVal\':0,\'stringVal\':\'\',\'arrayVal\':[]}" x-component="Rakoitde\CiAlpineUI\Cells\CiAlpineUiComponentTestCell"></div>', $ciAlpineUiComponent->render());
    }

}