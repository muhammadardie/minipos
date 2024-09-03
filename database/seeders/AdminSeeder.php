<?php

use Illuminate\Database\Seeder;
use App\Models\app_management\User_role;
use App\Models\app_management\Role_menu;
use App\Models\app_management\Menu;
use App\Models\app_management\Permission;
use App\Models\app_management\Menu_permission;
use App\Models\app_management\Users;
use App\Models\app_management\Role;
use App\Models\emp_management\Identity;
use App\Models\emp_management\Employee;
use App\Models\master_data\Discount_type;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// create identity
		$identity       = new Identity;
		$identity->name = 'SIM';
		$identity->save();
		
		$identity       = new Identity;
		$identity->name = 'KTP';
		$identity->save(); 
		
		// create admin employee
		$emp                     = new Employee;
		$emp->identity_id        = $identity->id;
		$emp->first_name         = 'Admin';
		$emp->birth_place        = 'Jakarta';
		$emp->birth_date         = '1990-10-10';
		$emp->email              = 'admin@localhost.com';
		$emp->gender             = 1;
		$emp->marital_status     = 1;
		$emp->is_active          = true;
		$emp->save();
		
		// create user admin
		$user                 = new Users;
		$user->employee_id    = $emp->id;
		$user->email          = 'admin@localhost.com';
		$user->is_owner       = TRUE;
		$user->password       = '$2y$10$WokZYxxuMkan29H4P8fZQOh5PLPgeCRf29Fpk/QwBXecteBx4Ekty'; // 123456
		$user->remember_token = 'tUpDgSWGHo1q5crYntFUNEqZHIF124UU1nklZLYMMpB2aryaHQ5XQ1VqhgAx'; 
		$user->save();
		
		// create role admin
		$role                    = new Role;
		$role->name              = 'Admin';
		$role->description       = 'Role Administrator';
		$role->active            = TRUE;
		$role->save();

		// create user role admin
		$role          = new User_role;
		$role->user_id = 1;
		$role->role_id = 1;
		$role->save();
    }
}
