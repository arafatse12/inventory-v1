<template>
    <div id="page-content" class="p20 clearfix">
        <div class="panel panel-default">

            <div class="d-flex align-items-center justify-content-between">
                <page-heading />
                <router-link to="create-new-sale" class="btn btn-success">
                    <i class="fa fa-plus"> Create New Sale </i>
                </router-link>
            </div>
            <div class="table-responsive">
                <data-table
                    :table-heading="tableHeading"
                    permission-name="view_mis_sale">

                    <template v-slot:filter>
                        <dataFilter  @click="getDataList()"></dataFilter>
                    </template>
                    <template v-slot:data>
                        <tr v-for="(saleData, saleindex) in dataList.data" :key="saleindex">
                            <td>{{ serialData(saleindex) }}</td>
                            <td>{{ showData(saleData.customer,"name") }}</td>
                            <td>{{ saleData.total_amount }}</td>
                            <td>{{ saleData.payment_mode }}</td>
                            <td>{{ saleData.due }}</td>
                            <td>{{ saleData.payment_amount }}</td>
                            <td>{{ saleData.status }}</td>
                            <td>{{ saleData.created_at }}</td>
                            <td class="w-50">
                                <div class="gap-10 peers">
                                    <div class="peer">
                                          <router-link :to="{
                                                    name: 'sale-edit',
                                                    params: { saleId: saleData.id },
                                                }"> 
                                                <edit-button/>
                                          </router-link>
                                    </div>
                                    <div class="peer">
                                        <delete-button @click.native="deleteInformation(saleData, saleData.id)"/>
                                    </div>
                                    <div class="peer">
                                          <router-link :to="{
                                                    name: 'sale-return',
                                                    params: { saleId: saleData.id },
                                                }"> 
                                               <a type="button"  class="btn btn-info btn-xs" data-dismiss="modal" aria-hidden="true"><i class="fa fa-reply" aria-hidden="true"></i> Return</a>
                                          </router-link>
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
    </div>
</template>

<script>

    export default {
        data() {
            return {
               tableHeading: {
                sl: "Sl",
                customer_id: "Customer",
                total_amount: "Total Amount",
                payment_mode: "Payment Mode",
                due: "Due",
                payment_amount: "Payment Amount",
                status: "Status",
                created_at: "Date",
                action: "Action",
              },
            };
        },
        methods: {

        },
        mounted() {
            this.getDataList();
        },
    };
</script>
