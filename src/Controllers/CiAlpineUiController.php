<?php

namespace Rakoitde\CiAlpineUI\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Exception;
use ReflectionClass;
use ReflectionMethod;

class CiAlpineUiController extends ResourceController
{
    protected $component;

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $request = array_merge(
            json_decode(json_encode(request()->getJson()), true) ?? [],
            json_decode(json_encode(request()->getGet()), true) ?? [],
        );

        $this->component = $this->getComponent($request);

        if (null === $this->component) {
            return $this->fail('No component found');
        }
        $this->component->fill($request['data'] ?? []);

        if (! isset($request['request']['action'])) {
            return $this->fail('no Action send');
        }

        $action = $request['request']['action'];

        // Check if action exists
        $viewCellClass = $this->component::class;
        if ($this->isNoPublicAction($action)) {
            return $this->fail("Method '{$action}' not found in component '{$viewCellClass}'");
        }

        if ($this->actionIsForbidden($action)) {
            return $this->failForbidden("You have no permission to access '{$action}' in component '{$viewCellClass}'");
        }

        $params = $request['request']['params'] ?? [];
        call_user_func_array([$this->component, $action], $params);

        if ($this->component->returnAsHtml()) {
            return $this->respond(['html' => $this->component->render()]);
        }

        return $this->respond($this->component->getOnlyPublicProperties());
    }

    protected function getComponent($request)
    {
        if (! isset($request['component'])) {
            return null;
        }

        $viewCellClass = str_replace('/', '\\', $request['component']['name']);
        if (! class_exists($viewCellClass)) {
            $viewCellClass = 'App\Cells\\' . $viewCellClass;
        }

        if (class_exists($viewCellClass)) {
            $viewCellObject = new $viewCellClass();
            if (! ($viewCellObject instanceof \Rakoitde\CiAlpineUI\Cells\CiAlpineUiComponent)) {
                throw new Exception($viewCellClass . ' is not an instanceof \Rakoitde\CiAlpineUI\Cells\CiAlpineUiComponent', 1);
            }

            return $viewCellObject;
        }

        return null;
    }

    protected function getPublicMethodNamesFromClass(): array
    {
        $class   = new ReflectionClass($this->component);
        $methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);

        $nonePublicActions = [
            'returnAsHtml',
            'getXDataTag',
            'getXComponentTag',
            'getXTags',
            '__construct',
            'getOnlyPublicProperties',
            'render',
            'setView',
            '__toString',
            'fill',
            'getPublicProperties',
            'getNonPublicProperties',
        ];

        return array_diff(array_column($methods, 'name'), $nonePublicActions);
    }

    protected function isNoPublicAction($action): bool
    {
        $publicMethodNames = $this->getPublicMethodNamesFromClass($this->component);

        return ! in_array($action, $publicMethodNames, true);
    }

    protected function actionIsForbidden($action): bool
    {
        $method = 'canAccess' . ucfirst($action);

        if ($this->isNoPublicAction($method)) {
            return false;
        }

        return ! call_user_func_array([$this->component, $method], []);
    }
}
