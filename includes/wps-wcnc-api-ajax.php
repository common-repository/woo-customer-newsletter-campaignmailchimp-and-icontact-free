<?php
Class WPS_WCNC_Api_Ajax{
	public function __construct()
	{
		add_action( 'wp_ajax_wps_wcnc_get_mc_list', array($this,'wps_wcnc_get_mc_list' ));
		add_action( 'wp_ajax_wps_wcnc_get_ic_list', array($this,'wps_wcnc_get_ic_list' ));
	}
	public static function wps_wcnc_get_mc_list(){
		$wps_wcnc_mailchimp_list_id  = (get_option('wps_wcnc_mailchimp_list_id')) ? get_option('wps_wcnc_mailchimp_list_id') : '';

		$api_key = $_POST['api_key'];
		$data = array(
			'fields' => 'lists',
		);
		$url = 'https://' . substr($api_key,strpos($api_key,'-')+1) . '.api.mailchimp.com/3.0/lists/';
		$result = json_decode( WPS_WCNC_Api_Ajax::mailchimp_curl_connect( $url, 'GET', $api_key, $data) );
		if( !empty($result->lists) ) {
			?>
			<select name="wps_wcnc_mailchimp_list_id" id="wps_wcnc_mailchimp_list_id">
			<?php
				foreach( $result->lists as $list ){
					//echo '<option value="' . $list->id . '">' . $list->name . ' (' . $list->stats->member_count . ')</option>';
					?>
						<option value="<?php echo $list->id; ?>"<?php if($list->id==$wps_wcnc_mailchimp_list_id){echo 'selected';}?>><?php echo $list->name; ?> ( <?php echo $list->member_count; ?> )</option>
					<?php
				}
			?>
			</select>
			<?php
		} elseif ( is_int( $result->status ) ) {
			echo '<strong>' . $result->title . ':</strong> ' . $result->detail;
		}
		exit;
	}
	public static function mailchimp_curl_connect( $url, $request_type, $api_key, $data = array() ) {
		if( $request_type == 'GET' )
			$url .= '?' . http_build_query($data);

		$mch = curl_init();
		$headers = array(
			'Content-Type: application/json',
			'Authorization: Basic '.base64_encode( 'user:'. $api_key )
		);
		curl_setopt($mch, CURLOPT_URL, $url );
		curl_setopt($mch, CURLOPT_HTTPHEADER, $headers);
		//curl_setopt($mch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
		curl_setopt($mch, CURLOPT_RETURNTRANSFER, true); // do not echo the result, write it into variable
		curl_setopt($mch, CURLOPT_CUSTOMREQUEST, $request_type); // according to MailChimp API: POST/GET/PATCH/PUT/DELETE
		curl_setopt($mch, CURLOPT_TIMEOUT, 10);
		curl_setopt($mch, CURLOPT_SSL_VERIFYPEER, false); // certificate verification for TLS/SSL connection

		if( $request_type != 'GET' ) {
			curl_setopt($mch, CURLOPT_POST, true);
			curl_setopt($mch, CURLOPT_POSTFIELDS, json_encode($data) ); // send data in json
		}

		return curl_exec($mch);
	}

	public function wps_wcnc_get_ic_list(){
		require_once 'library/icontact.php';
		$result = array();
		$appid = $_POST['api_key'];
		$apiusername = $_POST['user_name'];
		$apipassword = $_POST['app_pass'];
		$wps_wcnc_iconatct_list_id 	= (get_option('wps_wcnc_iconatct_list_id')) ? get_option('wps_wcnc_iconatct_list_id') : '';
		$result = wps_wcnc_icontact_getlists($appid, $apiusername, $apipassword);
		if($result){
			echo "<select name='wps_wcnc_iconatct_list_id' id='wps_wcnc_iconatct_list_id'>";
			foreach($result as $key=>$value){
				if($wps_wcnc_iconatct_list_id == $key){
					echo "<option value='".$key."' selected>".$value."</option>";
				}
				else{
					echo "<option value='".$key."'>".$value."</option>";
				}
			}
			echo "</select>";
		}
		else{
			echo 'No List Found, Please Check Your Data';
		}
		exit;
	}

	
}new WPS_WCNC_Api_Ajax();

?>