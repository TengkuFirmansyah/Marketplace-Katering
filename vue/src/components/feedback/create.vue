<template>
    <div class="card" :class="widgetClasses">
      <div class="card-body pb-0">
        <div class="d-flex align-items-center">
          <div class="d-flex align-items-center flex-grow-1">
            <div class="d-flex flex-column">
              <span class="text-gray-500 fw-semibold">Buat Feedback</span>
            </div>
          </div>
        </div>
        <form id="kt_forms_widget_1_form" class="ql-quil ql-quil-plain pb-3">
          <div id="kt_forms_widget_1_editor" class="py-2 my-2 px-2 border rounded"></div>
  
          <div class="separator"></div>
  
          <div
            id="kt_forms_widget_1_editor_toolbar"
            class="ql-toolbar d-flex flex-stack py-2"
          >
            <div class="me-2">
              <span class="ql-formats ql-size ms-0">
                <select class="ql-size w-75px"></select>
              </span>
  
              <span class="ql-formats">
                <button class="ql-bold"></button>
                <button class="ql-italic"></button>
                <button class="ql-underline"></button>
                <button class="ql-strike"></button>
                <button class="ql-link"></button>
                <button class="ql-clean"></button>
              </span>
            </div>
  
            <div class="me-n3">
              <span class="btn btn-icon btn-sm px-10 me-3 btn-primary" @click="send">
                <i class="bi bi-send"></i>&nbsp;Kirim
              </span>
            </div>
          </div>
        </form>
      </div>
    </div>
  </template>
  
  <script lang="ts">
  import { getAssetPath } from "@/core/helpers/assets";
  import { defineComponent, onMounted, ref } from "vue";
  import Quill from "quill";
import { useRoute } from "vue-router";
import ApiService from "@/core/services/ApiService";
import Swal from "sweetalert2";
  
  export default defineComponent({
    name: "widget-1",
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
    components: {},
    setup(props) {
      const route = useRoute();
      const loading = ref<boolean>(false);
      const formData = ref({
        id : null,
        reply_id : null,
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
        const editorId = "kt_forms_widget_1_editor";
        // init editor
        const options = {
          modules: {
            toolbar: {
              container: "#kt_forms_widget_1_editor_toolbar",
            },
          },
          theme: "snow",
        };
  
        // Init editor
        new Quill("#" + editorId, options);
      });
      
      const send = () => {
        const dataDiv = document.querySelector("#kt_forms_widget_1_editor .ql-editor");
        if (dataDiv && loading.value == false) {
          loading.value = true;
          formData.value.feed = dataDiv.innerHTML;
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
        formData,
        send,
        getAssetPath,
      };
    },
  });
  </script>
  