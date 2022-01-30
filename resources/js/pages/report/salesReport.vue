<template>
    <div id="page-content" class="p20 clearfix">
        <div class="panel panel-default">
            <div class="d-flex align-items-center justify-content-between">
                <page-heading />
                <div class="dt-buttons">          
                    <button @click="downloadFile()" class="btn cur-p btn-primary btn-color"  type="button">
                       <span> PDF </span> <i class="fa fa-download" aria-hidden="true"></i>
                    </button>
                    <button class="btn btn-info" type="button" @click="salesReport()">
                        <span>Print</span> <i class="fa fa-print" aria-hidden="true"></i>
                    </button> 
                </div>
            </div>
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered dataTable" cellspacing="0" width="100%" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                    <thead>
                        <tr role="row">
                            <th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 261px;">Item Name </th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 391px;">Item Code</th>
                            
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 194px;">Qty Sold</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 194px;">Sell Price</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 194px;">Total Price</th>
                            
                             
                        </tr>
                    </thead>
                    <tbody>
                       
                        <tr role="row" class="odd" v-for="(data, index) in requiredData.detailsSale" :key="index" >
                            <td class="sorting_1">{{ data.product.name }}</td>
                            <td class="sorting_1">{{ data.product.item_code }}</td>
                            <td class="sorting_1">{{ data.quantity }}</td>
                            <td class="sorting_1">{{ data.product.sell_price }}</td>
                            <td>{{ data.total }}</td>
                           
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>                       
</template>

<script>
export default {
    data() {
        return {
            tableHeading: {
                item_code: "Item Code",
                name: "Item Name",
                sell_price: "Sell Price",
                qty_sold: "Qty Sold",
                qty_hand: "Qty In Hand",
                total: "Total Price",
            },
        };
    },
    methods: {
        downloadFile(){
            this.$http.get( baseUrl +'/'+ "create-sales-report-pdf", {responseType: 'arraybuffer'})
                .then(response => {
                let blob = new Blob([response.data], { type: 'application/pdf' })
                let link = document.createElement('a')
                link.href = window.URL.createObjectURL(blob)
                link.download = 'sales-report.pdf'
                link.click()
            });    
        },
        salesReport(){
            const _this= this;
            let details = _this.requiredData.detailsSale;
            var product = "";
            var total = 0;
            var totalPrice = 0;
            details.forEach(element => {
                        product += '<tr>';
                        product += '<td class="item"> '+element.product.name+'</td>';
                        product += '<td class="item"> '+element.product.item_code+'</td>';
                        product += '<td class="item"> '+element.product.sell_price+'</td>';
                        product += '<td class="item"> '+element.quantity+'</td>';
                        product += '<td class="item"> '+element.total+'</td>';
                        product += '</tr>';
                        total  += parseInt(element.quantity);
                        totalPrice  += parseInt(element.total);
                        return product;
				});
            const WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
           WinPrint.document.write(`
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Product Transfer Report</title>
                        <style>
                            .item-table table{
                                width: 100%;
                                border-collapse: collapse;
                                border: 1px solid #000;
                            }
                            .blank-cell{
                                min-width: 50px;
                            }
                            .item{
                                padding: 8px;
                                text-align: left;
                            }
                            .item-table table th.item, .item-table table td.item {
                                border: 1px solid #000;
                            }
                        </style>
                    </head>
                    <body>
                        <h2></h2>
                        <h4>Product Transfer Report</h4>
                        <p></p>
                        <div class="item-table">
                            <table class="table-bordered">
                                <tr>
                                    <th class="item"> Name </th>
                                    <th class="item"> Code </th>
                                    <th class="item"> Sales Price </th>
                                    <th class="item"> Qty Sold </th>
                                    <th class="item"> Total Price </th>
                                </tr>
                                    ${product}
                                <tr>
                                    <th class="item"> Grand Total</th>
                                    <th class="item"> --- </th>
                                    <th class="item"> --- </th>
                                    <th class="item"> ${total} </th>
                                    <th class="item"> ${totalPrice} </th>
                                </tr>
                            </table>
                        </div>
                    </body>
                    </html>
                    `);
                WinPrint.document.close();
                WinPrint.focus();
                WinPrint.print();
                WinPrint.close();
        },
    },

    mounted() {
         this.getDataList();
         this.getGeneralData(["stockTransfer","detailsSale"]);
    },
}
</script>

