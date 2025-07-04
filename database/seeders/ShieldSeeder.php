<?php

namespace Database\Seeders;

use BezhanSalleh\FilamentShield\Support\Utils;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"Admin","guard_name":"web","permissions":["view_role","view_any_role","create_role","update_role","delete_role","delete_any_role","view_book","view_any_book","create_book","update_book","restore_book","restore_any_book","replicate_book","reorder_book","delete_book","delete_any_book","force_delete_book","force_delete_any_book","view_category","view_any_category","create_category","update_category","restore_category","restore_any_category","replicate_category","reorder_category","delete_category","delete_any_category","force_delete_category","force_delete_any_category","view_member","view_any_member","create_member","update_member","restore_member","restore_any_member","replicate_member","reorder_member","delete_member","delete_any_member","force_delete_member","force_delete_any_member","view_user","view_any_user","create_user","update_user","restore_user","restore_any_user","replicate_user","reorder_user","delete_user","delete_any_user","force_delete_user","force_delete_any_user","view_borrowing","view_any_borrowing","create_borrowing","update_borrowing","restore_borrowing","restore_any_borrowing","replicate_borrowing","reorder_borrowing","delete_borrowing","delete_any_borrowing","force_delete_borrowing","force_delete_any_borrowing","page_EditProfilePage","approve_borrowing","reject_borrowing","select_status_borrowing","confirm_pickup_borrowing","confirm_return_borrowing","page_BookCollectionPage","page_DashboardPage","page_ReportingPage","widget_StatsOverviewWidget","borrow_book"]},{"name":"Librarian","guard_name":"web","permissions":["view_book","view_any_book","create_book","update_book","restore_book","restore_any_book","replicate_book","reorder_book","delete_book","delete_any_book","force_delete_book","force_delete_any_book","view_category","view_any_category","create_category","update_category","restore_category","restore_any_category","replicate_category","reorder_category","delete_category","delete_any_category","force_delete_category","force_delete_any_category","view_member","view_any_member","create_member","update_member","restore_member","restore_any_member","replicate_member","reorder_member","view_borrowing","view_any_borrowing","update_borrowing","restore_borrowing","restore_any_borrowing","replicate_borrowing","reorder_borrowing","page_EditProfilePage","approve_borrowing","reject_borrowing","confirm_pickup_borrowing","confirm_return_borrowing","page_BookCollectionPage","page_DashboardPage","page_ReportingPage","widget_StatsOverviewWidget"]},{"name":"Member","guard_name":"web","permissions":["view_any_borrowing","page_EditProfilePage","page_BookCollectionPage","page_DashboardPage","borrow_book"]}]';
        $directPermissions = '{"67":{"name":"Perbaruri Status_borrowing","guard_name":"web"},"68":{"name":"update_borrowing_status_borrowing","guard_name":"web"},"69":{"name":"update_status_borrowing","guard_name":"web"},"72":{"name":"Setujui_borrowing","guard_name":"web"},"73":{"name":"Tolak_borrowing","guard_name":"web"}}';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
