<template>
    <div id="page-content" class="p20 clearfix">
        <div class="panel panel-default">


            <div class="d-flex align-items-center justify-content-between">
                <page-heading />
                <create-button modalHeader='Add New Office' modalId="formModal">
                    Add New Office
                </create-button>
            </div>


            <div class="table-responsive">

                <data-table
                    :table-heading="tableHeading">

                    <template v-slot:filter>
                        <dataFilter  @click="getDataList()"></dataFilter>
                    </template>

                    <template v-slot:data v-if="dataList.offices">
                        <tr v-for="(officeData, officeIndex) in dataList.offices.data" :key="officeIndex">
                            <td>{{ serialData(officeIndex) }}</td>
                            <td>{{ officeData.name }}</td>
                            <td >{{ officeData.type }}</td>
                            <td >{{ officeData.offices ? officeData.offices.name : ' ' }}</td>
                            <td class="w-50">
                                <div class="gap-10 peers">
                                    <div class="peer">
                                        <edit-button @click.native="editData(officeData, officeData.id)" />
                                    </div>
                                    <div class="peer">
                                        <delete-button @click.native="deleteInformation(officeData, officeData.id)"/>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>

                    <template v-else>
                        <h2>Data not found</h2>
                    </template>

                    <template v-slot:pagination>
                        <div class="datatable-tools clearfix">
                            <list-count v-if="dataList" :data-list-count="dataList.offices"></list-count>
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
                <label for="office_name" class="form-label required">Office Name </label>
                <input
                    id="office_name"
                    v-validate="'required'"
                    name="name"
                    type="text"
                    v-model="formObject.name"
                    placeholder="Office Name"
                    class="form-control"
                />
            </div>

            <div class="mb-3">
                <label for="office_type" class="form-label required">Office Type</label>
                <input
                    id="office_type"
                    v-validate="'required'"
                    name="mobile"
                    type="text"
                    v-model="formObject.type"
                    placeholder="Office Type"
                    class="form-control"
                />
            </div>

            <div class="mb-3">
                <label class="form-label required">Office</label>
                <select v-validate="'required'" name="office"  class="form-select" v-model="formObject.parent_id" >
                    <option v-for="office in dataList.parentsOffices" :value="office.id" :key="office.id">
                        {{ office.name }}
                    </option>
                </select>
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
                    name: "Office Name",
                    type: "Office Type",
                    parent: "Parent Office",
                    action: "Action",
                },
            };
        },

        methods: {
            resetForm() {
                const _this = this;
                this.$set(_this.formObject, "name");
            }
        },

        mounted() {
            this.resetForm();
            this.getDataList();
        },
    };
</script>

<style lang="scss" scoped>
tr {
    td {
        width: 15%;
    }
}
</style>


