<?php

namespace Footman\Acl;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // protected $table = ['roles'];
    protected $fillable = ['name'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public static function getAllRoles()
    {
        return Role::all();
    }

    public function givPermissionTo($permissions)
    {
        $this->permissions()->sync($permissions);
    }

    public function getPermissions()
    {
        // dd($this->permissions->get());
        return $this->permissions;
    }
}
