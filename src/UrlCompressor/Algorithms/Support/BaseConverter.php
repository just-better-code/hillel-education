<?php

namespace Kulinich\Hillel\UrlCompressor\Algorithms\Support;

class BaseConverter
{
    private const ALPHABET = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@-';

    public function __construct(private int $fromBase, private int $toBase)
    {
    }

    public function convert(string $number): string
    {
        $toBase = $this->getAlphabetForBase($this->toBase);
        $fromBase = $this->getAlphabetForBase($this->fromBase);
        return $this->convertAlphabets($number, $fromBase, $toBase);
    }

    private function getAlphabetForBase(int $base): string
    {
        return substr(self::ALPHABET, 0, $base);
    }

    private function convertAlphabets(string $value, string $fromAlphabet, string $toAlphabet): string
    {
        if ($fromAlphabet == $toAlphabet) {
            return $value;
        }

        $base10Alphabet = '0123456789';
        if ($toAlphabet == $base10Alphabet) {
            return $this->fromNTo10($value, $fromAlphabet);
        }
        if ($fromAlphabet == $base10Alphabet) {
            $base10Value = $value;
        } else {
            $base10Value = $this->convertAlphabets($value, $fromAlphabet, $base10Alphabet);
        }

        return $this->from10ToN($base10Value, $toAlphabet);
    }

    private function fromNTo10(string $value, string $fromAlphabet): string
    {
        $digits = str_split($value, 1);
        $from_base_chars = str_split($fromAlphabet, 1);
        $from_len = strlen($fromAlphabet);
        $value_len = strlen($value);
        $result = 0;
        for ($i = 1; $i <= $value_len; $i++) {
            $result = bcadd(
                $result,
                bcmul(array_search($digits[$i - 1], $from_base_chars), bcpow($from_len, $value_len - $i))
            );
        }
        return $result;
    }

    private function from10ToN(string $value, string $toAlphabet): string
    {
        $toBaseChars = str_split($toAlphabet);
        if ($value < strlen($toAlphabet)) {
            return $toBaseChars[$value];
        }
        $toLen = strlen($toAlphabet);
        $result = '';
        while ($value != '0') {
            $result = $toBaseChars[bcmod($value, $toLen)] . $result;
            $value = bcdiv($value, $toLen);
        }

        return $result;
    }
}