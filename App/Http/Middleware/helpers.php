<?php
function roles($number)
{
    return session('user.codigoRoles') === $number;
}