<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Education',
            'Environment',
            'Health',
            'Welfare',
        ];

        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert(
                ['slug' => Str::slug($category)],
                [
                    'name' => $category,
                    'slug' => Str::slug($category),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
