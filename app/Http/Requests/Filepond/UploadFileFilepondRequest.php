<?php

namespace App\Http\Requests\Filepond;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Auth;

class UploadFileFilepondRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool {
		return Auth::check();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	public function rules(): array {
		$fileRules = [
			File::image()->max('10mb')
		];

		if (is_array(request('file'))) {
			return [
				'file.*' => $fileRules
			];
		}

		return [
			'file' => $fileRules,
		];
	}

	public function failedValidation(Validator $validator) {
		dd($validator);
		throw new HttpResponseException(response()->noContent(400));
	}
}
