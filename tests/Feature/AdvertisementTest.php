<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Advertisement;
use App\Models\User;
use Database\Factories\AdvertisementFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AdvertisementTest extends TestCase
{
    use WithFaker;

    /**
    * CRUD guest actions with ads
    */

    public function test_create_ad_page_hasnt_assets_as_guest()
    {
        $this->get(route('ad.create'))
            ->assertRedirect(route('ad.index'));
    }

    public function test_store_ad_hasnt_assets_as_guest_post_request()
    {
        $this->post(
            route('ad.store'),
            [
                'title' => $this->faker->text(70),
                'description' => $this->faker->text(rand(100, 600))
            ]
        )
        ->assertRedirect(route('ad.index'));
    }

    public function test_read_ad_as_guest()
    {
        $this->get(
            route(
                'ad.show', 
                Advertisement::where('is_deleted', false)->first()->id
            )
        )
        ->assertOk();
    }

    public function test_update_page_ad_hasnt_assets_as_guest()
    {
        $this->get(
            route(
                'ad.edit',
                Advertisement::where('is_deleted', false)->first()->id
            )
        )
        ->assertRedirect(route('ad.index'));
    }

    public function test_delete_ad_hasnt_access_as_guest()
    {
        $this->get(
            route(
                'ad.delete',
                Advertisement::where('is_deleted', false)->first()->id
            )
        )
        ->assertRedirect(route('ad.index'));
    }

    public function test_dont_sees_delete_link_as_guest_list_page()
    {
        $this->get(route('ad.index'))
            ->assertDontSee('delete ad');
    }

    public function test_dont_sees_edit_link_as_guest_list_page()
    {
        $this->get(route('ad.index'))
            ->assertDontSee('edit ad');
    }

    public function test_dont_sees_delete_link_as_guest_ad_page()
    {
        $this->get(
            route(
                'ad.show',
                Advertisement::where('is_deleted', false)->first()->id
            )
        )
        ->assertDontSee('delete ad');
    }

    public function test_dont_sees_edit_link_as_guest_ad_page()
    {
        $this->get(
            route(
                'ad.show',
                Advertisement::where('is_deleted', false)->first()->id
            )
        )
        ->assertDontSee('edit ad');
    }
    
    /**
     * CRUD auth actions with ads
     */
    public function test_create_ad_page_has_assets_as_auth()
    {
        $this->actingAs(User::where('is_deleted', false)->first())
            ->get(route('ad.create'))
            ->assertStatus(200);
    }

    public function test_store_ad_as_auth()
    {
        $this->actingAs(User::where('is_deleted', false)->first())
            ->post(
                route('ad.store'), 
                [
                'title' => $this->faker->text(70),
                'description' => $this->faker->text(rand(100, 500)),
                ]
            )
            ->assertStatus(201);
    }

    public function test_read_ad_as_auth()
    {
        $this->actingAs(User::where('is_deleted', false)->first())
            ->get(
                route(
                    'ad.show', 
                    Advertisement::where('is_deleted', false)->first()->id
                )
            )
            ->assertOk();
    }

    public function test_update_ad_page_hasnt_assets_as_auth_not_author()
    {
        $user = User::where('is_deleted', false)->first();

        $this->actingAs($user)
        ->get(
            route(
                'ad.edit',
                Advertisement::where('user_id', '!=', $user->id)
                    ->first()
                    ->id
            )
        )
        ->assertStatus(403);
    }

    public function test_update_ad_as_auth_and_author()
    {
        $user = User::where('is_deleted', false)->first();
        $ad = Advertisement::where('user_id', $user->id)->first();
        
        $this->actingAs($user)
            ->post(
                route('ad.update', $ad->id),
                [
                    'title' => $ad->title . 'test_pass',
                    'description' => $ad->description
                ]
            );

        $this->get(
            route('ad.show', $ad->id)
        )->assertSee('test_pass');
    }

    public function test_cant_delete_ad_as_auth_no_author()
    {
        $user = User::where('is_deleted', false)->first();
        
        $this->actingAs($user)
            ->get(
                route(
                    'ad.delete',
                    Advertisement::where('is_deleted', false)
                        ->where('user_id', '!=', $user->id)
                        ->first()
                        ->id
                )
            )
            ->assertStatus(403);
    }

    public function test_delete_ad_as_auth_and_author()
    {
        $user = User::where('is_deleted', false)->first();

        $ad = Advertisement::where('is_deleted', false)
            ->where('user_id', $user->id)
            ->first();

        $this->actingAs($user)
            ->get(route('ad.delete', $ad->id));

        $this->get(route('ad.show', $ad->id))
            ->assertStatus(404);
    }

    public function test_sees_delete_link_as_auth_list_page()
    {
        $this->actingAs(User::where('is_deleted', false)->first())
            ->post(
                route('ad.store'), 
                [
                'title' => $this->faker->text(70),
                'description' => $this->faker->text(rand(100, 500)),
                ]
            );

        $this->get(route('ad.index'))
            ->assertSee('delete ad');
    }

    public function test_sees_edit_link_as_auth_list_page()
    {
        $this->actingAs(User::where('is_deleted', false)->first())
            ->post(
                route('ad.store'),
                [
                'title' => $this->faker->text(70),
                'description' => $this->faker->text(rand(100, 500)),
                ]
            );

        $this->get(route('ad.index'))
            ->assertSee('edit ad');
    }

    public function test_sees_edit_link_as_auth_ad_page()
    {
        $user = User::where('is_deleted', false)->first();

        $this->actingAs($user)
            ->get(
                route(
                    'ad.show', 
                    Advertisement::where('user_id', $user->id)->first()->id
                )
            )
            ->assertSee('edit ad');
    }

    public function test_sees_delete_link_as_auth_ad_page()
    {
        $user = User::where('is_deleted', false)->first();

        $this->actingAs($user)
            ->get(
                route(
                    'ad.show',
                    Advertisement::where('user_id', $user->id)->first()->id
                )
            )
            ->assertSee('delete ad');
    }

    /**
     * Pages
     */

    public function test_index_page_contains_ads()
    {
        $lastAd = Advertisement::where('is_deleted', false)
            ->orderBy('updated_at', 'desc')
            ->first();

        $this->get(route('ad.index'))
            ->assertSee($lastAd->title);
    }

    public function test_index_page_contains_pagination()
    {
        $this->get(route('ad.index'))
            ->assertSee('pagination');
    }

    public function test_index_page_dont_contains_create_link()
    {
        $this->get(route('ad.index'))
            ->assertDontSee('Create Ad');
    }

    public function test_index_page_contains_create_link()
    {
        $this->actingAs(User::where('is_deleted', false)->first())
            ->get(route('ad.index'))
            ->assertSee('Create Ad');
    }
}
