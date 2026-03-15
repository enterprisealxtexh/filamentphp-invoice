<?php

namespace Alxtexh\FilamentInvoices\Services\Templates;

use InvalidArgumentException;
use Alxtexh\FilamentInvoices\Contracts\InvoiceTemplateInterface;

class TemplateFactory
{
    /** @var array<string, class-string<InvoiceTemplateInterface>> */
    protected static array $templates = [];

    public static function register(string $name, string $templateClass): void
    {
        if (! is_subclass_of($templateClass, InvoiceTemplateInterface::class)) {
            throw new InvalidArgumentException(
                "Template class [{$templateClass}] must implement " . InvoiceTemplateInterface::class
            );
        }

        static::$templates[$name] = $templateClass;
    }

    public static function make(string $name): InvoiceTemplateInterface
    {
        if (! isset(static::$templates[$name])) {
            throw new InvalidArgumentException("Template [{$name}] is not registered.");
        }

        return app(static::$templates[$name]);
    }

    public static function has(string $name): bool
    {
        return isset(static::$templates[$name]);
    }

    /** @return array<string> */
    public static function getRegisteredNames(): array
    {
        return array_keys(static::$templates);
    }

    /** @return array<string, string> */
    public static function getOptions(): array
    {
        $options = [];

        foreach (static::$templates as $name => $class) {
            $template = app($class);
            $options[$name] = $template->getLabel();
        }

        return $options;
    }

    /** @return array<string, InvoiceTemplateInterface> */
    public static function all(): array
    {
        $templates = [];

        foreach (static::$templates as $name => $class) {
            $templates[$name] = app($class);
        }

        return $templates;
    }

    public static function clear(): void
    {
        static::$templates = [];
    }
}
