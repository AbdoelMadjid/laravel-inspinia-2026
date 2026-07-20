<div class="sidenav-menu">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}/" class="logo">
        <span class="logo logo-light">
            <span class="logo-lg"><img src="{{ asset('assets/images/logo.png') }}" alt="logo" /></span>
            <span class="logo-sm"><img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo" /></span>
        </span>

        <span class="logo logo-dark">
            <span class="logo-lg"><img src="{{ asset('assets/images/logo-black.png') }}" alt="dark logo" /></span>
            <span class="logo-sm"><img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo" /></span>
        </span>
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <button class="button-on-hover">
        <span class="btn-on-hover-icon"></span>
    </button>

    <!-- Full Sidebar Menu Close Button -->
    <button class="button-close-offcanvas">
        <i class="ti ti-menu-4 align-middle"></i>
    </button>

    <div class="scrollbar" data-simplebar="">
        <div id="user-profile-settings" class="sidenav-user" style="background: url({{ asset('assets/images/user-bg-pattern.svg') }})">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="#!" class="link-reset">
                        <img src="{{ asset('assets/images/users/user-1.jpg') }}" alt="user-image" class="rounded-circle mb-2 avatar-md" />
                        <span class="sidenav-user-name fw-bold">Damian D.</span>
                        <span class="fs-12 fw-semibold" data-lang="user-role">Art Director</span>
                    </a>
                </div>
                <div>
                    <a class="dropdown-toggle drop-arrow-none link-reset sidenav-user-set-icon" data-bs-toggle="dropdown" data-bs-offset="0,12" href="#!" aria-haspopup="false" aria-expanded="false">
                        <i class="ti ti-settings fs-24 align-middle ms-1"></i>
                    </a>

                    <div class="dropdown-menu">
                        <!-- Header -->
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome back!</h6>
                        </div>

                        <!-- My Profile -->
                        <a href="#!" class="dropdown-item">
                            <i class="ti ti-user-circle me-1 fs-lg align-middle"></i>
                            <span class="align-middle">Profile</span>
                        </a>

                        <!-- Settings -->
                        <a href="javascript:void(0);" class="dropdown-item">
                            <i class="ti ti-settings-2 me-1 fs-lg align-middle"></i>
                            <span class="align-middle">Account Settings</span>
                        </a>

                        <!-- Lock -->
                        <a href="{{ route('page', 'auth-lock-screen') }}" class="dropdown-item">
                            <i class="ti ti-lock me-1 fs-lg align-middle"></i>
                            <span class="align-middle">Lock Screen</span>
                        </a>

                        <!-- Logout -->
                        <a href="javascript:void(0);" class="dropdown-item text-danger fw-semibold">
                            <i class="ti ti-logout me-1 fs-lg align-middle"></i>
                            <span class="align-middle">Log Out</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!--- Sidenav Menu -->
        <div id="sidenav-menu">
            <ul class="side-nav">
                <li class="side-nav-title mt-2" data-lang="main">Main</li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#dashboards" aria-expanded="false" aria-controls="dashboards" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-dashboard"></i></span>
                        <span class="menu-text" data-lang="dashboards">Dashboards</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="dashboards">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'dashboard-ecommerce') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="dashboard-ecommerce">Ecommerce</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'dashboard-analytics') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="dashboard-analytics">Analytics</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('home') }}/" class="side-nav-link">
                                    <span class="menu-text" data-lang="dashboard-projects">Projects</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('page', 'landing') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-rocket"></i></span>
                        <span class="menu-text" data-lang="landing">Landing</span>
                    </a>
                </li>
                <li class="side-nav-title mt-2" data-lang="apps">Apps</li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#ecommerce" aria-expanded="false" aria-controls="ecommerce" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-basket"></i></span>
                        <span class="menu-text" data-lang="ecommerce">Ecommerce</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="ecommerce">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-ecommerce-marketplace') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-ecommerce-marketplace">Marketplace</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a data-bs-toggle="collapse" href="#products" aria-expanded="false" aria-controls="products" class="side-nav-link">
                                    <span class="menu-text" data-lang="products">Products</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="products">
                                    <ul class="sub-menu">
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'apps-ecommerce-products') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="apps-ecommerce-products">Products</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'apps-ecommerce-products-grid') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="apps-ecommerce-products-grid">Products Grid</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'apps-ecommerce-product-details') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="apps-ecommerce-product-details">Product Details</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'apps-ecommerce-product-add') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="apps-ecommerce-product-add">Add Product</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-ecommerce-categories') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-ecommerce-categories">Categories</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a data-bs-toggle="collapse" href="#orders" aria-expanded="false" aria-controls="orders" class="side-nav-link">
                                    <span class="menu-text" data-lang="orders">Orders</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="orders">
                                    <ul class="sub-menu">
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'apps-ecommerce-orders') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="apps-ecommerce-orders">Orders</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'apps-ecommerce-order-details') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="apps-ecommerce-order-details">Order Details</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'apps-ecommerce-order-add') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="apps-ecommerce-order-add">Add/Edit Order</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-ecommerce-customers') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-ecommerce-customers">Customers</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-ecommerce-cart') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-ecommerce-cart">Cart</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-ecommerce-checkout') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-ecommerce-checkout">Checkout</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a data-bs-toggle="collapse" href="#sellers" aria-expanded="false" aria-controls="sellers" class="side-nav-link">
                                    <span class="menu-text" data-lang="sellers">Sellers</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sellers">
                                    <ul class="sub-menu">
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'apps-ecommerce-sellers') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="apps-ecommerce-sellers">Sellers</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'apps-ecommerce-seller-details') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="apps-ecommerce-seller-details">Sellers Details</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-ecommerce-refunds') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-ecommerce-refunds">Refunds</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-ecommerce-reviews') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-ecommerce-reviews">Reviews</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a data-bs-toggle="collapse" href="#inventory" aria-expanded="false" aria-controls="inventory" class="side-nav-link">
                                    <span class="menu-text" data-lang="inventory">Inventory</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="inventory">
                                    <ul class="sub-menu">
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'apps-ecommerce-warehouse') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="apps-ecommerce-warehouse">Warehouse</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'apps-ecommerce-product-stocks') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="apps-ecommerce-product-stocks">Product Stocks</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'apps-ecommerce-purchased-orders') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="apps-ecommerce-purchased-orders">Purchased Orders</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="side-nav-item">
                                <a data-bs-toggle="collapse" href="#reports" aria-expanded="false" aria-controls="reports" class="side-nav-link">
                                    <span class="menu-text" data-lang="reports">Reports</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="reports">
                                    <ul class="sub-menu">
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'apps-ecommerce-product-views') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="apps-ecommerce-product-views">Product Views</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'apps-ecommerce-sales') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="apps-ecommerce-sales">Sales</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-ecommerce-attributes') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-ecommerce-attributes">Attributes</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-ecommerce-settings') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-ecommerce-settings">Settings</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#email" aria-expanded="false" aria-controls="email" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-mailbox"></i></span>
                        <span class="menu-text" data-lang="email">Email</span>
                        <span class="badge bg-danger text-white">New</span>
                    </a>
                    <div class="collapse" id="email">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-email-inbox') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-email-inbox">Inbox</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-email-details') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-email-details">Details</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-email-compose') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-email-compose">Compose</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#users" aria-expanded="false" aria-controls="users" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-users"></i></span>
                        <span class="menu-text" data-lang="users">Users</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="users">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-users-contacts') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-users-contacts">Contacts</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-users-roles') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-users-roles">Roles</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-users-role-details') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-users-role-details">Role Details</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-users-permissions') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-users-permissions">Permissions</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#projects" aria-expanded="false" aria-controls="projects" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-briefcase"></i></span>
                        <span class="menu-text" data-lang="projects">Projects</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="projects">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-projects-grid') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-projects-grid">My Projects</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-projects-list') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-projects-list">Projects List</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-projects-details') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-projects-details">View Project</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-projects-kanban') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-projects-kanban">Kanban Board</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-projects-team-board') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-projects-team-board">Team Board</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-projects-activity') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-projects-activity">Activity Steam</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('page', 'apps-file-manager') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-folder-open"></i></span>
                        <span class="menu-text" data-lang="apps-file-manager">File Manager</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('page', 'apps-chat') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-message"></i></span>
                        <span class="menu-text" data-lang="apps-chat">Chat</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('page', 'apps-calendar') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-calendar"></i></span>
                        <span class="menu-text" data-lang="apps-calendar">Calendar</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('page', 'apps-social-feed') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-rss"></i></span>
                        <span class="menu-text" data-lang="apps-social-feed">Social Feed</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#invoice" aria-expanded="false" aria-controls="invoice" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-invoice"></i></span>
                        <span class="menu-text" data-lang="invoice">Invoice</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="invoice">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-invoice-list') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-invoice-list">Invoices</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-invoice-details') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-invoice-details">Single Invoice</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-invoice-create') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-invoice-create">New Invoice</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('page', 'apps-companies') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-building"></i></span>
                        <span class="menu-text" data-lang="apps-companies">Companies</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#more-apps" aria-expanded="false" aria-controls="more-apps" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-apps"></i></span>
                        <span class="menu-text" data-lang="more-apps">More Apps</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="more-apps">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-clients') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-clients">Clients</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-outlook') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-outlook">Outlook View</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-vote-list') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-vote-list">Vote List</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-issue-tracker') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-issue-tracker">Issue Tracker</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-api-keys') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-api-keys">API Keys</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-manage') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-manage">Manage Apps</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a data-bs-toggle="collapse" href="#blog" aria-expanded="false" aria-controls="blog" class="side-nav-link">
                                    <span class="menu-text" data-lang="blog">Blog</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="blog">
                                    <ul class="sub-menu">
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'apps-blog-list') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="apps-blog-list">Blog List</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'apps-blog-grid') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="apps-blog-grid">Blog Grid</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'apps-blog-article') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="apps-blog-article">Article</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'apps-blog-add') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="apps-blog-add">Add Article</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'apps-pin-board') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="apps-pin-board">Pin Board</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a data-bs-toggle="collapse" href="#forum" aria-expanded="false" aria-controls="forum" class="side-nav-link">
                                    <span class="menu-text" data-lang="forum">Forum</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="forum">
                                    <ul class="sub-menu">
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'apps-forum-view') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="apps-forum-view">Forum View</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'apps-forum-post') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="apps-forum-post">Forum Post</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="side-nav-title mt-2" data-lang="custom-pages">Custom Pages</li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#pages" aria-expanded="false" aria-controls="pages" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-files"></i></span>
                        <span class="menu-text" data-lang="pages">Pages</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="pages">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'pages-profile') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="pages-profile">Profile</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'pages-account-settings') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="pages-account-settings">Account Settings</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'pages-faq') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="pages-faq">FAQ</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'pages-pricing') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="pages-pricing">Pricing</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'pages-empty') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="pages-empty">Empty Page</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'pages-timeline') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="pages-timeline">Timeline</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'pages-gallery') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="pages-gallery">Gallery</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'pages-sitemap') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="pages-sitemap">Sitemap</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'pages-search-results') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="pages-search-results">Search Results</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'pages-coming-soon') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="pages-coming-soon">Coming Soon</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'pages-privacy-policy') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="pages-privacy-policy">Privacy Policy</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'pages-terms-conditions') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="pages-terms-conditions">Terms &amp; Conditions</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#plugins" aria-expanded="false" aria-controls="plugins" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-cpu"></i></span>
                        <span class="menu-text" data-lang="plugins">Plugins</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="plugins">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'plugins-sortable') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="plugins-sortable">Sortable List</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'plugins-text-diff') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="plugins-text-diff">Text Diff</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'plugins-pdf-viewer') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="plugins-pdf-viewer">PDF Viewer</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'plugins-i18') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="plugins-i18">i18 Support</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'plugins-sweet-alerts') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="plugins-sweet-alerts">Sweet Alerts</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'plugins-idle-timer') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="plugins-idle-timer">Idle Timer</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'plugins-pass-meter') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="plugins-pass-meter">Password Meter</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'plugins-live-favicon') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="plugins-live-favicon">Live Favicon</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'plugins-clipboard') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="plugins-clipboard">Clipboard</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'plugins-tree-view') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="plugins-tree-view">Tree View</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'plugins-loading-buttons') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="plugins-loading-buttons">Loading Buttons</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'plugins-masonry') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="plugins-masonry">Masonry</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'plugins-tour') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="plugins-tour">Tour</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'plugins-animation') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="plugins-animation">Animation</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'plugins-video-player') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="plugins-video-player">Video Player</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#authentication" aria-expanded="false" aria-controls="authentication" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-password-user"></i></span>
                        <span class="menu-text" data-lang="authentication">Authentication</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="authentication">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a data-bs-toggle="collapse" href="#auth-basic" aria-expanded="false" aria-controls="auth-basic" class="side-nav-link">
                                    <span class="menu-text" data-lang="auth-basic">Basic</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="auth-basic">
                                    <ul class="sub-menu">
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'auth-sign-in') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="auth-sign-in">Sign In</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'auth-sign-up') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="auth-sign-up">Sign Up</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'auth-reset-pass') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="auth-reset-pass">Reset Password</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'auth-new-pass') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="auth-new-pass">New Password</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'auth-two-factor') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="auth-two-factor">Two Factor</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'auth-lock-screen') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="auth-lock-screen">Lock Screen</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'auth-success-mail') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="auth-success-mail">Success Mail</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'auth-login-pin') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="auth-login-pin">Login with PIN</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'auth-delete-account') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="auth-delete-account">Delete Account</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="side-nav-item">
                                <a data-bs-toggle="collapse" href="#auth-card" aria-expanded="false" aria-controls="auth-card" class="side-nav-link">
                                    <span class="menu-text" data-lang="auth-card">Card</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="auth-card">
                                    <ul class="sub-menu">
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'auth-card-sign-in') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="auth-card-sign-in">Sign In</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'auth-card-sign-up') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="auth-card-sign-up">Sign Up</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'auth-card-reset-pass') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="auth-card-reset-pass">Reset Password</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'auth-card-new-pass') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="auth-card-new-pass">New Password</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'auth-card-two-factor') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="auth-card-two-factor">Two Factor</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'auth-card-lock-screen') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="auth-card-lock-screen">Lock Screen</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'auth-card-success-mail') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="auth-card-success-mail">Success Mail</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'auth-card-login-pin') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="auth-card-login-pin">Login with PIN</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'auth-card-delete-account') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="auth-card-delete-account">Delete Account</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="side-nav-item">
                                <a data-bs-toggle="collapse" href="#auth-split" aria-expanded="false" aria-controls="auth-split" class="side-nav-link">
                                    <span class="menu-text" data-lang="auth-split">Split</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="auth-split">
                                    <ul class="sub-menu">
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'auth-split-sign-in') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="auth-split-sign-in">Sign In</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'auth-split-sign-up') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="auth-split-sign-up">Sign Up</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'auth-split-reset-pass') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="auth-split-reset-pass">Reset Password</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'auth-split-new-pass') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="auth-split-new-pass">New Password</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'auth-split-two-factor') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="auth-split-two-factor">Two Factor</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'auth-split-lock-screen') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="auth-split-lock-screen">Lock Screen</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'auth-split-success-mail') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="auth-split-success-mail">Success Mail</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'auth-split-login-pin') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="auth-split-login-pin">Login with PIN</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'auth-split-delete-account') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="auth-split-delete-account">Delete Account</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#error-pages" aria-expanded="false" aria-controls="error-pages" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-alert-triangle"></i></span>
                        <span class="menu-text" data-lang="error-pages">Error Pages</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="error-pages">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'error-400') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="error-400">400 Bad Request</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'error-401') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="error-401">401 Unauthorized</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'error-403') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="error-403">403 Forbidden</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'error-404') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="error-404">404 Not Found</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'error-408') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="error-408">408 Request Timeout</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'error-500') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="error-500">500 Internal Server</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'error-maintenance') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="error-maintenance">Maintenance</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="side-nav-title mt-2" data-lang="layouts">Layouts</li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#layout-options" aria-expanded="false" aria-controls="layout-options" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-layout"></i></span>
                        <span class="menu-text" data-lang="layout-options">Layout Options</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="layout-options">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'layouts-scrollable') }}" class="side-nav-link" target="_blank">
                                    <span class="menu-text" data-lang="layouts-scrollable">Scrollable</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'layouts-compact') }}" class="side-nav-link" target="_blank">
                                    <span class="menu-text" data-lang="layouts-compact">Compact</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'layouts-boxed') }}" class="side-nav-link" target="_blank">
                                    <span class="menu-text" data-lang="layouts-boxed">Boxed</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'layouts-horizontal') }}" class="side-nav-link" target="_blank">
                                    <span class="menu-text" data-lang="layouts-horizontal">Horizontal</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'layouts-preloader') }}" class="side-nav-link" target="_blank">
                                    <span class="menu-text" data-lang="layouts-preloader">Preloader</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebars" aria-expanded="false" aria-controls="sidebars" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-layout-sidebar-inactive"></i></span>
                        <span class="menu-text" data-lang="sidebars">Sidebars</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebars">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'layouts-sidebar-light') }}" class="side-nav-link" target="_blank">
                                    <span class="menu-text" data-lang="layouts-sidebar-light">Light Menu</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'layouts-sidebar-gradient') }}" class="side-nav-link" target="_blank">
                                    <span class="menu-text" data-lang="layouts-sidebar-gradient">Gradient Menu</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'layouts-sidebar-gray') }}" class="side-nav-link" target="_blank">
                                    <span class="menu-text" data-lang="layouts-sidebar-gray">Gray Menu</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'layouts-sidebar-image') }}" class="side-nav-link" target="_blank">
                                    <span class="menu-text" data-lang="layouts-sidebar-image">Image Menu</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'layouts-sidebar-compact') }}" class="side-nav-link" target="_blank">
                                    <span class="menu-text" data-lang="layouts-sidebar-compact">Compact Menu</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'layouts-sidebar-on-hover') }}" class="side-nav-link" target="_blank">
                                    <span class="menu-text" data-lang="layouts-sidebar-on-hover">On Hover Menu</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'layouts-sidebar-on-hover-active') }}" class="side-nav-link" target="_blank">
                                    <span class="menu-text" data-lang="layouts-sidebar-on-hover-active">On Hover Active</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'layouts-sidebar-offcanvas') }}" class="side-nav-link" target="_blank">
                                    <span class="menu-text" data-lang="layouts-sidebar-offcanvas">Offcanvas Menu</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'layouts-sidebar-no-icons') }}" class="side-nav-link" target="_blank">
                                    <span class="menu-text" data-lang="layouts-sidebar-no-icons">No Icons with Lines</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'layouts-sidebar-with-lines') }}" class="side-nav-link" target="_blank">
                                    <span class="menu-text" data-lang="layouts-sidebar-with-lines">Sidebar with Lines</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#topbar" aria-expanded="false" aria-controls="topbar" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-layout-bottombar"></i></span>
                        <span class="menu-text" data-lang="topbar">Topbar</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="topbar">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'layouts-topbar-dark') }}" class="side-nav-link" target="_blank">
                                    <span class="menu-text" data-lang="layouts-topbar-dark">Dark Topbar</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'layouts-topbar-gray') }}" class="side-nav-link" target="_blank">
                                    <span class="menu-text" data-lang="layouts-topbar-gray">Gray Topbar</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'layouts-topbar-gradient') }}" class="side-nav-link" target="_blank">
                                    <span class="menu-text" data-lang="layouts-topbar-gradient">Gradient Topbar</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="side-nav-title mt-2" data-lang="components">Components</li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#base-ui" aria-expanded="false" aria-controls="base-ui" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-components"></i></span>
                        <span class="menu-text" data-lang="base-ui">Base UI</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="base-ui">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'ui-accordions') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="ui-accordions">Accordions</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'ui-alerts') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="ui-alerts">Alerts</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'ui-images') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="ui-images">Images</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'ui-badges') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="ui-badges">Badges</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'ui-breadcrumb') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="ui-breadcrumb">Breadcrumb</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'ui-buttons') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="ui-buttons">Buttons</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'ui-cards') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="ui-cards">Cards</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'ui-carousel') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="ui-carousel">Carousel</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'ui-collapse') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="ui-collapse">Collapse</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'ui-colors') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="ui-colors">Colors</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'ui-dropdowns') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="ui-dropdowns">Dropdowns</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'ui-videos') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="ui-videos">Videos</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'ui-grid') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="ui-grid">Grid Options</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'ui-links') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="ui-links">Links</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'ui-list-group') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="ui-list-group">List Group</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'ui-modals') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="ui-modals">Modals</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'ui-notifications') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="ui-notifications">Notifications</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'ui-offcanvas') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="ui-offcanvas">Offcanvas</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'ui-placeholders') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="ui-placeholders">Placeholders</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'ui-pagination') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="ui-pagination">Pagination</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'ui-popovers') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="ui-popovers">Popovers</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'ui-progress') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="ui-progress">Progress</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'ui-scrollspy') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="ui-scrollspy">Scrollspy</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'ui-spinners') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="ui-spinners">Spinners</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'ui-tabs') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="ui-tabs">Tabs</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'ui-tooltips') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="ui-tooltips">Tooltips</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'ui-typography') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="ui-typography">Typography</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'ui-utilities') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="ui-utilities">Utilities</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('page', 'widgets') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-stack-2"></i></span>
                        <span class="menu-text" data-lang="widgets">Widgets</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="{{ route('page', 'metrics') }}" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-chart-histogram"></i></span>
                        <span class="menu-text" data-lang="metrics">Metrics</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-chart-donut"></i></span>
                        <span class="menu-text" data-lang="charts">Charts</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="charts">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a data-bs-toggle="collapse" href="#apex-charts" aria-expanded="false" aria-controls="apex-charts" class="side-nav-link">
                                    <span class="menu-text" data-lang="apex-charts">Apex Charts</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="apex-charts">
                                    <ul class="sub-menu">
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-apex-area') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-apex-area">Area</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-apex-bar') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-apex-bar">Bar</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-apex-bubble') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-apex-bubble">Bubble</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-apex-candlestick') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-apex-candlestick">Candlestick</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-apex-column') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-apex-column">Column</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-apex-heatmap') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-apex-heatmap">Heatmap</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-apex-line') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-apex-line">Line</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-apex-mixed') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-apex-mixed">Mixed</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-apex-timeline') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-apex-timeline">Timeline</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-apex-boxplot') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-apex-boxplot">Boxplot</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-apex-treemap') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-apex-treemap">Treemap</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-apex-pie') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-apex-pie">Pie</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-apex-radar') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-apex-radar">Radar</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-apex-radialbar') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-apex-radialbar">RadialBar</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-apex-scatter') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-apex-scatter">Scatter</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-apex-polar-area') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-apex-polar-area">Polar Area</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-apex-sparklines') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-apex-sparklines">Sparklines</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-apex-range') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-apex-range">Range</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-apex-funnel') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-apex-funnel">Funnel</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-apex-slope') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-apex-slope">Slope</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="side-nav-item">
                                <a data-bs-toggle="collapse" href="#echarts" aria-expanded="false" aria-controls="echarts" class="side-nav-link">
                                    <span class="menu-text" data-lang="echarts">Echarts</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="echarts">
                                    <ul class="sub-menu">
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-echart-line') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-echart-line">Line</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-echart-bar') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-echart-bar">Bar</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-echart-pie') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-echart-pie">Pie</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-echart-scatter') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-echart-scatter">Scatter</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-echart-geo-map') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-echart-geo-map">GEO Map</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-echart-gauge') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-echart-gauge">Gauge</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-echart-candlestick') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-echart-candlestick">Candlestick</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-echart-area') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-echart-area">Area</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-echart-radar') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-echart-radar">Radar</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-echart-heatmap') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-echart-heatmap">Heatmap</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'charts-echart-other') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="charts-echart-other">Other</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#forms" aria-expanded="false" aria-controls="forms" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-clipboard-list"></i></span>
                        <span class="menu-text" data-lang="forms">Forms</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="forms">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'form-elements') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="form-elements">Basic Elements</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'form-pickers') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="form-pickers">Pickers</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'form-select') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="form-select">Select</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'form-validation') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="form-validation">Validation</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'form-wizard') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="form-wizard">Wizard</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'form-fileuploads') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="form-fileuploads">File Uploads</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'form-text-editors') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="form-text-editors">Text Editors</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'form-range-slider') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="form-range-slider">Range Slider</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'form-layout') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="form-layout">Layouts</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'form-other-plugin') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="form-other-plugin">Other Plugins</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-table-column"></i></span>
                        <span class="menu-text" data-lang="tables">Tables</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="tables">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'tables-static') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="tables-static">Static Tables</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'tables-custom') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="tables-custom">Custom Tables</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a data-bs-toggle="collapse" href="#datatables" aria-expanded="false" aria-controls="datatables" class="side-nav-link">
                                    <span class="menu-text" data-lang="datatables">DataTables</span>
                                    <span class="badge bg-success text-white">15</span>
                                </a>
                                <div class="collapse" id="datatables">
                                    <ul class="sub-menu">
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'tables-datatables-basic') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="tables-datatables-basic">Basic</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'tables-datatables-export-data') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="tables-datatables-export-data">Export Data</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'tables-datatables-select') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="tables-datatables-select">Select</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'tables-datatables-ajax') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="tables-datatables-ajax">Ajax</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'tables-datatables-javascript') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="tables-datatables-javascript">Javascript Source</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'tables-datatables-rendering') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="tables-datatables-rendering">Data Rendering</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'tables-datatables-scroll') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="tables-datatables-scroll">Scroll</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'tables-datatables-fixed-columns') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="tables-datatables-fixed-columns">Fixed Columns</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'tables-datatables-fixed-header') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="tables-datatables-fixed-header">Fixed Header</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'tables-datatables-columns') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="tables-datatables-columns">Show &amp; Hide Column</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'tables-datatables-child-rows') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="tables-datatables-child-rows">Child Rows</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'tables-datatables-column-searching') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="tables-datatables-column-searching">Column Searching</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'tables-datatables-range-search') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="tables-datatables-range-search">Range Search</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'tables-datatables-rows-add') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="tables-datatables-rows-add">Add Rows</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="{{ route('page', 'tables-datatables-checkbox-select') }}" class="side-nav-link">
                                                <span class="menu-text" data-lang="tables-datatables-checkbox-select">Checkbox Select</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-icons"></i></span>
                        <span class="menu-text" data-lang="icons">Icons</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="icons">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'icons-tabler') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="icons-tabler">Tabler</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'icons-lucide') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="icons-lucide">Lucide</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'icons-flags') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="icons-flags">Flags</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#maps" aria-expanded="false" aria-controls="maps" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-map"></i></span>
                        <span class="menu-text" data-lang="maps">Maps</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="maps">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'maps-google') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="maps-google">Google Maps</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'maps-vector') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="maps-vector">Vector Maps</span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="{{ route('page', 'maps-leaflet') }}" class="side-nav-link">
                                    <span class="menu-text" data-lang="maps-leaflet">Leaflet Maps</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="side-nav-title mt-2" data-lang="menu-items">Menu Items</li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#menu-levels" aria-expanded="false" aria-controls="menu-levels" class="side-nav-link">
                        <span class="menu-icon"><i class="ti ti-sitemap"></i></span>
                        <span class="menu-text" data-lang="menu-levels">Menu Levels</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="menu-levels">
                        <ul class="sub-menu">
                            <li class="side-nav-item">
                                <a data-bs-toggle="collapse" href="#second-level" aria-expanded="false" aria-controls="second-level" class="side-nav-link">
                                    <span class="menu-text" data-lang="second-level">Second Level</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="second-level">
                                    <ul class="sub-menu">
                                        <li class="side-nav-item">
                                            <a href="#" class="side-nav-link">
                                                <span class="menu-text" data-lang="menu-item-1">Item 2.1</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a href="#" class="side-nav-link">
                                                <span class="menu-text" data-lang="menu-item-2">Item 2.2</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="side-nav-item">
                                <a data-bs-toggle="collapse" href="#second-level-2" aria-expanded="false" aria-controls="second-level-2" class="side-nav-link">
                                    <span class="menu-text" data-lang="second-level-2">Second Level</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="second-level-2">
                                    <ul class="sub-menu">
                                        <li class="side-nav-item">
                                            <a href="#" class="side-nav-link">
                                                <span class="menu-text" data-lang="menu-item-3">Item 2.1</span>
                                            </a>
                                        </li>
                                        <li class="side-nav-item">
                                            <a data-bs-toggle="collapse" href="#menu-item-4" aria-expanded="false" aria-controls="menu-item-4" class="side-nav-link">
                                                <span class="menu-text" data-lang="menu-item-4">Item 2.2</span>
                                                <span class="menu-arrow"></span>
                                            </a>
                                            <div class="collapse" id="menu-item-4">
                                                <ul class="sub-menu">
                                                    <li class="side-nav-item">
                                                        <a href="#" class="side-nav-link">
                                                            <span class="menu-text" data-lang="menu-item-5">Item 3.1</span>
                                                        </a>
                                                    </li>
                                                    <li class="side-nav-item">
                                                        <a href="#" class="side-nav-link">
                                                            <span class="menu-text" data-lang="menu-item-6">Item 3.2</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="side-nav-item">
                    <a href="#" class="side-nav-link disabled">
                        <span class="menu-icon"><i class="ti ti-ban"></i></span>
                        <span class="menu-text" data-lang="disabled-menu">Disabled Menu</span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="#" class="side-nav-link special-menu">
                        <span class="menu-icon"><i class="ti ti-star"></i></span>
                        <span class="menu-text" data-lang="special-menu">Special Menu</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Sidenav Menu End -->