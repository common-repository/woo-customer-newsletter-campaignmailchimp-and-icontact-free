<?php
function wps_wcnc_subscribe($email,$firstname,$icontact_apiusername,$icontact_apipassword,$icontact_appid) {
	$data = wps_wcnc_icontact_makecall($icontact_appid, $icontact_apiusername, $icontact_apipassword, '/a/', null, 'accounts');
	if (!empty($data['errors'])) return;
	$account = $data['response'][0];
	if (empty($account) || intval($account->enabled != 1)) return;

	$data = wps_wcnc_icontact_makecall($icontact_appid, $icontact_apiusername, $icontact_apipassword, '/a/'.$account->accountId.'/c/', null, 'clientfolders');
	if (!empty($data['errors'])) return;
	$client = $data['response'][0];
	if (empty($client)) return;

	$contact['email'] = $email;
	$contact['firstName'] = $firstname;
	$contact['status'] = 'normal';

	$data = wps_wcnc_icontact_makecall($icontact_appid, $icontact_apiusername, $icontact_apipassword, '/a/'.$account->accountId.'/c/'.$client->clientFolderId.'/contacts', array($contact), 'contacts');
	if (!empty($data['errors'])) return;
	$contact = $data['response'][0];
	if (empty($contact)) return;

	$subscriber['contactId'] = $contact->contactId;

	$lists = wps_wcnc_icontact_getlists($icontact_appid, $icontact_apiusername, $icontact_apipassword);
	foreach ($lists as $key => $value) {
		$subscriber['listId'] = $key;
	}
	$subscriber['status'] = 'normal';
	$data = wps_wcnc_icontact_makecall($icontact_appid, $icontact_apiusername, $icontact_apipassword, '/a/'.$account->accountId.'/c/'.$client->clientFolderId.'/subscriptions', array($subscriber), 'subscriptions');
	if(!empty($data['response'])){
		return true;
	}
	else{
		return false;
	}
}

function wps_wcnc_icontact_getlists($appid, $apiusername, $apipassword) {

		$data = wps_wcnc_icontact_makecall($appid, $apiusername, $apipassword, '/a/', null, 'accounts');
		if (!empty($data['errors'])) return array();
		$account = $data['response'][0];
		if (empty($account) || intval($account->enabled != 1)) return;
		$data = wps_wcnc_icontact_makecall($appid, $apiusername, $apipassword, '/a/'.$account->accountId.'/c/', null, 'clientfolders');
		if (!empty($data['errors'])) return array();
		$client = $data['response'][0];
		if (empty($client)) return array();
		$data = wps_wcnc_icontact_makecall($appid, $apiusername, $apipassword, '/a/'.$account->accountId.'/c/'.$client->clientFolderId.'/lists', array(), 'lists');
		if (!empty($data['errors'])) return array();
		if (!is_array($data['response'])) return array();
		$lists = array();
		foreach ($data['response'] as $list) {
			$lists[$list->listId] = $list->name;
		}
		return $lists;
}

function wps_wcnc_icontact_makecall($appid, $apiusername, $apipassword, $resource, $postdata = null, $returnkey = null) {
		$return = array();
		$url = "https://app.icontact.com/icp".$resource;
		$headers = array(
			'Except:', 
			'Accept:  application/json', 
			'Content-type:  application/json', 
			'Api-Version:  2.2',
			'Api-AppId:  '.$appid, 
			'Api-Username:  '.$apiusername, 
			'Api-Password:  '.$apipassword
		);
		$handle = curl_init();
		curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
		if (!empty($postdata)) {
			curl_setopt($handle, CURLOPT_POST, true);
			curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($postdata));
		}
		curl_setopt($handle, CURLOPT_URL, $url);
		if (!$response_json = curl_exec($handle)) {
			$return['errors'][] = __('Unable to execute the cURL handle.', 'ulp');
		}
		if (!$response = json_decode($response_json)) {
			$return['errors'][] = __('The iContact API did not return valid JSON.', 'ulp');
		}
		curl_close($handle);
		if (!empty($response->errors)) {
			foreach ($response->errors as $error) {
				$return['errors'][] = $error;
			}
		}
		if (!empty($return['errors'])) return $return;
		if (empty($returnkey)) {
			$return['response'] = $response;
		} else {
			$return['response'] = $response->$returnkey;
		}
		return $return;
}


?>