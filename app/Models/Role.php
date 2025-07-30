<?php

// App/Models/Role.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function subMenus()
    {
        return $this->belongsToMany(SubMenu::class, 'role_submenu', 'role_id', 'sub_menu_id')
                    ->withPivot('is_active');
    }
}