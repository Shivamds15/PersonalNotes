<nav class="navbar navbar-expand-lg bg-body-tertiary" style="padding:0!important; position:sticky; top:0;">
        <div class="container-fluid" style="padding: 0.5em 2em;background-color: #e5e5e5;">
            <a class="navbar-brand" href="home.php">PersonalNotes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <?php if (!isset($_SESSION['user_id'])): ?>
                <ul class="navbar-nav ms-auto" style="text-align: right;">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            User: <strong>Guest</strong>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" aria-current="page" href="login.php">Login</a>
                                <a class="dropdown-item" aria-current="page" href="register.php">Register</a>
                            </li>
                            
                        </ul>
                    </li>
                </ul>
            <?php endif; ?>
            <?php if (isset($_SESSION['user_id'])): ?>
                <ul class="navbar-nav ms-auto" style="text-align: right;">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            User: <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            <?php endif; ?>
         </div>
        </div>
    </nav>
    <style>
        .dropdown-item:hover {
           background-color: #dc3545;
            color: white;
        }
    </style>
               