<template>
    <div id="page-content" class="p20 clearfix">
        <div class="panel panel-default">

            <div class="d-flex align-items-center justify-content-between">
                <page-heading />
                <create-button  modalHeader='Add New Supplier'>
                    Add New Supplier
                </create-button>
            </div>

            <div class="table-responsive">
                <data-table
                    :table-heading="tableHeading"
                    permission-name="view_mis_supplier">

                    <template v-slot:filter>
                        <dataFilter  @click="getDataList()"></dataFilter>
                    </template>

                    <template v-slot:data v-if="dataList">
                        <tr v-for="(supplierData, supplierIndex) in dataList.data" :key="supplierIndex">
                            <td>{{ serialData(supplierIndex) }}</td>
                            <td>{{ supplierData.name }}</td>
                            <td>{{ supplierData.contact_name }}</td>
                            <td>{{ supplierData.address }}</td>
                            <td>{{ supplierData.mobile }}</td>
                            <td>{{ supplierData.email }}</td>
                            <td class="w-50">
                                <div class="gap-10 peers">
                                    <div class="peer">
                                        <edit-button @click.nat.native="editData(supplierData, supplierData.id, 'Edit Supplier')" />
                                    </div>
                                    <div class="peer">
                                        <delete-button @click.nat.native="deleteInformation(supplierIndex, supplierData.id)"/>
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
                <label class="form-label required"> Name </label
                >
                <input
                    v-validate="'required'"
                    name="name"
                    type="text"
                    v-model="formObject.name"
                    placeholder="Enter Name"
                    class="form-control"
                />
            </div>
            <div class="mb-3">
                <label class="form-label required"> Contact Name  </label
                >
                <input
                    v-validate="'required'"
                    name="contact_name"
                    type="text"
                    v-model="formObject.contact_name"
                    placeholder="Enter Contact Name"
                    class="form-control"
                />
            </div>
            <div class="mb-3">
                <label class="form-label required"> Address </label
                >
               <textarea  v-validate="'required'"
                    name="address"
                    type="text"
                    v-model="formObject.address"
                    placeholder="Enter Address"
                    class="form-control">
                </textarea>
            </div>
            <div class="mb-3">
                <label class="form-label required"> Mobile </label
                >
                <input
                    v-validate="'required'"
                    name="mobile"
                    type="number"
                    v-model="formObject.mobile"
                    placeholder="Enter Mobile"
                    class="form-control"
                />
            </div>
            <div class="mb-3">
                <label class="form-label required"> Email </label
                >
                <input
                    v-validate="'required'"
                    name="email"
                    type="email"
                    v-model="formObject.email"
                    placeholder="Enter Email"
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
                    name: " Name",
                    contact_name:"Contact Name",
                    address:"Address",
                    mobile:"Mobile",
                    email:"Email",
                    action: "Action",
                },
            };
        },
        mounted() {
            this.getDataList();
        },
    };
</script>


