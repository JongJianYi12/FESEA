<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\Student;
use Illuminate\Database\Seeder;
//use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        Student::factory(25)->create();

        Exam::factory(10)->create();

    }
}
