<?php

namespace Domain\Tests\Feature;

use Tests\TestCase;
use Domain\Auth\Models\User;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreTeamTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  /** @test */
  public function it_can_create_team()
  {
    $this->actingAs($user = User::factory()->create());

    $resp = $this->postJson(route('team.store'), [
      'name' => $this->faker->name,
      'color' => $this->faker->hexColor,
    ]);

    $resp
      ->assertStatus(Response::HTTP_CREATED)
      ->assertJsonStructure(['success', 'code', 'message', 'data'])
      ->assertJson([
        'success' => true,
        'code' => Response::HTTP_CREATED,
        'message' => 'Team successfully created.',
      ]);

    // Assert membership is created along with team creation, and the creator is added as a member.
    $this
      ->assertDatabaseCount('teams', 1)
      ->assertDatabaseCount('team_members', 1)
      ->assertDatabaseHas('team_members', [
        'team_id' => json_decode($resp->getContent())->data->id,
        'member_id' => $user->id,
        'accepted' => 1
      ]);
  }

  /** @test */
  public function it_fails_when_name_or_color_fields_are_not_filled()
  {
    $this->actingAs(User::factory()->create());

    $resp = $this->postJson(route('team.store'), []);

    $resp->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJsonValidationErrors(['name', 'color'])
      ->assertJson([
        'errors' => [
          'name' => [__('validation.required', ['attribute' => 'name'])],
          'color' => [__('validation.required', ['attribute' => 'color'])],
        ]
      ]);
  }

  /** @test */
  public function it_fails_when_color_field_is_incorrect_format()
  {
    $this->actingAs(User::factory()->create());

    $resp = $this->postJson(route('team.store'), [
      'name' => $this->faker->name,
      'color' => 'test',
    ]);

    $resp->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJsonValidationErrors(['color'])
      ->assertJson([
        'errors' => [
          'color' => [__('validation.color', ['attribute' => 'color'])],
        ]
      ]);
  }

  /** @test */
  public function it_fails_when_name_field_is_not_long_enough()
  {
    $this->actingAs(User::factory()->create());

    $resp = $this->postJson(route('team.store'), [
      'name' => 'asd',
      'color' => $this->faker->hexColor,
    ]);

    $resp->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJsonValidationErrors(['name'])
      ->assertJson([
        'errors' => ['name' => [__('validation.min.string', ['attribute' => 'name', 'min' => 6])]]
      ]);
  }
}
