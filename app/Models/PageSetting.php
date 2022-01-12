<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value'
    ];

    public static function getValue($key)
    {
        $setting = self::query()->where('key', $key)
            ->first();

        return $setting ? $setting->value : null;
    }

    public static function setValue($key, $value)
    {
        $setting = self::query()
            ->where('key', $key)
            ->first();

        if (!$setting) {
            self::query()
                ->create([
                    'key' => $key,
                    'value' => $value
                ]);
        } else {
            $setting->value = $value;
            $setting->save();
        }
    }
}
