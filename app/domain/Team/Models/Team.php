<?php

namespace Domain\Team\Models;

use Domain\Auth\Models\User;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Domain\Team\Models\Membership;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
	use HasFactory, HasSlug;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'color',
	];

	/**
	 * Generate slug.
	 * 
	 * @return \Spatie\Sluggable\SlugOptions
	 */
	public function getSlugOptions(): SlugOptions
	{
		return SlugOptions::create()
			->generateSlugsFrom('name')
			->saveSlugsTo('slug');
	}

	/**
	 * Return team members.
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function members(): BelongsToMany
	{
		return $this
			->belongsToMany(User::class, 'team_members', 'team_id', 'member_id')
			->using(Membership::class);
	}
}
