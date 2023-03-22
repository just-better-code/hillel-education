<?php

namespace Kulinich\Hillel\Lesson3;

use Kulinich\Hillel\Support\ConsoleLogger;

class Demo
{
    private string $message = 'Some dummy message';

    public function run(): void
    {
        $this->polymorphicCall();
        $this->abstractCall();
    }

    protected function polymorphicCall(): void
    {
        ConsoleLogger::log('==========Polymorphic demo==========');
        $base = new BaseStorage();
        $aws = new AwsStorage();
        $google = new GoogleDriveStorage();
        $this->storePolymorphic($base);
        $this->storePolymorphic($aws);
        $this->storePolymorphic($google);
    }

    protected function abstractCall(): void
    {
        ConsoleLogger::log('==========Abstraction demo==========');
        $base = new BaseStorage();
        $redis = new RedisStorage();
        $file = new FileStorage();
        $this->storeAbstract($base);
        $this->storeAbstract($file);
        $this->storeAbstract($redis);
    }

    protected function storePolymorphic(BaseStorage $storage)
    {
        $storage->store($this->message);
    }

    protected function storeAbstract(Storage $storage)
    {
        $storage->store($this->message);
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
}