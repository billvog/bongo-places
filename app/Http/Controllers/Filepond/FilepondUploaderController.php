<?php

namespace App\Http\Controllers\Filepond;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Filepond\UploadFileFilepondRequest;
use App\Models\TemporaryFile;

class FilepondUploaderController extends Controller {
	public function process(UploadFileFilepondRequest $request) {
		if ($request->hasFile('file')) {
			$temporaryFile = new TemporaryFile();
			$temporaryFile->save();

			$file = $request->file('file');
			if (is_array($file)) {
				$file = $file[0];
			}

			$uploadDirectory = config('filepond.upload_dir');
			$file->storeAs($uploadDirectory, $temporaryFile->id);

			return response($temporaryFile->id)->setStatusCode(200);
		}

		return response()->noContent(400);
	}

	public function revert(Request $request) {
		$temporaryFileId = $request->getContent();
		TemporaryFile::destroy($temporaryFileId);
		return response()->noContent();
	}
}
