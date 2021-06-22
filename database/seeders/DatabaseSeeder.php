<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);
    Status::factory()->create(['name' => 'Considering', 'classes' => 'bg-purple text-white']);
    Status::factory()->create(['name' => 'In Progress', 'classes' => 'bg-yellow text-white']);
    Status::factory()->create(['name' => 'Implemented', 'classes' => 'bg-green text-white']);
    Status::factory()->create(['name' => 'Closed', 'classes' => 'bg-red text-white']);

    $user = User::factory()->create([
        'name' => 'halilcakar',
        'email' => 'halil@cakar.com',
        'password' => bcrypt('password'),
        'email_verified_at' => Carbon::now(),
    ]);
    Idea::factory()
        ->count(10)
        ->forCategory(['name' => "Halil's Ideas!"])
        ->create([
            'user_id' => $user->id,
        ]);

    // \App\Models\User::factory(10)->create();
    Idea::factory()->count(10)->forCategory(['name' => 'Category 1'])->create();
    Idea::factory()->count(10)->forCategory(['name' => 'Category 2'])->create();
    Idea::factory()->count(10)->forCategory(['name' => 'Category 3'])->create();
    Idea::factory()->count(10)->forCategory(['name' => 'Category 4'])->create();

  }
}
