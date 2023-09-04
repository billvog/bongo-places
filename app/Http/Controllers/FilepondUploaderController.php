<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadFileFilepondRequest;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;

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
