<?php
class WPS_WCNC_Settings
{
	
	public function display_settings_MailChimp(){
		$wps_wcnc_mailchimp_key 	  = (get_option('wps_wcnc_mailchimp_key')) ? get_option('wps_wcnc_mailchimp_key') : '';
	    $wps_wcnc_mailchimp_status 	  = (get_option('wps_wcnc_mailchimp_status')) ? get_option('wps_wcnc_mailchimp_status') : 'disable';
		?>
			<article class="ac-large wps-wcnc-settings">
				<span class="wps-label">Status</span>
				<select name="wps_wcnc_mailchimp_status">
					<option value="enable" <?php if($wps_wcnc_mailchimp_status=='enable'){echo 'selected';}?>>Enable</option>
					<option value="disable" <?php if($wps_wcnc_mailchimp_status=='disable'){echo 'selected';}?>>Disable</option>
				</select>
		    	<span class="wps-label">API Key</span>
		    	<input type="text" name="wps_wcnc_mailchimp_key" id="wps_wcnc_mailchimp_key" value="<?php echo $wps_wcnc_mailchimp_key; ?>"/>
		    	
		    	<span class="wps-label">Lists</span>
		    	<p class="wpcWcncloaderDiv">
		    		Please wait,List is loading <img src="<?php echo WPS_WOO_CUST_NEWS_CAMP_IMG; ?>/loading.gif" title="List is loading" />
		    	</p>
		    	<div id="wps_wcnc_mailchimp_list_id">Fill The Above Details, List Will Be Automatically Appeared</div>
			</article>
		<?php
	}

	public function display_settings_IContact(){
		$wps_wcnc_icontact_status 	= (get_option('wps_wcnc_icontact_status')) ? get_option('wps_wcnc_icontact_status') : '';
		$wps_wcnc_icontact_username = (get_option('wps_wcnc_icontact_username')) ? get_option('wps_wcnc_icontact_username') : '';
		$wps_wcnc_iconatct_pass 	= (get_option('wps_wcnc_iconatct_pass')) ? get_option('wps_wcnc_iconatct_pass') : '';
		$wps_wcnc_iconatct_api_key 	= (get_option('wps_wcnc_iconatct_api_key')) ? get_option('wps_wcnc_iconatct_api_key') : '';

		?>
			<article class="ac-extra-large wps-wcnc-settings">
				<p class="wps-wcnc-notice">*This Feature Is Available With Premium Version*</p>
				<span class="wps-label">Status</span>
				<select name="wps_wcnc_icontact_status">
					<option value="enable" <?php if($wps_wcnc_icontact_status=='enable'){echo 'selected';}?>>Enable</option>
					<option value="disable" <?php if($wps_wcnc_icontact_status=='disable'){echo 'selected';}?>>Disable</option>
				</select>
				<span class="wps-label">API Username(Your account's Username)</span>
				<input type="text" name="wps_wcnc_icontact_username" id="wps_wcnc_icontact_username" value="<?php echo $wps_wcnc_icontact_username; ?>"/>
				<span class="wps-label">API Password</span>
				<input type="text" name="wps_wcnc_iconatct_pass" id="wps_wcnc_iconatct_pass" value="<?php echo $wps_wcnc_iconatct_pass; ?>"/>
				<span class="wps-label">API Id</span>
				<input type="text" name="wps_wcnc_iconatct_api_key" id="wps_wcnc_iconatct_api_key" value="<?php echo $wps_wcnc_iconatct_api_key; ?>"/>
				<span class="wps-label">Lists</span>
		    	<p class="wpcWcncloaderDiv">
		    		Please wait,List is loading <img src="<?php echo WPS_WOO_CUST_NEWS_CAMP_IMG; ?>/loading.gif" title="List is loading" />
		    	</p>
		    	<div id="wps_wcnc_iconatct_list_id">Fill The Above Details, List Will Be Automatically Show Here.</div>
			</article>
		<?php
	}


}

?>