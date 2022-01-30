import dashboard from '@/pages/dashboard/index';
import notFound from '@/pages/404/index';
import productCategory from "@/pages/inventory/productCategory/index";
import brand from "@/pages/inventory/brand/index";
import basePage from './pages/basePage'
import supplier from "@/pages/inventory/supplier/index";
import office from "@/pages/inventory/office/index";
import customer from "@/pages/inventory/customer/index";
import purchaseOrder from "@/pages/inventory/purchaseOrder/index";
import product from "@/pages/inventory/product/index";
import stock from "@/pages/stock/stockEntry/index";
import stockTransfer from "@/pages/stock/stockTransfer/index";
import sale from "@/pages/sale/sale/index";
import saleCreate from "@/pages/sale/sale/create";
import saleEdit from "@/pages/sale/sale/edit";
import saleReturn from "@/pages/sale/sale/return";
import user from "@/pages/rbac/user/index";
import stockPrint from "@/pages/report/stock";
import productTransfer from "@/pages/report/productTransfer";
import salesReport from "@/pages/report/salesReport";

import purchaseRequisition from "@/pages/purchase/purchaseRequisition/index";

const routes = [{
        path: '/home',
        component: basePage,
        children: [{
                path: 'dashboard',
                component: dashboard,
                name: 'dashboard',
            },
            {
                path: 'product-category',
                component: productCategory,
                name: 'product-category',
                meta: {
                    dataUrl: 'product-category',
                    pageTitle: 'Product Category',
                    permissionName: 'view_mis_product_category'
                }
            },
            {
                path: 'brand',
                component: brand,
                name: 'brand',
                meta: {
                    dataUrl: 'brand',
                    pageTitle: 'brand',
                    permissionName: 'view_mis_brand'
                }
            },
            {
                path: 'supplier',
                component: supplier,
                name: 'supplier',
                meta: {
                    dataUrl: 'supplier',
                    pageTitle: 'supplier',
                    permissionName: 'view_mis_supplier'
                }
            },
            {
                path: 'office',
                component: office,
                name: 'office',
                meta: {
                    dataUrl: 'office',
                    pageTitle: 'Manage Office',
                    permissionName: 'view_mis_office'
                }
            },
            {
                path: 'customer',
                component: customer,
                name: 'customer',
                meta: {
                    dataUrl: 'customer',
                    pageTitle: 'Manage Customer',
                    permissionName: 'view_mis_customer'
                }
            },
            {
                path: 'purchase-order',
                component: purchaseOrder,
                name: 'purchase-order',
                meta: {
                    dataUrl: 'purchase-order',
                    pageTitle: 'Purchase Order',
                    permissionName: 'view_mis_customer',
                }
            },
            {
                path: 'product',
                component: product,
                name: 'product',
                meta: {
                    dataUrl: 'product',
                    pageTitle: 'Product',
                    permissionName: 'view_mis_product'
                }
            },
            {
                path: 'stock',
                component: stock,
                name: 'stock',
                meta: {
                    dataUrl: 'stock',
                    pageTitle: 'Stock',
                    permissionName: 'view_mis_stock'
                }
            },
            {
                path: 'stock-transfer',
                component: stockTransfer,
                name: 'stock-transfer',
                meta: {
                    dataUrl: 'stock-transfer',
                    pageTitle: 'stock-transfer',
                    permissionName: 'view_mis_stock_transfer'
                }
            },
            {
                path: 'sale',
                component: sale,
                name: 'sale',
                meta: {
                    dataUrl: 'sale',
                    pageTitle: 'sale',
                    permissionName: 'view_mis_sale'
                }
            },
            {
                path: 'create-new-sale',
                component: saleCreate,
                name: 'create-new-sale',
                meta: {
                    dataUrl: 'sale/create',
                    pageTitle: 'sale create',
                    permissionName: 'view_mis_sale_create'
                }
            },
            {
                path: 'sale/:saleId',
                component: saleEdit,
                name: 'sale-edit',
                meta: {
                    dataUrl: 'sale/:saleId',
                    pageTitle: 'sale Edit',
                    permissionName: 'view_mis_sale_edit'
                }
            },
            {
                path: 'purchase-requisition',
                component: purchaseRequisition,
                name: 'purchase-requisition',
                meta: {
                    dataUrl: 'purchase-requisition',
                    pageTitle: 'purchase-requisition',
                    permissionName: 'view_mis_purchase_requisition'
                }
            },
            {
                path: 'user',
                component: user,
                name: 'user',
                meta: {
                    dataUrl: 'user',
                    pageTitle: 'User',
                    permissionName: 'view_mis_user'
                }
            },
            {
                path: 'sale-return/:saleId',
                component: saleReturn,
                name: 'sale-return',
                meta: {
                    dataUrl: 'sale-return',
                    pageTitle: 'Sale Return',
                    permissionName: 'view_mis_sale_return'
                }
            },
            {
                path: 'physical-stock-report',
                component: stockPrint,
                name: 'physical-stock-report',
                meta: {
                    dataUrl: 'physical-stock-report',
                    pageTitle: 'physical-stock-report',
                    permissionName: 'view_mis_stock_report'
                }
            },
            {
                path: 'product-transfer-report',
                component: productTransfer,
                name: 'product-transfer-report',
                meta: {
                    dataUrl: 'product-transfer-report',
                    pageTitle: 'product-transfer-report',
                    permissionName: 'view_mis_product_transfer_report'
                }
            },
            {
                path: 'sales-report',
                component: salesReport,
                name: 'sales-report',
                meta: {
                    dataUrl: 'sales-report',
                    pageTitle: 'Sales Report',
                    permissionName: 'view_mis_sales_report'
                }
            },

        ]
    },
    {
        path: '*',
        component: notFound
    },
];

export default routes;