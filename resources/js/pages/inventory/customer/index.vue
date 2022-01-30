<template>
    <div id="page-content" class="p20 clearfix">
        <div class="panel panel-default">


            <div class="d-flex align-items-center justify-content-between">
                <page-heading />
                <create-button modalHeader='Add New Customer' modalId="formModal">
                    Add New Customer
                </create-button>
            </div>


            <div class="table-responsive">

                <data-table
                    :table-heading="tableHeading">

                    <template v-slot:filter>
                        <dataFilter  @click="getDataList()"></dataFilter>
                    </template>

                    <template v-slot:data v-if="dataList.customers">
                        <tr v-for="(customerData, customerIndex) in dataList.customers.data" :key="customerIndex">
                            <td>{{ serialData(customerIndex) }}</td>
                            <td>{{ customerData.name }}</td>
                            <td>{{ customerData.mobile }}</td>
                            <td>{{ customerData.office.name }}</td>
                            <td class="w-50">
                                <div class="gap-10 peers">
                                    <div class="peer">
                                        <edit-button @click.nat.native="editData(customerData, customerData.id)" />
                                    </div>
                                    <div class="peer">
                                        <delete-button @click.nat.native="deleteInformation(customerData, customerData.id)"/>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>

                    <template v-slot:pagination>
                        <div class="datatable-tools clearfix">
                            <list-count v-if="dataList.customers" :data-list-count="dataList.customers"></list-count>
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
                <label for="company_name" class="form-label required">Company Name </label>
                <input
                    id="company_name"
                    v-validate="'required'"
                    name="name"
                    type="text"
                    v-model="formObject.name"
                    placeholder="Enter Company Name"
                    class="form-control"
                />
            </div>

            <div class="mb-3">
                <label for="mobile_number" class="form-label required">Mobile Number</label>
                <input
                    id="mobile_number"
                    v-validate="'required'"
                    name="mobile"
                    type="text"
                    v-model="formObject.mobile"
                    placeholder="Enter Mobile Number"
                    class="form-control"
                />
            </div>

            <div class="mb-3">
                <label class="form-label required">Office</label>
                <select v-validate="'required'" name="office"  class="form-select" v-model="formObject.office_id" >
                    <option v-for="office in dataList.offices" :value="office.id" :key="office.id">
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
                name: "Customer Name",
                mobile: "Customer Mobile",
                office: "Customer Office",
                action: "Action",
            },
        };
    },

    methods: {
        resetForm() {
            const _this = this;
            this.$set(_this.formObject, "name", "mobile");
        }
    },

    mounted() {
        this.resetForm();
        this.getDataList();
    },
};
</script>
