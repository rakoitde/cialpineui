<?php

namespace Rakoitde\CiAlpineUI\Config;

class Registrar
{
    public static function Generators(): array
    {
        return [
            'views' => [
                'make:uicomponent' => [
                    'class' => 'Rakoitde\CiAlpineUI\Commands\Views\uicomponent.tpl.php',
                    'view'  => 'Rakoitde\CiAlpineUI\Commands\Views\uicomponent_view.tpl.php',
                ],
            ],
        ];
    }
}
