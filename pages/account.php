<?php
defined('INDEX_CALL') or die('You cannot access this page directly.');
$td = new TDispatch();
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
if (isset($_POST['update']) && $_POST['update'] === 'Update') {
    $userData = array();

    //Name
    if (isset($_POST['update_name']) && trim($_POST['update_name']) != '')
        $userData['first_name'] = (trim($_POST['update_name']));
    else
        $errors['update_name'] = 'Name: this field is required.';

    //Last name
    if (isset($_POST['update_lastname']) && trim($_POST['update_lastname']) != '')
        $userData['last_name'] = (trim($_POST['update_lastname']));
    else
        $errors['update_lastname'] = 'Surname: this field is required.';

    //phone
    if (isset($_POST['update_phone']) && trim($_POST['update_phone']) != '')
        $userData['phone'] = (trim($_POST['update_phone']));
    else
        $errors['update_phone'] = 'Phone: this field is required.';

    //email
    if (isset($_POST['update_email']) && trim($_POST['update_email']) != '')
        $userData['email'] = (trim($_POST['update_email'])); //TODO validate email
    else
        $errors['update_email'] = 'Email: this field is required.';

    //birth_date
    if (isset($_POST['update_dob']) && trim($_POST['update_dob']) != '') {
        list($d, $m, $y) = explode('/', $_POST['update_dob']);
        $userData['birth_date'] = ($y . '-' . $m . '-' . $d . "T00:00:00");
    }else
        $errors['update_dob'] = 'Date of Birth: this field is required.';


    $userData['receive_email_notifications'] = (isset($_POST['receive_email']) && $_POST['receive_email'] == 'on') ? true : false;
    $userData['receive_sms_notifications'] = (isset($_POST['receive_sms']) && $_POST['receive_sms'] == 'on') ? true : false;
    $userData['use_account_location_as_pickup'] = (isset($_POST['account_pickup']) && $_POST['account_pickup'] == 'on') ? true : false;

    //location
    $userData['location'] = (object)array();
    if (isset($_POST['update_address_obj']) && trim($_POST['update_address_obj']) != 'Address' && trim($_POST['update_address_obj']) != '') {
        $location = json_decode(stripslashes($_POST["update_address_obj"]), true);
        if ($location) {
            $userData['location'] = $location;
        } else {
            $errors['update_address'] = 'Address: invalid address.';
        }
    }


    if (!count($errors)) {
        $output = $td->Account_setPreferences($userData);
        if (!$output)
            $statusmsg = $td->getErrorMessage();
        else
            $_SESSION['updated-data'] = 'SUCCESS!';
    }
}
?>
<!--[if lt IE 9]>
<style>
input[type=checkbox].account_checkbox {display:block;}
input[type=checkbox].account_checkbox + label.account_label {padding-left:0px;}
label.account_label {padding-top:3px;}
input[type=checkbox].account_checkbox:checked + label.account_label {}
.account_label{ background-image:none; }
</style>
<![endif]-->
<div id="maincol" >
    <!--ACCOUNT FORM CONTAINER-->
    <!--Update fields-->
    <?php
//Get user data from session
    $userInfo = $td->Account_getPreferences();

    if (!$userInfo)
        $statusmsg = $td->getErrorMessage();
    $errormsg = '';
    if (isset($errors) && count($errors)) {
        foreach ($errors as $key => $value) {
            $errormsg .= "<p>$value</p>";
        }
    }
    ?>

    <?php if (isset($_SESSION['updated-data']) && $_SESSION['updated-data'] == 'SUCCESS!'): ?>
    <div id="updated_data_message" class="account_fields_cont box-container">
        <h1>Account information updated</h1>
    </div>
    <?php unset($_SESSION['updated-data']); endif ?>

    <div class="account_fields_cont box-container">
        <h1>Your Account Details <font><?php if (isset($statusmsg)) echo $statusmsg; ?>&nbsp;</font></h1>
        <div style="color:red;"><?php echo $errormsg; ?></div><br/>
        <form id="update_form" name="update_form" class="update_form" method="post" autocomplete="off" action="/account">
            <div class="wrapper">
                <div class="update_fieldblock">
                    <label>Name:</label>
                    <input type="text" name="update_name" class="update_field" id="update_name" value="<?php echo $userInfo["first_name"]; ?>" />
                </div>
                <div class="update_fieldblock">
                    <label>Surname:</label>
                    <input type="text" name="update_lastname" class="update_field secondary" id="update_lastname" value="<?php echo $userInfo["last_name"]; ?>" />
                </div>
            </div>
            <div class="wrapper">
                <div class="update_fieldblock">
                    <label>Phone:</label>
                    <input type="text" name="update_phone" class="update_field" id="update_phone" value="<?php echo $userInfo["phone"]; ?>" />
                </div>
                <div class="update_fieldblock">
                    <label>Email:</label>
                    <input type="text" name="update_email" class="update_field secondary" id="update_email" value="<?php echo $userInfo["email"]; ?>" />
                </div>
            </div>
            <div class="wrapper">
                <div class="update_fieldblock last">
                    <label>Date of Birth:</label>
                    <input type="text" name="update_dob" class="update_field" id="update_dob" value="<?php echo date('d/m/Y', strtotime($userInfo["birth_date"])); ?>" />
                </div>
                <div class="update_fieldblock last">
                    <label>Address:</label>
                    <input type="text" name="update_address" class="update_field secondary" id="update_address" value="<?php echo (($userInfo["location"] != NULL) ? $userInfo["location"]["address"] . " " . $userInfo["location"]["postcode"] : "") ?>" />
                    <input type="hidden" id="update_address_obj" name="update_address_obj" value='<?php echo (($userInfo["location"] != NULL) ? json_encode($userInfo["location"],JSON_HEX_APOS | JSON_HEX_QUOT) : "Address") ?>' />
                </div>
            </div>
            <!--Update fields-->

            <!--Update checkboxes-->
            <div class="update_checkbox_cont">
                <input id="box_1" type="checkbox" name="receive_sms" <?php echo (($userInfo["receive_sms_notifications"] == true) ? "CHECKED" : "") ?> class="account_checkbox" value="on" />
                <label for="box_1" class="account_label">Receive SMS Notifications </label>
            </div>
            <div class="update_checkbox_cont">
                <input id="box_2" type="checkbox" name="receive_email" <?php echo (($userInfo["receive_email_notifications"] == true) ? "CHECKED" : "") ?> class="account_checkbox" value="on" />
                <label for="box_2" class="account_label">Receive E-mail Notifications</label>
            </div>
            <div class="update_checkbox_cont last">
                <input id="box_3" type="checkbox" name="account_pickup" <?php echo (($userInfo["use_account_location_as_pickup"] == true) ? "CHECKED" : "") ?> class="account_checkbox" value="on" />
                <label for="box_3" class="account_label">Use account location as pickup</label>
            </div>
            <!--Update checkboxes-->
            <input class="blue-button" type="submit" name="update" value="Update"  id="update_submit" />
        </form>
    </div>

    <!--ACCOUNT FORM CONTAINER-->

    <!--MAP CONTAINER-->
    <div id="right_float_cont">
        <div id="right_ad" class="box-container">
            <h2>Tips</h2>
            <p></p>
        </div>
    </div>
    <!--MAP CONTAINER-->

    <div style="clear:both"></div>
    <script type="text/javascript">
        $(function() {
            //account code
            if($("#update_form").length){
                $.validator.addMethod("monthTest", function(value, element, param) {
                    return this.optional(element) || /^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[0-9]{4}$/.test( value );
                }, "* Invalid Date");

                //Update validation
                var validateUpdateAccount = $("#update_form").validate({
                    rules: {
                        update_name: {
                            required: true,
                            notEqual: "First Name"
                        },
                        update_lastname : {
                            required: true,
                            notEqual: "Last Name"
                        },
                        update_phone    : {
                            NumbersOnly:true,
                            minlength: 8,
                            maxlength: 15,
                            required: true,
                            notEqual: "Phone"
                        },
                        update_email    : {
                            required: true,
                            email: true
                        },
                        update_dob      : {
                            required: true
                        },
                        update_address  : {
                            //required: true,
                            notEqual: "Address"
                        }
                    },
                    messages: {
                        update_name      : "Please enter your first name",
                        update_lastname  : "Please enter your last name",
                        update_phone     :  {
                            required  :"Please enter your phone number"
                        },
                        update_email     : "Please enter a valid email address",
                        update_dob       : "",
                        update_address   : ""
                    }
                });


                $('#update_dob').datepicker({
                    changeMonth: true,
                    changeYear: true,
                    yearRange: '1930:n',
                    onSelect: function(){
                        $('#update_dob').removeClass('error');
                    },
                    dateFormat        : "dd/mm/yy",
                    constrainInput    : true
                });

                autocomplete_getLocation("#update_address",'#update_address_obj',10,false);

                $('#update_address').change(function(){
                    var address = $(this).val();
                    if(address === ''){
                        $('#update_address_obj').val('');
                        $('#update_address_obj').data("location",'');
                    }
                });

                // Remove the notification of updated data notification message
                setTimeout(function(){
                    $('#updated_data_message').fadeOut(1000, function(){
                        $("updated_data_message").hide();
                    });
                },3000);
            }
            // Handler for .ready() called.
        });
    </script>
</div>