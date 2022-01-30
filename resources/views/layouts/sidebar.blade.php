<div class="sidebar">
    <div class="sidebar-inner">
        <div class="sidebar-logo">
            <div class="peers ai-c fxw-nw">
                <div class="peer peer-greed">
                    <router-link class="sidebar-link td-n" :to="{ name: 'dashboard'}">
                        <div class="peers ai-c fxw-nw">
                            <div class="peer">
                                <div class="logo">
                                    <img src="assets/static/images/logo.png" alt="">
                                </div>
                            </div>
                            <div class="peer peer-greed">
                                <h5 class="lh-1 mB-0 logo-text">{{ config('app.name') }}</h5>
                            </div>
                        </div>
                    </router-link>
                </div>
                <div class="peer">
                    <div class="mobile-toggle sidebar-toggle">
                        <a href="" class="td-n">
                            <i class="ti-arrow-circle-left"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ### $Sidebar Menu ### -->
        <ul class="sidebar-menu scrollable pos-r">
            <li class="nav-item mT-30 actived">
                <router-link class="sidebar-link" :to="{ name: 'dashboard'}" >
                <span class="icon-holder">
                  <i class="c-orange-500 ti-home"></i>
                </span>
                    <span class="title">Dashboard</span>
                </router-link>
            </li>

            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder">
                          <i class="c-orange-500 ti-user"></i>
                        </span>
                    <span class="title">RBAC</span>
                    <span class="arrow">
                          <i class="ti-angle-right"></i>
                        </span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <router-link :to="{ name: 'user'}"  class='sidebar-link'>User</router-link>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder">
                          <i class="c-orange-500 ti-layout-accordion-list"></i>
                        </span>
                    <span class="title">Inventory</span>
                    <span class="arrow">
                          <i class="ti-angle-right"></i>
                        </span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <router-link :to="{ name: 'office'}" class='sidebar-link'>Offices</router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'customer'}" class='sidebar-link'>Customer</router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'product-category'}" class='sidebar-link'>Product Category</router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'brand'}" class='sidebar-link'>Brand</router-link>
                    </li>
                    <li>
                        <router-link  :to="{ name: 'supplier'}" class='sidebar-link'>Supplier</router-link>
                    </li>
                      <li>
                        <router-link :to="{ name: 'product'}" class='sidebar-link'>Products</router-link>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder">
                          <i class="c-orange-500 ti-support"></i>
                        </span>
                    <span class="title">Purchase</span>
                    <span class="arrow">
                          <i class="ti-angle-right"></i>
                        </span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <router-link :to="{ name: 'purchase-requisition'}" class='sidebar-link'>Purchase Requisition</router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'purchase-order'}"  class='sidebar-link'>Purchase Order</router-link>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder">
                          <i class="c-orange-500 ti-plus"></i>
                        </span>
                    <span class="title">Stock</span>
                    <span class="arrow">
                          <i class="ti-angle-right"></i>
                        </span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <router-link  :to="{ name: 'stock'}" class='sidebar-link'>Stock</router-link>
                        <router-link  :to="{ name: 'stock-transfer'}" class='sidebar-link'>Stock Transfer</router-link>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder">
                          <i class="c-orange-500 ti-shopping-cart"></i>
                        </span>
                    <span class="title">Sales</span>
                    <span class="arrow">
                          <i class="ti-angle-right"></i>
                        </span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <router-link :to="{ name: 'sale'}" class='sidebar-link'>Manage Sale</router-link>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder">
                          <i class="c-orange-500 ti-printer"></i>
                        </span>
                    <span class="title">Inventory Report</span>
                    <span class="arrow">
                          <i class="ti-angle-right"></i>
                        </span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <router-link :to="{ name: 'physical-stock-report'}"  class='sidebar-link'>Physical Stock Report</router-link>
                        <router-link :to="{ name: 'product-transfer-report'}" class='sidebar-link'>Product Transfer Report</router-link>
                        <router-link :to="{ name: 'sales-report'}" class='sidebar-link'>Cost of Goods Report</router-link>
                        <router-link :to="{ name: 'sales-report'}" class='sidebar-link'>Purchase  Report</router-link>
                        <router-link :to="{ name: 'sales-report'}" class='sidebar-link'>Sales Report</router-link>
                        <router-link :to="{ name: 'sales-report'}" class='sidebar-link'>Sales Return Report</router-link>

                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
