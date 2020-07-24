<?php

namespace Michaelr0\ActionsAndFilters\Traits;

trait Hookable
{
    protected $listeners = [];

    public function add(string $hook, callable $callback, int $priority = 10, int $arguments = 1)
    {
        $this->listeners[$hook][$priority][] = [
            'callback' => $callback,
            'arguments' => $arguments,
        ];

        return $this;
    }

    public function exists(string $hook): bool
    {
        if (! empty($this->listeners[$hook])) {
            return true;
        }

        return false;
    }

    public function existsForCallback(string $hook, callable $callback): bool
    {
        if ($this->exists($hook)) {
            foreach ($this->listeners[$hook] as $priority) {
                foreach ($priority as $listener) {
                    if ($listener['callback'] === $callback) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function list(string $hook = null, int $priority = null): array
    {
        if (is_null($hook)) {
            return $this->listeners;
        } elseif (! empty($this->listeners[$hook])) {
            if (! is_null($priority)) {
                if (! empty($this->listeners[$hook][$priority])) {
                    return $this->listeners[$hook][$priority];
                }

                return [];
            }

            return $this->listeners[$hook];
        }

        return [];
    }

    public function listAll(): array
    {
        return $this->list(null);
    }

    public function remove(string $hook, callable $callback, int $priority = 10, int $arguments = 1)
    {
        if (! empty($this->listeners[$hook][$priority])) {
            foreach ($this->listeners[$hook][$priority] as $key => $value) {
                if ($value['callback'] === $callback && $value['arguments'] === $arguments) {
                    unset($this->listeners[$hook][$priority][$key]);
                    break;
                }
            }
        }

        return $this;
    }

    public function removeAllFor(string $hook)
    {
        unset($this->listeners[$hook]);

        return $this;
    }

    public function run(string $hook, ...$args)
    {
        if (! empty($this->listeners[$hook])) {
            $argsCount = count($args);

            foreach ($this->listeners[$hook] as $priority) {
                foreach ($priority as $listener) {
                    if ($listener['arguments'] === 0) {
                        call_user_func($listener['callback']);
                    } elseif ($listener['arguments'] >= $argsCount) {
                        call_user_func_array($listener['callback'], $args);
                    } else {
                        // Workaround if more args were passed than what the callback can accept
                        call_user_func_array($listener['callback'], array_slice($args, 0, $listener['arguments']));
                    }
                }
            }
        }

        return $this;
    }
}
