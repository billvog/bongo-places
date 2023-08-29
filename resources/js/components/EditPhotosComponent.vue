<script>
import draggable from "vuedraggable";
export default {
  props: {
    photos: {
      type: Array,
    },
    uploadPhotosUrl: {
      type: String,
    },
    updatePhotosApiUrl: {
      type: String,
    },
    csrfToken: {
      type: String,
    },
  },
  components: {
    draggable,
  },
  data() {
    return {
      images: this.photos,
      activePhotosNum: this.photos.length,
      isLoading: false,
    };
  },
  methods: {
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
      this.images = this.images.map((photo) => {
        if (photo.id === photoId) {
          this.activePhotosNum--;
          return { ...photo, deleted: true };
        } else {
          return photo;
        }
      });
    },
    handleSubmitPressed() {
      this.isLoading = true;

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
          this.isLoading = false;
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
        <a
          :href="uploadPhotosUrl"
          title="Upload photos"
          class="hover:no-underline"
        >
          <div
            class="bg-orange-200 bg-opacity-50 hover:bg-opacity-70 text-orange-600 text-2xl font-normal flex justify-center items-center w-auto h-full min-h-[100px] aspect-square"
          >
            +
          </div>
        </a>
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
        :class="{ loading: isLoading }"
        :disabled="isLoading"
        @click="handleSubmitPressed"
      >
        Update
      </button>
    </div>
  </div>
</template>
