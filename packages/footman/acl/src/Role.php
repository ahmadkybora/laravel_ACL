<?php

namespace Footman\Acl;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function permissions()
    {
        return self::belongsToMany(Permission::class);
    }

    protected function nonStaticGetAllRoles()
    {
        return Role::all();
    }

    protected static function staticGetAllRoles()
    {
        return Role::all();
    }

    public function nonStaticGetPermissionTo($permissions)
    {
        $this->permissions()->sync($permissions);
        return $this;
    }

    public static function staticGetPermissionTo($permissions)
    {
        self::permissions()->sync($permissions);
        return new self;
    }

    public function nonStaticGetPermissions()
    {
        $this->load('permissions');
        return $this;
    }

    public static function staticGetPermissions()
    {
        self::load('permissions');
        return new self;
    }

    public function __call($method, $parameters)
    {
        switch ($method)
        {
            case 'getAllRoles':
                return call_user_func([$this, 'nonStaticGetAllRoles'], $parameters[0] ?? null, $parameters[1] ?? null);
            break;

            case 'getPermissionTo':
                return call_user_func([$this, 'nonStaticGetPermissionTo'], $parameters[0] ?? null, $parameters[1] ?? null);
            break;

            case 'getPermissions':
                return call_user_func([$this, 'nonStaticGetPermissions'], $parameters[0] ?? null, $parameters[1] ?? null);
            break;
        }

        return parent::__call($method, $parameters);
    }

    public static function __callStatic($method, $parameters)
    {
        switch ($method)
        {
            case 'getAllRoles':
                return call_user_func([new self, 'staticGetAllRoles'], $parameters[0] ?? null);
            break;

            case 'givPermissionTo':
                return call_user_func([new self, 'staticGivePermissionTo'], $parameters[0] ?? null);
            break;

            case 'getPermissions':
                return call_user_func([new self, 'staticGetPermissions'], $parameters[0] ?? null);
            break;
        }

        return parent::__callStatic($method, $parameters);
    }

        // public function getAllRoles()
    // {
    //     return Role::all();
    // }

    // public function givPermissionTo($permissions)
    // {
    //     self::permissions()->sync($permissions);
    // }

    // public function getPermissions()
    // {
    //     return $this->load('permissions');
    // }

    // public static function __callStatic($name, $arguments)
    // {
    //     $strArgs = implode(',', $arguments);

    //     echo "You're calling the static method $name with $strArgs arguments";
    // }
}
