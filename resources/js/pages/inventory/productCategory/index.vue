<template>
    <div id="page-content" class="p20 clearfix">
        <div class="panel panel-default">

            <div class="d-flex align-items-center justify-content-between">
                <page-heading />
                <create-button  modalHeader='Add New Product Category'>
                    Add New Category
                </create-button>
            </div>


            <div class="table-responsive">
                <data-table
                    :table-heading="tableHeading"
                    permission-name="view_mis_product_category">

                    <template v-slot:filter>
                        <dataFilter  @click="getDataList()"></dataFilter>
                    </template>
                    <template v-slot:data>
                        <tr v-for="(data, index) in dataList.data" :key="index">
                            <td>{{ serialData(index) }}</td>
                            <td>{{ data.name }}</td>
                            <td class="w-50">
                                <div class="gap-10 peers">
                                    <div class="peer">
                                        <edit-button @click.nat.native="editData(data, data.id)" />
                                    </div>
                                    <div class="peer">
                                        <delete-button @click.nat.native="deleteInformation(index, data.id)"/>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <template v-slot:pagination>
                        <div class="datatable-tools clearfix">
                            <list-count :data-list="dataList"></list-count>
                            <div class="col-md-12">
                                <pagination
                                    previousText="PREV"
                                    nextText="NEXT"
                                    :data="dataList"
                                    @paginateTo="getDataList"
                                />
                            </div>
                        </div>
                    </template>
                </data-table>
            </div>
        </div>

        <base-modal
            modal-id="formModal"
            modal-size="modal-md"
            modal-title="Add New"
            @submit="submitForm(formObject, 'formModal')"
        >


            <div class="mb-3">
                <label class="form-label required">Category Name </label
                >
                <input
                    v-validate="'required'"
                    name="name"
                    type="text"
                    v-model="formObject.name"
                    placeholder="Enter Category Name"
                    class="form-control"
                />
            </div>
        </base-modal>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                tableHeading: {
                    sl: "Sl",
                    name: "Category Name",
                    action: "Action",
                },
            };
        },

        methods: {
            resetFormData() {
                const _this = this;
                this.$set(_this.formObject, "name", "");
            }
        },

        mounted() {
            this.resetFormData();
            this.getDataList();
        },
    };
</script>


