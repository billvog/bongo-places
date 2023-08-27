<?php

namespace App\Http\Requests;

use App\Enums\PlaceStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

class UpdatePlaceRequest extends FormRequest {
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
			'name' => 'required|string|min:5|max:120',
			'description' => 'required|string|max:5000',
			'location' => 'required|string',
			'coordinates' => 'required',
			'status' => ['required', new Enum(PlaceStatus::class)]
		];
	}
}
