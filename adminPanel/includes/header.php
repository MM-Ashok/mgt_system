<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Administrator</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />

    <!-- MetisMenu CSS -->
    <link href="assets/js/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="assets/css/sb-admin-2.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="assets/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    <script src="assets/js/jquery.min.js" type="text/javascript"></script>

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true): ?>
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="">Administrator</a>
                </div>

                <ul class="nav navbar-top-links navbar-right">
                        <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                            </li>
                            <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li>
                                <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                            </li>
                            <li <?php echo (CURRENT_PAGE == "bookRegistration.php" || CURRENT_PAGE == "searchFilter.php") ? 'class="active"' : ''; ?>>
                                <a href="#"><i class="fa fa-book fa-fw"></i>Catalog Management<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="bookRegistration.php"><i class="fa fa-book fa-fw"></i>Book Registration</a>
                                    </li>
                                    <li>
                                        <a href="searchFilter.php"><i class="fa fa-search fa-fw"></i>Search and Filtering</a>
                                    </li>
                                </ul>
                            </li>

                            <li <?php echo (CURRENT_PAGE == "bookRegistration.php" || CURRENT_PAGE == "searchFilter.php") ? 'class="active"' : ''; ?>>
                                <a href="#"><i class="fa fa-book fa-fw"></i>Book Borrowing System<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="#"><i class="fa fa-book fa-fw"></i>Check in/out</a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-search fa-fw"></i>Due Date</a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-search fa-fw"></i>Renewal</a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-search fa-fw"></i>Waiting List</a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-search fa-fw"></i>Available inventory</a>
                                    </li>
                                </ul>
                            </li>

                            <!-- <li <?php //echo (CURRENT_PAGE == "bookRegistration.php" || CURRENT_PAGE == "searchFilter.php") ? 'class="active"' : ''; 
                                        ?>>
                                    <a href="#"><i class="fa fa-book fa-fw"></i>Catalog Management<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="#"><i class="fa fa-book fa-fw"></i>Book Registration<span class="fa arrow"></span></a>
                                            <ul class="nav nav-third-level">
                                            <li>
                                                <a href="bookRegistration.php"><i class="fa fa-book fa-fw"></i>Add Book</a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="fa fa-book fa-fw"></i>Category</a>
                                                <ul class="nav nav-fourth-level">
                                                <li>
                                                <a href="#"><i class="fa fa-book fa-fw"></i>Add Category</a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="fa fa-book fa-fw"></i>Manage categories</a>
                                            </li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a href="#"><i class="fa fa-search fa-fw"></i>Author</a>
                                            </li>
                                            </ul>
                                        </li>
                                    <li>
                                        <a href="searchFilter.php"><i class="fa fa-search fa-fw"></i>Search and Filtering</a>
                                    </li>
                                    </ul>
                                </li> -->

                        </ul>
                    </div>
                </div>
            </nav>
        <?php endif; ?>