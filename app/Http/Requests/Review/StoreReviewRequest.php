<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreReviewRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool {
		// Because we haven't implemented authentication yet, we allow everyone to create review.
		// Once, authentication is implemented, make sure to uncomment the following line that
		// allows only logged in users to create a review.

		return true; // Auth::check(); <- this
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	public function rules(): array {
		return [
			'review_text' => 'required|string|min:5|max:1000',
			'rating' => 'required|decimal:1|min:0|max:5'
		];
	}
}
