<template>
    <div id="page-content" class="p20 clearfix">
        <div class="panel panel-default">


            <div class="d-flex align-items-center justify-content-between">
                <page-heading />
                <create-button modalHeader='New Purchase Order' modalId="formModal">
                    New Purchase Order
                </create-button>
            </div>


            <div class="table-responsive">
                <data-table :table-heading="tableHeading">

                    <template v-slot:filter>
                        <dataFilter @click="getDataList()"></dataFilter>
                    </template>

                    <template v-slot:data v-if="dataList.purchaseOrders">
                        <tr class="tr" v-for="(purchaseOrder, purchaseOrderIndex) in dataList.purchaseOrders.data" :key="purchaseOrderIndex">
                            <td>{{ serialData(purchaseOrderIndex) }}</td>
                            <td>{{ purchaseOrder.supplier.name }}</td>
                            <td>
                               <span :class="purchaseOrder.status === 'unpaid' ? 'bgc-pink-50 c-pink-700' : 'bgc-green-50 c-green-700'" class="badge  p-10 lh-0 tt-c rounded-pill">
                                   {{ purchaseOrder.status }}
                               </span>
                            </td>
                            <td>{{ purchaseOrder.date }}</td>
                            <td>{{ formatTaka(purchaseOrder.tax) }}</td>
                            <td>{{ formatTaka(purchaseOrder.total_amount) }}</td>
                            <td>
                                <button @click.prevent="addMoreOrder(purchaseOrder, purchaseOrder.id, 'Add Stock')" type="button" class="btn btn-primary btn-color py-1 px-2">
                                    Stock
                                </button>
                            </td>
                            <td class="action">
                                <div class="gap-10 peers d-flex">
                                    <div class="peer d-none">
                                        <eye-button />
                                    </div>
                                    <div class="peer">
                                        <edit-button @click.native="editCartProduct(purchaseOrder, purchaseOrder.id, 'Edit Purchase Order')" />
                                    </div>
                                    <div class="peer">
                                        <delete-button @click.native="deleteInformation(purchaseOrder, purchaseOrder.id)"/>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>

                    <template v-slot:pagination>
                        <div class="datatable-tools clearfix">
                            <div class="col-md-12">
                                Showing {{ dataList.from ? dataList.from : 0 }} To {{ dataList.to ? dataList.to : 0 }}
                                of {{ dataList.total }} entries
                            </div>

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
            modal-title="New Purchase Order"
            @submit="submitForm(formObject, 'formModal')">

            <div>
                <div  class="row pb-3">
                    <div  class="col-md-4">
                        <label class="form-label required">Supplier</label>
                        <v-select
                            label="name"
                            :clearable="false"
                            :reduce="supplier => supplier.id"
                            :options="dataList.suppliers"
                            v-model="formObject.supplier_id">
                        </v-select>
                    </div>

                    <div  class="col-md-4">
                        <label class="form-label required">Date</label>
                        <date-picker class="w-100" v-model="formObject.date" valueType="format"  name="stock_date"  >
                        </date-picker>
                    </div>

                    <div class="col-md-4">
                        <label for="tax1" class="form-label required">Tax</label>
                        <input
                            id="tax1"
                            name="name"
                            type="text"
                            v-model="formObject.tax"
                            placeholder="Tax"
                            class="form-control"
                        />
                    </div>

                </div>

                <div class="row">
                    <div  class="col-md-4">
                        <label class="form-label required">Product</label>
                        <v-select
                            label="item_code"
                            placeholder="Select"
                            :clearable="false"
                            :options="dataList.products"
                            @input="selectProduct"
                        >
                        </v-select>
                    </div>

                    <div class="col-md-4">
                        <label for="quantity1" class="form-label required">Quantity</label>
                        <input
                            id="quantity1"
                            name="quantity"
                            type="number"
                            @keydown="changeQuantity"
                            @keyup="changeQuantity"
                            @blur="addToCartProduct()"
                            v-model="formObject.quantity"
                            placeholder=""
                            class="form-control"
                        />
                    </div>

                    <div class="col-md-3">
                        <label for="amount1" class="form-label required">Amount</label>
                        <input
                            id="amount1"
                            name="name"
                            type="number"
                            @blur="addToCartProduct()"
                            v-model="formObject.amount"
                            placeholder=""
                            class="form-control"
                        />
                    </div>
                    <div class="mb-3  col-md-1 mt-1">
                         <a class="btn btn-success mt-4"  @click="addToCartProduct()"> <i class="fa fa-plus"></i> </a>
                     </div>
                </div>
            </div>

            <hr />

            <div class="card" v-if="hasShowingListedProduct">
                <div class="card-body">
                    <table class="display table-light no-footer w-100">
                        <thead>
                            <tr>
                                <th class="text-xl-start" v-for="(th, index) in ['Product', 'Quantity', 'Amount', 'Action']" :key="index">
                                    <small>{{ th }}</small>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(productItem, index) in formObject.products" :key="index">
                                <td>
                                    <v-select
                                        :disabled="true"
                                        :clearable="false"
                                        label="item_code"
                                        :reduce="product => product.id"
                                        :options="dataList.products"
                                        v-model="productItem.product_id">
                                    </v-select>
                                </td>
                                <td>
                                    <input
                                        name="item_quantity"
                                        type="number"
                                        v-model="productItem.quantity"
                                        class="form-control" readonly
                                    />
                                </td>
                                <td>
                                    <input
                                        name="item_amount"
                                        type="number"
                                        v-model="productItem.amount"
                                        class="form-control"
                                        readonly
                                    />
                                </td>
                                <td>
                                    <delete-button @click.native="(index) => formObject.products.splice(index,1)" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </base-modal>

        <base-modal
            modal-id="stockModal"
            modal-size="modal-lg"
            modal-title="Add Stock"
            @submit="submitStock(formObject, 'stockModal')">

            <div>
                <div class="row pb-3">
                    <div class="col-md-6">
                        <label class="form-label required">Posting Date</label>
                        <div>
                            <date-picker disabled class="w-100 disabled" v-model="formObject.posting_date_time" valueType="format"  name="posting_date_time" >
                            </date-picker>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">Stock Date </label>
                        <div>
                            <date-picker class="w-100" v-model="formObject.stock_date" valueType="format"  name="stock_date"  >
                            </date-picker>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card" v-if="hasShowingListedProduct">
                <div class="card-body">
                    <table class="display table-light no-footer w-100">
                        <thead>
                            <tr>
                                <th class="text-xl-start" v-for="(th, index) in ['Amount', 'Purchase Price', 'Markup', 'Sell Price', 'Action']" :key="index">
                                    <small>{{ th }}</small>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="(data, index) in formObject.products" :key="index">
                                <td>
                                    <input
                                        name="item_amount"
                                        type="text"
                                        v-model="data.amount"
                                        class="form-control"
                                        readonly
                                    />
                                </td>
                                <td>
                                    <input
                                        disabled
                                        name="purchasePrice"
                                        type="text"
                                        value="11"
                                        v-model="data.purchase_price = data.amount/data.quantity"
                                        class="form-control"
                                        readonly
                                    />
                                </td>
                                <td>
                                    <input
                                        name="markup"
                                        type="number"
                                        @keypress="generateSellPrice(index)"
                                        @keydown="generateSellPrice(index)"
                                        @change="generateSellPrice(index)"
                                        v-model="formObject.products[index].markup"
                                        class="form-control"
                                    />
                                </td>
                                <td>
                                    <input
                                        name="sell_price"
                                        type="number"
                                        v-model="data.sell_price"
                                        class="form-control"
                                    />
                                </td>
                                <td>
                                    <delete-button @click.native="(index) => formObject.products.splice(index,1)" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
                supplier_id: "Supplier",
                status: "Status",
                date: "Date",
                tax: "Tax",
                total_amount: "Total Amount",
                stock: 'Add Stock',
                action: "Action",
            },
        };
    },

    computed: {
      hasShowingListedProduct() {
          if (!this.formObject.products || this.formObject.products.length > 0) {
              return true
          }
          return false
      }
    },

    methods: {
        resetFormData() {
            this.$set(this.formObject, "item_code", "");
            this.$set(this.formObject, "quantity", "");
            this.$set(this.formObject, "amount", "");
            this.$set(this.formObject, "total_amount", "");
            this.$set(this.formObject, "supplier_id", "");
            this.$set(this.formObject, "date", "");
            this.$set(this.formObject, "tax", "");
        },

        resetProductValue() {
            const _this = this
            _this.$set(this.formObject, "product_id", '');
            _this.$set(this.formObject, "quantity", '');
            _this.$set(this.formObject, "amount", '');
        },

        addToCartProduct() {
            const _this = this;
            if (!_this.formObject.product_id || !_this.formObject.quantity || !_this.formObject.amount) {
                return false
            }
            _this.checkProductsUndefined();
            _this.formObject.products.push({
                product_id: _this.formObject.product_id,
                quantity: _this.formObject.quantity,
                amount: _this.formObject.amount
            });
            _this.resetProductValue()
        },

        editCartProduct (data, updateId, modalTitle) {
            const _this = this;
            _this.checkProductsUndefined();
            this.editData(data, updateId, modalTitle, "formModal", function () {
                _this.$set(_this.formObject, "products", data.purchase_order_details);
            });
        },

        addMoreOrder (data, updateId, modalTitle) {
            const _this = this;
            _this.checkProductsUndefined();

            this.editData(data, updateId, modalTitle, "stockModal", function () {
                _this.$set(_this.formObject, "products", data.purchase_order_details);
                _this.$set(_this.formObject, "posting_date_time",_this.newDate());
            });
        },

        submitStock(formObject, model = true){
            const _this = this;
            this.axios.post('/stock/store', _this.formObject)
                .then((response) => {
                    _this.$toastr('success', response.data.message, 'Success');
                    if (model) {
                        _this.closeModal(model);
                    }
                })
                .catch(error => {
                    _this.$toastr('error', error.message, 'error');
                })
        },

        newDate(){
            let currentDate = new Date();
            return currentDate.toJSON().slice(0, 10).replace(/-/g, '-');
        },

        selectProduct(product) {
           const _this = this
            _this.$set(_this.formObject, "product_id", product.id)
            _this.$set(_this.formObject, "amount", product.sell_price)
            _this.$set(_this.formObject, "sell_price", product.sell_price)
        },

        checkProductsUndefined (check = true) {
           const _this = this

            if (!check) {
                _this.$set(_this.formObject, "products", [])
            }

            if(_this.formObject.products == undefined) {
                _this.$set(_this.formObject, "products", [])
            }

        },

        generateSellPrice(index) {
            const _this = this
            setTimeout(() => {
                let product = _this.formObject.products[index]
                if (product.markup <= 0) {
                    this.$set(this.formObject.products[index], "sell_price", product.purchase_price);
                    return
                }
                this.$set(this.formObject.products[index], "sell_price", Math.round(this.percentage(product.markup, product.purchase_price)));
            }, 100)
        },

        percentage(percent, total) {
           let percentage = Math.round((( Number(percent) / 100) * Number(total)).toFixed(2))
            return percentage + total
        },

        changeQuantity () {
            const _this = this;
            let total = _this.formObject.quantity * _this.formObject.sell_price;
            this.$set(_this.formObject, "amount", total);
        },
    },

    mounted() {
        const _this = this;
        _this.resetFormData();
        _this.getDataList();
        _this.checkProductsUndefined(false)
    }
};
</script>

<style lang="scss" scoped>
.tr {
    td {
        width: 10%;
    }
}
.action{
    width: 12% !important;
}
</style>
