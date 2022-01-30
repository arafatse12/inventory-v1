<template>
    <div id="page-content" class="p20 clearfix">
        <div class="panel panel-default">

            <div class="d-flex align-items-center justify-content-between">
                <page-heading/>
                <create-button  modalHeader='Add New Brand'>
                    Add New Brand
                </create-button>
            </div>

            <div class="table-responsive">
                <data-table
                    :table-heading="tableHeading"
                    permission-name="view_mis_brand">

                    <template v-slot:filter>
                        <dataFilter  @click="getDataList()"></dataFilter>
                    </template>
                    <template v-slot:data>
                        <tr v-for="(brandData, brandIndex) in dataList.data" :key="brandIndex">
                            <td>{{ serialData(brandIndex) }}</td>
                            <td>{{ brandData.name }}</td>
                            <td><img
                                    width="50"
                                    alt=".."
                                    :src="getImage(brandData.logo)"
                                />
                            </td>
                            <td class="w-50">
                                <div class="gap-10 peers">
                                    <div class="peer">
                                        <edit-button @click.nat.native="editData(brandData, brandData.id)" />
                                    </div>
                                    <div class="peer">
                                        <delete-button @click.nat.native="deleteInformation(brandIndex, brandData.id)"/>
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
            @submit="submitForm(formObject, 'formModal')">
            <div class="mb-3">
                <label class="form-label required">Brand Name </label
                >
                <input
                    v-validate="'required'"
                    name="name"
                    type="text"
                    v-model="formObject.name"
                    placeholder="Enter Brand Name"
                    class="form-control"
                />
            </div>
            <div class="mb-3">
                <label class="form-label">Logo </label>
                <input type="file" class="custom-file-input" id="customFile"  ref="file" @change="onFileChange">
                <img width="50" alt=".." :src="getImage(formObject.logo)"/>
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
                    name: "Brand Name",
                    'logo':"Logo",
                    action: "Action",
                },
                 url: null,
            };
        },

        methods: {
             onFileChange(e) {
            const _this = this;
            const file = e.target.files[0];
            this.url = URL.createObjectURL(file);
            var formData = new FormData();
            var imagefile = event.target.files[0];
                formData.append("image", imagefile);
                _this.axios.post(_this.urlGenerate('image-upload'), formData).then(response => {
                        if (parseInt(response.data.status) === 2000) {
                            var retData ='images/'+response.data.result;
                            _this.$set(_this.formObject, name, retData);
                            _this.$set(_this.formObject, 'logo', retData);
                        } else {
                            _this.$toastr('error', response.data.message, 'Error');
                        }
                    }).catch(function(error) {
                        _this.$toastr('error', 'Something wrong', 'Error');
                    });
            },
        },

        mounted() {
            this.getDataList();
        },
    };
</script>


