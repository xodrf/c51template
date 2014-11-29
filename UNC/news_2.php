<?php
	
	$f0=$_POST["titolo"];
	$f1=$_POST["testo"];
	
	// adding persistence
	require_once( 'config.php' );
	require_once( 'IOsetget.php' );
	$obj= new IOs();
	$obj->getIOs();
	$obj->setFld( 5, $f0 );
	$obj->setFld( 6, $f1 );
	$obj->setIOs();
	$obj->__destruct();
	
	$fp = fsockopen( __CGXSERVER__, __CGNUMPORT__, $errno, $errstr, 10); 
	
	//------------------------------------------------
	$out="CG 1 REMOVE 7".__EOL__;
	fwrite($fp,  $out);
	usleep(5000);
	//------------------------------------------------
	$out="MIXER 1-3 CLEAR".__EOL__;
	fwrite($fp,  $out);
	usleep(5000);
	//------------------------------------------------
	$out="MIXER 1-3 FILL 0.165 0.75 0.67 0.2".__EOL__;
	fwrite($fp,  $out);
	usleep(5000);
	//------------------------------------------------
	$out="PLAY 1-3 aldia/zocalo LOOP".__EOL__;
	fwrite($fp,  $out);
	usleep(5000);
	//------------------------------------------------
	$out="CG 1 ADD 7 aldia/zocalo 1 \"<templateData><componentData id=\\\"f0\\\"><data id=\\\"text\\\" value=\\\"$f0 \\\"/></componentData><componentData id=\\\"f1\\\"><data id=\\\"text\\\" value=\\\"$f1 \\\"/></componentData></templateData>\"".__EOL__;
	fwrite($fp,  $out);
	usleep(5000);
	//------------------------------------------------
	fclose( $fp );
	header( 'Location: main.php' ) ;
?>