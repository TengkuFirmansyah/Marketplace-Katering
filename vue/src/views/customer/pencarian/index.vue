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
    </div>

    <div class="card-body pt-0">
      <Datatable
        @page-change="pageChange"
        @on-items-per-page-change="itemperpageChange"
        @on-sort="sort"
        :data="tableData"
        :header="tableHeader"
        :enable-items-per-page-dropdown="true"
        :items-per-page="table.pagination.rowsPerPage"
        :checkbox-enabled="false"
        :total="table.total"
        checkbox-label="id"
      >
        <template v-slot:nama="{ row: data }">
          {{ data.nama }}
        </template>
        <template v-slot:alamat="{ row: data }">
          {{ data.alamat }}
        </template>
        <template v-slot:deskripsi="{ row: data }">
          {{ data.deskripsi }}
        </template>
        <template v-slot:actions="{ row: data }">
          <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Action
          </button>
          <ul class="dropdown-menu">
            <router-link
              :to="{
                  name: 'customer-pencarian-menu',
                  params: { id : data.id },
              }"
              class="dropdown-item"
            >
              Lihat Menu
            </router-link>
          </ul>
        </div>
        </template>
      </Datatable>
    </div>
  </div>
</template>

<script lang="ts">
import { getAssetPath } from "@/core/helpers/assets";
import { defineComponent, onMounted, ref } from "vue";
import Datatable from "@/components/kt-datatable/KTDataTable.vue";
import type { Sort } from "@/components/kt-datatable//table-partials/models";

import type { IModel } from "./model";
import models from "./model";

import arraySort from "array-sort";
// import { MenuComponent } from "@/assets/ts/components";
import ApiService from "@/core/services/ApiService";
import Swal from "sweetalert2";
import { debounce } from "lodash";

export default defineComponent({
  name: "customers-listing",
  components: {
    Datatable,
  },
  setup() {
    const addModalRef = ref<null | HTMLElement>(null);
    const Modal= ref(false);
    const dataModal = ref({
      id: null,
      name : '',
      slug : '',
      description : '',
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
        columnName: "Nama Merchant",
        columnLabel: "nama",
        sortEnabled: true,
      },
      {
        columnName: "Alamat Merchant",
        columnLabel: "alamat",
        sortEnabled: true,
      },
      {
        columnName: "Deskripsi",
        columnLabel: "deskripsi",
        sortEnabled: true,
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

        let url = "merchant?table=true";
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
    };
  },

  computed: {
        selectItem(): any {
            const except = ["deskripsi", "actions"];
            return [
                ...this.tableHeader.filter(
                    (col) => !except.find((e) => e === col.columnLabel)
                ),
                { columnName: "Menu", columnLabel: "menus.nama" },
            ];
        },
    },
});
</script>
