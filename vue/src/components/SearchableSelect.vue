<template>
    <div class="custom-select">
        <input v-model="searchInput" @keyup="performSearch" @focus="openDropdown" @blur="closeDropdown"
            placeholder="Search..." :class="customClass">
        <ul v-show="isOpen" class="bg-light">
            <li v-for="item in data" :key="item[option]" @click="selectItem(item)"
                :class="{ 'active': item === selectedItem }">
                {{ item[label] }}
            </li>
        </ul>
    </div>
</template>
  
<script>
import { computed, defineComponent, ref } from "vue";
export default defineComponent({
    props: {
        value: {
            type: [String, Number],
            default: '',
        },
        items: {
            type: Array,
            default: () => [],
        },
        label: {
            type: String,
            default: 'label', // Provide a sensible default if you have one
        },
        option: {
            type: String,
            default: 'value', // Provide a sensible default if you have one
        },
        class: {
            type: String,
            default: '',
        }
    },
    data(props) {
        const customClass = computed(() => {
            return props.class ? props.class : "badge-light-primary";
        });
        return {
            customClass,
            searchInput: '',
            isOpen: false,
            isFocused: false,
            selectedItem: null,
            data: ref([])
        };
    },
    watch: {
        items: {
            handler() {
                this.data = this.items;
                this.$watch('value', this.valueWatcherHandler, { deep: true, immediate: true });
            },
            deep: true,
            immediate: true,
        },
        value: {
            handler: 'valueWatcherHandler', // Use a method for the handler
            deep: true,
        },
    },
    created() {
        this.data = this.items;
        if (this.value != null) {
            this.setSelectedItemFromValue();
        }
    },
    methods: {
        valueWatcherHandler() {
            this.setSelectedItemFromValue();
        },
        setSelectedItemFromValue() {
            if (this.value) {
                const matchingItem = this.items.find(item => item[this.option] === this.value);
                if (matchingItem) {
                    this.selectedItem = matchingItem;
                    this.searchInput = matchingItem[this.label];
                } else {
                    this.selectedItem = null;
                    this.searchInput = "";
                }
            } else {
                this.selectedItem = null;
                this.searchInput = "";
            }
        },
        filteredItems() {
            console.log("filter")
            if (this.searchInput.length == 0) {
                this.data = this.items;
            } else {
                this.data = this.items.filter(item => item[this.label].toLowerCase().includes(this.searchInput.toLowerCase()));
            }
        },
        openDropdown() {
            this.isOpen = true;
            this.isFocused = true;
        },
        closeDropdown() {
            this.isFocused = false;
            setTimeout(() => {
                this.setSelectedItemFromValue();
                this.isOpen = false;
            }, 500);
        },
        performSearch() {
            this.filteredItems();
        },
        selectItem(item) {
            event.preventDefault();
            this.searchInput = item[this.label];
            this.selectedItem = item;
            this.isOpen = false;
            this.$emit("update:modelValue", item[this.option]);
            this.$emit("change", item);
        },
    }
});
</script>
  
<style scoped>
/* Gaya CSS kustom untuk menyesuaikan tampilan */
.custom-select {
    position: relative;
    width: 100%;
    /* Sesuaikan dengan lebar yang diinginkan */
}

ul {
    border-radius: 5px;
    list-style: none;
    padding: 0;
    margin: 0;
    border: 1px solid #ccc;
    max-height: 150px;
    z-index: 10;
    overflow-y: auto;
    position: absolute;
    width: 100%;
}

li {
    background-color: var(--kt-input-solid-bg);
    border-color: var(--kt-input-solid-bg);
    color: var(--kt-input-solid-color);
    padding: 5px;
    cursor: pointer;
}

li.active {
    background-color: #e2e2e2;
}
</style>
  