<?php

namespace Domain\Team\Observers;

use Domain\Team\Models\Membership;
use Illuminate\Support\Str;

class MembershipObserver
{
  /**
   * Handle automaticlly invatation code generating.
   *
   * @param \Domain\Team\Models\Membership $model
   * @return void
   */
  public function creating(Membership $model): void
  {
    $model->invitation_code = Str::random(32);
  }
}
