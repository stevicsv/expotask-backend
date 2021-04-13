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
    $this->actingAs(User::factory()->create());

    $response = $this->postJson(route('team.store'), [
      'name' => $this->faker->name,
      'color' => $this->faker->hexColor,
    ]);

    $response
      ->assertStatus(Response::HTTP_CREATED)
      ->assertJsonStructure(['success', 'code', 'message', 'data'])
      ->assertJson([
        'success' => true,
        'code' => Response::HTTP_CREATED,
        'message' => 'Team successfully created.',
      ]);
  }

  /** @test */
  public function it_fails_when_name_or_color_fields_are_not_filled()
  {
    $this->actingAs(User::factory()->create());

    $response = $this->postJson(route('team.store'), []);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
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

    $response = $this->postJson(route('team.store'), [
      'name' => $this->faker->name,
      'color' => 'test',
    ]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
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

    $response = $this->postJson(route('team.store'), [
      'name' => 'asd',
      'color' => $this->faker->hexColor,
    ]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJsonValidationErrors(['name'])
      ->assertJson([
        'errors' => ['name' => [__('validation.min.string', ['attribute' => 'name', 'min' => 6])]]
      ]);
  }
}
