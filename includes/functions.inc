<?php

$GLOBALS['mysqli'] = new mysqli('localhost', "cam", "hello", "selftagme");
if(!$GLOBALS['mysqli']) throw new Exception('Unable to connect to database');

/**
 * Retrieve the client IP address, even if they're behind a proxy.
 * @return string
 */
if(!function_exists('ClientIP')){
	function ClientIP(){
		if(!empty($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP'];  //check ip from share internet
		if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) return $_SERVER['HTTP_X_FORWARDED_FOR']; //to check ip is pass from proxy
		return $_SERVER['REMOTE_ADDR'];
	}
}

/**
 * Create a text string to show how long ago something was performed.
 * @param string $timestamp     Time since unix epoch, not used if $datetime is provided and can thus be left blank.
 * @param string $datetime      Can be provided as a DateTime object, or a text string in a format that can be recognised by new DateTime()
 * @param string $format        One of: biggest, days, all, smallest, top2. Defaults to biggest.
 *
 * @return string
 */
if(!function_exists('TimeAgo')){
	function TimeAgo($timestamp='', $datetime='', $format='biggest'){
        $Now = new DateTime();
        
		//if($timestamp=='' && $datetime!='') $timestamp = strtotime($datetime);
        if(is_object($datetime)){
            $Mod = $datetime;
        }else{    
            if($datetime != ''){
                $Mod = new DateTime($datetime);
            }else{
                if(is_numeric($timestamp)){
                    $Mod = new DateTime(date('Y-m-d H:i:s', $timestamp));	
                }else{
                    return '????';
                }

            }
        }
		$interval = $Now->diff($Mod);

		switch($format){
			case 'days':
				$Return = $interval->days.' Day'.($interval->days>1 ? 's' : '');
				break;
			case 'all':
				$Return = '';

				if($interval->format('%y') > 0) $Return .= $interval->format('%y').' Year'.($interval->format('%y')>1 ? 's' : '').', ';
				if($interval->format('%m') > 0) $Return .= $interval->format('%m').' Month'.($interval->format('%m')>1 ? 's' : '').', ';
				if($interval->format('%d') > 0) $Return .= $interval->format('%d').' Day'.($interval->format('%d')>1 ? 's' : '').', ';
				if($interval->format('%h') > 0) $Return .= $interval->format('%h').' Hour'.($interval->format('%h')>1 ? 's' : '').', ';
				if($interval->format('%i') > 0) $Return .= $interval->format('%i').' Minute'.($interval->format('%i')>1 ? 's' : '').', ';
				if($interval->format('%s') > 0) $Return .= $interval->format('%s').' Second'.($interval->format('%s')>1 ? 's' : '').'';
				$Return = trim($Return, ',').' Ago';
				break;
			case 'smallest':
				$Return = '???';
				if($interval->format('%y') > 0){
					$Return = $interval->format('%y').'y';
				}elseif($interval->format('%m') > 0){
					$Return = $interval->format('%m').'mo';
				}elseif($interval->format('%d') > 0){
					$Return = $interval->format('%d').'d';
				}elseif($interval->format('%h') > 0){
					$Return = $interval->format('%h').'h';
				}elseif($interval->format('%i') > 0){
					$Return = $interval->format('%i').'m';
				}elseif($interval->format('%s') > 0){
					$Return = $interval->format('%s').'s';
				}
				break;
			case 'top2':
				$Done = 0;
				
				if($interval->format('%y') > 0){
					$Return .= $interval->format('%y').' Year'.($interval->format('%y')>1 ? 's' : '').', ';
					$Done++;
				}
				if($Done == 2) return trim($Return, ', ');
				
				if($interval->format('%m') > 0){
					$Return .= $interval->format('%m').' Month'.($interval->format('%m')>1 ? 's' : '').', ';
					$Done++;
				}
				if($Done == 2) return trim($Return, ', ');
				
				if($interval->format('%d') > 0){ 
					$Return .= $interval->format('%d').' Day'.($interval->format('%d')>1 ? 's' : '').', ';
					$Done++;
				}
				if($Done == 2) return trim($Return, ', ');
				
				if($interval->format('%h') > 0){ 
					$Return .= $interval->format('%h').' Hour'.($interval->format('%h')>1 ? 's' : '').', ';
					$Done++;
				}
				if($Done == 2) return trim($Return, ', ');
				
				if($interval->format('%i') > 0){ 
					$Return .= $interval->format('%i').' Minute'.($interval->format('%i')>1 ? 's' : '').', ';
					$Done++;
				}
				if($Done == 2) return trim($Return, ', ');
				
				if($interval->format('%s') > 0){ 
					$Return .= $interval->format('%s').' Second'.($interval->format('%s')>1 ? 's' : '').'';
					$Done++;
				}
				if($Done == 2) return trim($Return, ', ');
				
				break;
			case 'biggest':
			default:
				$Return = 'Just Now';

				if($interval->format('%y') > 0){
					$Return = $interval->format('%y').' Year'.($interval->format('%y') > 1 ? 's' :'');
				}elseif($interval->format('%m') > 0){
					$Return = $interval->format('%m').' Month'.($interval->format('%m') > 1 ? 's' :'');
				}elseif($interval->format('%d') > 0){
					$Return = $interval->format('%d').' Day'.($interval->format('%d') > 1 ? 's' :'');
				}elseif($interval->format('%h') > 0){
					$Return = $interval->format('%h').' Hour'.($interval->format('%h') > 1 ? 's' :'');
				}elseif($interval->format('%i') > 0){
					$Return = $interval->format('%i').' Minute'.($interval->format('%i') > 1 ? 's' :'');
				}elseif($interval->format('%s') > 0){
					$Return = $interval->format('%s').' Second'.($interval->format('%s') > 1 ? 's' :'');
				}
                if($Return != 'Just Now') $Return .= ' Ago';
			break;
		}
		return $Return;
	}
}

/**
 * Prepare a string as an input
 * @return string
 */
if(!function_exists('InputName')){
	function InputName($String){
		$String = str_replace(array(' '), '', $String);
        $String = strtolower($String);
		return $String;
	}
}
/**
 * Create a hash of a string
 * @return string
 */
if(!function_exists('HashInputs')){
	function HashInputs($text){
		$key = 'obscurekey';
		@$hash = urlencode(openssl_encrypt(base64_encode($text), 'aes-256-ctr', $key)); //@ at the front suppresses error messages, in this case, it'll be a warning about not including an $iv, but we can't, and this doesn't need password level security anyway, it needs two way decryption with a $key only.
		return $hash;
	}
}
/**
 * Create a string from a hash
 * @return string
 */
if(!function_exists('UnHashInputs')){
	function UnHashInputs($hash){
		$key = 'obscurekey';
		$text = base64_decode(openssl_decrypt(urldecode($hash), 'aes-256-ctr', $key));
		return $text;
	}
}
/**
 * Interpret an integer / type into a string
 * @return string
 */
if(!function_exists('Interpret')){
	function Interpret($ID, $Type, $Return='integer'){
		switch(strtolower($Type)){
            case 'quality':
                switch(strtolower($ID)){
                    case 'poor':
                    case '0':
                        return $Return=='integer' ? 0 : 'Poor';
                    case 'common':
                    case '1':
                        return $Return=='integer' ? 1 : 'Common';
                    case 'fine':
                    case '2':
                        return $Return=='integer' ? 2 : 'Fine';
                    case 'exquisite':
                    case '3':
                        return $Return=='integer' ? 3 : 'Exquisite';
                    case 'epic':
                    case '4':
                        return $Return=='integer' ? 4 : 'Epic';
                    case 'legendary':
                    case '5':
                        return $Return=='integer' ? 5 : 'Legendary';
                }
                break;
            case 'method':
                switch(strtolower($ID)){
                    case 'none':
                    case '0':
                        return $Return=='integer' ? 0 : 'none';
                    case 'gotctips35':
                    case '1':
                        return $Return=='integer' ? 1 : 'gotctips35';
                    case 'gotctips40':
                    case '2':
                        return $Return=='integer' ? 2 : 'gotctips40';
                    case 'gotctips45':
                    case '3':
                        return $Return=='integer' ? 3 : 'gotctips45';
                }
                break;
        }
	}
}

?>