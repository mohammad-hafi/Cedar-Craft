<?php

use App\Models\Home;

function setting($key)
{
    return Home::where('attribute', $key)->value('value');
}