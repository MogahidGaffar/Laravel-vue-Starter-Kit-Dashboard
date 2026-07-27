<?php

namespace App\Support;

class Countries
{
    protected static ?array $countries = null;

    protected static ?array $byValue = null;

    public static function all(): array
    {
        if (self::$countries === null) {
            self::$countries = json_decode(
                file_get_contents(public_path('dashboard-assets/js/countries.json')),
                true
            );
        }

        return self::$countries;
    }

    /**
     * Countries keyed by their numeric dial code (data_val), for O(1) lookup.
     */
    public static function byValue(): array
    {
        if (self::$byValue === null) {
            self::$byValue = [];

            foreach (self::all() as $country) {
                self::$byValue[(int) $country['data_val']] = $country['cname'];
            }
        }

        return self::$byValue;
    }

    /**
     * All valid values, for validation rules.
     */
    public static function values(): array
    {
        return array_keys(self::byValue());
    }

    public static function name(int|string|null $value): ?string
    {
        if (!$value) {
            return null;
        }

        return self::byValue()[(int) $value] ?? null;
    }

    /**
     * Build the {value, text} shape stored on the user record.
     */
    public static function option(int|string|null $value): ?array
    {
        $name = self::name($value);

        return $name ? ['value' => (int) $value, 'text' => $name] : null;
    }
}
