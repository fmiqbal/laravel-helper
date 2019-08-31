<?php

/**
 * Bind request queries (url parameter) with new one
 *
 * @param array $parameters Default parameter to keep from request()
 * @param array $additions Parameter to add (use associative array)
 * @return array
 */
function withParameters($parameters = [], $additions = [])
{
    $temp = Arr::wrap($parameters);

    $parameters = [];
    foreach ($temp as $item) {
        if (request()->has($item)) {
            $parameters[$item] = request($item);
        }
    }

    return array_merge($parameters, $additions);
}

/**
 * Generate a querystring url for the application.
 *
 * Assumes that you want a URL with a querystring rather than route params
 * (which is what the default url() helper does)
 *
 * @param string $path
 * @param mixed $qs
 * @param bool $secure
 * @return string
 */
function qs_url($path = null, $qs = [], $secure = null)
{
    $url = app('url')->to($path, $secure);
    if (count($qs)) {
        foreach ($qs as $key => $value) {
            $qs[$key] = sprintf('%s=%s', $key, urlencode($value));
        }
        $url = sprintf('%s?%s', $url, implode('&', $qs));
    }

    return $url;
}
