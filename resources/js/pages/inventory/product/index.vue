<template>
    <div id="page-content" class="p20 clearfix">
        <div class="panel panel-default">

            <div class="d-flex align-items-center justify-content-between">
                <page-heading />
                <create-button  modalHeader='Add New Product'>
                    Add New Product
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
                        <tr v-for="(productData, productIndex) in dataList.data" :key="productIndex">
                            <td>{{ serialData(productIndex) }}</td>
                            <td>{{ productData.item_code }}</td>
                            <td>{{ productData.name }}</td>
                            <td>{{ showData(productData.product_category,"name") }}</td>
                            <td>{{ productData.unit }}</td>
                            <td>{{ showData(productData.supplier,"name") }}</td>
                            <td>{{ showData(productData.brand,"name") }}</td>
                            <td>{{ productData.purchase_price }}</td>
                            <td>{{ productData.sell_price }}</td>
                            <td>{{ productData.tax }}</td>
                            <td>{{ productData.max_discount }}</td>
                            <td class="w-50">
                                <div class="gap-10 peers">
                                    <div class="peer">
                                        <edit-button @click.native="editProduct(productData, productData.id, 'Edit Product')" />
                                    </div>
                                    <div class="peer">
                                        <delete-button @click.native="deleteInformation(productIndex, productData.id)"/>
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
            modal-title="Add New product"
            @submit="submitForm(formObject, 'formModal')"
        >
            <div class="mb-3">
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label required" >Item Code</label>
                        <input
                            v-validate="'required'"
                            name="item_code"
                            type="text"
                            v-model="formObject.item_code"
                            placeholder="Enter Item Code"
                            class="form-control"
                        />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label required" >Item Name</label>
                        <input
                            v-validate="'required'"
                            name="name"
                            type="text"
                            v-model="formObject.name"
                            placeholder="Enter Name"
                            class="form-control"
                        />
                    </div>

                </div>
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label required">Unit </label>
                        <select v-validate="'required'" name="unit"  class="form-select" v-model="formObject.unit" >
                            <option v-for="unit in requiredData.unitTypes" :value="unit" :key="unit">
                                {{ unit }}
                            </option>
                        </select>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label required" > Product Category </label>
                       <a href="#" class="pb-5" @click="showNewForm('category')"><span class="label label-info pull-right mt0">
                            Add New</span></a>
                        <div v-if="selectInputs.category">
                            <add-new :dataObject="requiredData.productCategories"  url="product-category"  data-model="product_category_id"  @click="showNewForm('category')"></add-new>
                        </div>
                        <div v-else>
                            <select v-validate="'required'" name="product_category_id"  class="form-select" v-model="formObject.product_category_id">
                                <option v-for="category in requiredData.productCategories" :value="category.id" :key="category.id" >
                                    {{ category.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label required" >Reorder Qty</label>
                        <input
                            v-validate="'required'"
                            name="reorder_qty"
                            type="number"
                            v-model="formObject.reorder_qty"
                            placeholder="Enter Reorder Qty"
                            class="form-control"
                        />
                    </div>
                     <div class="mb-3 col-md-6">
                        <label class="form-label" >Opening Stock </label>
                        <input
                            name="is_opening"
                            type="number"
                            v-model="formObject.is_opening"
                            placeholder="Opening Stock"
                            class="form-control"
                        />
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label required">Supplier</label>
                        <select v-validate="'required'" name="supplier_id"  class="form-select" v-model="formObject.supplier_id" >
                            <option v-for="supplier in requiredData.suppliers" :value="supplier.id" :key="supplier.id">
                                {{ supplier.name }}
                            </option>
                        </select>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label required" >Brand</label>
                        <a href="#" class="pb-5" @click="showNewForm('brand')"><span class="label label-info pull-right mt0">
                            Add New</span>
                        </a>
                        <div v-if="selectInputs.brand">
                            <add-new :dataObject="requiredData.brands"  url="brand"  data-model="brand_id"  @click="showNewForm('brand')"></add-new>
                        </div>
                        <div v-else>
                         <select v-validate="'required'" name="brand_id"  class="form-select" v-model="formObject.brand_id" >
                            <option v-for="brand in requiredData.brands" :value="brand.id" :key="brand.id">
                                {{ brand.name }}
                            </option>
                        </select>
                        </div>
                    </div>
                </div>
                 <div class="row">
                    <div class="mb-3 col-md-4">
                        <label class="form-label required"> Purchase Price </label>
                        <input
                            v-validate="'required'"
                            name="purchase_price"
                            type="number"
                            v-model="formObject.purchase_price"
                            placeholder="Enter Purchase Price"
                            class="form-control"
                        />
                    </div>
                    <div class="mb-3 col-md-4">
                        <label class="form-label required" > Markup </label>
                        <input
                            v-validate="'required'"
                            name="markup"
                            type="number"
                            v-model="formObject.markup"
                            placeholder="Enter Markup"
                            class="form-control"
                             @keyup="changeMarkup()"
                        />
                    </div>
                    <div class="mb-3 col-md-4">
                        <label class="form-label required"> Sell Price </label>
                        <input
                             v-validate="formObject.sell_price > 0 ? '' :'required'"
                            name="sell_price"
                            type="number"
                            v-model="formObject.sell_price"
                            placeholder="Enter Sell Price"
                            class="form-control"
                        />
                    </div>

                </div>
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label required"> Max Discount </label>
                        <input
                            v-validate="'required'"
                            name="max_discount"
                            type="number"
                            v-model="formObject.max_discount"
                            placeholder="Enter Max Discount"
                            class="form-control"
                        />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label required" > Tax </label>
                        <input
                            v-validate="'required'"
                            name="tax"
                            type="number"
                            v-model="formObject.tax"
                            placeholder="Enter Tax"
                            class="form-control"
                        />
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
                    item_code: "Item Code",
                    name: "Item Name",
                    product_category_id: "Category",
                    unit: "Unit",
                    supplier_id: "Supplier",
                    brand_id: "Brand",
                    purchase_price: "Purchase Price",
                    sell_price: "Sell Price",
                    tax: "Tax",
                    max_discount: "Discount",
                    action: "Action",
                }
            };
        },

        methods: {
            editProduct: function (data, updateId, modalTitle) {
                const _this = this;
                this.editData(data, updateId, modalTitle, "formModal", function (unit) {
                    if(data.stock_details){
                        if(data.stock_details.stock.is_opening=="Yes"){
                            _this.$set(_this.formObject, "is_opening",data.stock_details.quantity);
                        }
                    }
                });
            },
            changeMarkup(){
                const _this = this;
                let markUp  =_this.formObject.markup;
                let purchasePrice  =_this.formObject.purchase_price;
                let salePrice = parseInt(purchasePrice*markUp/100)+parseInt(purchasePrice);
                this.$set(_this.formObject, "sell_price",salePrice);
            }
        },

        mounted() {
            this.getDataList();
            this.getGeneralData(["productCategories","unitTypes","suppliers","brands"]);
        },
    };
</script>


