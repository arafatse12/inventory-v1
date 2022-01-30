<template>
    <div id="item-table_wrapper" class="dataTables_wrapper no-footer">
        <div class="shadow__card">
            <div class="filter">
                <slot  name="filter"></slot>
            </div>
            <table
                id="item-table"
                class="display dataTable w-100 no-footer"
                role="grid"
                aria-describedby="item-table_info">
                <template>
                    <thead>
                    <tr role="row">
                        <th
                            v-for="(heading, index) in tableHeading"
                            :key="index"
                            @click="customSort(index)"
                            :id="index"
                            style="padding: .8rem 0rem; background-color:rgba(229, 231, 235, 1);"
                            :class="!non_sorted_field.includes(index) ? 'sorting sort_both' : '' || heading === 'Action' ? 'action_area': ''"
                        >
                            {{ heading }}
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y">
                    <slot name="data"></slot>
                    </tbody>
                </template>
            </table>
        </div>
        <slot  name="pagination"></slot>
    </div>
</template>

<script>
export default {
    name: "dataTable",

    props: {
        tableHeading: {
            type: [Array, Object],
            default: null,
        },

        permissionName: {
            type: String,
            default: "",
        },
    },

    computed: {
        calculateColspan() {
            return this.tableHeading.length ? this.tableHeading.length : "";
        },
    },

    data() {
        return {
            non_sorted_field: [
                "sl",
                "action",
                "role",
                "menu",
                "module",
                "parent",
                "icon",
                "permission",
                "identifier",
                "link",
                "address",
                "opening_balance",
                "opening_date",
                "contact_type",
                "contact_person",
                "logo",
            ],
        };
    },

    methods: {
        customSort(index) {
            if (!this.non_sorted_field.includes(index)) {
                this.$set(this.filter, "sort_column", index);
                $(".sort_both").removeClass("sort_both");
                $(".sorting_asc").removeClass("sorting_asc");
                $(".sorting_desc").removeClass("sorting_desc");
                if (this.filter.sort == "desc") {
                    $(`#${index}`).addClass("sorting_asc");
                    this.$set(this.filter, "sort", "asc");
                } else if (typeof this.filter.sort === "undefined") {
                    $(`#${index}`).addClass("sorting_asc");
                    this.$set(this.filter, "sort", "asc");
                } else {
                    $(`#${index}`).addClass("sorting_desc");
                    this.$set(this.filter, "sort", "desc");
                }
                this.getDataList();
            }
        },
    },
};
</script>

<style lang="scss" scoped>
table.dataTable thead th:first-child,
table.dataTable tbody td:first-child,
table.dataTable thead th:last-child,
table.dataTable tbody td:last-child {
    text-align: center;
    width: 6%;
}
.divide-y>:not([hidden])~:not([hidden]) {
    border-top-width: calc(1px * calc(1 - 0));
    border-bottom-width: calc(0px * 0);
    border-color: rgba(229,231,235, 1)
}
table {
    td {
        padding: .7rem 0rem;
    }
}
</style>

