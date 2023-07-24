<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <?php require_once './header_plugins.php' ?>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Sidebar -->
        <?php include('sidebar.php'); ?>

        <!-- Header -->
        <?php include('header.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Main content -->
            <section class="content py-3">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Dashboard</h3>
                                </div>
                                <div class="card-body">
                                    <h5>Welcome, <?php echo $_SESSION['name']; ?>!</h5>
                                    <p>You are logged in as <?php echo $_SESSION['type']; ?>.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>

        <!-- Main Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>
    </div>

    <?php require_once './footer_plugins.php'; ?>
</body>

</html>