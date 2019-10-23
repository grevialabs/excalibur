<?php 

define('OFFSET','0');
define('PERPAGE','20');
define('DS','/');
define('BR','<br/>');
define('HR','</hr>');
define('ASC','asc');
define('DESC','desc');

/* 
------------------------------------------------- 
START ENCRYPT METHOD
*/
DEFINE('ENCRYPT_METHOD','AES-256-CBC');
DEFINE('ENCRYPT_HASH','sha256');
DEFINE('ENCRYPT_SECRET_KEY','my_simple_secret_key');
DEFINE('ENCRYPT_SECRET_IV','my_simple_secret_iv');
function my_simple_crypt( $string, $action = 'e' ) {
    // you may change these values to your own
 
    $output = false;
    $key = hash( ENCRYPT_HASH, ENCRYPT_SECRET_KEY );
    $iv = substr( hash( ENCRYPT_HASH, ENCRYPT_SECRET_IV ), 0, 16 );
 
    if( $action == 'e' ) {
        $output = base64_encode( openssl_encrypt( $string, ENCRYPT_METHOD, $key, 0, $iv ) );
    }
    else if( $action == 'd' ){
        $output = openssl_decrypt( base64_decode( $string ), ENCRYPT_METHOD, $key, 0, $iv );
    }
 
    return $output;
}

function simple_encrypt($string) {
    $output = false;
    $key = hash( ENCRYPT_HASH, ENCRYPT_SECRET_KEY );
    $iv = substr( hash( ENCRYPT_HASH, ENCRYPT_SECRET_IV ), 0, 16 );
    $output = base64_encode( openssl_encrypt( $string, ENCRYPT_METHOD, $key, 0, $iv ) );
 
    return $output;
}

function simple_decrypt($string) {
 
    $output = false;
    $key = hash( ENCRYPT_HASH, ENCRYPT_SECRET_KEY );
    $iv = substr( hash( ENCRYPT_HASH, ENCRYPT_SECRET_IV ), 0, 16 );
    $output = openssl_decrypt( base64_decode( $string ), ENCRYPT_METHOD, $key, 0, $iv );
    return $output;
}
/* 
END ENCRYPT METHOD
------------------------------------------------- 
*/

function get_datetime($date = NULL, $format_date='Y-m-d H:i:s')
{
	$return = date($format_date);
	if (isset($date)) $return = date($format_date,strtotime($date));
	return $return;
}

function convert_datetime($timestamp = NULL, $format_date='d M Y H:i')
{
	if (isset($timestamp)) {
		if($timestamp != '' || $timestamp != NULL){
			if(strpos($timestamp, '0000-00-00') !== false){
				$timestamp = '';
			} else{
				$timestamp = strtotime($timestamp);
			}
		} else{
			$timestamp = '';
		}
	}
	$datetime = $timestamp;
	if($timestamp == '' || empty($timestamp)){ $msg='-'; return $msg; }
	$datetime = date($format_date,$timestamp);
	return $datetime;
}

function format_money($money, $currency = "IDR", $separator = '.')
{
	return number_format($money,0,'',$separator).' '.$currency;
}

function debug($data,$die = 0)
{
	echo "<pre>";
	print_r($data);
	echo "</pre>";
	
	if ($die) die;
}

function curl_api_liquid($url, $method = 'get', $attr = NULL, $data = NULL)
{
	$httpheader = $param = array();
	// $httpheader[] = 'Token: macbook';
	
	// Get all API_KEY from config .env files
	if (env('API_KEY')) {
		$httpheader[] = 'Token: '.env('API_KEY');
	} else {
		if (isset($attr['token'])) $httpheader[] = 'Token: '.$attr['token'];
	}
	// $httpheader[] = 'Secretkey: grevia';
	
	
	// Activate debug
	if (isset($attr['debug'])) $param['debug'] = $attr['debug'];
	
	// if (isset($attr['method'])) $param['method'] = $attr['method'];
	
	
	$is_site_global = $is_role_admin = NULL;
	
	// Validate site_id user by default
	if (isset($data['is_site_global']) && $data['is_site_global'] != "") $is_site_global = $data['is_site_global'];
	
	$is_role_admin = FALSE;

	if (! $is_site_global && ! $is_role_admin) {
		// $data['site_id'] = get_user_cookie('site_id');
	}

	$param['httpheader'] = $httpheader;
	$param['useragent'] = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36';
	
	// debug($url);
	// debug($method);
	// debug($param);
	// debug($data);
	
	// auto add api url if no http contain
	$API_URL = env('API_URL');
	// debug('before ' . $url);
	// if (! strpos($API_URL,$url) !== FALSE) {
	if (strpos($url,$API_URL) !== FALSE) {
		
	} else {
		$url = $API_URL.$url;
	}
	$return = curl($url, $method, $param, $data);
	
	// if (isset($attr['debug'])) debug($return,1);
	
	return $return;
}

function curl_report_liquid($url, $method = 'get', $attr = NULL, $data = NULL)
{
	$httpheader = $param = array();
	// $httpheader[] = 'Token: macbook';
	
	// Get all API_KEY from config .env files
	if (env('API_KEY')) {
		$httpheader[] = 'Token: '.env('API_KEY');
	} else {
		if (isset($attr['token'])) $httpheader[] = 'Token: '.$attr['token'];
	}
	// $httpheader[] = 'Secretkey: grevia';
	
	
	// Activate debug
	if (isset($attr['debug'])) $param['debug'] = $attr['debug'];
	// if (isset($attr['method'])) $param['method'] = $attr['method'];

	$param['httpheader'] = $httpheader;
	$param['useragent'] = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36';
	
	// debug($url);
	// debug($method);
	// debug($param);
	// debug($data);
	
	// auto add api url if no http contain
	$REPORT_URL = env('REPORT_URL');
	// debug('before ' . $url);
	// if (! strpos($REPORT_URL,$url) !== FALSE) {
	if (strpos($url,$REPORT_URL) !== FALSE) {
		
	} else {
		$url = $REPORT_URL.$url;
	}
	$return = curl($url, $method, $param, $data);
	
	// if (isset($attr['debug'])) debug($return,1);
	
	return $return;
}

function curl_poseidon($url, $method = 'get', $attr = NULL, $data = NULL)
{
	$httpheader = $param = array();
	// $httpheader[] = 'Token: macbook';
	$httpheader[] = 'Content-Type: application/json';
	$httpheader[] = 'Content-Length: ' . strlen($data);
	
	
	// curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    // 'Content-Type: application/json',                                                                                
    // 'Content-Length: ' . strlen($data_string))                                                                       
	// );
	
	// Get all API_KEY from config .env files
	// if (env('API_KEY')) {
		// $httpheader[] = 'Token: '.env('API_KEY');
	// } else {
		// if (isset($attr['token'])) $httpheader[] = 'Token: '.$attr['token'];
	// }
	// $httpheader[] = 'Secretkey: grevia';
	
	
	// Activate debug
	if (isset($attr['debug'])) $param['debug'] = $attr['debug'];
	// if (isset($attr['method'])) $param['method'] = $attr['method'];

	$param['is_json'] = 1;
	$param['httpheader'] = $httpheader;
	$param['useragent'] = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36';
	
	// debug($url);
	// debug($method);
	// debug($param);
	// debug($data);
	
	// auto add api url if no http contain
	$POSEIDON_URL = env('POSEIDON_URL');
	// debug('before ' . $url);
	// if (! strpos($REPORT_URL,$url) !== FALSE) {
	if (strpos($url,$POSEIDON_URL) !== FALSE) {
		
	} else {
		$url = $POSEIDON_URL.$url;
	}
	$return = curl($url, $method, $param, $data);
	
	// if (isset($attr['debug'])) debug($return,1);
	
	return $return;
}

function common_paging($totalRow = "",$dataPerPage = 10, $param = null)
{
	$str = "";
	$offset = 0;
	$noPage = '';
	$activePage = '';
	
	// $param['is_show_question_mark'] = TRUE;
	// $param['is_show_total_row'] = FALSE;
	
	if (!isset($param['is_show_question_mark'])) $param['is_show_question_mark'] = TRUE;
	if (!isset($param['is_show_total_row'])) $param['is_show_total_row'] = FALSE;
	
	if(! isset($dataPerPage) || $dataPerPage<=0){
		$dataPerPage = 20;
	}
	if (isset($_GET["page"])) {
		$noPage = $activePage = $_GET["page"];
	}
	else

	$noPage = 1;
	
	$showPage = '0';
	$jumData = $totalRow;
	$jumPage = ceil($jumData/$dataPerPage);
	if(!is_numeric($activePage) || $activePage > $jumPage || $activePage<=0){
		$activePage = 1;
	}
	
	// AUTO REMOVE PARAMETER "PAGE"
	$currentUrlParameter = current_url();
	$i = 1;
	if (!empty($_GET))
	{
		if (isset($_GET['page'])) {
			unset($_GET['page']);
		}

		foreach($_GET as $key => $val)
		{
			if(is_array($val) == false){
				if ($key == 0 && strpos($currentUrlParameter,'?') === FALSE) $currentUrlParameter.= '?';
				$currentUrlParameter.= $key.'='.$val;
				if (count($_GET) != $i) $currentUrlParameter.= '&';
			}
			$i++;
		}
	}
	
	if($noPage>=1){
		$offset = ($noPage-1) * $dataPerPage;
	}
	
	if ($jumData <= $dataPerPage) $dataPerPage = $jumData;

	if ($noPage >= 1) {
		$i = ($noPage-1) * $dataPerPage + 1;
		$dataPerPage = $noPage * $dataPerPage;
		if ($dataPerPage > $jumData) $dataPerPage = $jumData;
	}
	
	if( $jumData!=0 ){
		if (strpos($currentUrlParameter,'?') !== FALSE)
		{
			$currentUrlParameter.= "&";
		}
		else 
		{
			$currentUrlParameter.= "?";
		}
		$str.= "<nav>
		<ul class='pagination'>";
		//if ($param['is_show_total_row'] == TRUE ) {
			$str.= "<li class=''><a>Show ". $i ." - ".$dataPerPage." of <strong>".$jumData."</strong> row(s)<span class='sr-only'>Total <strong>".$jumData."</strong> row(s)</span></a></li>";
		//}
		$str.= "<li class=''><a>Page ".$activePage." of ".$jumPage." <span class='sr-only'>Page ".$activePage." of ".$jumPage."</span> </a></li>
		";
		if($noPage>1){
			$prev=($noPage-1);
			$str.= "<li><a href=".$currentUrlParameter."page=".$prev."><span aria-hidden='true'>Prev</span><span class='sr-only'>Prev</span></a></li>" ;
		}
		else
		$str.= "<li><a><span aria-hidden='true'>Prev</span><span class='sr-only'>Prev</span></a></li>" ;

		for($page = 1; $page <= $jumPage; $page++) {
			if ((($page >= $noPage - 3) && ($page <= $noPage + 8)) || ($page == 1) || ($page == $jumPage)) {
				if (($showPage == 1) && ($page != 2))  $str.= "<li><a>... <span class='sr-only'>...</span></a><li>"; 
				if (($showPage != ($jumPage - 1)) && ($page == $jumPage))  $str.= "<li><a>... <span class='sr-only'>...</span></a><li>";
				if ($page == $noPage) $str.= "<li class='active'><a>".$page." <span class='sr-only'>".$page."</span></a><li>";
				else 
					$str.= "<li><a href='".$currentUrlParameter."page=".$page."'>".$page." <span class='sr-only'>".$page."</span></a><li>";
					$showPage = $page;
			}
		}

		if($noPage<$jumPage) {
			$next=($noPage+1);
			$str.= "<li><a href='".$currentUrlParameter."page=".$next."'>Next <span class='sr-only'>Next</span></a><li>";
		}
		else
		$str.= "<li><a>Next <span class='sr-only'>Next</span></a><li>";
		$str .= "</ul></nav>";
	}
	return $str;
}

// function curl_api_grevia($url, $attr = NULL, $data = NULL)
// {
	// $httpheader = $param = array();
	// $httpheader[] = 'Secretkey: grevia';
	
	// // $data['secretkey'] = 'grevia';
	
	
	// if (isset($attr['debug'])) $param['debug'] = $attr['debug'];
	
	// $param['httpheader'] = $httpheader;
	// $param['useragent'] = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36';
	// // $param[''] = ;
	
	// $return = curl($url, $param, $data);
	
	// return $return;
// }

function curl($url, $method = 'get', $attr = NULL, $data = NULL)
{
	$ch = curl_init();
	
	// curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
	
	if (isset($attr['useragent'])) {
		curl_setopt($ch, CURLOPT_USERAGENT,$attr['useragent']);
	}
	
	if (isset($attr['httpheader'])) {
		curl_setopt($ch, CURLOPT_HTTPHEADER,$attr['httpheader']);
	}
	// curl_setopt($ch, CURLOPTGET, true);	
	//curl_setopt($ch, CURLOPT_POST, true);
	//curl_setopt($ch, CURLOPT_POSTFIELDS, "username=XXXXX&password=XXXXX");
	
	// // Using proxy
	// $arr_proxy = array(
		// // '187.44.1.167:8080', // BZ
		// // '123.205.131.69:21776', // taiwan
		// // '139.59.207.66:8080', // SG
		// // '163.47.11.113:3128', // SG
		
		// '36.67.85.3:8080', // all local indo proxy
		// '150.107.251.26:8080',
		// '182.30.225.36:8080',
		// '182.253.130.178:8080',
		// // '',
	// );
	// curl_setopt($ch, CURLOPT_PROXY , $arr_proxy[mt_rand(0,count($arr_proxy)-1)]);     // return web page
	
	// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);     // return web page
	curl_setopt($ch, CURLOPT_HEADER         , false);    // don't return headers
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION , true);     // follow redirects
	curl_setopt($ch, CURLOPT_ENCODING       , "");       // handle all encodings
	curl_setopt($ch, CURLOPT_USERAGENT      , "spider"); // who am i
	curl_setopt($ch, CURLOPT_AUTOREFERER    , true);     // set referer on redirect
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 120);      // timeout on connect
	curl_setopt($ch, CURLOPT_TIMEOUT        , 120);      // timeout on response
	curl_setopt($ch, CURLOPT_MAXREDIRS      , 10);       // stop after 10 redirects
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);    // Disabled SSL Cert checks
	curl_setopt($ch, CURLOPT_VERBOSE 		, true);     // Show info
	
	// turnoff proxy for kawanlama
	curl_setopt($ch, CURLOPT_PROXY, '');	
	
	// get, post, put, delete
	if (isset($method)) {		
		
		$method = strtolower($method);
		
		$post_arr = array('post','put','delete');
		
		if (in_array($method,$post_arr)) {
			
			if ($method == 'post') curl_setopt($ch, CURLOPT_POST, true);
			else if ($method == 'put') curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
			else if ($method == 'delete') curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
			
			if (isset($attr['is_json'])) {
				// json
				if (isset($data)) curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			} else {
				// non json
				if (! empty($data)) curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
			}
			
		} else if ($method == 'get') {
			
			if (! empty($data)) $url .= '?'.http_build_query($data);
		}
	} else {
		// method get
		if (! empty($data)) $url .= '?'.http_build_query($data);
	}
	
	curl_setopt($ch, CURLOPT_URL, $url);
	
	if (isset($attr['debug'])) {
		// debugging process
		// $resp['parameter'] = $data;
		// $resp['output'] = curl_exec($ch);
		$resp['output'] = curl_exec($ch);
		$resp['info'] = curl_getinfo($ch);
		$resp['error'] = curl_error($ch);
		$resp['info']['passing_header'] = $attr['httpheader'];
		$resp['info']['passing_data'] = $data;
		debug($resp,1);
	} else {
		
		// Normal process
		$resp = curl_exec($ch);
	}
	
	if (curl_error($ch)) {
		echo curl_error($ch);
	}
	curl_close($ch);
	
	if (! isset($resp)) $resp = NULL;
	
	return $resp;
}


DEFINE('ENCRYPTION_KEY', 'PrsQNb6H9a15578a0a');
function doencrypt($str){
	return simple_crypt(ENCRYPTION_KEY, $str, 'encrypt');
}
function dodecrypt($str){
	return simple_crypt(ENCRYPTION_KEY, $str, 'decrypt');
}

/**
 * http://www.westhost.com/contest/php/function/simple-encrypt-decrypt-using-a-key/227
 * Simple Encrypt / Decrypt using a key, specify the action
 * which defaults to encrypt or we assume it is to decrypt
 * the encrypted text can be saved into cookies, with out
 * being afraid of getting it cracked, provided the key is
 * long enough
 *
 * @param {$key} string - key to be used while string is encoded or decoded
 * @param {$string} string - string to be encoded or decoded
 * @param {$action} [encrypt/decrypt] - the action to be performed
 */
function simple_crypt($key, $string, $action = 'encrypt'){
		$res = '';
		if($action !== 'encrypt'){
			$string = base64_decode($string);
		} 
		for( $i = 0; $i < strlen($string); $i++){
				$c = ord(substr($string, $i));
				if($action == 'encrypt'){
					$c += ord(substr($key, (($i + 1) % strlen($key))));
					$res .= chr($c & 0xFF);
				}else{
					$c -= ord(substr($key, (($i + 1) % strlen($key))));
					$res .= chr(abs($c) & 0xFF);
				}
		}
		if($action == 'encrypt'){
			$res = base64_encode($res);
		} 
		return $res;
}

function print_message($string, $type = 'info'){
	$return = '';
	if ($type == "info") {
		$return = '<div class="alert alert-info b"><i class="fa fa-exclamation-circle"></i> &nbsp;&nbsp;'.$string.'</div>';
	}
	if ($type == "success") {
		$return = '<div class="alert alert-success b"><i class="fa fa-check-circle"></i> &nbsp;&nbsp;'.$string.'</div>';
	}
	if ($type == "error") {
		$return = '<div class="alert alert-danger b"><i class="fa fa-remove"></i> &nbsp;&nbsp;'.$string.'</div>';
	}
	
	// if ($type == "info") {
		// $return = '<div class="message-info b"> <i class="fa fa-exclamation-circle"></i> &nbsp;&nbsp;'.$string.'</div>';
	// }
	// if ($type == "success") {
		// $return = '<div class="message-success b"><i class="fa fa-check-circle"></i> &nbsp;&nbsp;'.$string.'</div>';
	// }
	// if ($type == "error") {
		// $return = '<div class="message-danger b"><i class="fa fa-remove"></i> &nbsp;&nbsp;'.$string.'</div>';
	// }
	return $return;
}

function current_full_url() {
    $curpageURL = 'http';
    if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$curpageURL.= "s";}
	$curpageURL.= "://";
	
    // if ($_SERVER["SERVER_PORT"] != "80") {
		// $curpageURL.= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		// $curpageURL.= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    // } else {
		// $curpageURL.= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    // }
	$curpageURL.= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    return $curpageURL;
	// return http://localhost/kisi-kisi.com/showcategoryarticle.php?aid=6&title=iniabsurd&wewew=hehe&jablay=gila
}

function get_cookie($name, $column = NULL)
{
	$temp = Cookie::get($name);
	if (isset($temp)) 
		$temp = explode('||',$temp);
	else 
		return FALSE;
	
	if (! empty($temp)) 
	{
		$cookie = array(
			'member_id' =>	$temp[0],
			'name'		=>	$temp[1],
			'email'		=>	$temp[2]
		);	
	}
	// $cookie['member_id'] = $temp[0];
	// debug($cookie,1);
	// $cookie['name'] = $temp[1];
	// $cookie['email'] = $temp[2];

	if (isset($column) && in_array($column,array('member_id','name','email')) == TRUE)
		return $cookie[$column]; 
	else
		return $cookie;
}

// function is_member()
// {
	// // No cookies then false
	// if (! isset($_COOKIE['tokenhash']) || $_COOKIE['tokenhash'] == '') return FALSE;
	
	// // return 'break';
	// // $tokenhash = NULL;
	// // $tokenhash = get_cookie('tokenhash','member_id');
	// // return (isset($tokenhash) && $tokenhash != '') ? TRUE : FALSE;
// }

function orm_get($q)
{
	$data = DB::select($q);
	if (! empty($data)) $data = $data[0];
	$data = json_decode(json_encode($data),1);
	
	// $data = DB::select($q)->get();
	// $data = $data->toArray();
	// if (! empty($data)) $data = $data[0];
	return $data;
}

function orm_get_list($q)
{
	$data = DB::select($q);
	$data = json_decode(json_encode($data),1);
	return $data;
}

// formula = format string to scrape
function ambilkata($source, $formula,$formula2 = NULL)
{
	$tmp = $tmp2 = $ret = NULL;
	
	$tmp = $source;
	// $tmp = explode($buka.$formula.$tutup,$tmp);
	$tmp = explode($formula,$tmp);
	// debug($tmp,1);
	if (isset($tmp[1])) {
		$tmp2 = explode($formula2,$tmp[1]);
		
		$ret = $tmp2;
		if (isset($tmp2[0])) {
			$ret = $tmp2[0];
			// remove prefix depan
			// $ret = str_replace($buka,'',$ret);
		}
	}
	// debug($ret);
	// die;
	$ret = trim($ret);
	return $ret;
}

// Hit curl project for scraper fachrie 12 september 2018
function curlf($url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
	// curl_setopt($ch, CURLOPTGET, true);	
	//curl_setopt($ch, CURLOPT_POST, true);
	//curl_setopt($ch, CURLOPT_POSTFIELDS, "username=XXXXX&password=XXXXX");
	
	// Using proxy
	$arr_proxy = array(
		
		// '36.67.85.3:8080', // all local indo proxy
		// '150.107.251.26:8080',
		// '182.30.225.36:8080',
		// '182.253.130.178:8080',
		
		// elite from https://premproxy.com/proxy-by-country/Indonesia-01.htm
		'139.255.112.129:53281',
		'114.7.5.214:53281',
		'182.16.171.1:53281',
	);
	// curl_setopt($ch, CURLOPT_PROXY , $arr_proxy[mt_rand(0,count($arr_proxy)-1)]);     // return web page
	
	// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);     // return web page
	curl_setopt($ch, CURLOPT_HEADER         , false);    // don't return headers
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION , true);     // follow redirects
	curl_setopt($ch, CURLOPT_ENCODING       , "");       // handle all encodings
	// curl_setopt($ch, CURLOPT_USERAGENT      , "spider"); // who am i
	curl_setopt($ch, CURLOPT_AUTOREFERER    , true);     // set referer on redirect
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 120);      // timeout on connect
	curl_setopt($ch, CURLOPT_TIMEOUT        , 120);      // timeout on response
	curl_setopt($ch, CURLOPT_MAXREDIRS      , 10);       // stop after 10 redirects
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);    // Disabled SSL Cert checks
	curl_setopt($ch, CURLOPT_VERBOSE 		, true);     // Disabled SSL Cert checks
	
	$resp = curl_exec($ch);
	if (curl_error($ch)) {
		echo curl_error($ch);
	}
	return $resp;
}

function base_url()
{
	// return URL::to('/').'/'; => /kalibri/
	// return URL::to('/').'/';
	return env('APP_URL'); // => http://localhost/ atau http://localhost/kalibri/ atau http://devklbox.kawanlama.com
	
	// // Get the base URL.
	// echo url('');

	// // Get the app URL from configuration which we set in .env file.
	// echo config('app.url'); 

	// // Get the current URL without the query string.
	// echo url()->current();

	// // Get the current URL including the query string.
	// echo url()->full();

	// // Get the full URL for the previous request.
	// echo url()->previous();
}

function get_ip()
{
	return $_SERVER['REMOTE_ADDR'];
}

/* 
 * 
 * Return full url without query string (Return string)
 * ex: when called in http://localhost/kalibri/company_list?page=4&order=ayam, the output will be 
 * http://localhost/kalibri/company_list
 */
function current_url() {
	return Request::url();
}

/****************************************************
 * Return cookie saved and encrypted when user login 
 ****************************************************
 * @parameter : array like 'user_id'
 *
 *
 *
*/
function get_user_cookie($param = NULL)
{
	$response = $cookie = $arrdata = $arrcook = NULL;
	// return true;
	$cookie = Cookie::get('tokenhash');
	if (! isset($cookie) || empty($cookie)) return false; 
	
	$arrcook = explode('||',$cookie);
	
	// if (empty($arrcook)) return false; 
	
	if (isset($arrcook[0])) $arrdata['user_id'] = $arrcook[0];
	if (isset($arrcook[1])) $arrdata['site_id'] = $arrcook[1];
	if (isset($arrcook[2])) $arrdata['fullname'] = $arrcook[2];
	if (isset($arrcook[3])) $arrdata['email'] = $arrcook[3];
	if (isset($arrcook[4])) $arrdata['job_title'] = $arrcook[4];
	if (isset($arrcook[5])) $arrdata['user_code'] = $arrcook[5];
	if (isset($arrcook[6])) $arrdata['role_id'] = $arrcook[6];
	if (isset($arrcook[7])) $arrdata['role_name'] = $arrcook[7];
	if (isset($arrcook[8])) $arrdata['division_id'] = $arrcook[8];
	
	$response = $arrdata;
	if (isset($param)) $response = $arrdata[$param];
	
	return $response;
}

function is_member($param = NULL)
{
	$temp = NULL;
	$temp = get_user_cookie();
	// $temp = get_user_cookie('hashtoken');
	
	$return = false;
	if (isset($temp) && $temp != '') $return = true;
	return $return;
}

function generateRandomString($length = 10) {
    $characters = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


// Get all record from table config and set into array with key_value
function get_all_config() {
	if (is_member()) $cookie_user = get_user_cookie();
	$config = $api_url = $api_method = $api_param = $api_header = NULL;
	$api_param['site_id'] = $cookie_user['site_id'];
	$api_url = 'config/get_list';
	$api_method = 'get';
	// $api_header['debug'] = 1;
	$api_header['paging'] = false;
	$listconfig = curl_api_liquid($api_url, $api_method, $api_header, $api_param);
	if (isset($listconfig)) $listconfig = json_decode($listconfig,1);
	$listconfig = $listconfig['data'];
	if (! empty($listconfig)) {
		foreach ($listconfig as $kcfg => $cfg) {
			$config[trim($listconfig[$kcfg]['config_name'])] = $cfg['config_value'];
		}
	}
	return $config;
}

// validate json
function json_validate($string)
{
    // decode the JSON data
    $result = json_decode($string,1);

    // switch and check possible JSON errors
    switch (json_last_error()) {
        case JSON_ERROR_NONE:
            $error = ''; // JSON is valid // No error has occurred
            break;
        case JSON_ERROR_DEPTH:
            $error = 'The maximum stack depth has been exceeded.';
            break;
        case JSON_ERROR_STATE_MISMATCH:
            $error = 'Invalid or malformed JSON.';
            break;
        case JSON_ERROR_CTRL_CHAR:
            $error = 'Control character error, possibly incorrectly encoded.';
            break;
        case JSON_ERROR_SYNTAX:
            $error = 'Syntax error, malformed JSON.';
            break;
        // PHP >= 5.3.3
        case JSON_ERROR_UTF8:
            $error = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
            break;
        // PHP >= 5.5.0
        case JSON_ERROR_RECURSION:
            $error = 'One or more recursive references in the value to be encoded.';
            break;
        // PHP >= 5.5.0
        case JSON_ERROR_INF_OR_NAN:
            $error = 'One or more NAN or INF values in the value to be encoded.';
            break;
        case JSON_ERROR_UNSUPPORTED_TYPE:
            $error = 'A value of a type that cannot be encoded was given.';
            break;
        default:
            $error = 'Unknown JSON error occured.';
            break;
    }

    if ($error !== '') {
        // throw the Exception or exit // or whatever :)
		$message = 'Sorry error occured, please try again later';
        exit($error);
		
		//save to log
		
		// redirect to no back
		// return redirect()->back()->with('message', print_message($message));
		// return back();
    }

    // everything is OK
    return $result;
}

function validate_string($string){
	$string = preg_replace('/[^A-Za-z0-9\-\_\"\s\(\)]/', '', $string);
	return $string;
}

// show label info popup
function info_label($msg, $class = 'btn-white btn-xs') {
	$ret = NULL;
	if (isset($msg)) $ret = '<a href="#" class="btn ' . $class . '" data-toggle="popover" title="Info" data-content="' . $msg . '"><i class="fa fa-info-circle fa-lg"></i> </a>';
	return $ret;
}
// public function validate_allowed_site($user_id)
// {
	// $allowed_site = NULL;
	// $allowed_site[] = get_user_cookie('site_id');
	
	// return $allowed_site;
// }

?>