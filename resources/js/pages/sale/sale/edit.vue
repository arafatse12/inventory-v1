<template>
    <div id="page-content" class="p20 clearfix">
        <div class="row">
            <!-- left column -->
            <div class="col-md-7">
                <!-- general form elements -->
                <div class="box box-primary">
                    <!-- form start -->
                    <form class="form-horizontal"  @submit.prevent="submitSale(formObject)">
                        <div class="box-header with-border" style="padding-bottom: 0px;">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <h3 class="box-title text-primary"><i class="fa fa-shopping-cart text-aqua"></i> Edit Sales Invoice</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label required">Customer</label>
                                     <v-select  v-validate="'required'" placeholder="--Select--"
                                                label="name"
                                                :clearable="false"
                                                v-model="formObject.customer_id"
                                                :reduce="customer => customer.id"
                                                :options="requiredData.customers"
                                                >
                                        </v-select>
                                </div>
                                <div class="col-md-6">
									 <!-- <auto-complete></auto-complete> -->
                                     <label class="form-label">Product</label><br>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search Item Code/Item Name"  autocomplete="off" v-model="item_code" @keyup="getProductSearch()"/>
                                        </div>
                                        <div class="panel-footer" v-if="search_data.length>0">
                                            <ul class="list-group" v-for="product in requiredData.allProductsSearch" :key="product.id">
                                                 <a href="#" class="list-group-item"    @click="getProduct(product)">{{ product.item_code +'--'+ '[ Qty:' }} {{product.stockIn-product.stockOut + ' ]'+ '---'+product.name}}</a>
                                            </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- row end -->
                            <br />
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12" style="overflow-y: auto; border: 1px solid rgb(51, 122, 183); height: 473px;">
                                            <table class="table table-condensed table-bordered table-striped table-responsive items_table" style="">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th width="20%">Item Name</th>
                                                        <th width="30%">Quantity</th>
                                                        <th width="15%">Price</th>
                                                        <th width="15%">Discount</th>
                                                        <th width="15%">Subtotal</th>
                                                        <th width="5%"><i class="fa fa-close"></i></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="pos-form-tbody" style="font-size: 16px; font-weight: bold; overflow: scroll;">
                                                    <tr  v-for="(productData, productIndex) in formObject.products" :key="productIndex">
                                                        <td>
                                                            <input
                                                                name="item_code"
                                                                type="text"
                                                                v-model="productData.item_code"
                                                                class="form-control"  readonly
                                                            />
                                                        </td>

                                                        <td>
                                                            <div class="input-group input-group-sm">
                                                                <span class="input-group-btn">
                                                                    <button @click="decrementQty(productData)" :index="productIndex" type="button" class="btn btn-default btn-flat">
                                                                        <i class="fa fa-minus text-danger"></i>
                                                                        </button>
                                                                </span>
                                                                <input type="number" v-model="productData.item_quantity" class="form-control no-padding text-center min_width">
                                                                <span class="input-group-btn">
                                                                    <button @click="incrementQty(productData)" :index="productIndex"  type="button" class="btn btn-default btn-flat">
                                                                        <i class="fa fa-plus text-success"></i></button>
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input
                                                            name="item_amount"
                                                            type="number"
                                                            v-model="productData.sell_price"
                                                            class="form-control" readonly
                                                            />
                                                        </td>
                                                      <td>
                                                        <input
                                                            name="discount_percentage"
                                                            type="number"
                                                            v-model="productData.discount_percentage"
                                                            class="form-control" @change="discountPercentage(productData)"
                                                            />
                                                        </td>
                                                        <td>
                                                            <input
                                                            name="amount"
                                                            type="number"
                                                            v-model="productData.amount"
                                                            class="form-control" readonly
                                                            />
                                                        </td>
                                                        <td>
                                                            <a class="fa fa-fw fa-trash-o text-danger" style="cursor: pointer;font-size: 20px;" @click="removeRow(productIndex)" title="Delete Item?"></a>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <!-- footer code -->
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
							<div class="row pt-3">
                                <div class="col-md-6">
                                    <label class="form-label required">Payment Method: </label>
                                     <v-select  v-validate="'required'" placeholder="--Select--"
										@input="paymentMode()" :options="requiredData.salesPaymentMode"
										v-model="formObject.payment_mode" >
									</v-select>
                                </div>
								<template v-if="!isChecque">
									<div class="col-md-2">
										<label class="form-label">Payable Amount </label><br>
										<div class="input-group">
											<input type="text" name="payment_amount" class="form-control" v-model="formObject.payment_amount" @keyup="payableAmount">
										</div>
									</div>
									<div class="col-md-2">
										<label class="form-label">Change Return </label><br>
										<div class="input-group">
											<input type="text" name="change_amount" class="form-control" v-model="formObject.change_amount">
										</div>
									</div>
                                     <div class="col-md-2">
										<label class="form-label">Due </label><br>
										<div class="input-group">
											<input  type="text" name="due" class="form-control" v-model="formObject.due">
										</div>
									</div>

								</template>
								<template v-if="isChecque">
									<div class="col-md-3">
										<label class="form-label">Bank Name </label><br>
										<div class="input-group">
											<input type="text" name="bank_name" class="form-control" v-model="formObject.bank_name">
										</div>
									</div>
									<div class="col-md-3">
										<label class="form-label">Checque No </label><br>
										<div class="input-group">
											<input type="text" name="checque_no" class="form-control" v-model="formObject.checque_no">
										</div>
									</div>
								</template>
                            </div>
                        </div>

                        <!-- /.box-body -->

                        <div class="box-footer bg-gray">
                            <div class="row">
                                <div class="col-md-4 text-right">
                                    <label> Quantity:</label><br/>
                                    <span class="text-bold tot_qty" style="font-family: sans-serif; font-size: 150%;">{{totalQuantity}}</span>
                                </div>
                                <div class="col-md-4 text-right">
                                    <label>Total Amount:</label><br />
                                  <span style="font-family: sans-serif; font-size: 150%;" class="tot_amt text-bold"> ৳  {{ totalPrice }}</span>
                                </div>

                                <div class="col-md-4 text-right">
                                    <label>Grand Total:</label><br />
                                    <span style="font-family: sans-serif; font-size: 150%;" class="tot_grand text-bold"> ৳  {{ grandTotal }}</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-center pt-4">
                                        <button type="submit" class="btn bg-purple btn-block btn-flat btn-lg ctrl_a" >
                                            <i class="fa fa-money" aria-hidden="true"></i>
                                            Submit
                                        </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-5">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <!-- form start -->
                    <div class="box-body">
                        <div class="row pb-3">
                            <div class="col-md-12">
                                <section class="content" style="height: 500px;">
                                    <div class="row"  style="overflow-y: scroll; min-height: 100px; height: 500px;" >
                                        <div class="col-md-3 col-xs-6" v-for="product in requiredData.allProducts" :key="product.id"  disabled="disabled" data-toggle="tooltip" title="" style="padding-left: 5px; padding-right: 5px;" data-original-title="Rado Watch">
                                            <div
                                                class="box box-default"
                                                @click="addRow(product.id,(product.stockIn-product.stockOut))"
                                                style="max-height: 150px; min-height: 150px; cursor: pointer; background-color: #a1db75;"
                                                >
                                                <span class="label label-danger push-right" style="font-weight: bold; font-family: sans-serif;" data-toggle="tooltip" :title="product.stockIn-product.stockOut + ' Quantity in stock'">Qty: {{product.stockIn-product.stockOut}}</span>
                                                <div class="box-body box-profile">
                                                    <center>
                                                        <img class="img-responsive item_image" style="border: 1px solid gray;" src="https://pos.creatantech.com/uploads/items/1566111944_thumb.jpg" alt="Item picture" />
                                                    </center>
                                                    <label class="text-center search_item" style="font-weight: bold; font-family: sans-serif;">
                                                        {{product.item_code}}<br/>
                                                        <span class="" style="font-family: sans-serif; font-size: 150%;">৳ {{product.sell_price}} </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

                <!-- /.box -->
            </div>
            <!--/.col (right) -->
        </div>

    </div>
</template>

<script>

    export default {

        data() {
            return {
				totalQuantity:0,
				totalPrice:0,
				totalDiscount:0,
				grandTotal:0,
				isChecque: false,
                item_code:'',
                search_data:[]
			};

        },

        methods: {
			submitSale(formObject){
				const _this = this;
                 let saleId = this.$route.params.saleId;
				let URL = baseUrl +'/'+ "sale/"+saleId;
                    this.axios.put(URL,_this.formObject)
                    .then((response) => {
						_this.$toastr('success','sales updated successfully', 'Success');
					})
				.catch()
			},
			payableAmount(){
 				const _this = this;
				let payableAmount = _this.formObject.payment_amount;
				var totalAmount = 0;
				_this.formObject.products.forEach(element => {
					totalAmount += (element.amount);
				});
				let grandTotal = Math.round(totalAmount);
                if(grandTotal<parseInt(payableAmount)){
                     this.$set(_this.formObject, "due",0);
                     this.$set(_this.formObject, "change_amount",parseInt(payableAmount)-grandTotal);

                }else{
                    this.$set(_this.formObject, "due",grandTotal-parseInt(payableAmount));
                    this.$set(_this.formObject, "change_amount",0);
                   
                }
			},
             getProductSearch(){
                const _this = this;
                this.search_data = [];
                let item = _this.item_code;
                let URL = baseUrl +'/'+ "search-by-product?keyword=" + item;
                    this.axios.get(URL)
                    .then((response) => {
                        let allSearches = response.data.result;
                        this.search_data = allSearches;
                        _this.requiredData.allProductsSearch = allSearches;
                        _this.requiredData.allProductsSearch = this.search_data;
                });
            },
            getProduct(product){

                const _this = this;
                console.log(_this.formObject.products);
                let maxDiscount = Math.round(product.max_discount * product.sell_price / 100);
                let amount = product.sell_price * 1;
                let stocQty = ( product.stockIn - product.stockOut );
                if(_this.formObject.products !== undefined){
                _this.formObject.products.push
                    ({
                        id:product.id,
                        item_code:product.item_code,
                        item_quantity:1,
                        quantity:1,
                        amount:(product.sell_price * 1),
                        sell_price:product.sell_price,
                        max_discount:product.max_discount,
                        max_discount_amount:maxDiscount,
                        discount_percentage:0,
                        purchase_amount:product.purchase_price,
                        markup:product.markup,
                        stock_qty: stocQty,
                    });
                }else{
                    _this.formObject.products = [];
                    _this.formObject.products.push
                    ({
                        id:product.id,
                        item_code:product.item_code,
                        item_quantity:1,
                        quantity:1,
                        amount:(product.sell_price * 1),
                        sell_price:product.sell_price,
                        max_discount:product.max_discount,
                        max_discount_amount:maxDiscount,
                        discount_percentage:0,
                        purchase_amount:product.purchase_price,
                        markup:product.markup,
                        stock_qty: stocQty,
                    });
                }
                this.calulation();
                this.search_data = [];
            },
            addRow: function(value,stockQty) {
                const _this = this;
                let product_id  = value;
                let URL = baseUrl +'/'+ "get-by-product-by-stock?product_id=" + product_id;
                    this.axios.get(URL)
                    .then((response) => {

                    let quantity = response.data.stock_details.quantity;

                    let sellPrice = response.data.sell_price;
                    let productCode = response.data.item_code;
                    let maxDiscount = Math.round(response.data.max_discount * sellPrice / 100);
                    let amount = sellPrice * 1;
                     if(_this.requiredData.products == undefined){
                    	this.$set(_this.formObject, "products",[]);
                     }
                    if(_this.formObject.products == undefined){
                        this.$set(_this.formObject, "products",[]);
                    }

                    if(product_id!== undefined && product_id!== ''){
                        _this.formObject.products.push
                        ({
                            id:product_id,
                            item_code:productCode,
                            item_quantity:1,
                            quantity:quantity,
                            amount:amount,
                            sell_price:sellPrice,
                            max_discount:response.data.max_discount,
                            max_discount_amount:maxDiscount,
                            discount_percentage:0,
                            purchase_amount:response.data.purchase_price,
                            markup:response.data.markup,
                            stock_qty: stockQty,
                        });
                        this.calulation();
                    }


                });

            },
			discountPercentage(productData){
				const _this = this;
				let discount = productData.discount_percentage;
				let maxDiscount = productData.max_discount;

				if(maxDiscount>=discount){
					 let discountAmount = Math.round(discount * (productData.sell_price * productData.item_quantity) / 100);
					productData.discount_percentage = discount;
					productData.max_discount_amount = discountAmount;
					productData.amount = (productData.sell_price * productData.item_quantity)-discountAmount;
				}else{
					// console.log(maxDiscount,discount);
					_this.$toastr('warning','Discount Percentage more than '+ maxDiscount +'%', 'warning');
					productData.discount_percentage = 0;
				}
				this.calulation();
                _this.item_code='';

			},
			paymentMode(){
				const _this = this;
				let paymentMode = _this.formObject.payment_mode;
				if(paymentMode=="Checque"){
					this.isChecque=true;
				}else{
					this.isChecque=false;
				}
			},
			incrementQty(productData) {
				const _this = this;
				let itemQuantity = productData.item_quantity;
				let stockQty = productData.stock_qty;
				productData.item_quantity = productData.item_quantity + 1;
				if(stockQty>=productData.item_quantity){
					productData.item_quantity = productData.item_quantity;
					productData.amount = productData.sell_price * productData.item_quantity;
				}else{
					_this.$toastr('warning','Maximum Stock Quantity '+ stockQty, 'warning');
					productData.item_quantity = 1;
					productData.amount =  productData.sell_price * productData.item_quantity;
				}

				this.calulation();
			},
			decrementQty(productData) {
				if(productData.item_quantity > 1){
					productData.item_quantity = productData.item_quantity - 1;
					productData.amount = productData.sell_price * productData.item_quantity;
					this.calulation();
				}
			},
			calulation(){
				const _this = this;
				var totalQty = 0;
				var totalSellPrice = 0;
				var discount = 0;
				var totalAmount = 0;
				_this.formObject.products.forEach(element => {
					totalQty += (element.item_quantity);
					totalSellPrice += (element.amount);
					discount += (element.max_discount_amount);
					totalAmount += (element.amount);
				});

				this.totalQuantity = totalQty;
				this.totalPrice =  Math.round(totalSellPrice);
				this.totalDiscount =  Math.round(discount);
				this.grandTotal = Math.round(totalAmount);
			},
             removeRow(productIndex){
                const _this = this;
                _this.formObject.products.splice(productIndex,1);
				this.calulation();
            },
			  itemSelected (item) {
				this.item = item;
				},
				setLabel (item) {
				return item.name;
				},
				inputChange (text) {
				// your search method
				// this.items = items.filter(item => item.name.contains(text));
				// now `items` will be showed in the suggestion list
				},
        },

        mounted() {
             const _this = this;
             let saleId = this.$route.params.saleId;
              let URL = baseUrl +'/'+ "get-by-sale-id-details?sale_id=" + saleId;
                this.axios.get(URL)
                .then((response) => {
                    let sales = response.data.result;
                    let salesInformation = response.data.result[0];
                    _this.formObject.products = sales;
                    this.$set(_this.formObject, "customer_id",salesInformation.customer_id);
                    this.$set(_this.formObject, "payment_mode",salesInformation.payment_mode);
                    this.$set(_this.formObject, "payment_amount",salesInformation.payment_amount);
                    this.$set(_this.formObject, "change_amount",salesInformation.change_amount);
                    this.$set(_this.formObject, "bank_name",salesInformation.bank_name);
                    this.$set(_this.formObject, "checque_no",salesInformation.checque_no);
                    this.$set(_this.formObject, "sale_id",salesInformation.sale_id);
                    this.calulation();
            });
            this.getGeneralData(["customers", "products","productCategories","allProducts","salesPaymentMode","allProductsSearch"]);
        },
    };
</script>
<style scoped>
    .list-group{
        width: 47%;
        max-width: 100%;
        position: absolute;
    }

    .table-striped > tbody > tr:nth-of-type(2n + 1) {
        background-color: #ede3e3;
    }

    .table-striped > tbody > tr {
        background-color: #ddc8c8;
    }

    .search_item {
        text-transform: uppercase;
        font-size: 10px;
        color: #000000;
        text-align: center;
        text-overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }

    .item_image {
        min-width: 70px;
        min-height: 70px;
        max-width: 70px;
        max-height: 70px;
    }

    .min_width {
        min-width: 70px;
    }
@keyframes flipInX {
	0% {
		transform:perspective(400px) rotate3d(1, 0, 0, 90deg);
		transition-timing-function:ease-in;
		opacity:0
	}
	40% {
		transform:perspective(400px) rotate3d(1, 0, 0, -20deg);
		transition-timing-function:ease-in
	}
	60% {
		transform:perspective(400px) rotate3d(1, 0, 0, 10deg);
		opacity:1
	}
	80% {
		transform:perspective(400px) rotate3d(1, 0, 0, -5deg)
	}
	100% {
		transform:perspective(400px)
	}
}
@-webkit-keyframes flipInX {
	0% {
		-webkit-transform:perspective(400px) rotate3d(1, 0, 0, 90deg);
		-webkit-transition-timing-function:ease-in;
		opacity:0
	}
	40% {
		-webkit-transform:perspective(400px) rotate3d(1, 0, 0, -20deg);
		-webkit-transition-timing-function:ease-in
	}
	60% {
		-webkit-transform:perspective(400px) rotate3d(1, 0, 0, 10deg);
		opacity:1
	}
	80% {
		-webkit-transform:perspective(400px) rotate3d(1, 0, 0, -5deg)
	}
	100% {
		-webkit-transform:perspective(400px)
	}
}

.box {
	position:relative;
	border-radius:3px;
	background:#ffffff;
	border-top:3px solid #d2d6de;
	margin-bottom:20px;
	width:100%;
	box-shadow:0 1px 1px rgba(0,0,0,0.1)
}
.box.box-primary {
	border-top-color:#3c8dbc
}

.box.box-info {
    border-top-color: #00c0ef;
}

.box>.overlay,.overlay-wrapper>.overlay,.box>.loading-img,.overlay-wrapper>.loading-img {
	position:absolute;
	top:0;
	left:0;
	width:100%;
	height:100%
}
.box .overlay,.overlay-wrapper .overlay {
	z-index:50;
	background:rgba(255,255,255,0.7);
	border-radius:3px
}
.box .overlay>.fa,.overlay-wrapper .overlay>.fa {
	position:absolute;
	top:50%;
	left:50%;
	margin-left:-15px;
	margin-top:-15px;
	color:#000;
	font-size:30px
}
.box .overlay.dark,.overlay-wrapper .overlay.dark {
	background:rgba(0,0,0,0.5)
}
.box-header:before,.box-body:before,.box-footer:before,.box-header:after,.box-body:after,.box-footer:after {
	content:" ";
	display:table
}
.box-header:after,.box-body:after,.box-footer:after {
	clear:both
}
.box-header {
	color:#444;
	display:block;
	padding:10px;
	position:relative
}
.box-header.with-border {
	border-bottom:1px solid #f4f4f4
}
.collapsed-box .box-header.with-border {
	border-bottom:none
}
.box-header>.fa,.box-header>.glyphicon,.box-header>.ion,.box-header .box-title {
	display:inline-block;
	font-size:18px;
	margin:0;
	line-height:1
}
.box-header>.fa,.box-header>.glyphicon,.box-header>.ion {
	margin-right:5px
}
.box-header>.box-tools {
	position:absolute;
	right:10px;
	top:5px
}
.box-header>.box-tools [data-toggle="tooltip"] {
	position:relative
}
.box-header>.box-tools.pull-right .dropdown-menu {
	right:0;
	left:auto
}
.box-header>.box-tools .dropdown-menu>li>a {
	color:#444!important
}

.box-body {
	border-top-left-radius:0;
	border-top-right-radius:0;
	border-bottom-right-radius:3px;
	border-bottom-left-radius:3px;
	padding:10px
}
.no-header .box-body {
	border-top-right-radius:3px;
	border-top-left-radius:3px
}
.box-body>.table {
	margin-bottom:0
}
.box-body .fc {
	margin-top:5px
}
.box-body .full-width-chart {
	margin:-19px
}
.box-body.no-padding .full-width-chart {
	margin:-9px
}
.box-body .box-pane {
	border-top-left-radius:0;
	border-top-right-radius:0;
	border-bottom-right-radius:0;
	border-bottom-left-radius:3px
}
.box-body .box-pane-right {
	border-top-left-radius:0;
	border-top-right-radius:0;
	border-bottom-right-radius:3px;
	border-bottom-left-radius:0
}
.box-footer {
	border-top-left-radius:0;
	border-top-right-radius:0;
	border-bottom-right-radius:3px;
	border-bottom-left-radius:3px;
	border-top:1px solid #f4f4f4;
	padding:10px;
	background-color:#fff
}


.btn {
	border-radius:3px;
	-webkit-box-shadow:none;
	box-shadow:none;
	border:1px solid transparent
}
.btn.uppercase {
	text-transform:uppercase
}
.btn.btn-flat {
	border-radius:0;
	-webkit-box-shadow:none;
	-moz-box-shadow:none;
	box-shadow:none;
	border-width:1px
}
.btn:active {
	-webkit-box-shadow:inset 0 3px 5px rgba(0,0,0,0.125);
	-moz-box-shadow:inset 0 3px 5px rgba(0,0,0,0.125);
	box-shadow:inset 0 3px 5px rgba(0,0,0,0.125)
}
.btn:focus {
	outline:none
}

.btn-default {
	background-color:#f4f4f4;
	color:#444;
	border-color:#ddd
}
.btn-default:hover,.btn-default:active,.btn-default.hover {
	background-color:#e7e7e7
}

.btn-info {
	background-color:#00c0ef;
	border-color:#00acd6
}
.btn-info:hover,.btn-info:active,.btn-info.hover {
	background-color:#00acd6
}


.btn[class*='bg-']:hover {
	-webkit-box-shadow:inset 0 0 100px rgba(0,0,0,0.2);
	box-shadow:inset 0 0 100px rgba(0,0,0,0.2)
}

.table>thead>tr>th,.table>tbody>tr>th,.table>tfoot>tr>th,.table>thead>tr>td,.table>tbody>tr>td,.table>tfoot>tr>td {
	border-top:1px solid #f4f4f4
}
.table>thead>tr>th {
	border-bottom:2px solid #f4f4f4
}
.table tr td .progress {
	margin-top:5px
}
.table-bordered {
	border:1px solid #f4f4f4
}
.table-bordered>thead>tr>th,.table-bordered>tbody>tr>th,.table-bordered>tfoot>tr>th,.table-bordered>thead>tr>td,.table-bordered>tbody>tr>td,.table-bordered>tfoot>tr>td {
	border:1px solid #f4f4f4
}
.table-bordered>thead>tr>th,.table-bordered>thead>tr>td {
	border-bottom-width:2px
}
.table.no-border,.table.no-border td,.table.no-border th {
	border:0
}
table.text-center,table.text-center td,table.text-center th {
	text-align:center
}
.table.align th {
	text-align:left
}
.table.align td {
	text-align:right
}



.bg-red,.bg-yellow,.bg-aqua,.bg-blue,.bg-light-blue,.bg-green,.bg-navy,.bg-teal,.bg-olive,.bg-lime,.bg-orange,.bg-fuchsia,.bg-purple,.bg-maroon,.bg-black,.bg-red-active,.bg-yellow-active,.bg-aqua-active,.bg-blue-active,.bg-light-blue-active,.bg-green-active,.bg-navy-active,.bg-teal-active,.bg-olive-active,.bg-lime-active,.bg-orange-active,.bg-fuchsia-active,.bg-purple-active,.bg-maroon-active,.bg-black-active,.callout.callout-danger,.callout.callout-warning,.callout.callout-info,.callout.callout-success,.alert-success,.alert-danger,.alert-error,.alert-warning,.alert-info,.label-danger,.label-info,.label-warning,.label-primary,.label-success {
	color:#fff !important
}
.bg-gray {
	color:#000;
	background-color:#d2d6de !important
}

.bg-red,.label-danger {
	background-color:#dd4b39 !important
}

.bg-purple {
	background-color:#605ca8 !important
}

/* Let's get this party started */
::-webkit-scrollbar {
    width: 5px;
}

/* Track */
::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    -webkit-border-radius: 5px;
    border-radius: 5px;
}

/* Handle */
::-webkit-scrollbar-thumb {
    -webkit-border-radius: 5px;
    border-radius: 5px;
    background: rgba(255,0,0,0.8);
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5);
}
::-webkit-scrollbar-thumb:window-inactive {
	background: rgba(255,0,0,0.4);
}
</style>
