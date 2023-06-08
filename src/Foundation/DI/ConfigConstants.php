<?php

namespace Kulinich\Hillel\Foundation\DI;

enum ConfigConstants: string
{
    const CLASSNAME = 'class';
    const ARGUMENTS = 'arguments';
    const CALLS = 'calls';
    const METHOD = 'method';
}