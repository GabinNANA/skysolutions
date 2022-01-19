<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    use HasFactory;
    protected $fillable = ['privilege','lib_privilege','groupe'];
    
    public function privilege_roles()
    {
        return $this->hasMany(PrivilegeRole::class, 'privilege_id');
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
