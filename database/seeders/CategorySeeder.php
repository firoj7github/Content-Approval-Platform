<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name'=>"movie",
                'created_at'=> now(),
                'updated_at'=> now()
            ],
            [
                'name'=>"entertainment",
                'created_at'=> now(),
                'updated_at'=> now()
            ]
            ];

            Category::insert($categories);
    }
}
