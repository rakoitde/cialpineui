<?php

namespace Config {

    /**
     * Core App Configuration
     */
    class App
    {
        /** @var string */
        public string $baseURL;
        /** @var string */
        public string $charset;
        /** @var string */
        public string $defaultLocale;
        /** @var bool */
        public bool $forceGlobalSecureRequests;
    }

    /**
     * Generators Config for CodeIgniter CLI
     */
    class Generators
    {
        /**
         * @var array<string, array<string, string>>
         */
        public array $views = [];
    }

    /**
     * Services Config (usually dynamically resolved)
     */
    class Services
    {
        /**
         * @template T
         * @param string $name
         * @return T
         */
        public static function getSharedInstance(string $name) {}
    }
}

namespace {
    use CodeIgniter\HTTP\ResponseInterface;
    use CodeIgniter\HTTP\RequestInterface;
    use CodeIgniter\HTTP\RedirectResponse;
    use CodeIgniter\HTTP\URI;
    use CodeIgniter\Router\RouteCollection;

    // ---- Global Variables ----
    /** @var RouteCollection $routes */
    $routes = new RouteCollection();

    // ---- Common Helpers ----

    /**
     * Get the current response instance
     * @return ResponseInterface
     */
    function response(): ResponseInterface {}

    /**
     * Get the current request instance
     * @return RequestInterface
     */
    function request(): RequestInterface {}

    /**
     * Get the current URI instance
     * @return URI
     */
    function uri(): URI {}

    /**
     * Redirect to a specific URI
     * @param string|null $uri
     * @param string $method
     * @param int|null $code
     * @return RedirectResponse
     */
    function redirect(string $uri = null, string $method = 'auto', ?int $code = null): RedirectResponse {}

    /**
     * Load helpers
     * @param string|array $filename
     * @return void
     */
    function helper($filename): void {}

    /**
     * Escape data for HTML
     * @param string|null $str
     * @param string $context
     * @param string $encoding
     * @param bool $doubleEncode
     * @return string|null
     */
    function esc(?string $str, string $context = 'html', string $encoding = 'UTF-8', bool $doubleEncode = true): ?string {}

    /**
     * Get environment value
     * @return string
     */
    function environment(): string {}

    // ---- Additional Utility Functions ----

    /**
     * Retrieve config class instance
     *
     * @template T of object
     * @param class-string<T>|null $name
     * @return T
     */
    function config(?string $name = null): object {}

    /**
     * Convert CamelCase to snake_case
     * @param string $word
     * @return string
     */
    function decamelize(string $word): string {}

    /**
     * Get the class basename
     * @param string|object $class
     * @return string
     */
    function class_basename($class): string {}
}