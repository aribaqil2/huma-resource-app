<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class HumanResourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Seed departments
        
        DB::table('departments')->insert([
            [
                'name' => 'HR', 
                'description' => 'Human Resources Department', 
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'IT',
                'description' => 'Department responsible for information technology',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
        

        // Seed roles
        DB::table('roles')->insert([
            [
                'title' => 'Manager',
                'description' => 'Manages the team and oversees operations',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Developer',
                'description' => 'Responsible for software development and maintenance',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'HR Specialist',
                'description' => 'Handles recruitment, employee relations, and other HR functions',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);

        // Seed employees
        DB::table('employees')->insert([
            [
                'fullname' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'phone_number' => $faker->phoneNumber(),
                'address' => $faker->address(),
                'birth_date' => $faker->dateTimeBetween('-40 years', '-18 years'),
                'hire_date' => Carbon::now(),
                'department_id' => 1, // Assuming HR department
                'role_id' => 3, // Assuming HR Specialist role
                'status' => 'active',
                'salary' => $faker->randomFloat(2, 30000, 60000),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
            [
                'fullname' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'phone_number' => $faker->phoneNumber(),
                'address' => $faker->address(),
                'birth_date' => $faker->dateTimeBetween('-40 years', '-18 years'),
                'hire_date' => Carbon::now(),
                'department_id' => 2, // Assuming IT department
                'role_id' => 2, // Assuming Developer role
                'status' => 'active',
                'salary' => $faker->randomFloat(2, 50000, 100000),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ],
        ]);

        // Seed tasks
        DB::table('tasks')->insert([
            [
                'title' => $faker->sentence(),
                'description' => $faker->paragraph(),
                'assigned_to' => 1, // Assuming assigned to the first employee
                'due_date' => Carbon::parse('2025-02-01'),
                'status' => 'pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => $faker->sentence(),
                'description' => $faker->paragraph(),
                'assigned_to' => 2, // Assuming assigned to the second employee
                'due_date' => Carbon::parse('2025-03-01'),
                'status' => 'pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);

        // Seed payrolls
        DB::table('payrolls')->insert([
            [
                'employee_id' => 1,
                'salary' => $faker->randomFloat(2, 30000, 60000),
                'bonuses' => $faker->randomFloat(2, 1000, 5000),
                'deductions' => $faker->randomFloat(2, 500, 1000),
                'net_salary' => $faker->randomFloat(2, 28000, 65000),
                'pay_date' => Carbon::parse('2025-01-31'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'employee_id' => 2,
                'salary' => $faker->randomFloat(2, 50000, 100000),
                'bonuses' => $faker->randomFloat(2, 2000, 10000),
                'deductions' => $faker->randomFloat(2, 1000, 2000),
                'net_salary' => $faker->randomFloat(2, 48000, 110000),
                'pay_date' => Carbon::parse('2025-01-31'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);

        // Seed presences
        DB::table('presences')->insert([
            [
                'employee_id' => 1,
                'check_in' => Carbon::parse('2025-01-01 08:00:00'),
                'check_out' => Carbon::parse('2025-01-01 17:00:00'),
                'date' => Carbon::parse('2025-01-01'),
                'status' => 'present',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'employee_id' => 2,
                'check_in' => Carbon::parse('2025-01-01 09:00:00'),
                'check_out' => Carbon::parse('2025-01-01 18:00:00'),
                'date' => Carbon::parse('2025-01-01'),
                'status' => 'present',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);

        // Seed leave requests
        DB::table('leave_requests')->insert([
            [
                'employee_id' => 1,
                'leave_type' => 'vacation',
                'start_date' => Carbon::parse('2025-02-10'),
                'end_date' => Carbon::parse('2025-02-20'),
                'status' => 'approved',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'employee_id' => 2,
                'leave_type' => 'sick',
                'start_date' => Carbon::parse('2025-02-15'),
                'end_date' => Carbon::parse('2025-02-18'),
                'status' => 'pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
