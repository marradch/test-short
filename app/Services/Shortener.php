<?php

namespace App\Services;

use App\Models\Link;

class Shortener
{
    private const ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    private const RANDOM_STRING_LENGTH = 8;

    public function make(string $link): string
    {
        $existedLink = Link::query()->where('link', $link)->first();

        if ($existedLink) {
            return url('/') . '/'. $existedLink->short;
        }

        $short = $this->makeShort();

        Link::create([
            'link' => $link,
            'short' => $short,
        ]);

        return url('/') . '/' . $short;
    }

    private function makeShort(): string
    {
        $short = $this->generateRandomString();

        $existedLink = Link::query()->where('short', $short);
        if ($existedLink) {
            return $this->generateRandomString();
        } else {
            return $short;
        }
    }

    private function generateRandomString(): string
    {
        $randomString = '';
        $charLength = strlen(self::ALPHABET);

        for ($i = 0; $i < self::RANDOM_STRING_LENGTH; $i++) {
            $randomString .= self::ALPHABET[rand(0, $charLength - 1)];
        }

        return $randomString;
    }
}
