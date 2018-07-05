<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'vendor/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

class Users extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

   function __construct()
   {
       parent::__construct();
       $this->load->library(array( 'form_validation'));
      $this->load->helper(array('url', 'language','form'));
   }

	public function index()
	{
		$this->getDevices();
	}


function createGeotrigger(){
  $client = new GuzzleHttp\Client();
  $res = $client->request('POST', "https://manager.gimbal.com/api/communications/1135083/geofence_trigger", [
  'headers' => ['Accept' => 'application/json','Content-type' => 'application/json','Authorization' =>'Token 42ebff8e667d065703b568df48a7392f'],
  'json' => ['event_type' => 'left','locations' => ['46E4A69C288C4EEAA254A1848AD9D959']]
   ]);
   $contents =(string) $res->getBody();
   $contents=json_decode($contents);
   print_r($contents);

}

  // NOTE: Only fetches the first 300 devices.
  //       Will need to add looping with offset to get all devices.
function getPlace($id){
  $client = new GuzzleHttp\Client();
  $res = $client->request('GET', "https://manager.gimbal.com/api/v2/places/$id", [
  'headers' => ['Accept' => 'application/json','Content-type' => 'application/json','Authorization' =>'Token 42ebff8e667d065703b568df48a7392f']
   ]);

   $contents =(string) $res->getBody();
   $contents=json_decode($contents);
   print_r($contents);
}
function getPlaces(){

  $client = new GuzzleHttp\Client();
  $res = $client->request('GET', "https://manager.gimbal.com/api/v2/places", [
  'headers' => ['Accept' => 'application/json','Content-type' => 'application/json','Authorization' =>'Token 42ebff8e667d065703b568df48a7392f']
   ]);

   $contents =(string) $res->getBody();
   $contents=json_decode($contents);
   print_r($contents[0]-> id);
}

function publishComm($comm_id){
  $client = new GuzzleHttp\Client();
  $res = $client->request('POST', "https://manager.gimbal.com/api/communications/".$comm_id."/publish", [
  'headers' => ['Accept' => 'application/json','Content-type' => 'application/json','Authorization' =>'Token 42ebff8e667d065703b568df48a7392f']
   ]);
}

  function createComm(){
$client = new GuzzleHttp\Client();
$res = $client->request('POST', "https://manager.gimbal.com/api/communications", [
'headers' => ['Accept' => 'application/json','Content-type' => 'application/json','Authorization' =>'Token 42ebff8e667d065703b568df48a7392f'],
'json' => ['name' => 'Leave Anspire','start_date' => '2018-06-09',   'end_date' => '2020-06-09']
 ]);

$contents =(string) $res->getBody();
$contents=json_decode($contents);
print_r($contents->  id);

/*
    $post = [
        'start_date' => '2018-06-09',
        'end_date' => '2020-06-09',
        'name'   => 'Leave Anspire',
    ];


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://manager.gimbal.com/api/communications");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_HEADER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Token 42ebff8e667d065703b568df48a7392f'));
    $response = curl_exec($ch);
    echo curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    $return = json_decode( $response);
    print_r( $return);*/
  }


  function getGeofenceTrigger(){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://manager.gimbal.com/api/communications/1/geofence_trigger");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
                                               'Authorization: Token token=42ebff8e667d065703b568df48a7392f'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $response = curl_exec($ch);
    curl_close($ch);
    $return = json_decode( $response);
    print_r( $return);
  }

  function getComms(){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://manager.gimbal.com/api/communications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
                                               'Authorization: Token token=42ebff8e667d065703b568df48a7392f'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $response = curl_exec($ch);
    curl_close($ch);
    $return = json_decode( $response);
    print_r( $return);
  }

  function getDevices(){
    $app_id = APPID;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/players?app_id=" . $app_id);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
                                               'Authorization: Basic '.APKEY));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $response = curl_exec($ch);
    curl_close($ch);
    $return = json_decode( $response);
    $this->data['players']=$return->players;
    //print("\n\nJSON received:\n");
  //  print_r(($return));
    //print_r(($return->players));      //get a tag of a device in a certain row
    //print_r(($return->players[0])->tags);      get a tag of a device in a certain row
    //print("\n");
    $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
    $this->load->view("devices/index",$this->data);
  }


  function getMessages(){
    $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://onesignal.com/api/v1/notifications?app_id=334c02d1-c267-41e2-ab22-7ae2658ed06f&limit=100&offset=0",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "authorization: Basic ". APKEY,
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  echo $response;
  }
}
