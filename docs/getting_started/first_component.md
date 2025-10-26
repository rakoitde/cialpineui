
# First component

CiAlpineUI is fundamentally based on CodeIgniter View Cells. The easiest way to create a new component is to use the CLI command **make:uicomponent**, followed by the name of the component.

I recommend familiarizing yourself with the standard functionalities of [View Cells](https://codeigniter4.github.io/CodeIgniter4/outgoing/view_cells.html) and [Alpine.js](https://alpinejs.dev).

## Create new component

```shell
php spark make:uicomponent New
```

This command creates two files in ```APPPATH/Cells```

### Component: NewCell.php

```php
<?php

namespace App\Cells;

use Rakoitde\CiAlpineUI\Cells\CiAlpineUiComponent;

class NewCell extends CiAlpineUiComponent
{
    //
}
```

Let's modify the **NewCell** component as follows

```php
<?php

namespace App\Cells;

use Rakoitde\CiAlpineUI\Cells\CiAlpineUiComponent;

class NewCell extends CiAlpineUiComponent
{
    public int $count = 0;
    
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
The public property ```$count``` and the two public functions ```increment()``` and ```decrement()``` are used in the view.

### View: new.php

```php
<div <?= $this->getXTags() ?>>
    <!-- Your HTML here -->
</div>
```

Let's modify **New** View as follows

```html
<div <?= $this->getXTags() ?>>
    <button x-on:click="$cell.increment">++</button>
    <span x-text="count"></span>
    <button x-on:click="$cell.decrement">--</button>
    <input type="text" x-model="count">
</div>
```

In the view file, we use the ```$cell``` directive followed by the public function we created in **NewCell** within both buttons to increment and decrement the ```$count``` property.

The public property ```$count``` is used in the ```<span>``` tag to display the value and in the ```<input>``` tag to allow the value to be changed manually.

### Usage

Now we include the **New** component in the layout

```php hl_lines="7"
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

The rendered component looks like this.

```html
<div x-data="{'count':0}" x-component="NewCell">
    <button x-on:click="$cell.increment">++</button>
    <span x-text="count">0</span>
    <button x-on:click="$cell.decrement">--</button>
    <input type="text" x-model="count">
</div>
```

#### Passing Parameters

You can also pass default parameters

```php
<!doctype html>
<head>
    <title>CiAlpineUi</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>
    <?= view_cell('App\Cells\NewCell', ['count' => 10]) ?>
    <?= $this->include('Rakoitde\CiAlpineUI\Views\CiAlpineUiJs') ?>
</body>
</html>
```