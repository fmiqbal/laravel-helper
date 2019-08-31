<?php

function part($coaAccountNumber)
{
    return explode('.', $coaAccountNumber);
}

function fuse($coaAccountNumber)
{
    return implode('.', $coaAccountNumber);
}
