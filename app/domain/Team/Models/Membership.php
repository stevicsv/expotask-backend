<?php

namespace Domain\Team\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Membership extends Pivot
{
  protected $table = 'team_members';
  public $timestamps = false;
}
