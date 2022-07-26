<?php

namespace Footman\Acl;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    protected function nonStaticGetAllRoles()
    {
        return Role::all();
    }

    protected static function staticGetAllRoles()
    {
        return Role::all();
    }

    public function nonStaticGivePermissionTo($permissions)
    {
        $this->permissions()->sync($permissions);
        return $this;
    }

    public static function staticGivePermissionTo($permissions)
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

    public function nonStaticRemovePermission($permission)
    {
        $this->permissions()->detach($permission->id);
        return $this;
    }

    public static function staticRemovePermission($permission)
    {
        self::permissions()->detach($permission->id);
        return new self;
    }

    public function nonStaticAssignRole($user)
    {
        $this->users()->attach($user->id);
        return $this;
    }

    public static function staticAssignRole($user)
    {
        self::users()->atach($user->id);
        return new self;
    }

    public function __call($method, $parameters)
    {
        switch ($method)
        {
            case 'getAllRoles':
                return call_user_func([$this, 'nonStaticGetAllRoles'], $parameters[0] ?? null, $parameters[1] ?? null);
            break;

            case 'givePermissionTo':
                return call_user_func([$this, 'nonStaticGivePermissionTo'], $parameters[0] ?? null, $parameters[1] ?? null);
            break;

            case 'getPermissions':
                return call_user_func([$this, 'nonStaticGetPermissions'], $parameters[0] ?? null, $parameters[1] ?? null);
            break;

            case 'removePermission':
                return call_user_func([$this, 'nonStaticRemovePermission'], $parameters[0] ?? null);
            break;

            case 'assignRole':
                return call_user_func([$this, 'nonstaticAssignRole'], $parameters[0] ?? null);
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

            case 'givePermissionTo':
                return call_user_func([new self, 'staticGivePermissionTo'], $parameters[0] ?? null);
            break;

            case 'getPermissions':
                return call_user_func([new self, 'staticGetPermissions'], $parameters[0] ?? null);
            break;

            case 'removePermission':
                return call_user_func([new self, 'staticRemovePermission'], $parameters[0] ?? null);
            break;

            case 'assignRole':
                return call_user_func([new self, 'staticAssignRole'], $parameters[0] ?? null);
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
