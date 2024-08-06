<template>
  <div class="card">
    <div class="card-body pt-0" v-if="loading == false">
      <Datatable
        @on-items-select="onItemSelect"
        :data="tableData"
        :header="tableHeader"
        :enable-items-per-page-dropdown="true"
        :checkbox-enabled="true"
        :total="table.total"
        :item-checked="itemChecked"
        :items-per-page-dropdown-enabled="false"
        :items-per-page="table.pagination.rowsPerPage"
        checkbox-label="id"
      >
        <template v-slot:name="{ row: data }">
          {{ data.name }}
        </template>
        <template v-slot:slug="{ row: data }">
          {{ data.slug }}
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
              Save
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
    const selectedIds = ref<Array<number>>([]);
    const itemChecked = ref<Array<number>>([]);
        const route = useRoute();
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
        columnName: "Url",
        columnLabel: "name",
        sortEnabled: false,
      },
      {
        columnName: "Slug",
        columnLabel: "slug",
        sortEnabled: false,
      },
    ]);

    onMounted(() => {
      refreshList();
    });
    //// Start data Table
    const refreshList = () => {
      getMenus()
      getData({
          pagination: table.value.pagination,
          search: table.value.search,
      });
    };

    const getMenus = () => {
      let url = "roles/role_permissions?role_id="+route.params.id;
        ApiService.get("",url)
        .then(({ data }) => {
          data.data.forEach(item => {
            itemChecked.value.push(item.id);
          });
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
    const getData =(props) => {
        const { page, rowsPerPage } = props.pagination;
        const perpage =
            rowsPerPage === 0
                ? table.value.pagination.rowsNumber
                : rowsPerPage;

        let url = "permissions?table=true";
        url = url + "&page=" + page;
        url = url + "&limit=" + perpage;
        url = url + "&order=slug:asc";
        ApiService.get('',url)
            .then(({ data }) => {
                tableData.value.splice(
                    0,
                    tableData.value.length,
                    ...data.data.data
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

    const onItemSelect = (selectedItems: Array<number>) => {
      selectedIds.value = selectedItems;
    };

    const saveData = () => {
      if(loadingSave.value == false) {
        loadingSave.value = true;
        let url = "roles/role_permissions?role_id="+route.params.id;
          ApiService.post(url, {data: selectedIds.value })
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
              router.push({ name: "setting-roles" });
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
      onItemSelect,
      getAssetPath,
      selectedIds,
      loading,
      loadingSave,
      itemChecked,
      saveData
    };
  },

  computed: {
        selectItem(): any {
            const except = ["log-info", "actions"];
            return [
                ...this.tableHeader.filter(
                    (col) => !except.find((e) => e === col.columnLabel)
                ),
            ];
        },
    },
});
</script>
