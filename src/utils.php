<?php

/**
 * Prevents direct access to the file. if the file is accessed directly, it will run die().
 * @param mixed $file always pass \_\_FILE\_\_ to this function.
 * @return void
 */
function disallowDirectAccess($file): void
{
    if (pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME) == pathinfo($file, PATHINFO_FILENAME))
        die('Error: NO_DIRECT_ACCESS_ALLOWED');

}


disallowDirectAccess(__FILE__);

function groupByArrayKey(string $arrayKey, array $array): array
{
    $groups = [];
    foreach ($array as $item) {
        if (!isset($item[$arrayKey])) {
            continue;
        }

        $key = $item[$arrayKey];
        $groups[$key][] = $item;
    }

    return $groups;
}

function mustAllExist(...$args): bool
{
    foreach ($args as $arg) {
        if (!isset($arg)) {
            return false;
        }
    }
    return true;
}
function isLoggedIn(): bool
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        if (isset($_SESSION['user_data'])) {
            if (
                mustAllExist(
                    $_SESSION['user_data']['username'],
                    $_SESSION['user_data']['first_name'],
                    $_SESSION['user_data']['last_name'],
                    $_SESSION['user_data']['role']
                )
            ) {
                return true;
            }
        }
    }
    return false;
}
function redirect(string $url, int $responseCode = 307): void
{
    header("Location: {$url}", true, $responseCode);
}
function getDoubleValuesAmount(array $array){
    $values = [];
    foreach ($array as $item) {
        if (!isset($values[$item])) {
            $values[$item] = 0;
        }
        $values[$item]++;
    }
    return $values;

}

function resolveStatus(int $status):string{
    return match ($status) {
        1 => 'Bestelling ontvangen',
        2 => 'In de oven',
        3 => 'Klaar om bezorgd te worden',
        4 => 'Onze bezorger is onderweg',
        5 => 'Bezorgd, eet smakelijk!',
        default => 'Wij hebben geen active herinnering over deze bestelling :( bel ons op als je dit leest',
    };
}