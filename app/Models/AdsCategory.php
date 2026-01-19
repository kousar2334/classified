<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdsCategory extends Model
{
    public function parentCategory()
    {
        return $this->belongsTo(self::class, 'parent')->select(['id', 'title']);
    }

    public function child()
    {
        return $this->hasMany($this, 'parent')->orderBy('id', 'ASC');
    }
}
