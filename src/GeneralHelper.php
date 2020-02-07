<?php

use Illuminate\Database\Query\Builder;

/**
 * array_key_exists() but for multiple keys
 *
 * @param array $keys
 * @param array $arr
 * @return bool
 */
if (! function_exists('array_keys_exists')) {
    function array_keys_exists(array $keys, array $arr)
    {
        return ! array_diff_key(array_flip($keys), $arr);
    }
}

/**
 * Check if array is associative array
 *
 * @param array $arr
 * @return bool
 */
if (!function_exists('is_assoc')) {
    function is_assoc(array $arr)
    {
        if ([] === $arr) {
            return false;
        }

        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}

/**
 * Like dd() but more readable because it always convert to array
 *
 */

if (function_exists('ddr')) {
function ddr()
{
    $args = func_get_args();
    foreach ($args as $key => $arg) {
        if ($arg instanceof Illuminate\Contracts\Support\Arrayable) {
            $args[$key] = $arg->toArray();
        }
    }

    dd(...$args);
}
}
/**
 * Like ddr() but didnt die
 *
 * @param mixed ...$args
 */

if (function_exists('dr')) {
function dr(...$args)
{
    foreach ($args as $key => $arg) {
        if ($arg instanceof Illuminate\Contracts\Support\Arrayable) {
            $args[$key] = $arg->toArray();
        }
    }

    foreach ($args as $key => $x) {
        \Symfony\Component\VarDumper\VarDumper::dump($x);
    }
}
}
/**
 * Rounding number up with default per
 *
 * @param $number
 * @param int $per
 * @return float|int
 */

if (function_exists('round_up')) {
function round_up($number, $per = 500)
{
    return (ceil($number / $per) * $per);
}
}
/**
 * Rounding number down with default per
 *
 * @param $number
 * @param int $per
 * @return float|int
 */

if (function_exists('round_down')) {
function round_down($number, $per = 500)
{
    return (floor($number / $per) * $per);
}
}
/**
 * This will create toSql() like result but with all the binding already binded
 * normal toSql() result = SELECT * FROM projects WHERE id = ? , [1]
 * this function result = SELECT * FROM projects WHERE id = 1
 *
 * @param $builder
 * @return string
 */

if (function_exists('bind_sql')) {
function bind_sql(Builder $builder)
{
    $bindings = collect($builder->getBindings())
        ->map(function ($item) {
            return '\'' . $item . '\'';
        })
        ->toArray();

    return Str::replaceArray('?', $bindings, $builder->toSql());
}
}
/**
 * Insert something before specific key in an array
 *
 * @param array $array
 * @param $key
 * @param array $new
 * @return array
 */

if (function_exists('array_insert_before')) {
function array_insert_before(array $array, $key, array $new)
{
    $keys = array_keys($array);
    $pos = (int) array_search($key, $keys);

    return array_merge(array_slice($array, 0, $pos), $new, array_slice($array, $pos));
}
}
