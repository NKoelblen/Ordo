<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use ReflectionClass;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('to_array', [$this, 'toArray']),
            new TwigFilter('class_name', [$this, 'getClassName']),
        ];
    }

    public function toArray(object $entity): array
    {
        $reflection = new ReflectionClass($entity);
        $properties = $reflection->getProperties();

        $data = [];
        foreach ($properties as $property) {
            $property->setAccessible(true);
            $data[$property->getName()] = $property->getValue($entity);
        }

        return $data;
    }

    public function getClassName(object|string $entity): string
    {
        if (is_string($entity)) {
            $entity = new ReflectionClass($entity);
        } else {
            $entity = new ReflectionClass(get_class($entity));
        }
        return $entity->getShortName();
    }
}
