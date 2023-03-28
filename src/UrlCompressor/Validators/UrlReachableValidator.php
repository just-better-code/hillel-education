<?php

namespace Kulinich\Hillel\UrlCompressor\Validators;

class UrlReachableValidator extends ValidatorChain
{
    public function __construct()
    {
    }

    protected function validate($url): void
    {
        if (!$this->urlExists($url)) {
            throw new \InvalidArgumentException("URL '$url' not reachable!");
        }
    }

    private function urlExists(string $url): bool
    {
        $ch = curl_init($url);
        $ua = 'Mozilla/5.0 (X11; Linux i686; rv:111.0) Gecko/20100101 Firefox/111.0';
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $code == 200;
    }
}