<?php

namespace Domain\Auth\Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Response;
use Domain\Auth\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  /** @test */
  public function it_can_create_account()
  {
    $resp = $this->postJson(route('auth.register'), $this->data());

    $resp
      ->assertStatus(Response::HTTP_CREATED)
      ->assertJsonStructure([
        'success', 'code', 'message', 'data' => ['name', 'email']
      ])
      ->assertJson([
        'success' => true,
        'code' => Response::HTTP_CREATED
      ]);
  }

  /** @test */
  public function it_fails_when_name_email_or_password_field_are_not_filled()
  {
    $resp = $this->postJson(route('auth.register'), $this->data([
      'name' => '',
      'email' => '',
      'password' => ''
    ]));

    $resp
      ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJsonValidationErrors(['name', 'email', 'password'])
      ->assertJson([
        'errors' => [
          'name' => [__('validation.required', ['attribute' => 'name'])],
          'email' => [__('validation.required', ['attribute' => 'email'])],
          'password' => [__('validation.required', ['attribute' => 'password'])]
        ]
      ]);
  }

  /** @test */
  public function it_fails_when_email_field_is_not_valid_format()
  {
    $resp = $this->postJson(route('auth.register'), $this->data(['email' => 'asd']));

    $resp
      ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJsonValidationErrors(['email'])
      ->assertJson([
        'errors' => ['email' => [__('validation.email', ['attribute' => 'email'])]]
      ]);
  }

  /** @test */
  public function it_fails_when_password_field_is_not_long_enough()
  {
    $resp = $this->postJson(route('auth.register'), $this->data(['password' => '12345']));

    $resp
      ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJsonValidationErrors(['password'])
      ->assertJson([
        'errors' => ['password' => [__('validation.min.string', ['attribute' => 'password', 'min' => 6])]]
      ]);
  }

  /** @test */
  public function it_fails_when_password_field_is_not_confirmed()
  {
    $resp = $this->postJson(route('auth.register'), $this->data(['password_confirmation' => '']));

    $resp
      ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJsonValidationErrors(['password'])
      ->assertJson([
        'errors' => ['password' => [__('validation.confirmed', ['attribute' => 'password'])]]
      ]);
  }

  /**
   * Generate data for requests.
   *
   * @param array $mergeData
   * @return array
   */
  public function data(array $mergeData = []): array
  {
    $user = User::factory()->make();

    return array_merge([
      'name' => $user->name,
      'email' => $user->email,
      'password' => 'password',
      'password_confirmation' => 'password',
    ], $mergeData);
  }
}
