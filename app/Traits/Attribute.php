<?php

declare(strict_types=1);

namespace App\Traits;

use ReflectionClass;
use Exception;

trait Attribute
{
    protected function attributeExists(string $attributeName): bool
    {
        return property_exists($this, $attributeName);
    }

    protected function attributeType(string $name): ?string
    {
        try {
            $reflection = new ReflectionClass($this);
            $property = $reflection->getProperty($name);
            if ($property->hasType()) {
                $type = $property->getType()->getName();
                return match ($type) {
                    'int' => 'integer',
                    'bool' => 'boolean',
                    'double' => 'float',
                    default => $type
                };
            }
        } catch (Exception $exception) {}

        return null;
    }

    protected function fragmentationMethodName(string $methodName): array
    {
        $type = substr($methodName, 0, 3);
        $name = lcfirst(str_replace($type, '', $methodName));

        return compact('type', 'name');
    }

    protected function getAttribute(string $name): mixed
    {
        return $this->attributeExists($name) ? $this->{$name} : null;
    }

    protected function setAttributeWhereType(string $name, mixed $value): bool
    {
        $attributeType = $this->attributeType($name);
        if (
            is_null($attributeType) ||
            $attributeType === 'NULL' ||
            $attributeType !== gettype($value)
        )
            return false;

        $this->{$name} = $value;
        return true;
    }

    protected function setAttribute(string $name, mixed $value): bool
    {
        if (
            $this->attributeExists($name) &&
            $this->setAttributeWhereType($name, $value)
        ) return true;

        return false;
    }

    public function __call(string $name, array $arguments): mixed
    {
        /**
         * @var string $type
         * @var string $method_name
         */
        $fragmentation = $this->fragmentationMethodName($name);
        extract($fragmentation, EXTR_PREFIX_SAME, 'method');

        return match ($type) {
            'get' => $this->getAttribute($method_name),
            'set' => $this->setAttribute($method_name, $arguments[0] ?? ''),
            default => null,
        };
    }
}
