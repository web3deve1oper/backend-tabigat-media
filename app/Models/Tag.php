<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

    public static function createOrReturnIds($tags)
    {
        $ids = [];

        foreach ($tags as $tag) {
            $existingTag = self::where('name', $tag)->first();

            if ($existingTag) {
                $ids[] = $existingTag->id;
            } else {
                $newTag = self::create([
                    'name' => $tag
                ]);
                $ids[] = $newTag->id;
            }
        }

        return $ids;
    }
}
