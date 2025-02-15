<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Month;
use App\Models\PaymentMode;
use App\Models\User;
use App\Models\UserBranch;
use App\Models\Year;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'branch-list',
            'branch-create',
            'branch-edit',
            'branch-delete',
            'student-list',
            'student-create',
            'student-edit',
            'student-delete',
            'course-list',
            'course-create',
            'course-edit',
            'course-delete',
            'batch-list',
            'batch-create',
            'batch-edit',
            'batch-delete',
            'student-batch-create',
            'student-batch-delete',
            'fee-list',
            'fee-create',
            'fee-edit',
            'fee-delete',
            'syllabus-list',
            'syllabus-create',
            'syllabus-edit',
            'syllabus-delete',
            'module-list',
            'module-create',
            'module-edit',
            'module-delete',
            'topic-list',
            'topic-create',
            'topic-edit',
            'topic-delete',
            'notes-list',
            'notes-create',
            'notes-edit',
            'notes-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        $user = User::create([
            'name' => 'Administrator',
            'email' => 'mail@cybernetics.me',
            'password' => Hash::make('stupid'),
        ]);

        $branch = Branch::create([
            'name' => 'Trivandrum',
            'code' => 'TVM',
            'contact_number' => '0123456789',
            'address' => 'Trivandrum',
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        Role::create(['name' => 'Student']);
        $role = Role::create(['name' => 'Administrator']);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
        UserBranch::create([
            'user_id' => $user->id,
            'branch_id' => $branch->id
        ]);

        $pmodes = [
            'cash',
            'Card',
            'Upi',
            'Bank Transfer',
            'Other',
        ];

        foreach ($pmodes as $pmode) {
            PaymentMode::create(['name' => $pmode]);
        }

        for ($i = date('Y'); $i <= date('Y') + 5; $i++) {
            Year::create(['name' => $i]);
        }

        $months = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December',
        ];

        foreach ($months as $month) {
            Month::create(['name' => $month, 'code' => substr($month, 0, 3)]);
        }
    }
}
