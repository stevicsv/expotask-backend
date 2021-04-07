<?php

namespace Domain\Auth\Controllers;

use Domain\Auth\Models\User;
use App\Traits\JsonResponser;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Domain\Auth\Resources\UserResource;
use Domain\Auth\Requests\RegisterRequest;

final class RegisterController
{
  use JsonResponser;

  /**
   * Send register request.
   * 
   * @param \Domain\Auth\Requests\LoginRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function __invoke(RegisterRequest $request): JsonResponse
  {
    $data = $request->validated();

    $user = User::create($data);

    Auth::loginUsingId($user->id);

    return $this->sendSuccessResponse(new UserResource(Auth::user()), 'Succesfully logged in.', Response::HTTP_CREATED);
  }
}
