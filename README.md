# CiAlpineUI

**CiAlpineUI** is a library for **CodeIgniter 4** that provides an elegant way to build UI components (Cells) powered by **Alpine.js**. It is designed to seamlessly integrate dynamic front-end behavior within your CodeIgniter 4 applications.

## Features

- Component-based architecture for CodeIgniter 4.
- Fully integrated with Alpine.js for lightweight interactivity.

## Installation

```bash
composer require rakoitde/cialpineui
```

Or if you are developing locally:

```bash
git clone https://github.com/rakoitde/cialpineui.git
cd cialpineui
composer install
```

## Requirements

- PHP 8.3+
- CodeIgniter 4

## Usage

1. Create new Cell

```bash
php spark make:uicomponent New
```

Modify **New** Component:

```php
<?php

namespace App\Cells;

use Rakoitde\CiAlpineUI\Cells\CiAlpineUiComponent;

class NewCell extends CiAlpineUiComponent
{
    public $count = 0;
    
    public function increment()
    {
        $this->count++;
    }

    public function decrement()
    {
        $this->count--;
    }
}
```

2. Modify **New** View (`app/Cells/new.php`):

```html
<div <?= $this->getXTags() ?>>
    <button x-on:click="$cell.increment">++</button>
    <span x-text="count"></span>
    <button x-on:click="$cell.decrement">--</button>
    <input type="text" x-model="count">
</div>
```

3. Include **AlpineJS**, **CiAlpineUiJs** and the **New** component in your layout

```php
<!doctype html>
<head>
    <title>CiAlpineUi</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>
    <?= view_cell('App\Cells\NewCell') ?>
    <?= $this->include('Rakoitde\CiAlpineUI\Views\CiAlpineUiJs') ?>
</body>
</html>
```

4. Rendered component

```php
<div x-data="{'count':0}" x-component="NewCell">
    <button x-on:click="$cell.increment">++</button>
    <span x-text="count">0</span>
    <button x-on:click="$cell.decrement">--</button>
    <input type="text" x-model="count">
</div>
```

## Development

Scripts available:

```bash
composer analyze    # Static analysis (phpstan, psalm, rector)
composer test       # Run PHPUnit tests
composer cs         # Check coding style
composer cs-fix     # Fix coding style
```

## License

This project is licensed under the MIT License.

## Contributing

Contributions, issues, and feature requests are welcome!
Feel free to check [issues page](https://github.com/rakoitde/cialpineui/issues) if you want to contribute.

## Roadmap

- [ ] Publish initial stable version
- [ ] Expand documentation and examples
- [ ] Create a set of common UI components

