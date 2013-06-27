<?php

defined('INDEX_CALL') or die('You cannot access this page directly.');

$td = new TDispatch();
//Check if user already logged in
if (!$td->Account_checkLogin()) {
    header('Location:' . $td->getHomeUrl());
    exit;
}

if (isset($_REQUEST['pk']) && $_REQUEST['pk'] != '') {   
    $bk_resp = $td->Bookings_receipt($_REQUEST['pk']);
    if($bk_resp){
        header('Content-type: application/pdf');
        echo $bk_resp;
        exit;
    }
}
?>
<div id="maincol" >
    <div id="book_forms_cont">
        <!--Location/Destination container-->
        <div id="addresses_cont" class="box-container">
            <h2>Sorry</h2>
            <div class="location-block">
                An error occurred while generating a receipt. Please try again later...<br/>
                <a href="<?php echo $td->getHomeUrl()?>bookings">go back</a>
            </div>
        </div>
    </div>
    <!--MAP CONTAINER-->
    <div id="right_float_cont">
        <div id="right_ad" class="box-container">
            <h2></h2>
            <p></p>
        </div>
    </div>
    <!--MAP CONTAINER-->
    <div style="clear:both"></div>
</div>
