<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivilegeRole extends Model
{
    use HasFactory;
    protected $table="privilege_role";
    protected $fillable = ['privilege_id','role_id'];
    
    /**
     * @return BelongsTo
     **/
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    
    /**
     * @return BelongsTo
     **/
    public function privilege()
    {
        return $this->belongsTo(Privilege::class, 'privilege_id');
    }
}
