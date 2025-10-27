# $cell-Directive

The $cell directive allows us to access public methods of the view cell in the backend from the Alpine.js component.

## Access Cell View Methods

The simplest usage is a method without parameters.

```php
<?php
    public function increment()
    {
        $this->count++;
    }
```

```$cell.increment``` executes this method in the backend.

```html
<div <?= $this->getXTags() ?>>
    <button x-on:click="$cell.increment">++</button>
    <span x-text="count"></span>
</div>
```

### Parameter

Passing parameters to public methods is also possible. 

```php
<?php
    public string $name = '';
    public int $age = 0;

    public function setNameAndAge(string $name, int $age)
    {
        $this->name = $name;
        $this->age  = $age;
    }
```

It is important to ensure that the parameters passed correspond to the types expected in the method.

```html
    <button x-on:click="$cell.setNameAndAge('Tom', 21)">Tom, 21</button>
    <span x-text="name"></span>
    <span x-text="age"></span>
```

The wrong format, as in this example, throws an error message.

```html
    <button x-on:click="$cell.setNameAndAge(21, 'Tom')">21, Tom</button>
```

### Interval

Intervals can also be used very easily. To do this, the directive is added after the method call using the `interval` keyword. The interval in milliseconds is passed as the first parameter.

It can be used, for example, in the `x-init` attribute of an element.

```html hl_lines="3"
<div <?= $this->getXTags() ?>>
    <button 
        x-init="$cell.increment.interval(5000)" 
        x-on:click="$cell.increment">++</button>
    <span x-text="count"></span>
    <button x-on:click="$cell.decrement">--</button>
    <input type="text" x-model="count">
    <span x-text="message"></span>
</div>
```

It is also possible to append further parameters to the interval.

```html
x-init="$cell.method.interval(5000, param1, param2, ...)" 
```
