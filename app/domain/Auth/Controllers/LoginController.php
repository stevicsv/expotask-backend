<?php

namespace Domain\Auth\Controllers;

use App\Traits\JsonResponser;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Domain\Auth\Requests\LoginRequest;
use Domain\Auth\Resources\UserResource;
use Illuminate\Validation\ValidationException;

final class LoginController
{
  use JsonResponser;

  /**
   * Send login request.
   * 
   * @param \Domain\Auth\Requests\LoginRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function __invoke(LoginRequest $request): JsonResponse
  {
    $creds = $request->validated();

    if (!Auth::attempt($creds)) {
      throw ValidationException::withMessages([
        'email' => __('auth.failed')
      ]);
    }

    return $this->sendSuccessResponse(new UserResource(Auth::user()), 'Succesfully logged in.', Response::HTTP_OK);
  }
}
