<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GravatarTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_generate_gravatar_default_image_when_no_email_found()
    {
        $array = array_merge(range('a', 'z'), range(0, 9));

        foreach ($array as $key => $value) {
            $user = User::factory()->create([
                'email' => $value . 'fakeemail@fakeemail.com'
            ]);

            $gravatarUrl = $user->getAvatar();

            $this->assertEquals(
                "https://www.gravatar.com/avatar/" . md5($user->email)
                    . "?s=200&d=https://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-"
                    . ($key + 1) . ".png",
                $gravatarUrl
            );

            // making test's quite slow since it's actually checking the file exists on the server!
            // $response = Http::get($user->getAvatar());

            // $this->assertTrue($response->successful());
        }
    }

    /** @test */
    public function check_users_gravatar_image_exits()
    {
        $user = User::factory()->create([
            'email' => 'afakeemail@fakeemail.com'
        ]);

        $response = Http::get($user->getAvatar());

        $this->assertTrue($response->successful());
    }
}
