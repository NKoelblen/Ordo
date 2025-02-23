<?php
namespace App\Service;

use ReflectionClass;
use App\Attribute\Displayable;

class FieldService
{
    public function getFields(string $entityName): array
    {
        $class = 'App\\Entity\\' . ucfirst($entityName);
        if (!class_exists($class)) {
            return [];
        }

        $reflection = new ReflectionClass($class);
        $fields = [];

        foreach ($reflection->getProperties() as $property) {
            if ($property->getAttributes(Displayable::class)) {
                $fields[] = $property->getName();
            }
        }

        return $fields;
    }
}