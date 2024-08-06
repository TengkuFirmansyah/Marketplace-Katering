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
    <div class="mb-7 ps-10" v-for="(item, i) in child" :key="i">
        <div v-if="item.id != null">
            <div class="separator mb-4"></div>
            <Child2 :data="item" :refIdFeed="refIdFeed" :refFeed="refFeed"></Child2>
        </div>
    </div>

    <div class="separator mb-4"></div>

    <form class="position-relative mb-6">
        <textarea
        class="form-control border-0 p-0 pe-10 resize-none min-h-25px"
        data-kt-autosize="true"
        placeholder="Reply.."
        v-model="formData.feed"
        ></textarea>

        <div class="position-absolute top-0 end-0">
            <span class="btn btn-icon btn-active-color-primary" @click="send">
              <i class="bi bi-send"></i>
            </span>
        </div>
    </form>
  </template>
  
  <script lang="ts">
  import { getAssetPath } from "@/core/helpers/assets";
  import { defineComponent, onMounted, ref } from "vue";
  import Child2 from "./child2.vue";
import ApiService from "@/core/services/ApiService";
import { useRoute } from "vue-router";
import Swal from "sweetalert2";
  
  export default defineComponent({
    name: "widget-3",
    props: {
      data: {
        type: Object,
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
        Child2
    },
    setup(props) {
      const route = useRoute();
      const loading = ref<boolean>(false);
      const child = ref([
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
      const formData = ref({
        id : null,
        reply_id : props.data.id,
        ref : 'penelitian',
        ref_id : route.params.id,
        user_id : null,
        feed : '',
      });
      onMounted(() => {
        if(props.refIdFeed != null) {
          formData.value.ref_id = props.refIdFeed
        }
        if(props.refFeed != null) {
          formData.value.ref = props.refFeed
        }
        getFeedback();
      });
      const getFeedback = () => {
        let ref_id = props.refIdFeed != null ? props.refIdFeed : route.params.id
        let url = "feedback?table=false&limit=0";
        url = url + "&search=ref:"+props.refFeed+"|ref_id:"+ref_id+"|reply_id:"+props.data.id;
        url = url + "&order=created_at:asc";
        ApiService.get('',url)
            .then(({ data }) => {
                child.value = data.data.data
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
      const send = () => {
        if (loading.value == false) {
          loading.value = true;
          ApiService.post("feedback", formData.value)
            .then(({ data }) => {
              Swal.fire({
                text: "Data telah terkirim!",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                heightAuto: false,
                customClass: {
                  confirmButton: "btn btn-primary",
                },
              }).then(() => {
                loading.value = false;
                window.location.reload();
              });
            })
            .catch(({ response }) => {
              loading.value = false;
              Swal.fire({
                text: "Sorry, looks like there are some errors detected, please try again.",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                heightAuto: false,
                customClass: {
                  confirmButton: "btn btn-primary",
                },
              });
            });
        }
      }
      return {
        getAssetPath,
        child,
        formData,
        send
      };
    },
  });
  </script>
  