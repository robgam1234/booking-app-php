<?php

//Check if user already logged in
if (!$td->Account_checkLogin()) {
    header('Location:' . $td->getHomeUrl());
    exit;
}

$errors = array();
$statusmsg = '';

/**
  Update info
 *
 *
 */
if (isset($_POST['change']) && $_POST['change'] != '') {
    $change = array();

    $preferences = $td->Account_getPreferences();
    $change['email'] = $preferences['email'];

    // Current Password
    if (isset($_POST['current_password']) && ($_POST['current_password']) != '')
        $change['current_password'] = $_POST['current_password'];
    else
        $errors['current_password'] = 'Current Password: this field is required.';

    //New Password
    if (isset($_POST['new_password']) && ($_POST['new_password']) != '')
        $change['new_password'] = $_POST['new_password'];
    else
        $errors['new_password'] = 'New Password: this field is required.';

    //Confirm password
    if (isset($_POST['new_password_confirm']) && $_POST['new_password_confirm'] != '')
        $change['new_password_confirm'] = $_POST['new_password_confirm'];
    else
        $errors['new_password_confirm'] = 'Confirm Password: this field is required.';

    //If no erros, lets confirm that the password are equal
    if (!count($errors)) {
        if ($change['new_password'] != $change['new_password_confirm'])
            $errors['notequal'] = 'The passwords are not a match';
    }

    if (!count($errors)) {
        unset($change['new_password_confirm']);

        $output = $td->Account_changePassword($change);
        if (!$output)
            $statusmsg = $td->getErrorMessage();
        else {
            $_SESSION['change-pass'] = 'SUCCESS!';
        }
    }
}
?>
<div id="maincol" >
    <?php
    $errormsg = '';
    if (isset($errors) && count($errors)) {
        foreach ($errors as $key => $value) {
            $errormsg .= "<p>$value</p>";
        }
    }
    ?>
    <style>
        #errorMSGpass_reset{
            display: none !important;
            visibility: hidden !important;
        }

    </style>
    <?php if (isset($_SESSION['change-pass']) && $_SESSION['change-pass'] == 'SUCCESS!'): ?>
        <div class="account_fields_cont box-container">
            <h1>Change Password</h1>
            <div>Password changed !</div>
        </div>
        <?php
        unset($_SESSION['change-pass']);

    else:
        ?>
        <div class="account_fields_cont box-container">
            <h1>Change Password  <font style="color:red"><?php if (isset($statusmsg)) echo $statusmsg; ?>&nbsp;</font></h1>
            <div style="color:red;"><?php echo $errormsg; ?></div><br/>
            <form id="changepassword_form" name="changepassword_form" class="update_form" method="post" autocomplete="off" action="/change-password">
                <div class="wrapper">
                    <div class="update_fieldblock">
                        <label>Current Password:</label>
                        <input  type="password" name="current_password" class="update_field" id="current_password" value="" />
                        <br/><label id="errorMSGpass_reset" for="current_password" class="error" >Password must be at least 6 characters including 1 letter and 1 Alphanumeric Character.</label>
                    </div>
                </div>
                <div class="wrapper">
                    <div class="update_fieldblock">
                        <label>New Password:</label>
                        <input  type="password" name="new_password" class="update_field" id="new_password" value="" />
                        <div class="password-meter">
                            <div class="password-meter-bg">
                                <div class="password-meter-bar"></div>
                            </div>
                        </div>
                        <br/><label id="errorMSGpass_reset" for="new_password" class="error" >Password must be at least 6 characters including 1 letter and 1 Alphanumeric Character.</label>

                    </div>
                </div>
                <div class="wrapper">
                    <div class="update_fieldblock">
                        <label>Confirm Password:</label>
                        <input type="password" name="new_password_confirm" class="update_field secondary" id="new_password_confirm" value="" />
                        <div class="password-meter">
                            <div class="password-meter-bg">
                                <div class="password-meter-bar"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Update checkboxes-->
                <input type="hidden" name="token" value="<?php echo $token; ?>" />
                <input class="blue-button" type="submit" name="change" value="Update"  id="updatepassword_submit" />
            </form>
        </div>

        <!--ACCOUNT FORM CONTAINER-->

        <!--MAP CONTAINER-->
        <div id="right_float_cont">
            <div id="right_ad" class="box-container">
                <h2>Tips</h2>
                <p>Password must be at least 6 characters including 1 letter and 1 Alphanumeric Character.</p>
            </div>
        </div>
    <?php endif; ?>
    <!--MAP CONTAINER-->

    <div style="clear:both"></div>
    <script type="text/javascript">
        $(function() {
            //Register validation
            var changepassword_form = $("#changepassword_form").validate({
                rules: {
                    current_password     : {
                        password: true,
                        required: true,
                    },
                    new_password     : {
                        password:true,
                        required: true,
                        minlength: 6,
                    },
                    new_password_confirm : {
                        password: true
                        required: true,
                        minlength: 6,
                        equalTo: "#new_password"
                    }
                },
                messages: {
                    new_password :"Password must be at least 6 characters including 1 letter and 1 Alphanumeric Character.",
                    new_password_confirm: {
                        required  : "Please provide a password",
                        minlength : "Password must be at least 5 characters long",
                        equalTo   : "Passwords do not match"
                    }
                }
            });

            $('#new_password').click(function(){
                changepassword_form.element( "#new_password" )
            });

            // Handler for .ready() called.
        });
    </script>
</div>