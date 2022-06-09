<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use WithFaker;

    /**
     * Guest
     */

    public function test_guest_sees_auth_form()
    {
        $this->get(route('ad.index'))
            ->assertSee([
                'Your username',
                'Your password',
                'Sign in'
            ]);
    }

    public function test_guest_sees_oauth_facebook_button()
    {
        $this->get(route('ad.index'))
            ->assertSee('facebook');
    }

    public function test_logout_guest_user()
    {
        $this->get(route('auth.logOut'))
            ->assertRedirect(route('ad.index'));
    }

    /**
     * Auth
     */

    public function test_sign_in_existing_user()
    {
        $this->withoutMiddleware();
        $user = User::factory()->create();

        $response = $this->post(
            route('auth.signIn'),
            [
                'username' => $user->username,
                'password' => 'secret777'
            ]
        );

        $response->assertRedirect(route('ad.index'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_sign_in_new_user()
    {
        $this->withoutMiddleware();

        $response = $this->post(
            route('auth.signIn'),
            [
                'username' => Str::slug($this->faker()->lastName()),
                'password' => $this->faker()->password()
            ]
        );

        $response->assertRedirect(route('ad.index'));
        $this->assertAuthenticated();
    }

    public function test_logout_auth_user()
    {
        $this->actingAs(User::where('is_deleted', false)->first())
            ->get(route('auth.logOut'))
            ->assertRedirect(route('ad.index'));

        $this->assertGuest();
    }
}
