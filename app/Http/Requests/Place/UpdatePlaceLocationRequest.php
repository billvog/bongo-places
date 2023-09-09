<?php

namespace App\Http\Requests\Place;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatePlaceLocationRequest extends FormRequest {
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
			'location' => 'required|string',
			'coordinates' => 'required|array',
			'coordinates.latitude' => 'required|between:-90,90',
			'coordinates.longitude' => 'required|between:-180,180'
		];
	}
}
