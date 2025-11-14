<?php 
 
namespace Database\Seeders; 
 
// use Illuminate\Database\Console\Seeds\WithoutModelEvents; 
use Illuminate\Database\Seeder; 
 
class DatabaseSeeder extends Seeder 
{ 
    /** 
     * Seed the application's database. 
     */ 
    public function run(): void 
    { 
 
        $this->call([ 
            AdminSeeder::class, 
            MemberSeeder::class, 
            AuthorSeeder::class, 
            PublisherSeeder::class, 
 
        ]); 
 
        $this->call([ 
            BookSeeder::class, 
        ]); 
 
        $this->call([ 
            LoanSeeder::class, 
        ]); 
    } 
}