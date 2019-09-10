<?php
include __DIR__ . '/../bootstrap.php';

if(\Application\Authentication::isNotLoggedIn()) {
    header('location:index.php');
} else {
    $editid = null;
    if(isset($_GET['edit'])) {
        $editid = $_GET['edit'];
    }

    $usersGateway = new \Application\UsersGateway($dbh);
    $request = new \Application\Request();
    $filesystem = new \Application\Filesystem(IMAGES_DIR);
    $usersTransactions = new \Application\Users\UsersTransactions($usersGateway, $request, $filesystem);

    if(isset($_POST['submit'])) {
        $usersTransactions->submitEdit();
        $msg = "Information Updated Successfully";
    }

    // Render a template
    echo $templates->render('edit-user', [
        'result' => $usersTransactions->findByUserId($_GET['edit']),
        'editid' => $editid,
        'cnt' => 1
    ]);
}