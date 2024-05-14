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
            <li class="search-box">
                <i class='bx bx-search icon'></i>
                <input type="text" placeholder="Search...">
            </li>

            <ul class="menu-links">

                <li class="nav-link">
                    <a href="admin-dashboard.php">
                        <i class='bx bx-home-alt icon'></i>
                        <span class="text nav-text">Dashboard</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="#">
                        <i class='bx bx-home-alt icon'></i>
                        <span class="text nav-text">Stocks</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="#">
                        <i class='bx bxs-shopping-bag icon'></i>
                        <span class="text nav-text">To Order</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="#">
                        <i class='bx bx-fork icon'></i>
                        <span class="text nav-text">Recipes</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="#">
                        <i class='bx bx-pie-chart-alt icon'></i>
                        <span class="text nav-text">Logs</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="admin-crud-users-page.php">
                        <i class='bx bx-user icon'></i>
                        <span class="text nav-text">Users</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="bottom-content">
            <li class="">
                <a href="logout.php">
                    <i class='bx bx-log-out icon'></i>
                    <span class="text nav-text">Logout</span>
                </a>
            </li>

            <li class="mode">
                <div class="sun-moon">
                    <i class='bx bx-moon icon moon'></i>
                    <i class='bx bx-sun icon sun'></i>
                </div>
                <span class="mode-text text">Dark mode</span>
                <div class="toggle-switch">
                    <span class="switch"></span>
                </div>
            </li>
        </div>
    </div>
</nav>