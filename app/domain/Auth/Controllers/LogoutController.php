<?php

namespace Domain\Auth\Controllers;

use App\Traits\JsonResponser;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

final class LogoutController
{
  use JsonResponser;

  /**
   * Send logout request.
   * 
   * @return \Illimunate\Http\JsonResponse;
   */
  public function __invoke(): JsonResponse
  {
    Auth::guard('web')->logout();

    return $this->sendSuccessResponse(null, 'Succesfully logged out.', Response::HTTP_OK);
  }
}
