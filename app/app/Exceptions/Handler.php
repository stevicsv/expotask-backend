<?php

namespace App\Exceptions;

use App\Traits\JsonResponser;
use Illuminate\Http\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
	use JsonResponser;

	/**
	 * A list of the exception types that are not reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		//
	];

	/**
	 * A list of the inputs that are never flashed for validation exceptions.
	 *
	 * @var array
	 */
	protected $dontFlash = [
		'current_password',
		'password',
		'password_confirmation',
	];

	/**
	 * Register the exception handling callbacks for the application.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->renderable(function (ValidationException $ex) {
			return $this->sendErrorResponse($ex->validator->getMessageBag(), 'The given data is invalid!', Response::HTTP_UNPROCESSABLE_ENTITY);
		});

		$this->renderable(function (AuthenticationException $ex) {
			return $this->sendErrorResponse(null, $ex->getMessage(), Response::HTTP_UNAUTHORIZED);
		});
	}
}
