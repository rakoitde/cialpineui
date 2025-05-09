<?php declare(strict_types = 1);

$ignoreErrors = [];
$ignoreErrors[] = [
	'message' => '#^Call to an undefined method ReflectionType::getName\\(\\)\\.$#',
	'identifier' => 'method.notFound',
	'count' => 1,
	'path' => __DIR__ . '/src/Controllers/CiAlpineUiController.php',
];
$ignoreErrors[] = [
	'message' => '#^Variable \\$this might not be defined.$#',
	'identifier' => 'variable.undefined',
	'count' => 1,
	'path' => __DIR__ . '/src/Cells/ci_alpine_ui_component_test_cell.php',
];
$ignoreErrors[] = [
	'message' => '#^Variable \\$routes might not be defined.$#',
	'identifier' => 'variable.undefined',
	'count' => 1,
	'path' => __DIR__ . '/src/Config/Routes.php',
];

return ['parameters' => ['ignoreErrors' => $ignoreErrors]];
