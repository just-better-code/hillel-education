<?php

namespace Kulinich\Hillel\Lesson3;

interface Storage
{
    public function store(string $message);
}