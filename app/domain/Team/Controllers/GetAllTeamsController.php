<?php

namespace Domain\Team\Controllers;

use App\Traits\JsonResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

final class GetAllTeamsController
{
  use JsonResponser;

  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function __invoke(): JsonResponse
  {
    $teams = Auth::user()->teams;
    
    return $this->sendSuccessResponse($teams, 'Successfully listed all teams.');
  }
}