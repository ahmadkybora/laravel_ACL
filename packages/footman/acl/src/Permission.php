<?php

namespace Footman\Acl;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function noneStaticgetAllPermissions()
    {
        return Permission::all();
    }

    public static function staticGetAllPermissions()
    {
        return Permission::all();
    }

    public function nonStaticGiveRoleTo($roles)
    {
        $this->permissions()->sync($roles);
        return $this;
    }

    public static function staticGiveRoleTo($roles)
    {
        self::permissions()->sync($roles);
        return new self;
    }

    public function nonStaticGetRoles()
    {
        $this->load('roles');
        return $this;
    }

    public static function staticGetRoles()
    {
        self::load('roles');
        return new self;
    }
    
    public function nonStaticRemoveRole($role)
    {
        $this->roles()->detach($role->id);
        return $this;
    }

    public static function staticRemoveRole($role)
    {
        self::roles()->detach($role->id);
        return new self;
    }

    public function nonStaticAssignPermission($user)
    {
        $this->users()->detach($user->id);
        return $this;
    }

    public static function staticAssignPermission($user)
    {
        self::users()->detach($user->id);
        return new self;
    }

    // public static function getAllRoles()
    // {
    //     return Permission::all();
    // }

    public function __call($method, $parameters)
    {
        switch ($method)
        {
            case 'getAllPermissions':
                return call_user_func([$this, 'nonStaticGetAllPermissions'], $parameters[0] ?? null, $parameters[1] ?? null);
            break;

            case 'giveRoleTo':
                return call_user_func([$this, 'nonStaticGiveRoleTo'], $parameters[0] ?? null, $parameters[1] ?? null);
            break;

            case 'getRoles':
                return call_user_func([$this, 'nonStaticGetRoles'], $parameters[0] ?? null, $parameters[1] ?? null);
            break;

            case 'removeRole':
                return call_user_func([new self, 'nonStaticRemoveRole'], $parameters[0] ?? null);
            break;

            case 'assignPermission':
                return call_user_func([$this, 'staticAssignPermission'], $parameters[0] ?? null);
            break;
        }

        return parent::__call($method, $parameters);
    }

    public static function __callStatic($method, $parameters)
    {
        switch ($method)
        {
            case 'getAllPermissions':
                return call_user_func([new self, 'staticGetAllPermissions'], $parameters[0] ?? null);
            break;

            case 'giveRoleTo':
                return call_user_func([new self, 'staticGiveRoleTo'], $parameters[0] ?? null);
            break;

            case 'getRoles':
                return call_user_func([new self, 'staticGetRoles'], $parameters[0] ?? null);
            break;

            case 'removeRole':
                return call_user_func([new self, 'staticRemoveRole'], $parameters[0] ?? null);
            break;

            case 'assignPermission':
                return call_user_func([new self, 'staticAssignPermission'], $parameters[0] ?? null);
            break;
        }

        return parent::__callStatic($method, $parameters);
    }

    // public static function __callStatic($name, $arguments)
    // {
    //     $strArgs = implode(',', $arguments);

    //     echo "You're calling the static method $name with $strArgs arguments";
    // }

    // public function sendObject() {
    //     self::send($this->text);
    // }

    // public static function sendText($text) {
    //     // send something
    // }

    // public function __call($name, $arguments) {
    //     if ($name === 'send') {
    //         call_user_func(array($this, 'sendObject'));
    //     }
    // }

    // public static function __callStatic($name, $arguments) {
    //     if ($name === 'send') {
    //         call_user_func(array('test', 'sendText'), $arguments[0]);
    //     }
    // }
}
