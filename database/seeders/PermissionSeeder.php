<?php

namespace Database\Seeders;

use Footman\Acl\Permission;
use Footman\Acl\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = 
        [
            'create-user', 'update-user', 'view-user', 'view-users', 'delete-user', 'create-role', 
            'update-role', 'view-role', 'view-roles', 'delete-role', 'create-transaction', 'update-transaction', 
            'view-transaction', 'view-transactions', 'delete-transaction', 'view-ticket', 'view-tickets', 
            'reply-ticket', 'close-ticket', 'create-product', 'update-product', 
            'view-product', 'view-products','delete-product', 'view-seller-ticket', 'view-seller-tickets', 
            'reply-seller-ticket', 'create-voucher', 'update-voucher', 'view-voucher', 
            'view-vouchers', 'delete-voucher', 'create-order', 'update-order', 
            'view-orders', 'view-order', 'delete-order', 'create-category', 'update-category', 
            'view-category', 'view-categories', 'delete-category', 'view-brands', 'view-brand', 
            'create-brand', 'update-brand', 'delete-brand', 'view-sale-support', 'view-sale-supports','create-bank', 
            'update-bank', 'view-banks', 'view-bank', 'delete-bank', 'view-sales', 'view-pending-orders', 
            'view-pending-order', 'update-pending-order', 'payment-confirm-order', 'create-article-category', 
            'update-article-category', 'view-article-category', 'view-article-categories', 
            'delete-article-category', 'create-article', 
            'update-article', 'view-article', 'view-articles', 'delete-article'
        ];
        
        foreach ($permissions as $permission)
        {
            $permissionSeed = new Permission();
            $permissionSeed->name = $permission;
            $permissionSeed->save();
        }

        $permissions = Permission::getAllPermissions();
        $role = Role::find(1);
        $role->givePermissionTo($permissions);
        $role->save();
    }
}
