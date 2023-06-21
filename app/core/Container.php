<?php

namespace Isoros\core;

require_once __DIR__ . '/../..//vendor/autoload.php';

use Exception;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;

class Container implements ContainerInterface
{

    private array $bindings = [];

    public function bind($abstract, $concrete): void
    {
        $this->bindings[$abstract] = $concrete;
    }

    /**
     * @throws ReflectionException
     */
    public function make($abstract)
    {
        $concrete = $this->bindings[$abstract] ?? $abstract;

        if (is_callable($concrete)) {
            return $concrete($this);
        }

        $reflector = new ReflectionClass($concrete);
        $constructor = $reflector->getConstructor();

        if ($constructor === null) {
            return new $concrete;
        }

        $parameters = $constructor->getParameters();
        $dependencies = $this->resolveDependencies($parameters);

        return $reflector->newInstanceArgs($dependencies);
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    private function resolveDependencies($parameters): array
    {

        $dependencies = [];

        foreach ($parameters as $parameter) {

            $dependencyType = $parameter->getType();
            if ($dependencyType instanceof ReflectionNamedType && !$dependencyType->isBuiltin()) {
                $dependencyClassName = $dependencyType->getName();
                $dependency = new ReflectionClass($dependencyClassName);
            } else {
                // Handle non-class types or built-in types
                $dependency = null;  // or any other appropriate handling
            }

            if ($dependency === null) {
                throw new Exception("Unresolvable dependency");
            }

            $dependencies[] = $this->make($dependency->name);
        }

        return $dependencies;
    }


    /**
     * @throws ReflectionException
     */
    public function get($id)
    {
        return $this->make($id);
    }

    public function has($id): bool
    {
        return isset($this->bindings[$id]);
    }
}