<?php

namespace Domain\Team\Controllers;

use Domain\Team\Models\Team;
use App\Traits\JsonResponser;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Domain\Team\Requests\StoreTeamRequest;

final class StoreTeamController
{
  use JsonResponser;

  /**
   * Send store team requests.
   * 
   * @param \Domain\Team\Requests\StoreTeamRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function __invoke(StoreTeamRequest $request): JsonResponse
  {
    $createdTeam = Team::create($request->validated());
    $createdTeam->members()->attach(Auth::user(), ['accepted' => true]);

    return $this->sendSuccessResponse($createdTeam, 'Team successfully created.', Response::HTTP_CREATED);
  }
}
