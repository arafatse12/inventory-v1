<template>
    <div>
        <div class="d-flex dataTable justify-content-between align-items-center">
            <div id="item-table_length" class="d-flex">
                <span style="width:30px" class="pr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" style="height: 29px;" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                    </svg>
                </span>
                <select
                    name="dataTable_length"
                    v-model="$store.state.filter.per_page"
                    @change="search"
                    class="custom-select custom-select-sm form-control form-control-sm"
                >
                    <option v-for="item in filterByNumber" :value="item">{{ item }}</option>
                </select>
            </div>

            <div>
                <slot></slot>
            </div>

            <div id="item-table_filter" class="position-relative">
                <input
                    v-model="$store.state.filter.keyword"
                    @keyup.enter="search()"
                    type="search"
                    class="form-control"
                    placeholder="Search"
                />
                <span class="search__icon" @click="search()">
                  <i class="fa fa-search"></i>
              </span>
            </div>
        </div>

        <div
            id="item-table_processing"
            class="dataTables_processing"
            style="display: none"
        >
            <div class="table-loader"><span class="loading"></span></div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "listFilter",

        props: {
            filterByNumber: {
                type: Array, Object,
                default: () => [10, 20, 25, 50, 100]
            }
        },


        methods: {
            search() {
                this.$emit("click");
            }
        }
    }
</script>

<style lang="scss" scoped>
    .search__icon {
        position: absolute;
        top: 8px;
        right: 8px;
    }
</style>
