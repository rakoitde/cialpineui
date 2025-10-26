# Authorization

The ```canAccess``` methods can be used to authorize access to public methods. The return value must be a boolean.
In this example, the can() function from CodeIgniter Shield is used.

```php
<?php

public function increment()
{
    $this->count++;
}

public function canAccessIncrement(): bool
{
    return auth()->user()->can('counter.increment');
}
```

If you do not have permission to use the method, you will receive the following response

```json
{
    "status": 403,
    "error": 403,
    "messages": {
        "error": "You have no permission to access 'increment' in component 'App\\Cells\\NewCell'"
    }
}
```
