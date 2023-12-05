<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style/current-user.css">
    <link rel="stylesheet" href="style/profile-developer.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.2/css/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>User Dashboard</title>
</head>
<body>
<?php
    require_once "./php-function/function.php";
?>
<!--Current User-->
<div class="container current-user mt-5">
    <div class="card">
        <div class="row g-0">
            <div class="col-md-4 current-user-gambar">
                <img src="../img/developer/<?php echo $user['img']; ?>" class="img-thumbnail img-current-user" alt="User Image">
            </div>
            <div class="col-md-8 current-user-card-body">
                <div class="card-body">
                    <form id="user-form">
                        <div class="mb-3 current-user-card-form">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" value="<?= $user['username'] ?>" disabled>
                        </div>
                        <div class="mb-3 current-user-card-form">
                            <label for="last-registered" class="form-label">Last Registered</label>
                            <input type="text" class="form-control" id="last-registered" value="<?= $user['last_registered'] ?>" disabled>
                        </div>
                        <div class="mb-3 current-user-card-form">
                            <label for="last-activity" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" value="<?= $user['location'] ?>" disabled>
                        </div>
                        <h3 class="text-center reset-password">Change Password</h3>
                        <div class="row current-user-card-form-row-new-password">
                            <div class="col current-user-card-col-new-password">
                                <label for="newPassword" class="form-label current-user-form-label-new-password">New Password</label>
                                <input type="password" class="form-control current-user-form-control-new-password" id="newPassword" name="newPassword" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                            </div>
                            <div class="col current-user-card-col-confirm-password">
                                <label for="confirmNewPassword" class="form-label current-user-card-form-label-confirm-password">Confirm New Password</label>
                                <input type="password" class="form-control current-user-card-form-control-confirm-password" id="confirmNewPassword" name="confirmNewPassword">
                            </div>
                        </div>
                        <div class="mb-3 current-user-card-col-image-user">
                            <label for="formFile" class="form-label current-user-card-form-label-image-user">Upload Image</label>
                            <input class="form-control current-user-card-control-image-user" type="file" id="formFile" name="image">
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-success update-akun" type="button" id="updateProfile" data-bs-toggle="modal" data-bs-target="#updateProfileModal">
                                Update Profile
                            </button>
                            <button class="btn btn-primary back-awal" type="button" data-bs-toggle="modal" data-bs-target="#homePageModal">
                                Home page
                            </button>
                            <button class="btn btn-danger back-awal" type="button" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                                Delete Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End Current User-->


<!--Popup modal update profile-->
<div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content update-profile-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="updateProfileModalLabel">Update data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to proceed with the update?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success">Save Changes</button>
            </div>
        </div>
    </div>
</div>
<!--End Popup modal update profile-->

<!--Modal untuk delete-account-->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content delete-account-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAccountModalLabel">Delete Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete your account?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>
<!--end Modal delete account-->


<!--Modal untuk home-page-->
<div class="modal fade" id="homePageModal" tabindex="-1" aria-labelledby="homePageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content home-page-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="homePageModalLabel">Cancel update or delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to go back to the home page (index) ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="../index.php" class="btn btn-primary">Back to home</a>
            </div>
        </div>
    </div>
</div>
<!--end modal home-page-->

<!--Start Profile Developer-->
<div class="container profile-developer mt-5 text-center">
    <h4 class="header-developer">Profile Developer - Admin</h4>
    <div class="row justify-content-center">
        <div class="col-md-3 col-sm-12 social-developer1 social-developer1">
            <img src="../img/developer/<?php echo $admins[2]['img']; ?>" class="img-thumbnail img-developer3 rounded-circle" alt="User Image">
            <p><?php echo $admins[2]['username']; ?></p>
            <div class="d-flex justify-content-center">
                <a href="#" class="bi bi-github"></a>
                <a href="#" class="bi bi-instagram"></a>
                <a href="#" class="bi bi-linkedin"></a>
                <a href="#" class="bi bi-youtube"></a>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 social-developer2">
            <img src="../img/developer/<?php echo $admins[1]['img']; ?>" class="img-thumbnail img-developer3 rounded-circle" alt="User Image">
            <p><?php echo $admins[1]['username']; ?></p>
            <div class="d-flex justify-content-center">
                <a href="#" class="bi bi-github"></a>
                <a href="#" class="bi bi-instagram"></a>
                <a href="#" class="bi bi-linkedin"></a>
                <a href="#" class="bi bi-youtube"></a>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 social-developer3">
            <img src="../img/developer/<?php echo $admins[0]['img']; ?>" class="img-thumbnail img-developer3 rounded-circle" alt="User Image">
            <p><?php echo $admins[0]['username']; ?></p>
            <div class="d-flex justify-content-center">
                <a href="#" class="bi bi-github"></a>
                <a href="#" class="bi bi-instagram"></a>
                <a href="#" class="bi bi-linkedin"></a>
                <a href="#" class="bi bi-youtube"></a>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 social-developer4">
            <img src="../img/developer/<?php echo $admins[3]['img']; ?>" class="img-thumbnail img-developer3 rounded-circle" alt="User Image">
            <p><?php echo $admins[3]['username']; ?></p>
            <div class="d-flex justify-content-center">
                <a href="#" class="bi bi-github"></a>
                <a href="#" class="bi bi-instagram"></a>
                <a href="#" class="bi bi-linkedin"></a>
                <a href="#" class="bi bi-youtube"></a>
            </div>
        </div>
        <!-- Repeat the above div for the other 3 images -->
    </div>
</div>
<!--End Profile Developer-->

<script src="javascript/profile-developer.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>