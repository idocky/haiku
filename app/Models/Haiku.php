<?php

namespace App\Models;

use App\Exceptions\QueryException;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Haiku extends Model
{
    use HasFactory;
    use Sluggable;

    protected $table = 'haiku';

    protected $fillable = ['title', 'content'];

    const IS_DRAFT = 1;
    const IS_PUBLIC = 0;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class, 'theme_id');
    }

    public static function add($fields)
    {
        $haiku = new static;
        $haiku->fill($fields);
        $haiku->save();

        return $haiku;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }

    public function setUser($id)
    {
        if($id == null){return;}

        $this->user_id = $id;
        $this->save();
    }

    public function setTheme($id)
    {
        if($id == null){return;}

        $this->theme_id = $id;
        $this->save();
    }

    public function setDraft()
    {
        $this->is_hidden = Haiku::IS_DRAFT;
        $this->save();
    }

    public function setPublic()
    {
        $this->is_hidden = Haiku::IS_PUBLIC;
        $this->published_at = Carbon::now();
        $this->save();
    }

    public function toggleStatus($value)
    {
        if($value == null)
        {
            return $this->setPublic();
        }
        else
        {
            return $this->setDraft();
        }
    }

    public static function findBySlug($slug)
    {
        $haiku = Haiku::where('slug', $slug)->first();

        if($haiku)
        {
            return $haiku;
        }

        throw QueryException::wrongData('Haiku');
    }
}
