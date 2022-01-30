<template>
    <div id="page-content" class="p20 clearfix">
        <div class="panel panel-default">


            <div class="d-flex align-items-center justify-content-between">
                <page-heading />
                <create-button modalHeader='Add New User' modalId="formModal">
                    Add New User
                </create-button>
            </div>


            <div class="table-responsive">

                <data-table
                    :table-heading="tableHeading">

                    <template v-slot:filter>
                        <dataFilter  @click="getDataList()"></dataFilter>
                    </template>

                    <template v-slot:data v-if="dataList.data">
                        <tr v-for="(userData, userIndex) in dataList.data" :key="userIndex">
                            <td>{{ serialData(userIndex) }}</td>
                            <td>{{ userData.name }}</td>
                            <td>{{ userData.email }}</td>
                            <td>{{ userData.username }}</td>
                            <td>{{  showData(userData.office,'name') }}</td>
                            <td>{{ userData.address }}</td>
                            <td>{{ userData.phone }}</td>
                            <td class="w-50">
                                <div class="gap-10 peers">
                                    <div class="peer">
                                        <edit-button @click.native="editData(userData, userData.id)" />
                                    </div>
                                    <div class="peer">
                                        <delete-button @click.native="deleteInformation(userData, userData.id)"/>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>

                    <template v-slot:pagination>
                        <div class="datatable-tools clearfix">
                            <list-count v-if="dataList.data" :data-list-count="dataList.data"></list-count>
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
            @submit="submitForm(formObject, 'formModal')">
            <div class="mb-3">
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="name" class="form-label required"> Name </label>
                        <input
                            v-validate="'required'"
                            name="name"
                            type="text"
                            v-model="formObject.name"
                            placeholder="Enter Name"
                            class="form-control"
                        />
                    </div>
                    <div class="mb-3 col-md-6">
                         <label for="email" class="form-label required">Email</label>
                        <input
                            v-validate="'required'"
                            name="email"
                            type="email"
                            v-model="formObject.email"
                            placeholder="Enter Email"
                            class="form-control"
                        />
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="username" class="form-label required">User Name</label>
                        <input
                            v-validate="'required'"
                            name="username"
                            type="text"
                            v-model="formObject.username"
                            placeholder="Enter User Name"
                            class="form-control"
                        />
                    </div>
                    <div class="mb-3 col-md-6">
                        <template v-if="formType === 1">
                                <label for="password" class="form-label required"  >Password</label>
                        </template>
                         <template v-if="formType === 2">
                              <label for="password" class="form-label">Password</label>
                         </template>
                        <input
                            v-validate="formType === 1 ? 'required' : ''"
                            name="password"
                            type="password"
                            v-model="formObject.password"
                            placeholder="Enter Password"
                            class="form-control"
                        />
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-12">
                        <label for="password" class="form-label">Address</label>
                        <textarea name="address"  cols="10" rows="2" class="form-control"  v-model="formObject.address"></textarea>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label" >Phone Num:</label>
                        <input
                            name="phone"
                            type="text"
                            v-model="formObject.phone"
                            placeholder="Enter Phone"
                            class="form-control"
                        />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="office_id" class="form-label required"> Office </label>
                        <v-select  v-validate="'required'"  name="office_id" placeholder="--Select--"
                                label="name"
                                :clearable="false"
                                :reduce="office => office.id"
                                :options="requiredData.offices"
                                v-model="formObject.office_id">
                        </v-select>
                    </div>
                </div>
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
                name: "Name",
                email: "Email",
                username: "UserName",
                office_id: "Office",
                address: "Address",
                phone: "Phone",
                action: "Action",
            },
        };
    },
    methods: {

    },
    mounted() {
        this.getDataList();
        this.getGeneralData(["offices"]);
    },
};
</script>
