<header class="app-topbar">
    <div class="container-fluid topbar-menu">
        <div class="d-flex align-items-center gap-2">
            <!-- Topbar Brand Logo -->
            <div class="logo-topbar">
                <!-- Logo light -->
                <a href="{{ route('dashboard') }}" class="logo-light">
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="logo" />
                    </span>
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo" />
                    </span>
                </a>

                <!-- Logo Dark -->
                <a href="{{ route('dashboard') }}" class="logo-dark">
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-black.png') }}" alt="dark logo" />
                    </span>
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo" />
                    </span>
                </a>
            </div>

            <!-- Sidebar Menu Toggle Button -->
            <button class="sidenav-toggle-button btn btn-default btn-icon">
                <i class="ti ti-menu-4"></i>
            </button>

            <!-- Horizontal Menu Toggle Button -->
            <button class="topnav-toggle-button px-2" data-bs-toggle="collapse" data-bs-target="#topnav-menu">
                <i class="ti ti-menu-4"></i>
            </button>

            <div id="search-box" class="app-search d-none d-xl-flex">
                <input type="search" class="form-control topbar-search" name="search" placeholder="Search for something..." />
                <i class="ti ti-search app-search-icon text-muted"></i>
            </div>

            <div id="megamenu-header" class="topbar-item d-none d-md-flex">
                <div class="dropdown">
                    <button class="topbar-link btn fw-medium btn-link dropdown-toggle drop-arrow-none px-2" data-bs-toggle="dropdown" type="button" aria-haspopup="false" aria-expanded="false">
                        <span data-lang="mega-menu">Mega Menu</span>
                        <i class="ti ti-chevron-down ms-1"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-xxl p-0">
                        <div class="h-100" style="max-height: 380px" data-simplebar="">
                            <div class="row g-0">
                                <div class="col-12">
                                    <div class="px-3 py-2 text-center bg-light bg-opacity-50">
                                        <h4 class="mb-0 fs-lg fw-semibold">
                                            <span data-lang="mega-welcome">Welcome to</span>
                                            <span class="text-primary">Inspinia</span>
                                            <span data-lang="mega-admin-theme">Admin Theme.</span>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <div class="p-3">
                                        <h5 class="mb-2 fw-semibold fs-sm dropdown-header" data-lang="mega-dash-analytics">Dashboard &amp; Analytics</h5>
                                        <ul class="list-unstyled megamenu-list">
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item" data-lang="mega-sales-dash">Sales Dashboard</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item" data-lang="mega-mktg-dash">Marketing Dashboard</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item" data-lang="mega-fin-overview">Finance Overview</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item" data-lang="mega-user-analytics">User Analytics</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item" data-lang="mega-traffic-insights">Traffic Insights</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="p-3">
                                        <h5 class="mb-2 fw-semibold fs-sm dropdown-header" data-lang="mega-proj-mgmt">Project Management</h5>
                                        <ul class="list-unstyled megamenu-list">
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item" data-lang="mega-task-overview">Task Overview</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item" data-lang="mega-kanban-board">Kanban Board</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item" data-lang="mega-gantt-chart">Gantt Chart</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item" data-lang="mega-team-collab">Team Collaboration</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item" data-lang="mega-proj-milestones">Project Milestones</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="p-3">
                                        <h5 class="mb-2 fw-semibold fs-sm dropdown-header" data-lang="mega-user-mgmt">User Management</h5>
                                        <ul class="list-unstyled megamenu-list">
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item" data-lang="mega-user-profiles">User Profiles</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item" data-lang="mega-access-control">Access Control</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item" data-lang="mega-role-permissions">Role Permissions</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item" data-lang="mega-activity-logs">Activity Logs</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item" data-lang="mega-security-settings">Security Settings</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="megamenu-apps" class="topbar-item d-none d-md-flex">
                <div class="dropdown">
                    <button class="topbar-link btn fw-medium btn-link dropdown-toggle drop-arrow-none px-2" data-bs-toggle="dropdown" type="button" aria-haspopup="false" aria-expanded="false">
                        <span data-lang="apps-menu">Apps</span>
                        <i class="ti ti-chevron-down ms-1"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-xxl p-0">
                        <div class="h-100" style="max-height: 380px" data-simplebar="">
                            <div class="row g-0">
                                <div class="col-sm-8">
                                    <div class="row g-0">
                                        <div class="col-sm-6">
                                            <div class="p-2">
                                                <a href="#!" class="dropdown-item">
                                                    <span class="d-flex align-items-center">
                                                        <span class="avatar-md me-2">
                                                            <span class="avatar-title text-primary border border-light bg-light bg-opacity-50 rounded">
                                                                <i class="ti ti-basket fs-22"></i>
                                                            </span>
                                                        </span>
                                                        <span>
                                                            <h5 class="fs-base mb-0 lh-base" data-lang="ecommerce">eCommerce</h5>
                                                            <span class="text-muted fs-12" data-lang="app-desc-ecommerce">Products, orders &amp; etc.</span>
                                                        </span>
                                                    </span>
                                                </a>

                                                <a href="#!" class="dropdown-item my-2">
                                                    <span class="d-flex align-items-center">
                                                        <span class="avatar-md me-2">
                                                            <span class="avatar-title text-success border border-light bg-light bg-opacity-50 rounded">
                                                                <i class="ti ti-message fs-22"></i>
                                                            </span>
                                                        </span>
                                                        <span>
                                                            <h5 class="fs-base mb-0 lh-base" data-lang="apps-chat">Chat</h5>
                                                            <span class="text-muted fs-12" data-lang="app-desc-chat">Team conversations</span>
                                                        </span>
                                                    </span>
                                                </a>

                                                <a href="#!" class="dropdown-item my-2">
                                                    <span class="d-flex align-items-center">
                                                        <span class="avatar-md me-2">
                                                            <span class="avatar-title text-danger border border-light bg-light bg-opacity-50 rounded">
                                                                <i class="ti ti-list-check fs-22"></i>
                                                            </span>
                                                        </span>
                                                        <span>
                                                            <h5 class="fs-base mb-0 lh-base" data-lang="task">Task</h5>
                                                            <span class="text-muted fs-12" data-lang="app-desc-task">Plan and track work</span>
                                                        </span>
                                                    </span>
                                                </a>

                                                <a href="#!" class="dropdown-item mt-2">
                                                    <span class="d-flex align-items-center">
                                                        <span class="avatar-md me-2">
                                                            <span class="avatar-title text-info border border-light bg-light bg-opacity-50 rounded">
                                                                <i class="ti ti-mailbox fs-22"></i>
                                                            </span>
                                                        </span>
                                                        <span>
                                                            <h5 class="fs-base mb-0 lh-base" data-lang="email">Email</h5>
                                                            <span class="text-muted fs-12" data-lang="app-desc-email">Messages and inbox</span>
                                                        </span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="p-2">
                                                <a href="#!" class="dropdown-item">
                                                    <span class="d-flex align-items-center">
                                                        <span class="avatar-md me-2">
                                                            <span class="avatar-title text-secondary border border-light bg-light bg-opacity-50 rounded">
                                                                <i class="ti ti-building fs-22"></i>
                                                            </span>
                                                        </span>
                                                        <span>
                                                            <h5 class="fs-base mb-0 lh-base" data-lang="apps-companies">Companies</h5>
                                                            <span class="text-muted fs-12" data-lang="app-desc-companies">Business profiles</span>
                                                        </span>
                                                    </span>
                                                </a>

                                                <a href="#!" class="dropdown-item my-2">
                                                    <span class="d-flex align-items-center">
                                                        <span class="avatar-md me-2">
                                                            <span class="avatar-title text-dark border border-light bg-light bg-opacity-50 rounded">
                                                                <i class="ti ti-id fs-22"></i>
                                                            </span>
                                                        </span>
                                                        <span>
                                                            <h5 class="fs-base mb-0 lh-base" data-lang="apps-users-contacts">Contacts Diary</h5>
                                                            <span class="text-muted fs-12" data-lang="app-desc-contacts">People and connections</span>
                                                        </span>
                                                    </span>
                                                </a>

                                                <a href="#!" class="dropdown-item my-2">
                                                    <span class="d-flex align-items-center">
                                                        <span class="avatar-md me-2">
                                                            <span class="avatar-title text-warning border border-light bg-light bg-opacity-50 rounded">
                                                                <i class="ti ti-calendar fs-22"></i>
                                                            </span>
                                                        </span>
                                                        <span>
                                                            <h5 class="fs-base mb-0 lh-base" data-lang="apps-calendar">Calendar</h5>
                                                            <span class="text-muted fs-12" data-lang="app-desc-calendar">Events and reminders</span>
                                                        </span>
                                                    </span>
                                                </a>

                                                <a href="#!" class="dropdown-item mt-2">
                                                    <span class="d-flex align-items-center">
                                                        <span class="avatar-md me-2">
                                                            <span class="avatar-title text-success border border-light bg-light bg-opacity-50 rounded">
                                                                <i class="ti ti-lifebuoy fs-22"></i>
                                                            </span>
                                                        </span>
                                                        <span>
                                                            <h5 class="fs-base mb-0 lh-base" data-lang="support">Support</h5>
                                                            <span class="text-muted fs-12" data-lang="app-desc-support">Help and assistance</span>
                                                        </span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end row-->

                                    <div class="row g-0 border-top border-light border-dashed text-center">
                                        <div class="col">
                                            <div class="p-3">
                                                <p class="fw-medium text-muted mb-2 fs-11 text-uppercase lh-1">-: &nbsp; <span data-lang="support">Support</span> &nbsp;:-</p>
                                                <h5 class="fs-15 mb-0">help@mydomain.com</h5>
                                            </div>
                                        </div>
                                        <!-- end col-->
                                        <div class="col">
                                            <div class="p-3">
                                                <p class="fw-medium text-muted mb-2 fs-11 text-uppercase lh-1">-: &nbsp; <span data-lang="support">Help:</span> &nbsp;:-</p>
                                                <h5 class="fs-15 mb-0">+(12) 3456 7890</h5>
                                            </div>
                                        </div>
                                        <!-- end col-->
                                    </div>
                                    <!-- end row-->
                                </div>
                                <!-- end col-->

                                <div class="col-sm-4">
                                    <div class="h-100 position-relative rounded-end rounded-0 overflow-hidden" style="background: url({{ asset('assets/images/stock/small-8.jpg') }}); background-size: cover">
                                        <div class="p-3 card-img-overlay bg-gradient bg-secondary bg-opacity-90 d-flex align-items-center justify-content-center">
                                            <div class="text-center text-white">
                                                <i class="ti ti-atom fs-36"></i>

                                                <p class="text-white text-opacity-75 mb-3 text-uppercase" data-lang="limited-offer">Limited Offer</p>

                                                <h3 class="fw-semibold text-white mb-2 fs-20" data-lang="unlock-savings">Unlock Exclusive Savings</h3>

                                                <h4 class="fw-medium fs-16 mb-1">
                                                    <del class="text-white text-opacity-75">$49.00</del>
                                                    /
                                                    <span class="fw-bold text-white">$25 USD</span>
                                                </h4>

                                                <button type="button" class="btn btn-danger btn-sm mt-3">
                                                    <i class="ti ti-shopping-cart me-1"></i>
                                                    <span data-lang="grab-deal">Grab Deal</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end .bg-light-->
                                </div>
                                <!-- end col-->
                            </div>
                            <!-- end row-->
                        </div>
                        <!-- end .h-100-->
                    </div>
                    <!-- .dropdown-menu-->
                </div>
                <!-- .dropdown-->
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            <div id="theme-toggler" class="topbar-item d-none d-sm-flex">
                <button class="topbar-link" id="light-dark-mode" type="button">
                    <i class="ti ti-moon topbar-link-icon mode-light-moon"></i>
                    <i class="ti ti-sun topbar-link-icon mode-light-sun"></i>
                </button>
            </div>

            <div id="apps-dropdown-rounded" class="topbar-item">
                <div class="dropdown">
                    <button class="topbar-link dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown" type="button" data-bs-auto-close="outside" aria-haspopup="false" aria-expanded="false">
                        <i class="ti ti-apps topbar-link-icon"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-lg p-2 dropdown-menu-end">
                        <div class="row align-items-center g-1">
                            <div class="col-4">
                                <a href="javascript:void(0);" class="dropdown-item rounded text-center py-2">
                                    <span class="avatar-sm d-block mx-auto mb-1">
                                        <span class="avatar-title text-bg-light rounded-circle">
                                            <img src="{{ asset('assets/images/logos/google.svg') }}" alt="Google Logo" height="18" />
                                        </span>
                                    </span>
                                    <span class="align-middle fw-medium">Google</span>
                                </a>
                            </div>

                            <div class="col-4">
                                <a href="javascript:void(0);" class="dropdown-item rounded text-center py-2">
                                    <span class="avatar-sm d-block mx-auto mb-1">
                                        <span class="avatar-title text-bg-light rounded-circle">
                                            <img src="{{ asset('assets/images/logos/figma.svg') }}" alt="Figma Logo" height="18" />
                                        </span>
                                    </span>
                                    <span class="align-middle fw-medium">Figma</span>
                                </a>
                            </div>

                            <div class="col-4">
                                <a href="javascript:void(0);" class="dropdown-item rounded text-center py-2">
                                    <span class="avatar-sm d-block mx-auto mb-1">
                                        <span class="avatar-title text-bg-light rounded-circle">
                                            <img src="{{ asset('assets/images/logos/slack.svg') }}" alt="Slack Logo" height="18" />
                                        </span>
                                    </span>
                                    <span class="align-middle fw-medium">Slack</span>
                                </a>
                            </div>

                            <div class="col-4">
                                <a href="javascript:void(0);" class="dropdown-item rounded text-center py-2">
                                    <span class="avatar-sm d-block mx-auto mb-1">
                                        <span class="avatar-title text-bg-light rounded-circle">
                                            <img src="{{ asset('assets/images/logos/dropbox.svg') }}" alt="Dropbox Logo" height="18" />
                                        </span>
                                    </span>
                                    <span class="align-middle fw-medium">Dropbox</span>
                                </a>
                            </div>

                            <div class="col-4">
                                <a href="javascript:void(0);" class="dropdown-item rounded text-center py-2">
                                    <span class="avatar-sm d-block mx-auto mb-1">
                                        <span class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                            <i class="ti ti-calendar fs-18"></i>
                                        </span>
                                    </span>
                                    <span class="align-middle fw-medium">Calendar</span>
                                </a>
                            </div>

                            <div class="col-4">
                                <a href="javascript:void(0);" class="dropdown-item rounded text-center py-2">
                                    <span class="avatar-sm d-block mx-auto mb-1">
                                        <span class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                            <i class="ti ti-folder fs-18"></i>
                                        </span>
                                    </span>
                                    <span class="align-middle fw-medium">Files</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- End dropdown-menu -->
                </div>
                <!-- end dropdown-->
            </div>

            <div id="simple-messages-dropdown" class="topbar-item">
                <div class="dropdown">
                    <button class="topbar-link dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown" type="button" data-bs-auto-close="outside" aria-haspopup="false" aria-expanded="false">
                        <i class="ti ti-mail topbar-link-icon"></i>
                        <span class="badge text-bg-success badge-circle topbar-badge">7</span>
                    </button>

                    <div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg">
                        <div class="px-3 py-2 border-bottom">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0 fs-md fw-semibold">Messages</h6>
                                </div>
                                <div class="col text-end">
                                    <a href="#!" class="badge badge-soft-success badge-label py-1">09 Notifications</a>
                                </div>
                            </div>
                        </div>

                        <div style="max-height: 300px" data-simplebar="">
                            <!-- item 1 -->
                            <div class="dropdown-item notification-item py-2 text-wrap active" id="message-1">
                                <span class="d-flex gap-3">
                                    <span class="flex-shrink-0">
                                        <img src="{{ asset('assets/images/users/user-1.jpg') }}" class="avatar-md rounded-circle" alt="User Avatar" />
                                    </span>
                                    <span class="flex-grow-1 text-muted">
                                        <span class="fw-medium text-body">Liam Carter</span>
                                        uploaded a new document to
                                        <span class="fw-medium text-body">Project Phoenix</span>
                                        <br />
                                        <span class="fs-xs">5 minutes ago</span>
                                    </span>
                                    <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0" data-dismissible="#message-1">
                                        <i class="ti ti-square-rounded-x fs-xxl"></i>
                                    </button>
                                </span>
                            </div>

                            <!-- item 2 -->
                            <div class="dropdown-item notification-item py-2 text-wrap" id="message-2">
                                <span class="d-flex gap-3">
                                    <span class="flex-shrink-0">
                                        <img src="{{ asset('assets/images/users/user-2.jpg') }}" class="avatar-md rounded-circle" alt="User Avatar" />
                                    </span>
                                    <span class="flex-grow-1 text-muted">
                                        <span class="fw-medium text-body">Ava Mitchell</span>
                                        commented on
                                        <span class="fw-medium text-body">Marketing Campaign Q3</span>
                                        <br />
                                        <span class="fs-xs">12 minutes ago</span>
                                    </span>
                                    <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0" data-dismissible="#message-2">
                                        <i class="ti ti-square-rounded-x fs-xxl"></i>
                                    </button>
                                </span>
                            </div>

                            <!-- item 3 -->
                            <div class="dropdown-item notification-item py-2 text-wrap" id="message-3">
                                <span class="d-flex gap-3">
                                    <span class="avatar-md flex-shrink-0">
                                        <span class="avatar-title text-bg-info rounded-circle fs-22">
                                            <i class="ti ti-user-hexagon fs-22"></i>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1 text-muted">
                                        <span class="fw-medium text-body">Noah Blake</span>
                                        updated the status of
                                        <span class="fw-medium text-body">Client Onboarding</span>
                                        <br />
                                        <span class="fs-xs">30 minutes ago</span>
                                    </span>
                                    <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0" data-dismissible="#message-3">
                                        <i class="ti ti-square-rounded-x fs-xxl"></i>
                                    </button>
                                </span>
                            </div>

                            <!-- item 4 -->
                            <div class="dropdown-item notification-item py-2 text-wrap" id="message-4">
                                <span class="d-flex gap-3">
                                    <span class="flex-shrink-0">
                                        <img src="{{ asset('assets/images/users/user-4.jpg') }}" class="avatar-md rounded-circle" alt="User Avatar" />
                                    </span>
                                    <span class="flex-grow-1 text-muted">
                                        <span class="fw-medium text-body">Sophia Taylor</span>
                                        sent an invoice for
                                        <span class="fw-medium text-body">Service Renewal</span>
                                        <br />
                                        <span class="fs-xs">1 hour ago</span>
                                    </span>
                                    <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0" data-dismissible="#message-4">
                                        <i class="ti ti-square-rounded-x fs-xxl"></i>
                                    </button>
                                </span>
                            </div>

                            <!-- item 5 -->
                            <div class="dropdown-item notification-item py-2 text-wrap" id="message-5">
                                <span class="d-flex gap-3">
                                    <span class="flex-shrink-0">
                                        <img src="{{ asset('assets/images/users/user-5.jpg') }}" class="avatar-md rounded-circle" alt="User Avatar" />
                                    </span>
                                    <span class="flex-grow-1 text-muted">
                                        <span class="fw-medium text-body">Ethan Moore</span>
                                        completed the task
                                        <span class="fw-medium text-body">UI Review</span>
                                        <br />
                                        <span class="fs-xs">2 hours ago</span>
                                    </span>
                                    <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0" data-dismissible="#message-5">
                                        <i class="ti ti-square-rounded-x fs-xxl"></i>
                                    </button>
                                </span>
                            </div>

                            <!-- item 6 -->
                            <div class="dropdown-item notification-item py-2 text-wrap" id="message-6">
                                <span class="d-flex gap-3">
                                    <span class="flex-shrink-0">
                                        <img src="{{ asset('assets/images/users/user-6.jpg') }}" class="avatar-md rounded-circle" alt="User Avatar" />
                                    </span>
                                    <span class="flex-grow-1 text-muted">
                                        <span class="fw-medium text-body">Olivia White</span>
                                        assigned you a task in
                                        <span class="fw-medium text-body">Sales Pipeline</span>
                                        <br />
                                        <span class="fs-xs">Yesterday</span>
                                    </span>
                                    <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0" data-dismissible="#message-6">
                                        <i class="ti ti-square-rounded-x fs-xxl"></i>
                                    </button>
                                </span>
                            </div>
                        </div>

                        <!-- All-->
                        <a href="javascript:void(0);" class="dropdown-item text-center text-reset text-decoration-underline link-offset-2 fw-bold notify-item border-top border-light py-2">Read All Messages</a>
                    </div>
                    <!-- End dropdown-menu -->
                </div>
                <!-- end dropdown-->
            </div>

            <div id="notification-dropdown-alert" class="topbar-item">
                <div class="dropdown">
                    <button class="topbar-link dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown" type="button" data-bs-auto-close="outside" aria-haspopup="false" aria-expanded="false">
                        <i class="ti ti-bell topbar-link-icon"></i>
                        <span class="badge badge-square text-bg-warning topbar-badge">12</span>
                    </button>

                    <div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg">
                        <div class="px-3 py-2 border-bottom">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0 fs-md fw-semibold">Notifications</h6>
                                </div>
                                <div class="col text-end">
                                    <a href="#!" class="badge text-bg-light badge-label py-1">12 Alerts</a>
                                </div>
                            </div>
                        </div>

                        <div style="max-height: 300px" data-simplebar="">
                            <!-- item 1 -->
                            <div class="dropdown-item notification-item py-2 text-wrap" id="notification-1">
                                <span class="d-flex gap-2">
                                    <span class="avatar-md flex-shrink-0">
                                        <span class="avatar-title bg-danger-subtle text-danger rounded">
                                            <i class="ti ti-server-bolt notification-item-icon fill-danger"></i>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1 text-muted">
                                        <span class="fw-medium text-body">Critical alert: Server crash detected</span>
                                        <br />
                                        <span class="fs-xs">30 minutes ago</span>
                                    </span>
                                    <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0" data-dismissible="#notification-1">
                                        <i class="ti ti-square-rounded-x fs-xxl"></i>
                                    </button>
                                </span>
                            </div>

                            <!-- item 2 -->
                            <div class="dropdown-item notification-item py-2 text-wrap" id="notification-2">
                                <span class="d-flex gap-2">
                                    <span class="avatar-md flex-shrink-0">
                                        <span class="avatar-title bg-warning-subtle text-warning rounded">
                                            <i class="ti ti-alert-triangle notification-item-icon fill-warning"></i>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1 text-muted">
                                        <span class="fw-medium text-body">High memory usage on Node A</span>
                                        <br />
                                        <span class="fs-xs">10 minutes ago</span>
                                    </span>
                                    <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0" data-dismissible="#notification-2">
                                        <i class="ti ti-square-rounded-x fs-xxl"></i>
                                    </button>
                                </span>
                            </div>

                            <!-- item 3 -->
                            <div class="dropdown-item notification-item py-2 text-wrap" id="notification-3">
                                <span class="d-flex gap-2">
                                    <span class="avatar-md flex-shrink-0">
                                        <span class="avatar-title bg-success-subtle text-success rounded">
                                            <i class="ti ti-circle-check notification-item-icon fill-success"></i>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1 text-muted">
                                        <span class="fw-medium text-body">Backup completed successfully</span>
                                        <br />
                                        <span class="fs-xs">1 hour ago</span>
                                    </span>
                                    <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0" data-dismissible="#notification-3">
                                        <i class="ti ti-square-rounded-x fs-xxl"></i>
                                    </button>
                                </span>
                            </div>

                            <!-- item 4 -->
                            <div class="dropdown-item notification-item py-2 text-wrap" id="notification-4">
                                <span class="d-flex gap-2">
                                    <span class="avatar-md flex-shrink-0">
                                        <span class="avatar-title bg-primary-subtle text-primary rounded">
                                            <i class="ti ti-user-plus notification-item-icon fill-primary"></i>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1 text-muted">
                                        <span class="fw-medium text-body">New user registration: Sarah Miles</span>
                                        <br />
                                        <span class="fs-xs">Just now</span>
                                    </span>
                                    <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0" data-dismissible="#notification-4">
                                        <i class="ti ti-square-rounded-x fs-xxl"></i>
                                    </button>
                                </span>
                            </div>

                            <!-- item 5 -->
                            <div class="dropdown-item notification-item py-2 text-wrap" id="notification-5">
                                <span class="d-flex gap-2">
                                    <span class="avatar-md flex-shrink-0">
                                        <span class="avatar-title bg-danger-subtle text-danger rounded">
                                            <i class="ti ti-bug notification-item-icon fill-danger"></i>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1 text-muted">
                                        <span class="fw-medium text-body">Bug reported in payment module</span>
                                        <br />
                                        <span class="fs-xs">20 minutes ago</span>
                                    </span>
                                    <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0" data-dismissible="#notification-5">
                                        <i class="ti ti-square-rounded-x fs-xxl"></i>
                                    </button>
                                </span>
                            </div>

                            <!-- item 6 -->
                            <div class="dropdown-item notification-item py-2 text-wrap" id="notification-6">
                                <span class="d-flex gap-2">
                                    <span class="avatar-md flex-shrink-0">
                                        <span class="avatar-title bg-info-subtle text-info rounded">
                                            <i class="ti ti-message-circle notification-item-icon fill-info"></i>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1 text-muted">
                                        <span class="fw-medium text-body">New comment on Task #142</span>
                                        <br />
                                        <span class="fs-xs">15 minutes ago</span>
                                    </span>
                                    <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0" data-dismissible="#notification-6">
                                        <i class="ti ti-square-rounded-x fs-xxl"></i>
                                    </button>
                                </span>
                            </div>

                            <!-- item 7 -->
                            <div class="dropdown-item notification-item py-2 text-wrap" id="notification-7">
                                <span class="d-flex gap-2">
                                    <span class="avatar-md flex-shrink-0">
                                        <span class="avatar-title bg-warning-subtle text-warning rounded">
                                            <i class="ti ti-battery-charging notification-item-icon fill-warning"></i>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1 text-muted">
                                        <span class="fw-medium text-body">Low battery on Device X</span>
                                        <br />
                                        <span class="fs-xs">45 minutes ago</span>
                                    </span>
                                    <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0" data-dismissible="#notification-7">
                                        <i class="ti ti-square-rounded-x fs-xxl"></i>
                                    </button>
                                </span>
                            </div>

                            <!-- item 8 -->
                            <div class="dropdown-item notification-item py-2 text-wrap" id="notification-8">
                                <span class="d-flex gap-2">
                                    <span class="avatar-md flex-shrink-0">
                                        <span class="avatar-title bg-success-subtle text-success rounded">
                                            <i class="ti ti-cloud-upload notification-item-icon fill-success"></i>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1 text-muted">
                                        <span class="fw-medium text-body">File upload completed</span>
                                        <br />
                                        <span class="fs-xs">1 hour ago</span>
                                    </span>
                                    <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0" data-dismissible="#notification-8">
                                        <i class="ti ti-square-rounded-x fs-xxl"></i>
                                    </button>
                                </span>
                            </div>

                            <!-- item 9 -->
                            <div class="dropdown-item notification-item py-2 text-wrap" id="notification-9">
                                <span class="d-flex gap-2">
                                    <span class="avatar-md flex-shrink-0">
                                        <span class="avatar-title bg-primary-subtle text-primary rounded">
                                            <i class="ti ti-calendar notification-item-icon fill-primary"></i>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1 text-muted">
                                        <span class="fw-medium text-body">Team meeting scheduled at 3 PM</span>
                                        <br />
                                        <span class="fs-xs">2 hours ago</span>
                                    </span>
                                    <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0" data-dismissible="#notification-9">
                                        <i class="ti ti-square-rounded-x fs-xxl"></i>
                                    </button>
                                </span>
                            </div>

                            <!-- item 10 -->
                            <div class="dropdown-item notification-item py-2 text-wrap" id="notification-10">
                                <span class="d-flex gap-2">
                                    <span class="avatar-md flex-shrink-0">
                                        <span class="avatar-title bg-secondary-subtle text-secondary rounded">
                                            <i class="ti ti-download notification-item-icon fill-secondary"></i>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1 text-muted">
                                        <span class="fw-medium text-body">Report ready for download</span>
                                        <br />
                                        <span class="fs-xs">3 hours ago</span>
                                    </span>
                                    <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0" data-dismissible="#notification-10">
                                        <i class="ti ti-square-rounded-x fs-xxl"></i>
                                    </button>
                                </span>
                            </div>

                            <!-- item 11 -->
                            <div class="dropdown-item notification-item py-2 text-wrap" id="notification-11">
                                <span class="d-flex gap-2">
                                    <span class="avatar-md flex-shrink-0">
                                        <span class="avatar-title bg-danger-subtle text-danger rounded">
                                            <i class="ti ti-lock notification-item-icon fill-danger"></i>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1 text-muted">
                                        <span class="fw-medium text-body">Multiple failed login attempts</span>
                                        <br />
                                        <span class="fs-xs">5 hours ago</span>
                                    </span>
                                    <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0" data-dismissible="#notification-11">
                                        <i class="ti ti-square-rounded-x fs-xxl"></i>
                                    </button>
                                </span>
                            </div>

                            <!-- item 12 -->
                            <div class="dropdown-item notification-item py-2 text-wrap" id="notification-12">
                                <span class="d-flex gap-2">
                                    <span class="avatar-md flex-shrink-0">
                                        <span class="avatar-title bg-info-subtle text-info rounded">
                                            <i class="ti ti-bell-ringing notification-item-icon fill-info"></i>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1 text-muted">
                                        <span class="fw-medium text-body">Reminder: Submit your timesheet</span>
                                        <br />
                                        <span class="fs-xs">Today, 9:00 AM</span>
                                    </span>
                                    <button type="button" class="flex-shrink-0 text-muted btn btn-link p-0" data-dismissible="#notification-12">
                                        <i class="ti ti-square-rounded-x fs-xxl"></i>
                                    </button>
                                </span>
                            </div>
                        </div>

                        <!-- All-->
                        <a href="javascript:void(0);" class="dropdown-item text-center text-reset text-decoration-underline link-offset-2 fw-bold notify-item border-top border-light py-2">View All Alerts</a>
                    </div>
                </div>
            </div>

            <div id="fullscreen-toggler" class="topbar-item d-none d-md-flex">
                <button class="topbar-link" type="button" data-toggle="fullscreen">
                    <i class="ti ti-maximize topbar-link-icon"></i>
                    <i class="ti ti-minimize topbar-link-icon d-none"></i>
                </button>
            </div>

            <div id="monochrome-toggler" class="topbar-item d-none d-xl-flex">
                <button id="monochrome-mode" class="topbar-link" type="button" data-toggle="monochrome">
                    <i class="ti ti-palette topbar-link-icon"></i>
                </button>
            </div>

            <div class="topbar-item d-none d-sm-flex">
                <button class="topbar-link btn-theme-setting" data-bs-toggle="offcanvas" data-bs-target="#theme-settings-offcanvas" type="button">
                    <i class="ti ti-settings topbar-link-icon"></i>
                </button>
            </div>

            <div id="language-selector" class="topbar-item">
                <div class="dropdown">
                    <button class="topbar-link fw-bold" data-bs-toggle="dropdown" type="button" aria-haspopup="false" aria-expanded="false">
                        <img src="{{ asset('assets/images/flags/us.svg') }}" alt="user-image" class="rounded me-2" height="18" id="selected-language-image" />
                        <span id="selected-language-code">EN</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="javascript:void(0);" class="dropdown-item" data-translator-lang="en" title="English">
                            <img src="{{ asset('assets/images/flags/us.svg') }}" alt="English" class="me-1 rounded" height="18" data-translator-image="" />
                            <span class="align-middle">English</span>
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item" data-translator-lang="id" title="Indonesia">
                            <img src="{{ asset('assets/images/flags/id.svg') }}" alt="Indonesia" class="me-1 rounded" height="18" data-translator-image="" />
                            <span class="align-middle">Indonesia</span>
                        </a>
                    </div>
                </div>
            </div>

            <div id="simple-user-dropdown" class="topbar-item nav-user">
                <div class="dropdown">
                    <a class="topbar-link dropdown-toggle drop-arrow-none px-2" data-bs-toggle="dropdown" href="#!" aria-haspopup="false" aria-expanded="false">
                        <img src="{{ Auth::user()?->avatar_url ?? asset('assets/images/users/user-1.jpg') }}" width="32" height="32" class="rounded-circle me-lg-2 d-flex object-fit-cover" alt="user-image" />
                        <div class="d-lg-flex align-items-center gap-1 d-none">
                            <h5 class="my-0">{{ Auth::user()->name ?? 'Damian D.' }}</h5>
                            <i class="ti ti-chevron-down align-middle"></i>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- Header -->
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0" data-lang="welcome-back">Welcome back!</h6>
                        </div>

                        <!-- My Profile -->
                        <a href="{{ route('page', 'profile-page') }}" class="dropdown-item">
                            <i class="ti ti-user-circle me-1 fs-lg align-middle"></i>
                            <span class="align-middle" data-lang="profile">Profile</span>
                        </a>

                        <!-- Notifications -->
                        <a href="javascript:void(0);" class="dropdown-item">
                            <i class="ti ti-bell-ringing me-1 fs-lg align-middle"></i>
                            <span class="align-middle" data-lang="notifications">Notifications</span>
                        </a>

                        <!-- Wallet -->
                        <a href="javascript:void(0);" class="dropdown-item">
                            <i class="ti ti-credit-card me-1 fs-lg align-middle"></i>
                            <span class="align-middle">
                                <span data-lang="balance">Balance:</span>
                                <span class="fw-semibold">$985.25</span>
                            </span>
                        </a>

                        <!-- Settings -->
                        <a href="javascript:void(0);" class="dropdown-item">
                            <i class="ti ti-settings-2 me-1 fs-lg align-middle"></i>
                            <span class="align-middle" data-lang="account-settings">Account Settings</span>
                        </a>

                        <!-- Support -->
                        <a href="javascript:void(0);" class="dropdown-item">
                            <i class="ti ti-headset me-1 fs-lg align-middle"></i>
                            <span class="align-middle" data-lang="support">Support Center</span>
                        </a>

                        <!-- Divider -->
                        <div class="dropdown-divider"></div>

                        <!-- Lock -->
                        <a href="{{ route('page', 'auth-lock-screen') }}" class="dropdown-item">
                            <i class="ti ti-lock me-1 fs-lg align-middle"></i>
                            <span class="align-middle" data-lang="lock-screen">Lock Screen</span>
                        </a>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}" id="topbar-logout-form" class="d-none">
                            @csrf
                        </form>
                        <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('topbar-logout-form').submit();" class="dropdown-item text-danger fw-semibold">
                            <i class="ti ti-logout me-1 fs-lg align-middle"></i>
                            <span class="align-middle" data-lang="log-out">Log Out</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
