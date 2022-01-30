<template>
    <div id="page-content" class="p20 clearfix">
        <div class="panel panel-default">

            <div class="d-flex align-items-center justify-content-between">
                <page-heading />
                <create-button  modalHeader='Add New Purchase Requisition'>
                    Add New Purchase Requisition
                </create-button>
            </div>
            <div class="table-responsive">
                <data-table
                    :table-heading="tableHeading"
                    permission-name="view_mis_purchase_requisition">

                    <template v-slot:filter>
                        <dataFilter  @click="getDataList()"></dataFilter>
                    </template>
                    <template v-slot:data>
                        <tr v-for="(purchaseRequisition, purchaseRequisitionIndex) in dataList.data" :key="purchaseRequisitionIndex">
                            <td>{{ serialData(purchaseRequisitionIndex) }}</td>
                            <td>{{ purchaseRequisition.remark }}</td>
                            <td>{{ purchaseRequisition.date }}</td>
                            <td>{{ showData(purchaseRequisition.office,"name") }}</td>
                            
                            <td>
                             <button class="btn cur-p btn-danger btn-color" :disabled='isDisabled' v-if="purchaseRequisition.status=='Cancel'">
                                    Cancel
                            </button>
                            <button class="btn cur-p btn-success btn-color" :disabled='isDisabled' v-if="purchaseRequisition.status=='Approved'">
                                    Approved
                            </button>
                                <button @click="approveStatus(purchaseRequisition, purchaseRequisition.id)" class="btn cur-p btn-info btn-color"  :disabled='!isDisabled'   v-if="purchaseRequisition.status=='Pending'">
                                    Pending
                                </button>
                            </td>
                            <td class="w-50">
                                <div class="gap-10 peers">
                                    <div class="peer" v-if="purchaseRequisition.status=='Pending'">
                                        <edit-button @click.native="editPurchaseRequisition(purchaseRequisition, purchaseRequisition.id, 'Edit Purchase Requisition')" />
                                    </div>
                                    <div class="peer">
                                        <delete-button @click.native="deleteInformation(purchaseRequisitionIndex, purchaseRequisition.id)"/>
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
                        <label class="form-label required">Date </label>
                        <date-picker v-model="formObject.date" valueType="format"  name="date" v-validate="'required'" >
                        </date-picker>
                    </div>
                    <div class="mb-3 col-md-6">
                         <label class="form-label required">Remark </label>
                         <textarea class="form-control" name="remark" v-model="formObject.remark" cols="10" rows="1"></textarea>
                    </div>
                </div>
                 <div class="row">
                    <div class="mb-3  col-md-4">
                        <label class="form-label required">Product </label>
                         <select  v-validate="formType === 1 ? 'required' : ''" name="product_id"  class="form-select" v-model="formObject.product_id" @change="changeItem()">
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
                             @keyup="changeAmount()"
                            />
                    </div>
                    <div class="mb-3  col-md-4">
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
                    <table class="display dataTable w-100" v-if="formObject.products && formObject.products.length>0">
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
                remark: "Remark",
                date: "Date",
                office_id: "Office",
                status: "Status",
                action: "Action",
              },
               isDisabled:true,
            };
        },
        methods: {
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
                    });
                }
            },

            approveStatus:function(data){
            const _this = this;
            let purchaseRequisitionId  = data.id;
            console.log(purchaseRequisitionId);
            let URL = baseUrl +'/'+ "purchase-requisition-approve?purchase_requisition_id=" + purchaseRequisitionId;
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

            changeItem(){
                const _this = this;
                let product_id  = _this.formObject.product_id;
                let URL = baseUrl +'/'+ "get-by-product?product_id=" + product_id;
                 
                    this.axios.get(URL)
                    .then((response) => {
                    let price = response.data.purchase_price;
                    this.$set(_this.formObject, "amount",price);
                });
            },

            changeAmount(){
                const _this = this;
                let quantity  = _this.formObject.quantity;
                let amount = _this.formObject.amount;
                let totalAmount =  Math.round(amount * quantity);
                this.$set(_this.formObject, "amount",totalAmount);
            },
            
            removeRow(productIndex){
                const _this = this;
                _this.formObject.products.splice(productIndex,1);
            },

            editPurchaseRequisition: function (data, updateId, modalTitle) {
                const _this = this;
                if(_this.formObject.products==undefined){
                    _this.$set(_this.formObject, "products",[]);
                }
                this.editData(data, updateId, modalTitle, "formModal", function () {
                    _this.$set(_this.formObject, "products",data.purchase_requisitions);

                });
            }
        },
        mounted() {
            this.getDataList();
            this.getGeneralData(["products"]);
        },
    };
</script>
<style scoped>
    .mx-datepicker{
        width: 100% !important;
    }
</style>