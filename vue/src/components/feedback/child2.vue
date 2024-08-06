<template>
  <div class="d-flex align-items-center mb-3">
      <div class="d-flex align-items-center flex-grow-1">
      <div class="symbol symbol-45px me-5">
          <img :src="getAssetPath('media/avatars/blank.png')" alt="" />
      </div>

      <div class="d-flex flex-column">
          <a href="#" class="text-gray-800 text-hover-primary fs-6 fw-bold">{{data.user ? data.user.name : ''}}</a>
          <span class="text-gray-500 fw-semibold">{{ $Helpers.logInfo(data.updated_at) }}</span>
      </div>
      </div>
  </div>

  <div class="mb-7">
      <div class="text-gray-800 mb-5">
        <span v-html="data.feed"></span>
      </div>
  </div>
</template>

<script lang="ts">
import { getAssetPath } from "@/core/helpers/assets";
import { defineComponent, onMounted, ref } from "vue";

export default defineComponent({
  name: "widget-3",
  props: ["data"],
  components: {},
  setup() {
    return {
      getAssetPath,
    };
  },
});
</script>
