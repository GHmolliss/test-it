<?php

declare(strict_types=1);

namespace App\Components;

/**
 * Простой DI-контейнер для управления зависимостями
 */
class Container
{
    private static ?Container $instance = null;
    
    /** @var array<string, callable> */
    private array $factories = [];
    
    /** @var array<string, object> */
    private array $instances = [];

    private function __construct()
    {
        $this->registerDefaults();
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Регистрация фабрики для создания объекта
     */
    public function register(string $id, callable $factory): void
    {
        $this->factories[$id] = $factory;
        unset($this->instances[$id]);
    }

    /**
     * Регистрация singleton-экземпляра
     */
    public function singleton(string $id, callable $factory): void
    {
        $this->factories[$id] = function (Container $c) use ($factory, $id) {
            if (!isset($this->instances[$id])) {
                $this->instances[$id] = $factory($c);
            }

            return $this->instances[$id];
        };
    }

    /**
     * Получение объекта из контейнера
     * 
     * @template T
     * @param class-string<T> $id
     * @return T
     */
    public function get(string $id): object
    {
        if (isset($this->factories[$id])) {
            return $this->factories[$id]($this);
        }

        // Автоматическое создание, если класс существует
        if (class_exists($id)) {
            return $this->autowire($id);
        }

        throw new \CException("Service not found: {$id}");
    }

    /**
     * Проверка наличия сервиса
     */
    public function has(string $id): bool
    {
        return isset($this->factories[$id]) || class_exists($id);
    }

    /**
     * Автоматическое разрешение зависимостей через рефлексию
     */
    private function autowire(string $class): object
    {
        $reflection = new \ReflectionClass($class);
        $constructor = $reflection->getConstructor();

        if ($constructor === null) {
            return new $class();
        }

        $parameters = $constructor->getParameters();
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $type = $parameter->getType();

            if ($type instanceof \ReflectionNamedType && !$type->isBuiltin()) {
                $dependencies[] = $this->get($type->getName());
            } elseif ($parameter->isDefaultValueAvailable()) {
                $dependencies[] = $parameter->getDefaultValue();
            } else {
                throw new \CException(
                    "Cannot resolve parameter \${$parameter->getName()} for {$class}"
                );
            }
        }

        return $reflection->newInstanceArgs($dependencies);
    }

    /**
     * Регистрация стандартных сервисов
     */
    private function registerDefaults(): void
    {
        // Сервисы как singleton
        $this->singleton(\BookService::class, fn() => new \BookService());
        $this->singleton(\AuthorService::class, fn() => new \AuthorService());
        $this->singleton(\SubscriptionService::class, fn() => new \SubscriptionService());
        $this->singleton(\AuthService::class, fn() => new \AuthService());
        $this->singleton(\SmsService::class, fn() => new \SmsService());
    }

    /**
     * Сброс контейнера (для тестов)
     */
    public static function reset(): void
    {
        self::$instance = null;
    }
}
