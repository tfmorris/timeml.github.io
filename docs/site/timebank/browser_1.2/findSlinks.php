<?phprequire('utils.php');$find = $HTTP_POST_VARS['find'];$rel = $HTTP_POST_VARS['rel'];$s1 = $HTTP_POST_VARS['s1'];$c1 = $HTTP_POST_VARS['c1'];$t1 = $HTTP_POST_VARS['t1'];$a1 = $HTTP_POST_VARS['a1'];$s2 = $HTTP_POST_VARS['s2'];$c2 = $HTTP_POST_VARS['c2'];$t2 = $HTTP_POST_VARS['t2'];$a2 = $HTTP_POST_VARS['a2'];$searchmax = 250;?><!doctype html public "-//W3C//DTD HTML 4.0 //EN"> <html><head><title>Find SLinks (<?php echo $_SERVER['SERVER_NAME'] ?>)</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><link href="timebank.css" rel="stylesheet" type="text/css"><style type="text/css"><!--.button { 	background-color: #ccccff;	font-weight: bold; }--></style><script language="JavaScript" type="text/JavaScript"><!--function MM_goToURL() { //v3.0  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");}//--></script></head><body><?php readfile("topnav.php"); ?><h2>&nbsp;Find SLinks</h2><?php// --------------------------------------------------------------------// CASE 1:// Produce HTML code for the results:// - new search and refine search buttons// - search pattern// - number of matches// - list of matches// --------------------------------------------------------------------if ($find) {?><table><tr><td>   <form name="f2" action="<?php echo $_SERVER['PHP_SELF'] ?>" method=POST>   <table cellpadding=5 bgcolor='#ffffaa'>   <tr><td><input class=button type=submit value="New Search"></td></tr>   </table>   </form></td><td>   <form name="f2" action="<?php echo $_SERVER['PHP_SELF'] ?>" method=POST>   <table cellpadding=5 bgcolor='#ffffaa'>   <tr><td>	   <input class=button type=submit value="Refine Search">   <input name="rel" type="hidden" value=<?php echo $rel; ?>>   <input name="s1" type="hidden" value=<?php echo $s1; ?>>   <input name="c1" type="hidden" value=<?php echo $c1; ?>>   <input name="t1" type="hidden" value=<?php echo $t1; ?>>   <input name="a1" type="hidden" value=<?php echo $a1; ?>>   <input name="s2" type="hidden" value=<?php echo $s2; ?>>   <input name="c2" type="hidden" value=<?php echo $c2; ?>>   <input name="t2" type="hidden" value=<?php echo $t2; ?>>   <input name="a2" type="hidden" value=<?php echo $a2; ?>>   </td></tr>   </table>   </form></td></tr></table><p><?php  $q = "SELECT * from $EXPANDED_SLINKS_TABLE WHERE ";  $pos = strpos($s1,'----');  if ($pos === false) { $ps1 = $s1; $q = $q . "str1='$s1' AND "; }  $pos = strpos($s2,'----');  if ($pos === false) { $ps2 = $s2; $q .= "str2='$s2' AND "; }  if ($rel != 'nil') { $prel = $rel; $q .= "reltype='$rel' AND "; }  if ($c1 != 'nil') { $pc1 = $c1; $q .= "class1='$c1' AND "; }  if ($t1 != 'nil') { $pt1 = $s1; $q .= "tense1='$t1' AND "; }  if ($a1 != 'nil') { $pa1 = $a1; $q .= "aspect1='$a1' AND "; }  if ($c2 != 'nil') { $pc2 = $c2; $q .= "class2='$c2' AND "; }  if ($t2 != 'nil') { $pt2 = $t2; $q .= "tense2='$t2' AND "; }  if ($a2 != 'nil') { $pa2 = $a2; $q .= "aspect2='$a2' AND "; }  $q = substr($q,0,-5);  if (substr($q,-1) == 'W') { $unrestrictedSearch = true; }  //echo $q;  $result = mysql_query($q, $db_conn);    $num_rows = mysql_num_rows($result);  if (mysql_errno()) { printMySqlErrors($q,$_SERVER['SCRIPT_NAME'] . ":" . __LINE__); }  $rows = Array();  $count = 0;  while ($row = mysql_fetch_assoc($result) and $count < $searchmax) { 	$rows[] = $row; 	$count++; }?><table bgcolor='#ddffdd' cellpadding=2><tr><td><?php   if ($unrestrictedSearch) {	 echo "<font color=red><b>You have to restrict your search, please try again.</b></font>"; }    else {	 echo "Search Pattern:&nbsp;&nbsp; <b>{ $ps1 $pc1 $pt1 $pa1 } ";	 echo "&nbsp; { $prel } &nbsp; { $ps2 $pc2 $pt2 $pa2 }</b><p>\n";	 if ($num_rows > $searchmax) { 		 echo "Number of matches: $num_rows (only printing first $searchmax)<p>\n"; }	 else {		 echo "Number of matches: $num_rows<p>\n"; }	 echoLinkSearch($rows); }?></td></tr></table><?php// --------------------------------------------------------------------// CASE 2:// Produce HTML code for the search screen:// - new search button// - search form// --------------------------------------------------------------------} else {  $reltypes = getDistinct("reltype",$SLINKS_TABLE);  $classes = getDistinct("class",$EVENTS_TABLE);  $tenses = getDistinct("tense",$INSTANCES_TABLE);  $aspects = getDistinct("aspect",$INSTANCES_TABLE);  function echoOptions($list,$val) {	foreach ($list as $x) { 	  echo "<option";	  if ($val == $x) { echo " selected"; }	  echo ">$x</option>\n"; }}?><form action="<?php echo $_SERVER['PHP_SELF'] ?>" method=POST><table cellpadding=5 bgcolor='#ffffaa'><tr><td><input name="s1" size=25 value='------------ token1 ------------'><td>&nbsp;<td><select name="rel"><option value=nil>-- select reltype --</option><?php echoOptions($reltypes,$rel); ?></select><td>&nbsp;<td><input name="s2" size=25 value='------------ token2 ------------'>	<tr><td><select name="c1"><option value=nil>--------- select class1 ------</option><?php echoOptions($classes,$c1); ?></select><td>&nbsp;<td>&nbsp;<td>&nbsp;<td><select size=1 name="c2"><option value=nil>--------- select class2 ------</option><?php echoOptions($classes,$c2); ?></select><tr><td><select name="t1"><option value=nil>--------- select tense1 ------</option><?php echoOptions($tenses,$t1); ?></select><td>&nbsp;<td align=center><input class=button type=submit value="Find SLinks"><input name="find" type="hidden" value='yes'><td>&nbsp;<td><select size=1 name="t2"><option value=nil>--------- select tense2 ------</option><?php echoOptions($tenses,$t2); ?></select><tr><td><select name="a1"><option value=nil>-------- select aspect1 -----</option><?php echoOptions($aspects,$a1); ?> </select><td>&nbsp;<td>&nbsp;<td>&nbsp;<td><select name="a2"><option value=nil>-------- select aspect2 -----</option><?php echoOptions($aspects,$a2); ?> </select></table></form><?php}?></td></tr></table></body></html>