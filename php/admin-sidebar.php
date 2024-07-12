<nav class="sidebar close">
    <header>
        <div class="image-text">
            <span class="image">
                <i class='bx bx-baguette doughpro-icon'></i>
            </span>

            <div class="text logo-text">
                <span class="name">DoughPro</span>
                <span class="profession">Admin - <span class="user-name"> <?php echo htmlspecialchars($user_name); ?> </span> </span>
            </div>
        </div>

        <i class='bx bx-chevron-right toggle'></i>
    </header>

    <div class="menu-bar">
        <div class="menu">

            <ul class="menu-links">

                <li class="nav-link" title="Dashboard">
                    <a href="admin-dashboard.php">
                        <i class='bx bxs-dashboard icon'></i>
                        <span class="text nav-text">Dashboard</span>
                    </a>
                </li>

                <li class="nav-link" title="Inventory">
                    <a href="admin-crud-inventory-page.php">
                        <i class='bx bxs-baguette icon'></i>
                        <span class="text nav-text">Inventory</span>
                    </a>
                </li>

                <li class="nav-link" title="Stock In">
                    <a href="admin-crud-stocks-page.php">
                        <i class='bx bxs-objects-vertical-bottom icon'></i>
                        <span class="text nav-text">Stock In</span>
                    </a>
                </li>

                <li class="nav-link" title="Stock Out">
                    <a href="admin-stocks-out-page.php">
                        <i class='bx bxs-objects-vertical-bottom icon'></i>
                        <span class="text nav-text">Stock Out</span>
                    </a>
                </li>

                <li class="nav-link" title="Categories">
                    <a href="admin-crud-categories-page.php">
                        <i class='bx bx-category-alt icon'></i>
                        <span class="text nav-text">Categories</span>
                    </a>
                </li>

                <li class="nav-link" title="To Order">
                    <a href="#">
                        <i class='bx bxs-shopping-bag icon'></i>
                        <span class="text nav-text">To Order</span>
                    </a>
                </li>

                <li class="nav-link" title="Recipes">
                    <a href="#">
                        <i class='bx bx-fork icon'></i>
                        <span class="text nav-text">Recipes</span>
                    </a>
                </li>

                <li class="nav-link" title="Logs">
                    <a href="#">
                        <i class='bx bx-pie-chart-alt icon'></i>
                        <span class="text nav-text">Logs</span>
                    </a>
                </li>

                <li class="nav-link" title="Users">
                    <a href="admin-crud-users-page.php">
                        <i class='bx bx-user icon'></i>
                        <span class="text nav-text">Users</span>
                    </a>
                </li>

                <li class="nav-link" title="Suppliers">
                    <a href="admin-crud-suppliers-page.php">
                        <i class='bx bx-group icon'></i>
                        <span class="text nav-text">Suppliers</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="bottom-content" title="Logout">
            <li class="">
                <a href="logout.php">
                    <i class='bx bx-log-out icon'></i>
                    <span class="text nav-text">Logout</span>
                </a>
            </li>

            <!-- <li class="mode">
                <div class="sun-moon">
                    <i class='bx bx-moon icon moon'></i>
                    <i class='bx bx-sun icon sun'></i>
                </div>
                <span class="mode-text text">Dark mode</span>
                <div class="toggle-switch">
                    <span class="switch"></span>
                </div>
            </li> -->
        </div>
    </div>
</nav>