## Installation

### Troubleshooting

If you get the following error:

???+ Warning
    Could not find a version of package codeigniter4/shield matching your minimum-stability (stable).

    Require it with an explicit version constraint allowing its desired stability.

Run the following commands to change your minimum-stability in your project composer.json:

```
composer config minimum-stability dev
composer config prefer-stable true
```

### Install

Install the library as required

```
composer require rakoitde/cialpineui
```

or if you are developing locally you can clone the library

```bash
git clone https://github.com/rakoitde/cialpineui.git
cd cialpineui
composer install
```

## Prepare Layout

Include **AlpineJS** and **CiAlpineUiJs** in your layout

```php hl_lines="4 7"
<!doctype html>
<head>
    <title>CiAlpineUi</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>
    <?= $this->include('Rakoitde\CiAlpineUI\Views\CiAlpineUiJs') ?>
</body>
</html>
```