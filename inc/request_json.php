<?php
/*
 ******************************************************************************
 *
 * Copyright (C) 2013 T Dispatch Ltd
 *
 * Licensed under the GPL License, Version 3.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.gnu.org/licenses/gpl-3.0.html
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 ******************************************************************************
*/

require_once 'inc/tdispatch/tdispatch.php';
$td = new TDispatch();

$type = (isset($_POST['TYPE']) ? $_POST['TYPE'] : '');
switch ($type) {
    case 'cancelBooking':
        if ($td->Account_checkLogin()) {
            $bookingPk = (isset($_POST['bookingPk']) ? $_POST['bookingPk'] : '');
            $bookingNotes = (isset($_POST['notes']) ? $_POST['notes'] : '');
            //$bookingPk = '51c0e268c8bf070517a11874';
            $out = $td->Bookings_cancel($bookingPk,$bookingNotes);
            if ($out) {
                header('Content-type: application/json');
                echo json_encode($out);
                exit;
            }
        }
        break;

    case 'resetPassword':
        $email = (isset($_POST['email']) ? $_POST['email'] : '');
        if ($email != '') {
            $out = $td->Account_resetPassword($email);
            if ($out) {
                header('Content-type: application/json');
                echo json_encode($out);
                exit;
            }
        }
        break;

    case 'getLocation':
        $location = (isset($_POST['location']) ? $_POST['location'] : '');
        $limit = (int) (isset($_POST['limit']) ? $_POST['limit'] : 10);
        $pickup = ((isset($_POST['pickup']) && $_POST['pickup'] === 'pickup') ? $_POST['pickup'] : null);
        $out = $td->Location_search($location, $limit, $pickup);
        if ($out) {
            header('Content-type: application/json');
            echo json_encode($out);
            exit;
        }
        break;

    case 'getTrack':
        if ($td->Account_checkLogin()) {
            $bookingPk = (isset($_POST['bookingPk']) ? $_POST['bookingPk'] : '');
            //$bookingPk = '51c0e268c8bf070517a11874';
            $out = $td->Bookings_tracking($bookingPk);
            if ($out) {
                header('Content-type: application/json');
                echo json_encode($out);
                exit;
            }
        }
        break;

    case 'getBooking':
        if ($td->Account_checkLogin()) {
            $bookingPk = (isset($_POST['bookingPk']) ? $_POST['bookingPk'] : '');
            //$bookingPk = '51c0e268c8bf070517a11874';
            $out = $td->Bookings_get($bookingPk);
            if ($out) {
                header('Content-type: application/json');
                echo json_encode($out);
                exit;
            }
        }
        break;

    case 'getquotes':
        $pickupLocation = json_decode(stripslashes($_POST["locationobj"]), true);
        $dropoffLocation = json_decode(stripslashes($_POST["destinationobj"]), true);
		$vehicle_type = $_POST["vehicle_type"];
		
		//generate pickup time
		$pickup_date = $_POST["date"];
        try {
            list($day, $month, $year) = explode("/", $pickup_date);
            $hours = join("", $_POST["hours"]);
            $minutes = join("", $_POST["minutes"]);
            $pickup_time = date("c", mktime(intval($hours), intval($minutes), 0, intval($month), intval($day), intval($year)));
        } catch (Exception $e) {
            $pickup_time = null;
        } 

		$pickup_postcode = $pickupLocation["postcode"];
        $dropoff_postcode = $dropoffLocation["postcode"];
        $pickup_location = array("lat" => (float)$pickupLocation["location"]["lat"], "lng" => (float)$pickupLocation["location"]["lng"]);
        $dropoff_location = array("lat" => (float)$dropoffLocation["location"]["lat"], "lng" => (float)$dropoffLocation["location"]["lng"]);
        $fare_calculation = $td->FareCalculation_fare($pickup_postcode, $dropoff_postcode, $pickup_time, $pickup_location, $dropoff_location, $vehicle_type/* ,$waypoints */);

        if ($fare_calculation) {
            $response = $fare_calculation;

            $response['pickup_postcode'] = $pickupLocation["postcode"];
            $response['dropoff_postcode'] = $dropoffLocation["postcode"];
            $response['pickup_location']['lat'] = $pickupLocation["location"]["lat"];
            $response['pickup_location']['lng'] = $pickupLocation["location"]["lng"];
            $response['dropoff_location']['lat'] = $dropoffLocation["location"]["lat"];
            $response['dropoff_location']['lng'] = $dropoffLocation["location"]["lng"];
        } else {
            $response = array("message" => array("text" => $e->getMessage()), "status_code" => 400);
        }
        header('Content-type: application/json');
        echo json_encode($response);
        exit();
        break;

    default:
        break;
}
