<?php

/**
 * Shorthand for number_format thousand separator
 *
 * @param $number
 * @param null $delimiter
 * @return string
 */
function to_thousand($number, $delimiter = null)
{
    if ($delimiter !== null) {
        return number_format($number, 0, ',', $delimiter);
    }

    return number_format($number, 0, ',', '.');
}

/**
 * Change number to short readable human
 * like :
 * 100.000 = 100 RB
 * 121.000.000 = 121 JT
 *
 * only support indonesian
 *
 * @param $number
 * @return bool|string
 */
function to_human($number)
{
    // first strip any formatting;
    $number = (0 + str_replace(",", "", $number));

    // is this a number?
    if (! is_numeric($number)) {
        return false;
    }

    // now filter it;
    if ($number > 1000000000000) {
        return round(($number / 1000000000000), 2) . ' TRI';
    }

    if ($number > 1000000000) {
        return round(($number / 1000000000), 2) . ' MIL';
    }

    if ($number > 1000000) {
        return round(($number / 1000000), 2) . ' JT';
    }

    return number_format($number, 0, ',', '.');
}

/**
 * Format number to bytes based
 *
 * @param $bytes
 * @param int $precision
 * @param bool $tebi Using TebiBytes (/1000 instead /1024)
 * @return string
 */
function to_bytes($bytes, $precision = 2, $tebi = false)
{
    $units = ['KB', 'MB', 'GB', 'TB'];

    $bytes = max($bytes, 0);

    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    // Uncomment one of the following alternatives
    if ($tebi) {
        $bytes /= (1 << (10 * $pow));
    } else {
        $bytes /= pow(1024, $pow);
    }

    return round($bytes, $precision) . ' ' . $units[$pow];
}

/**
 * Clean everything except number
 *
 * @param $number
 * @return int
 */
function clean_number($number)
{
    return (int) preg_replace('/\D+/', '', $number);
}

/**
 * Used in char()
 *
 * @param $end_column
 * @param string $first_letters
 * @return array
 */
function createColumnsArray($end_column, $first_letters = '')
{
    $columns = [];
    $length = strlen($end_column);
    $letters = range('A', 'Z');

    // Iterate over 26 letters.
    foreach ($letters as $letter) {
        // Paste the $first_letters before the next.
        $column = $first_letters . $letter;

        // Add the column to the final array.
        $columns[] = $column;

        // If it was the end column that was added, return the columns.
        if ($column == $end_column) {
            return $columns;
        }
    }

    // Add the column children.
    foreach ($columns as $column) {
        // Don't itterate if the $end_column was already set in a previous itteration.
        // Stop iterating if you've reached the maximum character length.
        if (! in_array($end_column, $columns) && strlen($column) < $length) {
            $new_columns = createColumnsArray($end_column, $column);
            // Merge the new columns which were created with the final columns array.
            $columns = array_merge($columns, $new_columns);
        }
    }

    return $columns;
}

/**
 * Generate string from A to n in excel column format
 * A B C ... AA AB AC ... AAA AAB
 *
 * @param $num
 * @return mixed
 */
function excel_column($num)
{
    if (! Cache::has('char_lists')) {
        Cache::forever('char_lists', createColumnsArray('ZZ'));
    }

    $alphabet = Cache::get('char_lists');

    return $alphabet[$num - 1];
}

/**
 * Check if string is JSON
 *
 * @param $string
 * @return bool
 */
function is_json($string)
{
    json_decode($string, true);

    return (json_last_error() === JSON_ERROR_NONE);
}
