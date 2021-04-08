<?php

namespace Domain\Auth\Tests\Feature;

use Tests\TestCase;
use Domain\Auth\Models\User;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutTest extends TestCase
{
  use RefreshDatabase;

  /** @test */
  public function it_can_logout()
  {
    $this->actingAs(User::factory()->create());

    $resp = $this->deleteJson(route('auth.logout'));

    $resp
      ->assertOk()
      ->assertJsonStructure(['success', 'code', 'message', 'data'])
      ->assertJson([
        'success' => true,
        'code' => Response::HTTP_OK,
        'data' => null,
      ]);
  }

  /** @test */
  public function it_throws_unauthenticated_exception_when_user_is_not_logged_in()
  {
    $resp = $this->deleteJson(route('auth.logout'));

    $resp
      ->assertStatus(Response::HTTP_UNAUTHORIZED)
      ->assertJsonStructure(['success', 'code', 'message', 'errors'])
      ->assertJson([
        'success' => false,
        'code' => Response::HTTP_UNAUTHORIZED,
        'errors' => null,
      ]);
  }
}
