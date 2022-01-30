<template>
    <div id="page-content" class="p20 clearfix">
        <div class="panel panel-default">

            <div class="d-flex align-items-center justify-content-between">
                <page-heading />
                <create-button  modalHeader='Add New Stock'>
                    Add New Stock
                </create-button>
            </div>
            <div class="table-responsive">
                <data-table
                    :table-heading="tableHeading"
                    permission-name="view_mis_product">

                    <template v-slot:filter>
                        <dataFilter  @click="getDataList()"></dataFilter>
                    </template>
                    <template v-slot:data>
                        <tr v-for="(stockData, stockIndex) in dataList.data" :key="stockIndex">
                            <td>{{ serialData(stockIndex) }}</td>
                            <td>{{ stockData.posting_date_time }}</td>
                            <td>{{ stockData.stock_date }}</td>
                            <td class="w-50">
                                <div class="gap-10 peers">
                                    <div class="peer">
                                        <edit-button @click.native="editStock(stockData, stockData.id, 'Edit Stock')" />
                                    </div>
                                    <div class="peer">
                                        <delete-button @click.native="deleteInformation(stockIndex, stockData.id)"/>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <template v-slot:pagination>
                        <div class="datatable-tools clearfix">
                            <list-count></list-count>
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
                    <div class="mb-3  col-md-5">
                        <label class="form-label required">Product </label>
                         <select  v-validate="formType === 1 ? 'required' : ''" name="product_id"  class="form-select" v-model="formObject.product_id">
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
                            />
                    </div>
                    <div class="mb-3  col-md-4">
                        <label class="form-label">Amount </label>
                        <input
                            name="amount"
                            type="number"
                            v-model="formObject.amount"
                            class="form-control"
                            @keyup="changeAmount()"
                            />
                    </div>
                    <div class="mb-3  col-md-4">
                        <label class="form-label required">Purchase Price  </label>
                        <input
                            v-validate="formType === 1 ? 'required' : ''"
                            name="purchase_price"
                            v-model="formObject.purchase_price"
                            class="form-control"
                            readonly
                            />
                    </div>
                    <div class="mb-3  col-md-3">
                        <label class="form-label">Markup </label>
                        <input
                            name="markup"
                            type="number"
                            v-model="formObject.markup"
                            class="form-control"
                             @keyup="changeMarkup()"
                            />
                    </div>
                    <div class="mb-3  col-md-4">
                        <label class="form-label required">Sell Price </label>
                        <input
                            v-validate="formType === 1 ? 'required' : ''"
                            name="sell_price"
                            type="number"
                            v-model="formObject.sell_price"
                            class="form-control"
                            />
                    </div>
                     <div class="mb-3  col-md-1 mt-1">
                         <a class="btn btn-success mt-4"  @click="addRow()"> <i class="fa fa-plus"></i> </a>
                     </div>
                    
                </div>
                <template>
                    <table class="display dataTable no-footer" v-if="formObject.products && formObject.products.length>0">
                        <thead>
                            <tr>
                                <th>Product </th>
                                <th>Quantity</th>
                                <th>Amount</th>
                                <th>Purchase Price</th>
                                <th>Markup</th>
                                <th>Sell Price</th>
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
                                    <input
                                    name="purchase_price"
                                    type="number"
                                    v-model="productData.purchase_price"
                                    class="form-control" readonly
                                    />
                                </td>
                                 <td>
                                    <input
                                    name="markup"
                                    type="number"
                                    v-model="productData.markup"
                                    class="form-control" readonly
                                    />
                                </td>
                                 <td>
                                    <input
                                    name="sell_price"
                                    type="number"
                                    v-model="productData.sell_price"
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
                posting_date_time: "Posting Date",
                stock_date: "Stock Date",
                action: "Action",
              },
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
                        purchase_price:_this.formObject.purchase_price,
                        sell_price:_this.formObject.sell_price,
                        markup:_this.formObject.markup
                    });
                }
            },

            changeAmount(){
                const _this = this;
                let quantity  = _this.formObject.quantity;
                let amount = _this.formObject.amount;
                let purchasePrice =  Math.round(amount / quantity);
                this.$set(_this.formObject, "purchase_price",purchasePrice);
            },
            
            removeRow(productIndex){
                const _this = this;
                _this.formObject.products.splice(productIndex,1);
            },

            changeMarkup(){
                const _this = this;
                let markUp  =_this.formObject.markup;
                if(markUp > 100){
                     _this.$toastr('warning','Markup cannot be greater than 100 Percent', 'warning');
                     let markUp  =_this.formObject.markup;
                     let purchasePrice  =_this.formObject.purchase_price;
                      this.$set(_this.formObject, "markup",1);
                      this.$set(_this.formObject, "sell_price",purchasePrice * 1);
                }else{
                    let purchasePrice  =_this.formObject.purchase_price;
                    let salePrice = parseInt(purchasePrice * markUp/100)+parseInt(purchasePrice);
                    this.$set(_this.formObject, "sell_price",salePrice);
                }
                
            },

            editStock: function (data, updateId, modalTitle) {
                const _this = this;
                if(_this.formObject.products==undefined){
                    _this.$set(_this.formObject, "products",[]);
                }
                this.editData(data, updateId, modalTitle, "formModal", function () {
                    console.log(data,data.stock_details);
                    _this.$set(_this.formObject, "products",data.stock_details);

                });
            }
        },
        mounted() {
            this.getDataList();
            this.getGeneralData(["products","unitTypes","suppliers","brands"]);
        },
    };
</script>
<style scoped>
    .mx-datepicker{
        width: 100% !important;
    }
</style>