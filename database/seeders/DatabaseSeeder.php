<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;
use App\Models\Vote;
use App\Models\User;
use App\Models\Status;
use App\Models\Idea;
use App\Models\Comment;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user_count = 20;
        $idea_count = 250;
        $user = User::factory()->create([
            'name' => 'halilcakar',
            'email' => 'hcakar.1992@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => Carbon::now(),
        ]);
        User::factory($user_count - 1)->create();

        Category::factory()->create(['name' => 'Category 1']);
        Category::factory()->create(['name' => 'Category 2']);
        Category::factory()->create(['name' => 'Category 3']);
        Category::factory()->create(['name' => 'Category 4']);

        Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);
        Status::factory()->create(['name' => 'Considering', 'classes' => 'bg-purple text-white']);
        Status::factory()->create(['name' => 'In Progress', 'classes' => 'bg-yellow text-white']);
        Status::factory()->create(['name' => 'Implemented', 'classes' => 'bg-green text-white']);
        Status::factory()->create(['name' => 'Closed', 'classes' => 'bg-red text-white']);

        Idea::factory($idea_count)->existing()->create();

        // generate unique votes. Ensure idea_id and user_id are unique for each row
        foreach (range(1, $user_count) as $user_id) {
            foreach (range(1, $idea_count) as $idea_id) {
                if (rand(0, 10) < 7/*$idea_id % 2 === 0*/) {
                    Vote::factory()->create([
                        'user_id' => $user_id,
                        'idea_id' => $idea_id,
                    ]);
                }
            }
        }

        // generate comments
        foreach (Idea::all() as $idea) {
            Comment::factory(5)->existing()->create([
                'idea_id' => $idea->id
            ]);
        }
    }
}
