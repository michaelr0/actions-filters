<?php

namespace Michaelr0\ActionsAndFilters;

use Michaelr0\ActionsAndFilters\Traits\Hookable;

class Filter
{
    use Hookable;

    public function run(string $hook, ...$args)
    {
        $value = $args[0] ?? null;

        $argsCount = count($args);

        foreach ($this->listeners[$hook] ?? [] as $priority) {
            foreach ($priority as $listener) {
                $args[0] = $value;

                if ($listener['arguments'] === 0) {
                    $value = call_user_func($listener['callback']);
                } elseif ($listener['arguments'] >= $argsCount) {
                    $value = call_user_func_array($listener['callback'], $args);
                } else {
                    // Workaround if more args were passed than what the callback can accept
                    $value = call_user_func_array($listener['callback'], array_slice($args, 0, $listener['arguments']));
                }
            }
        }

        return $value;
    }
}
