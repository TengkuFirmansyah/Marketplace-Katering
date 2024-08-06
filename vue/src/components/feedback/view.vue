<template>
  <div class="card mb-5" v-for="(item, i) in feed" :key="i">
    <div class="card-body pb-0" v-if="item.id != null">
        <Child :data="item" :refIdFeed="refIdFeed" :refFeed="refFeed"></Child>
    </div>
  </div>
</template>

<script lang="ts">
import { getAssetPath } from "@/core/helpers/assets";
import { defineComponent, onMounted, ref } from "vue";
import Child from "./child.vue";
import ApiService from "@/core/services/ApiService";
import Swal from "sweetalert2";
import { useRoute } from "vue-router";

export default defineComponent({
  name: "widget-3",
  props: {
    widgetClasses: {
      type: String,
      default: null
    },
    refIdFeed: {
      type: String,
      default: null
    },
    refFeed: {
      type: String,
      default: 'penelitian'
    }
  },
  components: {
    Child
  },
  setup(props) {
    const route = useRoute();
    const feed = ref([
      {
        id : null,
        reply_id : null,
        ref : '',
        ref_id : '',
        user_id : null,
        feed : '',
        children : null,
        user: ref({})
      }
    ])

    onMounted(() => {
      getFeedback();
    });
    const getFeedback = () => {
      let ref_id = props.refIdFeed != null ? props.refIdFeed : route.params.id
      let url = "feedback?table=false&limit=0";
      url = url + "&search=ref:"+props.refFeed+"|ref_id:"+ref_id+"|reply_id:is_null";
      url = url + "&order=created_at:desc";
      ApiService.get('',url)
          .then(({ data }) => {
              feed.value = data.data.data
          })
          .catch(({ response }) => {
              Swal.fire({
                  text: response.data.message,
                  icon: "error",
                  buttonsStyling: false,
                  confirmButtonText: "Try again!",
                  customClass: {
                      confirmButton: "btn fw-semobold btn-light-danger",
                  },
              });
          });
    };
    return {
      feed,
      getAssetPath,
    };
  },
});
</script>
