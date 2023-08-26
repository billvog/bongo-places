import * as FilePond from "filepond";

import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginImageTransform from "filepond-plugin-image-transform";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";

import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css";

FilePond.registerPlugin(
    FilePondPluginImagePreview,
    FilePondPluginImageTransform,
    FilePondPluginFileValidateType
);

const fileInput = document.querySelector('input[type="file"].filepond');
const filepond = FilePond.create(fileInput, {
    allowMultiple: true,
    allowReorder: true,
    acceptedFileTypes: ["image/*"],
    imageResizeTargetWidth: 600,
    imageCropAspectRatio: 1,
});

window.filepond = filepond;
