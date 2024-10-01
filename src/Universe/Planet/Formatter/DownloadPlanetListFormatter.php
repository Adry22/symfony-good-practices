<?php

namespace Universe\Planet\Formatter;

class DownloadPlanetListFormatter
{
    const NAME = 'name';
    const MAIN_TITLE = 'main_title';

    private array $planets;

    public function __construct(array $planets)
    {
        $this->planets = $planets;
    }

    public function toArray(): array
    {
        $result = [];

        $result['titles'] = [
            self::MAIN_TITLE => 'Planets list'
        ];

        $result['columns'] = [
            self::NAME => 'Name'
        ];

        $result['planets'] = [];

        foreach ($this->planets as $planet) {
            $result['planets'][] = [
                self::NAME => $planet->name()
            ];
        }

        return $result;
    }
}