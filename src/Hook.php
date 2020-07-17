<?php

namespace Michaelr0\ActionsAndFilters;

class Hook
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

    public function existsFor(string $hook)
    {
        if (! empty($this->listeners[$hook])) {
            return true;
        }

        return false;
    }

    public function existsForCallback(string $hook, callable $callback)
    {
        if ($this->existsFor($hook)) {
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

    public function existsForPriority(string $hook, int $priority)
    {
        if (! empty($this->listeners[$hook][$priority])) {
            return true;
        }

        return false;
    }

    public function list(string $hook = null, int $priority = null)
    {
        if (is_null($hook)) {
            return $this->listeners;
        } elseif (! empty($this->listeners[$hook])) {
            if (! is_null($priority) && ! empty($this->listeners[$hook][$priority])) {
                return $this->listeners[$hook][$priority];
            }

            return $this->listeners[$hook];
        }
    }

    public function listAll()
    {
        return $this->list(null);
    }

    public function remove(string $hook, callable $callback, int $priority = 10, int $arguments = 1)
    {
        if (! empty($this->listeners[$hook][$priority])){
            $listeners = $this->listeners[$hook][$priority];
            foreach ($listeners as $key => $value) {
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
        if (! empty($this->listeners)) {
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
