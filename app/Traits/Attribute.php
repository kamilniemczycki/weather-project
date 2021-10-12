<?php

declare(strict_types=1);

namespace App\Traits;

trait Attribute
{
    protected function getAttribute(string $name): string|null
    {
        return isset($this->{$name}) && !empty($this->{$name}) ? $this->{$name} : null;
    }

    protected function setAttribute(string $name, ?string $value): bool
    {
        if (property_exists($this, $name)) {
            $this->{$name} = $value;
            return true;
        }

        return false;
    }

    public function __call(string $name, array $arguments): string|bool|null
    {
        $methodType = substr($name, 0, 3);
        $methodName = lcfirst(str_replace($methodType, '', $name));

        return match ($methodType) {
            'get' => $this->getAttribute($methodName),
            'set' => $this->setAttribute($methodName, $arguments[0] ?? ''),
            default => null,
        };
    }
}
