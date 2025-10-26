# JSON response

Normally, when using a public method, the components are returned as HTML and completely replaced. However, in some cases, this can lead to unwanted display issues. In this case, you can switch the return type to JSON. AlpineJS will then handle the update. This is done using the `asJson()` method.

## asJson()

```php
<?php

namespace App\Cells;

use Rakoitde\CiAlpineUI\Cells\CiAlpineUiComponent;

class NewCell extends CiAlpineUiComponent
{
    public int $count = 0;

    public string $countText = '';

    public function increment()
    {
        $this->count++;
        $this->countText = 'Counter = ' . strval($this->count);

        $this->asJson();
    }
```

The JSON response then looks like this

```json
{
    "count": 1,
    "countText": "Counter = 1"
}
```

## asJson([properties])

For larger or more complex components, you may want to restrict the properties that are returned. To do this, you can pass an array with the desired properties to `asJson()`.

```php
<?php

    public function increment()
    {
        $this->count++;
        $this->countText = 'Counter = ' . strval($this->count);

        $this->asJson(['countText']);
    }
```

The JSON response then looks like this

```json
{
    "countText": "Counter = 1"
}
```