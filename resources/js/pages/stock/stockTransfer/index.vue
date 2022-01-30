<template>
    <div id="page-content" class="p20 clearfix">
        <div class="panel panel-default">

            <div class="d-flex align-items-center justify-content-between">
                <page-heading />
                <create-button  modalHeader='Add New Stock Trasnfer'>
                    Add New Stock Trasnfer
                </create-button>
            </div>
            <div class="table-responsive">
                <data-table
                    :table-heading="tableHeading">

                    <template v-slot:filter>
                        <dataFilter  @click="getDataList()"></dataFilter>
                    </template>
                    <template v-slot:data>
                        <tr v-for="(transferData, transferIndex) in dataList.data" :key="transferIndex">
                             <td>{{ serialData(transferIndex) }}</td>
                            <td>{{ showData(transferData.office,"name") }}</td>
                            <td>{{ showData(transferData.office_to,"name") }}</td>
                            <td>
                                <button class="btn btn-success" :disabled='isDisabled' v-if="transferData.status=='Receipt'">
                                    Approved
                                </button>
                                <button class="btn btn-info"  :disabled='!isDisabled'  @click="approveStatus(transferData, transferData.id)" v-if="transferData.status=='Transit'" >
                                    Pending
                                </button>

                            </td>
                             <td class="w-50">
                                <div class="gap-10 peers">
                                    <div class="peer">
                                        <edit-button @click.native="editStockTransfer(transferData, transferData.id, 'Edit Stock Trasnfer')" />
                                    </div>
                                    <div class="peer">
                                        <delete-button @click.native="deleteInformation(transferIndex, transferData.id)"/>
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
            modal-size="modal-lg"
            modal-title="Add New Stock"
            @submit="submitForm(formObject, 'formModal')"
        >
            <div class="mb-3">
                <div class="row">
                    <div class="mb-3  col-md-6">
                        <label class="form-label required">Posting Date Time </label>
                        <date-picker v-model="formObject.posting_date_time" valueType="format"  name="posting_date_time" v-validate="'required'" >
                        </date-picker>
                    </div>
                    <div class="mb-3 col-md-6">
                         <label class="form-label required">Stock Date </label>
                        <date-picker v-model="formObject.stock_date" valueType="format"  name="stock_date"  v-validate="'required'">
                        </date-picker>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3  col-md-6">
                        <label class="form-label required">Office From </label>
                        <select  v-validate="formType === 1 ? 'required' : ''" name="office_id_from"  class="form-select" v-model="formObject.office_id_from">
                                <option v-for="office in requiredData.offices" :value="office.id" :key="office.id" >
                                    {{ office.name }}
                                </option>
                        </select>
                    </div>
                    <div class="mb-3 col-md-6">
                         <label class="form-label required">Office To</label>
                        <select  v-validate="formType === 1 ? 'required' : ''" name="office_id_to"  class="form-select" v-model="formObject.office_id_to">
                                <option v-for="office in requiredData.offices" :value="office.id" :key="office.id" >
                                    {{ office.name }}
                                </option>
                        </select>
                    </div>
                </div>
                 <div class="row">
                    <div class="mb-3  col-md-5">
                        <label class="form-label required">Product </label>
                         <select  @change="changeItem()" v-validate="formType === 1 ? 'required' : ''" name="product_id"  class="form-select" v-model="formObject.product_id">
                                <option v-for="product in requiredData.products" :value="product.id" :key="product.id" >
                                    {{ product.item_code }}
                                </option>
                        </select>
                    </div>
                   <div class="mb-3  col-md-3">
                        <label class="form-label required">Quantity </label>
                        <input
                            v-validate="formType === 1 ? 'required' : ''" 
                            name="quantity"
                            type="number"
                            v-model="formObject.quantity"
                            class="form-control"
                             @keyup="changeQuantity()"
                            />
                    </div>
                    <div class="mb-3  col-md-3">
                        <label class="form-label">Amount </label>
                        <input
                            name="amount"
                            type="number"
                            v-model="formObject.amount"
                            class="form-control"
                            />
                    </div>
                     <div class="mb-3  col-md-1 mt-1">
                         <a class="btn btn-success mt-4"  @click="addRow()"> <i class="fa fa-plus"></i> </a>
                     </div>
                    
                </div>
                <template>
                    <table class="display dataTable no-footer w-100" v-if="formObject.products && formObject.products.length>0">
                        <thead>
                            <tr>
                                <th>Product </th>
                                <th>Quantity</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr  v-for="(productData, productIndex) in formObject.products" :key="productIndex">
                                <td>
                                    <select
                                        class="form-control"
                                        v-model="productData.product_id"
                                        name="product_id"
                                        :value="productData.product_id"
                                        >
                                        <option value="">--Select--</option>
                                        <option
                                            v-for="(productData, productIndex) in requiredData.products"
                                            :key="productIndex"
                                            :value="productData.id"
                                        >
                                        {{productData.item_code}}
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <input
                                        name="item_quantity"
                                        type="number"
                                        v-model="productData.quantity"
                                        class="form-control" readonly
                                    />
                                    </td>
                                <td>
                                    <input
                                    name="item_amount"
                                    type="number"
                                    v-model="productData.amount"
                                    class="form-control" readonly
                                    />
                                </td>
                                <td>
                                    <a class="btn btn-danger removeRow" id="removeRow" @click="removeRow(productIndex)"> <i class="fa fa-remove"></i> </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </template>
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
                    office_id_from: "From Office",
                    office_id_to: "To Office",
                    approve: "Approve",
                    action: "Action",
                },
                isDisabled:true,
            };
        },
        methods: {
            approveStatus:function(data){
            const _this = this;
            let stock_id  = data.stock_id;
            let URL = baseUrl +'/'+ "stock-transfer-approve?stock_id=" + stock_id;
                _this.axios.get(URL)
                .then((response) => {
                if(response.data.status===2000){
                    this.$toastr('success',response.data.message, 'Success');
                }else{
                    this.$toastr('error',response.data.message, 'error');
                }
                });
                this.getDataList();
                this.isDisabled= !this.isDisabled;
            },
            addRow: function() {
                const _this = this;
                let product_id  = _this.formObject.product_id;
                if(_this.requiredData.products== undefined){
                    this.$set(_this.formObject, "products",[]);
                }
                if(_this.formObject.products== undefined){
                    this.$set(_this.formObject, "products",[]);
                }
                if(product_id!== undefined && product_id!== ''){
                    _this.formObject.products.push
                    ({
                        product_id:_this.formObject.product_id, 
                        quantity:_this.formObject.quantity,
                        amount:_this.formObject.amount,
                        purchase_price:_this.formObject.purchase_price,
                        sell_price:_this.formObject.sell_price,
                        markup:_this.formObject.markup
                    });
                }
            },

            changeItem(){
                const _this = this;
                let product_id  = _this.formObject.product_id;
                let URL = baseUrl +'/'+ "get-by-product?product_id=" + product_id;
                 
                    this.axios.get(URL)
                    .then((response) => {
                    let price = response.data.purchase_price;
                    let purchase_price = response.data.purchase_price;
                    let sell_price = response.data.sell_price;
                    let markup = response.data.markup;
                    this.$set(_this.formObject, "amount",price);
                    this.$set(_this.formObject, "purchase_price",purchase_price);
                    this.$set(_this.formObject, "sell_price",sell_price);
                    this.$set(_this.formObject, "markup",markup);
                });
            },
            changeQuantity(){
                const _this = this;
                let product_id  = _this.formObject.product_id;
                let URL = baseUrl +'/'+ "get-by-product?product_id=" + product_id;
                    this.axios.get(URL)
                    .then((response) => {
                    console.log(response);
                    let quantity  = _this.formObject.quantity;
                        let amount = response.data.purchase_price;
                        let total = quantity*amount;
                        this.$set(_this.formObject, "amount",total);
                });
            },
                    
            removeRow(productIndex){
                const _this = this;
                _this.formObject.products.splice(productIndex,1);
            },

            editStockTransfer: function (data, updateId, modalTitle) {
                const _this = this;
                if(_this.formObject.products==undefined){
                    _this.$set(_this.formObject, "products",[]);
                }
                this.editData(data, updateId, modalTitle, "formModal", function () {
                    _this.$set(_this.formObject, "products",data.stock_details);
                    _this.$set(_this.formObject, "posting_date_time",data.stock.posting_date_time);
                    _this.$set(_this.formObject, "stock_date",data.stock.stock_date);

                });
            }
        },
        mounted() {
            this.getDataList();
            this.getGeneralData(["products","unitTypes","suppliers","brands","offices"]);
        },
    };
</script>
<style scoped>
    .mx-datepicker{
        width: 100% !important;
    }
</style>