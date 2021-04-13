<?php

namespace Domain\Team\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
}
