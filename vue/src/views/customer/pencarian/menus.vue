<template>
  <div class="card">
    <div class="card-body pt-0" v-if="loading == false">
      <Datatable
        @on-items-select="onItemSelect"
        :data="tableData"
        :header="tableHeader"
        :enable-items-per-page-dropdown="true"
        :items-per-page-dropdown-enabled="false"
        :items-per-page="table.pagination.rowsPerPage"
        :checkbox-enabled="false"
        :total="table.total"
        checkbox-label="id"
      >
        <template v-slot:nama="{ row: data }">
          {{ data.nama }}
        </template>
        <template v-slot:deskripsi="{ row: data }">
          {{ data.deskripsi }}
        </template>
        <template v-slot:harga="{ row: data }">
          {{ $Helpers.setCurrency2(data.harga) }}
        </template>
        <template v-slot:foto="{ row: data }">
          <img :src="data.foto" class="h-50px h-lg-50px" />
        </template>
        <template v-slot:qty="{ row: data }">
          <input type="number" class="form-control" min="0" max="10" v-model="data.qty">
        </template>
      </Datatable>
    </div>
    <div class="card-footer border-0 pt-6">
      <div class="card-toolbar">
        <div
          class="d-flex justify-content-end"
          data-kt-customer-table-toolbar="base"
        >
          <button
            type="button"
            class="btn btn-primary"
            :data-kt-indicator="loadingSave ? 'on' : null"
            @click="saveData"
          >
            <span v-if="!loadingSave" class="indicator-label">
              <KTIcon icon-name="save-2" icon-class="fs-2" />
              Order
            </span>
            <span v-if="loadingSave" class="indicator-progress">
              Please wait...
              <span
                class="spinner-border spinner-border-sm align-middle ms-2"
              ></span>
            </span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { getAssetPath } from "@/core/helpers/assets";
import { defineComponent, onMounted, ref } from "vue";
import Datatable from "@/components/kt-datatable/KTDataTable.vue";
import { useRoute } from "vue-router";

import type { IModel } from "./model";
import models from "./model";
import ApiService from "@/core/services/ApiService";
import Swal from "sweetalert2";
import router from "@/router";

export default defineComponent({
  name: "customers-listing",
  components: {
    Datatable,
  },
  setup() {
    const route = useRoute();
    const formData = ref({});
    const table = ref({
        pagination: {
            page: 1,
            rowsPerPage: 1000,
            rowsNumber: 0,
        },
        total: 0,
        search: "",
        searchBySelected: null,
    });
    const tableData = ref<Array<IModel>>(models);
    const loading = ref<boolean>(true);
    const loadingSave = ref<boolean>(false);
    const tableHeader = ref([
      {
        columnName: "Nama",
        columnLabel: "nama",
        sortEnabled: false,
      },
      {
        columnName: "Deskripsi",
        columnLabel: "deskripsi",
        sortEnabled: false,
      },
      {
        columnName: "Foto",
        columnLabel: "foto",
        sortEnabled: false,
      },
      {
        columnName: "Harga",
        columnLabel: "harga",
        sortEnabled: false,
      },
      {
        columnName: "Qty",
        columnLabel: "qty",
        sortEnabled: false,
      },
    ]);

    onMounted(() => {
      refreshList();
    });
    //// Start data Table
    const refreshList = () => {
      getData({
          pagination: table.value.pagination,
          search: table.value.search,
      });
    };
    const getData =(props) => {
        const { page, rowsPerPage } = props.pagination;
        const perpage =
            rowsPerPage === 0
                ? table.value.pagination.rowsNumber
                : rowsPerPage;

        let url = "menu?table=true";
        url = url + "?page=" + page;
        url = url + "&limit=" + perpage;
        url = url + "&search=merchant_id:"+route.params.id;
        url = url + "&order=slug:asc";
        ApiService.get('',url)
            .then(({ data }) => {
                  const updatedData = data.data.data.map(item => ({
                      ...item,
                      qty: 0
                  }));
                tableData.value.splice(
                    0,
                    tableData.value.length,
                    ...updatedData
                );
                table.value.total = data.total;
                table.value.pagination.rowsNumber = data.data.total;
                loading.value = false
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

    const saveData = () => {
      const hasValidQty = Object.values(tableData.value).some(
        (data) => data.qty > 0
      );

      if (!hasValidQty) {
        Swal.fire({
          text: "Harap masukkan qty lebih dari 0 untuk setidaknya satu item.",
          icon: "warning",
          buttonsStyling: false,
          confirmButtonText: "Ok",
          customClass: {
            confirmButton: "btn btn-warning",
          },
        });
        return;
      }
      if(loadingSave.value == false) {
        loadingSave.value = true;
        let url = "order";
          ApiService.post(url, {data: tableData.value })
          .then(({ data }) => {
            Swal.fire({
              text: "Data telah tersimpan!",
              icon: "success",
              buttonsStyling: false,
              confirmButtonText: "Ok, got it!",
              heightAuto: false,
              customClass: {
                confirmButton: "btn btn-primary",
              },
            }).then(() => {
              loadingSave.value = false;
              router.push({ name: "customer-pembelian" });
            });
          })
          .catch(({ response }) => {
              loadingSave.value = false;
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
    };
    //// End data Table
    return {
      table,
      tableData,
      tableHeader,
      getAssetPath,
      loading,
      loadingSave,
      saveData,
      formData
    };
  },

  computed: {},
});
</script>
