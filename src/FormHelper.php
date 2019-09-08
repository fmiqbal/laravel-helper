<?php

/**
 * Fill input type text
 * Order :
 * 1. Request (url param and other thing get from request())
 * 2. Old form data using old()
 * 3. Object provided and should be accessible using ->lorem or ['lorem']
 * 4. Default
 *
 * @param $name
 * @param null $object
 * @param null $default
 * @return array|\Illuminate\Http\Request|mixed|string|null
 */
function fill($name, $object = null, $default = null)
{
    if ($value = request($name)) {
        return $value;
    }

    if ($value = old($name)) {
        return $value;
    }

    if (
        ($object instanceof \Illuminate\Contracts\Support\Arrayable || is_array($object))
        && isset($object[$name])
    ) {
        return $object[$name];
    }

    return $default;
}

/**
 * Like fill() but for date must specify format to be expected
 *
 * @param $name
 * @param $format
 * @param null $object
 * @param null $default
 * @return string|null
 */
function fill_date($name, $format, $object = null, $default = null)
{
    $return = null;
    if ($value = request($name)) {
        $return = $value;
    }

    if ($value = old($name)) {
        $return = $value;
    }

    if (
        ($object instanceof \Illuminate\Contracts\Support\Arrayable || is_array($object))
        && isset($object[$name])
    ) {
        $return = $object[$name];
    }

    if ($return !== null) {
        try {
            $return = $return instanceof \Carbon\Carbon ? $return : \Carbon\Carbon::parse($return);

            return $return->format($format);
        } catch (\Exception $e) {
        }
    }

    return $default;
}

/**
 * Like fill() but for select multiple
 *
 * @param $name
 * @param $value
 * @param array|null $object
 * @param null $default
 * @return string
 */
function fill_select_multiple($name, $value, array $object = null, $default = null)
{
    if (old($name) !== null) {
        if (in_array((string) $value, old($name) ?: [], true)) {
            return 'selected';
        }
    } elseif (in_array((string) $value, $object ?: [], true)) {
        return 'selected';
    }

    return $value === $default ? 'selected' : '';
}

/**
 * Like fill() but for select (not multiple !, for select multiple check fillSelectMultiple())
 *
 * @param $name
 * @param $value
 * @param null $object
 * @param null $default
 * @return string
 */
function fill_select($name, $value, $object = null, $default = null)
{
    if (old($name) === (string) $value) {
        return 'selected';
    }

    if (
        ($object instanceof \Illuminate\Contracts\Support\Arrayable || is_array($object))
        && isset($object[$name])
    ) {
        return (string) $object[$name] === (string) $value ? 'selected' : '';
    }

    if (
        is_string($object) || is_numeric($object)
    ) {
        return (string) $object === (string) $value ? 'selected' : '';
    }

    return $value === $default ? 'selected' : '';
}

/**
 * Like fill() but for checkbox
 *
 * @param $name
 * @param $value
 * @param array|null $object
 * @param null $default
 * @return string
 */
function fill_checkbox($name, $value, array $object = null, $default = null)
{
    if (old($name) !== null) {
        if (in_array((string) $value, old($name) ?: [], true)) {
            return 'checked';
        }
    } elseif (in_array((string) $value, $object ?: [], true)) {
        return 'checked';
    }

    return $value === $default ? 'checked' : '';
}
