<template>
  <div class="card">
    <div class="card-header border-0 pt-6">
      <div class="card-title">
        <div class="row">
            <div class="col-xl-4 my-1">
              <el-form-item>
                <el-select v-model="table.searchBySelected" class="mt-2">
                    <el-option
                        v-for="(item, j) in selectItem"
                        :key="j"
                        :value="item.columnLabel"
                        :label="item.columnName"
                    />
                </el-select>
              </el-form-item>
            </div>
            <div class="col-xl-4">
              <div class="d-flex align-items-center position-relative my-1">
                <KTIcon
                  icon-name="magnifier"
                  icon-class="fs-1 position-absolute ms-6"
                />
                <input
                  type="text"
                  v-model="table.search"
                  @input="searchItems()"
                  class="form-control form-control-solid w-250px ps-15"
                  placeholder="Search.."
                />
              </div>
            </div>
        </div>
      </div>
      <div class="card-toolbar">
        <div
          class="d-flex justify-content-end"
          data-kt-customer-table-toolbar="base"
        >
          <button
            type="button"
            class="btn btn-primary"
            data-bs-toggle="modal"
            @click="addModal"
            data-bs-target="#kt_modal_add"
          >
            <KTIcon icon-name="plus" icon-class="fs-2" />
            Add New
          </button>
        </div>
      </div>
    </div>

    <div class="card-body pt-0">
      <Datatable
        @page-change="pageChange"
        @on-items-per-page-change="itemperpageChange"
        @on-sort="sort"
        :data="tableData"
        :header="tableHeader"
        :enable-items-per-page-dropdown="true"
        :checkbox-enabled="false"
        :total="table.total"
        checkbox-label="id"
      >
        <template v-slot:name="{ row: data }">
          {{ data.name }}
        </template>
        <template v-slot:slug="{ row: data }">
          {{ data.slug }}
        </template>
        <template v-slot:path="{ row: data }">
          {{ data.path }}
        </template>
        <template v-slot:icon="{ row: data }">
          {{ data.icon }}
        </template>
        <template v-slot:order="{ row: data }">
          {{ data.order }}
        </template>
        <template v-slot:parent="{ row: data }">
          {{ data.parent ? data.parent.name : '-' }}
        </template>
        <template v-slot:log-info="{ row: data }">
            <LogInfo :data="data"></LogInfo>
        </template>
        <template v-slot:actions="{ row: data }">
          <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Action
          </button>
          <ul class="dropdown-menu">
            <li>
              <a class="dropdown-item" href="#" 
              data-bs-toggle="modal"
              @click="editModal(data.id)"
              data-bs-target="#kt_modal_add">Edit</a>
            </li>
            <li>
              <a class="dropdown-item" href="#" 
              @click="generatePermission(data.id)"
              >Generate Permission</a>
            </li>
            <li><a class="dropdown-item" href="#" 
              @click="deleteData(data.id)">Hapus</a></li>
          </ul>
        </div>
        </template>
      </Datatable>
    </div>
  </div>

  <div
    class="modal fade"
    id="kt_modal_add"
    ref="addModalRef"
    tabindex="-1"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered mw-650px">
      <div class="modal-content">
        <div class="modal-header" id="kt_modal_add">
          <template v-if="Modal && dataModal.id">
            <h2 class="fw-bold">Edit Url</h2>
          </template>
          <template v-else>
            <h2 class="fw-bold">Tambah Url</h2>
          </template>
          <div
            id="kt_modal_add_close"
            data-bs-dismiss="modal"
            class="btn btn-icon btn-sm btn-active-icon-primary"
          >
            <KTIcon icon-name="cross" icon-class="fs-1" />
          </div>
        </div>
        <template v-if="Modal && dataModal.id">
          <AddData @on-save="submit()" :data="dataModal" :modal="Modal"></AddData>
        </template>
        <template v-else-if="Modal">
          <AddData @on-save="submit()" :data="dataModal" :modal="Modal"></AddData>
        </template>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { getAssetPath } from "@/core/helpers/assets";
import { defineComponent, onMounted, ref } from "vue";
import Datatable from "@/components/kt-datatable/KTDataTable.vue";
import type { Sort } from "@/components/kt-datatable//table-partials/models";
import AddData from "./AddData.vue";

import type { IModel } from "./model";
import models from "./model";

import arraySort from "array-sort";
// import { MenuComponent } from "@/assets/ts/components";
import ApiService from "@/core/services/ApiService";
import Swal from "sweetalert2";
import LogInfo from "@/components/LogInfo.vue";
import { debounce } from "lodash";
import { hideModal } from "@/core/helpers/modal";

export default defineComponent({
  name: "customers-listing",
  components: {
    LogInfo,
    Datatable,
    AddData,
  },
  setup() {
    const addModalRef = ref<null | HTMLElement>(null);
    const Modal= ref(false);
    const dataModal = ref({
      id: null,
      name : '',
      slug : '',
      path : '',
      icon : '',
      order : '',
      parent_id : null,
    });
    const table = ref({
        pagination: {
            page: 1,
            rowsPerPage: 10,
            rowsNumber: 0,
        },
        total: 0,
        search: "",
        searchBySelected: null,
    });
    const tableData = ref<Array<IModel>>(models);
    const tableHeader = ref([
      {
        columnName: "Nama",
        columnLabel: "name",
        sortEnabled: true,
      },
      {
        columnName: "Slug",
        columnLabel: "slug",
        sortEnabled: true,
      },
      {
        columnName: "Path",
        columnLabel: "path",
        sortEnabled: true,
      },
      {
        columnName: "Icon",
        columnLabel: "icon",
        sortEnabled: true,
      },
      {
        columnName: "Order",
        columnLabel: "order",
        sortEnabled: true,
      },
      {
        columnName: "Parent",
        columnLabel: "parent",
        sortEnabled: false,
      },
      {
        columnName: "Log",
        columnLabel: "log-info",
        sortEnabled: true,
        columnWidth: 20,
      },
      {
        columnName: "Actions",
        columnLabel: "actions",
        sortEnabled: false,
        columnWidth: 150,
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

        let url = "url?table=true";
        url = url + "&page=" + page;
        url = url + "&limit=" + perpage;
        if (table.value.search !== "") {
          url = url + "&search=";
          if(table.value.searchBySelected != null){
            url = url + table.value.searchBySelected +
            ":" +
            table.value.search;
          }
        }
        ApiService.get('',url)
            .then(({ data }) => {
                tableData.value.splice(
                    0,
                    tableData.value.length,
                    ...data.data.data
                );
                table.value.total = data.data.total;
                table.value.pagination.rowsNumber = data.data.total;
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

    const searchItemsDebounced = debounce(() => {
      table.value.pagination.page = 1;
      getData({
        pagination: table.value.pagination,
        search: table.value.search,
      });
    }, 1000);

    const pageChange = (page: number) => {
        table.value.pagination.page = page;
        refreshList();
    };
    const itemperpageChange = (page: number) => {
        table.value.pagination.rowsPerPage = page;
        refreshList();
    };
    const searchItems = () => {
      searchItemsDebounced();
    };

    const sort = (sort: Sort) => {
      const reverse: boolean = sort.order === "asc";
      if (sort.label) {
        arraySort(tableData.value, sort.label, { reverse });
      }
    };
    //// End data Table

    const submit = () => {
      hideModal(addModalRef.value);
      Modal.value = false;
      refreshList();
    };

    const editModal = (id: string) => {
      dataModal.value.name = ''
      dataModal.value.id = null
      ApiService.get("url", id)
        .then(({ data }) => {
          dataModal.value = data.data
          Modal.value = true
        });
    };

    const addModal = () => {
      dataModal.value.name = ''
      dataModal.value.id = null
      Modal.value = true
    };

    const deleteData = (id : string) => {
      ApiService.delete("url/"+id)
        .then(({ data }) => {
          Swal.fire({
            text: "Data telah terhapus!",
            icon: "success",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            heightAuto: false,
            customClass: {
              confirmButton: "btn btn-primary",
            },
          }).then(() => {
            refreshList()
          });
        })
        .catch(({ response }) => {
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
    const generatePermission = (id : string) => {
      ApiService.post("url/generate-permission/"+id, dataModal)
        .then(({ data }) => {
          Swal.fire({
            text: "Permission telah terbuat!",
            icon: "success",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            heightAuto: false,
            customClass: {
              confirmButton: "btn btn-primary",
            },
          }).then(() => {
            refreshList()
          });
        })
        .catch(({ response }) => {
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
    return {
      addModalRef,
      Modal,
      dataModal,
      pageChange,
      itemperpageChange,
      table,
      tableData,
      tableHeader,
      searchItems,
      sort,
      getAssetPath,
      submit,
      editModal,
      addModal,
      deleteData,
      generatePermission,
    };
  },

  computed: {
        selectItem(): any {
            const except = ["log-info", "actions","parent"];
            return [
                ...this.tableHeader.filter(
                    (col) => !except.find((e) => e === col.columnLabel)
                ),
                { columnName: "Parent", columnLabel: "parent.nama" },
            ];
        },
    },
});
</script>
