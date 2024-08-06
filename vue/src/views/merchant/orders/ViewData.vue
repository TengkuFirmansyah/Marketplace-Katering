<template>
  <el-form
    ref="formRef"
  >
    <div class="modal-body py-10 px-lg-17">
      <div
        class="scroll-y me-n7 pe-7"
        id="kt_modal_add_scroll"
        data-kt-scroll="true"
        data-kt-scroll-activate="{default: false, lg: true}"
        data-kt-scroll-max-height="auto"
        data-kt-scroll-dependencies="#kt_modal_add"
        data-kt-scroll-wrappers="#kt_modal_add_scroll"
        data-kt-scroll-offset="300px"
      >
        <h6>Rincian Pesanan</h6>
        <table class="table">
          <tr v-for="(data, index) in dataModal.details" :key="index">
            <td style="width: 100px;">
              <img :src="data.menu.foto" class="w-100px w-lg-100px" />
            </td>
            <td>
              {{ data.qty +" x " + data.menu.nama }}
            </td>
            <td class="text-end">Rp {{ $Helpers.setCurrency2(data.harga) }}</td>
          </tr>
          <tr>
            <th colspan="2" class="mt-0"><h6>Subtotal Pesanan</h6></th>
            <th class="text-end">Rp {{ $Helpers.setCurrency2(totalPrice) }}</th>
          </tr>
          <tr>
            <th colspan="2">Kode Pesanan</th>
            <th class="text-end">{{ data.kode }}</th>
          </tr>
          <tr>
            <th colspan="2">Tanggal Pesanan</th>
            <th class="text-end">{{ data.tanggal }}</th>
          </tr>
        </table>
      </div>
    </div>

    <div class="modal-footer flex-center">
      <button
        type="reset"
        data-bs-dismiss="modal"
        id="kt_modal_add_cancel"
        class="btn btn-light me-3"
      >
        Close
      </button>
    </div>
  </el-form>
</template>

<script lang="ts">
import { getAssetPath } from "@/core/helpers/assets";
import { defineComponent, onMounted, ref, computed } from "vue";
import { countries } from "@/core/data/countries";
import Swal from "sweetalert2/dist/sweetalert2.js";
import ApiService from "@/core/services/ApiService";

export default defineComponent({
  name: "add-customer-modal",
  components: {},
  emits: ["on-save"],
  props: ["data"],
  setup(props, {emit}) {
    const dataModal = props.data;
    const formRef = ref<null | HTMLFormElement>(null);
    const loading = ref<boolean>(false);
    const totalPrice = ref(0);
    onMounted(() => {
      totalPrice.value = dataModal.details.reduce((total, item) => {
        return total + item.qty * item.harga;
      }, 0);
    });
    return {
      dataModal,
      formRef,
      loading,
      getAssetPath,
      totalPrice,
    };
  },
});
</script>
