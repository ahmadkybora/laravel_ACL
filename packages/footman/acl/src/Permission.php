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

    public function noneStaticgetAllPermissions()
    {
        return Permission::all();
    }

    public static function staticGetAllPermissions()
    {
        return Permission::all();
    }

    public function nonStaticGetRoleTo($roles)
    {
        $this->permissions()->sync($roles);
        return $this;
    }

    public static function staticGetRoleTo($roles)
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
    
    // public static function getAllRoles()
    // {
    //     return Permission::all();
    // }

    public function __call($method, $parameters)
    {
        switch ($method)
        {
            case 'getAllPermissions':
                return call_user_func([$this, 'nonStaticGetPermissions'], $parameters[0] ?? null, $parameters[1] ?? null);
            break;

            case 'getRoleTo':
                return call_user_func([$this, 'nonStaticGetRoleTo'], $parameters[0] ?? null, $parameters[1] ?? null);
            break;

            case 'getRoles':
                return call_user_func([$this, 'nonStaticGetRoles'], $parameters[0] ?? null, $parameters[1] ?? null);
            break;
        }

        return parent::__call($method, $parameters);
    }

    public static function __callStatic($method, $parameters)
    {
        switch ($method)
        {
            case 'getAllPermissions':
                return call_user_func([new self, 'staticGetPermissions'], $parameters[0] ?? null);
            break;

            case 'getRoleTo':
                return call_user_func([new self, 'staticGetRoleTo'], $parameters[0] ?? null);
            break;

            case 'getRoles':
                return call_user_func([new self, 'staticGetRoles'], $parameters[0] ?? null);
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
