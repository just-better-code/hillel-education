<?php

namespace Kulinich\Hillel\Http\Controllers;

class Info
{
    public function __invoke(): void
    {
        echo phpinfo();
    }
}