<?php

namespace Kulinich\Hillel;

use Kulinich\Hillel\Lesson3\Demo;

final class App
{
    public function run(): void
    {
        (new Demo())->run();
    }
}