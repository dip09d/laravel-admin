<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'url', 'icon_class', 'parent_id'];

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->with('children');
    }

    // Linked permission
    public function permission()
    {
        return $this->hasOne(Permission::class, 'name', 'slug');
    }
}
