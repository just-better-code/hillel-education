<?php

namespace Kulinich\Hillel\Foundation\Logging;

use Monolog\Formatter\LineFormatter;
use Monolog\Level;
use Monolog\LogRecord;
use UfoCms\ColoredCli\CliColor;

class ColorCliFormatter extends LineFormatter
{
    public const SIMPLE_DATE = 'Y-m-d H:i:s';
    public const SIMPLE_FORMAT = "%datetime% > %level_name% > %message% %context% %extra%\n";

    public function format(LogRecord $record): string
    {
        $output = parent::format($record);
        $color = $this->resolveColor($record);

        return $this->wrapOutput($output, $color);
    }

    private function resolveColor(LogRecord $record): CliColor
    {
        return match ($record->level) {
            Level::Emergency,
            Level::Error => CliColor::RED,
            Level::Info => CliColor::GREEN,
            Level::Alert => CliColor::YELLOW,
            default => CliColor::WHITE,
        };
    }

    private function wrapOutput(string $output, CliColor $color): string
    {
        return $color->value . $output . CliColor::RESET->value;
    }
}