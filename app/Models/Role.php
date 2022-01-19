<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = ['title'];

    public function user_roles()
    {
        return $this->hasMany(UserRole::class, 'role_id');
    }
    
    public function privilege_roles()
    {
        return $this->hasMany(PrivilegeRole::class, 'role_id');
    }
    public function privileges()
    {
        return $this->belongsToMany(Privilege::class);
    }
}
