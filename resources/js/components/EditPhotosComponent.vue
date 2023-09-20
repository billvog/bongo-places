<script>
import { ref } from "vue";
import draggable from "vuedraggable";

export default {
  props: {
    place: Object,
    photos: Array,
    uploadPhotosModalId: String,
    updatePhotosApiUrl: String,
    csrfToken: String,
  },
  components: {
    draggable,
  },
  data() {
    return {
      images: this.photos,
      activePhotosNum: this.photos.length,
    };
  },
  setup() {
    const submitChangesButton = ref(null);
    return {
      submitChangesButton,
    };
  },
  mounted() {
    window.onPhotosUploadedCallback = (photos) => {
      this.mergePhotos(photos);
    };
  },
  methods: {
    // ================================================================ //
    // Methods for handling reordering, deleting and submiting updates. //
    // ================================================================ //
    onChange(event) {
      if (event.moved) {
        let oldIndex = event.moved.oldIndex;
        let newIndex = event.moved.newIndex;

        let oldPhotoOrder = this.images[oldIndex].order;
        this.images[oldIndex].order = this.images[newIndex].order;
        this.images[newIndex].order = oldPhotoOrder;

        this.images.sort((a, b) => {
          if (a.order < b.order) return -1;
          if (a.order > b.order) return 1;
          return 0;
        });
      }
    },
    handleDeletePressed(photoId) {
      // If place is published and the user tries to delete
      // the 1 of 2 remaining images, warn them that doing so
      // will make the place draft.
      if (
        this.place.status === "published" &&
        this.activePhotosNum == 2 &&
        confirm(
          "Deleting this photo will leave the post with only 1 active photo, making it a draft. Are you sure you want to continue?"
        ) == false
      ) {
        return;
      }

      this.images = this.images.map((photo) => {
        if (photo.id === photoId) {
          this.activePhotosNum--;
          return { ...photo, deleted: true };
        } else {
          return photo;
        }
      });
    },
    handleSubmitChangesButtonPressed() {
      this.submitChangesButton.setIsLoading(true);

      fetch(this.updatePhotosApiUrl, {
        method: "POST",
        body: JSON.stringify({
          images: this.images,
        }),
        headers: {
          "X-CSRF-TOKEN": this.csrfToken,
          "Content-Type": "application/json",
        },
      })
        .then((response) => {
          if (response.status == 200) {
          } else {
          }
        })
        .catch(() => {})
        .finally(() => {
          this.submitChangesButton.setIsLoading(false);
        });
    },
    // =============================== //
    // Methods for handling uploading. //
    // =============================== //
    handleOpenUploadModalButtonPressed() {
      MicroModal.show(this.uploadPhotosModalId);
    },
    mergePhotos(newPhotos) {
      // The `newPhotos` variable doesn't actually contain
      // new photos. The API returns all the photos associated
      // with the place.
      // So, the job of this function is to find the photos that
      // are not currently in the `this.images` array and append them.
      newPhotos.forEach((photo) => {
        let existingImage = this.images.find((image) => photo.id === image.id);
        if (existingImage === undefined) {
          this.images.push(photo);
        }
      });
    },
  },
};
</script>

<template>
  <div class="space-y-8">
    <draggable
      v-model="images"
      group="place-photos"
      item-key="id"
      class="flex space-x-2 overflow-x-auto"
      @change="onChange"
    >
      <template #item="{ element }">
        <div class="cursor-grab relative group" v-if="!element.deleted">
          <img :src="element.file_url" class="h-[100px] w-auto object-cover" />
          <div
            class="absolute top-0 bottom-0 left-0 right-0 w-full h-full flex justify-center items-center bg-black bg-opacity-70 opacity-0 group-hover:opacity-100"
          >
            <button
              class="danger text-xs px-2 py-0.5 hover:no-underline hover:opacity-90 focus:ring-1 ring-offset-transparent"
              @click="handleDeletePressed(element.id)"
            >
              Delete
            </button>
          </div>
        </div>
      </template>
      <template #footer>
        <div
          title="Upload photos"
          class="bg-orange-200 bg-opacity-50 hover:bg-opacity-70 text-orange-600 text-2xl font-normal flex justify-center items-center w-auto h-full min-h-[100px] aspect-square cursor-pointer"
          @click="handleOpenUploadModalButtonPressed"
        >
          +
        </div>
      </template>
    </draggable>
    <div v-if="activePhotosNum <= 0">
      <span class="font-bold text-xl">
        There are no photos attached to this place.
      </span>
      <br />
      <span class="text-zinc-400 font-medium">
        Start adding photos by clicking the "+" button.
      </span>
    </div>
    <div>
      <button
        is="custom-button"
        ref="submitChangesButton"
        @click="handleSubmitChangesButtonPressed"
      >
        Update
      </button>
      <div class="text-sm text-zinc-400 font-medium mt-2.5">
        For the changes to take effect, you need to click the "Update" button.
      </div>
    </div>
  </div>
</template>
