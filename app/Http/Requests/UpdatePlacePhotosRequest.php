<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class UpdatePlacePhotosRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool {
		$place = $this->route('place');
		return Auth::check() && Auth::user()->id == $place->owner_id;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	public function rules(): array {
		return [
			'images' => 'required|array',
			'images.*.id' => 'required|integer',
			'images.*.order' => 'required|integer',
		];
	}

	public function failedValidation(Validator $validator) {
		throw new HttpResponseException(response()->json([
			'success'   => false,
			'message'   => 'Validation errors',
			'data'      => $validator->errors()
		], 400));
	}
}
