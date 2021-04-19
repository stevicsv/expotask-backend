<?php

namespace Domain\Tests\Feature;

use Tests\TestCase;
use Domain\Auth\Models\User;
use Domain\Team\Models\Team;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetAllTeamsTest extends TestCase
{
  use RefreshDatabase;

  /** @test */
  public function it_can_retrieve_teams()
  {
    $this->actingAs($user = User::factory()->create());

    $user->teams()->attach($teams = Team::factory()->count(10)->create());

    $resp = $this->getjson(route('team.get'));
    
    $resp
      ->assertOk()
      ->assertJsonStructure(['success', 'code', 'message', 'data'])
      ->assertJson(['data' => $teams->toArray()]);
  }

  /** @test */
  public function it_throws_unauthorized_error_when_user_is_not_logged_in()
  {
    $resp = $this->getjson(route('team.get'));

    $resp->assertStatus(Response::HTTP_UNAUTHORIZED);
  }
}