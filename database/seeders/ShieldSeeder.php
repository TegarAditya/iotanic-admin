<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_land","view_any_land","create_land","update_land","restore_land","restore_any_land","replicate_land","reorder_land","delete_land","delete_any_land","force_delete_land","force_delete_any_land","view_period","view_any_period","create_period","update_period","restore_period","restore_any_period","replicate_period","reorder_period","delete_period","delete_any_period","force_delete_period","force_delete_any_period","view_plant","view_any_plant","create_plant","update_plant","restore_plant","restore_any_plant","replicate_plant","reorder_plant","delete_plant","delete_any_plant","force_delete_plant","force_delete_any_plant","view_plant::variety","view_any_plant::variety","create_plant::variety","update_plant::variety","restore_plant::variety","restore_any_plant::variety","replicate_plant::variety","reorder_plant::variety","delete_plant::variety","delete_any_plant::variety","force_delete_plant::variety","force_delete_any_plant::variety","view_recommendation","view_any_recommendation","create_recommendation","update_recommendation","restore_recommendation","restore_any_recommendation","replicate_recommendation","reorder_recommendation","delete_recommendation","delete_any_recommendation","force_delete_recommendation","force_delete_any_recommendation","view_role","view_any_role","create_role","update_role","delete_role","delete_any_role","view_user","view_any_user","create_user","update_user","restore_user","restore_any_user","replicate_user","reorder_user","delete_user","delete_any_user","force_delete_user","force_delete_any_user","page_MyProfilePage","widget_StatOverview"]},{"name":"user","guard_name":"web","permissions":[]}]';
        $directPermissions = '[]';

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
