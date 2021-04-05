<?php

namespace Domain\Auth\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

final class TestController
{
  /**
   * @return JsonResponse
   */
  public function __invoke(): JsonResponse
  {
    return response()
      ->json('Welcome!', Response::HTTP_OK);
  }
}
