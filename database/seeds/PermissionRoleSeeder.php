<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions =Permission::all();
        /******admin roles  */
        $admin_role = Role::where('name','admin')->first();
        foreach($permissions as $permission)
        {
            DB::table('role_permission')->insert(
                [
                    'role_id' => $admin_role->id,
                     'permission_id' => $permission->id
                ]
            );
        }
        /*****editor roles  */
        $editor = Role::where('name','Editor')->first();
        foreach($permissions as $permission)
        {
            if(!in_array($permission->name , ['edit_roles']))
            {
                DB::table('role_permission')->insert(
                    [
                        'role_id' => $editor->id,
                        'permission_id' => $permission->id
                    ]
                );
            }

        }

         /*****viewr roles  */

         $viewer = Role::where('name','Viewer')->first();
         foreach($permissions as $permission)
         {
             if(!in_array($permission->name , ['edit_users','edit_roles','edit_products','edit_orders']))
             {
                 DB::table('role_permission')->insert(
                     [
                         'role_id' => $viewer->id,
                         'permission_id' => $permission->id
                     ]
                 );
             }

         }
    }
}
