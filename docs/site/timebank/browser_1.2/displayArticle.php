<?php require('utils.php');$fileName = $HTTP_GET_VARS['file'];if ( $HTTP_GET_VARS['highlight'] ) {	$ids = explode(",",$HTTP_GET_VARS['highlight']); 	foreach ($ids as $id) {		$highlightIDs[$id] = 1; }}?><!doctype html public "-//W3C//DTD HTML 4.0 //EN"> <html><head><title>Document <?php echo $fileName; ?></title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><script language="JavaScript" type="text/JavaScript"><!--savedTags = new Array();function MM_goToURL() { //v3.0  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'"); }function openEvents() {  var newurl = "displayEvents.php?file=<?php echo $fileName ?>";  var w = window.open(newurl,"events","width=750,height=600,status=yes,scrollbars=yes,resizable=yes");   w.xopener = window;}function openTimexes() {  var newurl = "displayTimexes.php?file=<?php echo $fileName ?>";  var w = window.open(newurl,"timexes","width=800,height=600,status=yes,scrollbars=yes,resizable=yes");   w.xopener = window;}function openLinks(linkType) {  var newurl = "displayLinks.php?linktype=" + linkType + "&file=<?php echo $fileName ?>";  var w = window.open(newurl,"links","width=500,height=600,status=yes,scrollbars=yes,resizable=yes");   w.xopener = window;}//--></script><link href="timebank.css" rel="stylesheet" type="text/css"></head><body><?php readfile("topnav.php"); ?><h2><?php echo $fileName; ?></h2><form><table cellspacing=5 bgcolor='#ccccff'><tr><td>Show:<a href=javascript:openEvents()>events</a> |<a href=javascript:openTimexes()>timexes</a> |<a href=javascript:openLinks("all")>all links</a> |<a href=javascript:openLinks("ALinks")>alinks</a> |<a href=javascript:openLinks("SLinks")>slinks</a> |<a href=javascript:openLinks("TLinks")>tlinks</a></td></tr><tr><td>Selected link:<input size=70 type=text readOnly=true id=linkdata bgcolor='#eeeeee' value=''></td></tr></table></form><?php echoDocument($fileName,$highlightIDs,'<br>'); ?></body></html>