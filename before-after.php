<?php

/*
Plugin Name: Before And After
Plugin URI: http://www.jacobfresco.nl/programmeren/wordpress/before-and-after/ 
Description: You decide when a text - within an article - is shown. This plugin makes it possible to schedule text within an Wordpress-post or page
Version: 0.3.2
Author: Jacob Fresco
Author URI: http://www.jacobfresco.nl

Copyright 2011  Jacob Fresco

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

date_default_timezone_set(get_option('timezone_string'));


function baReplaceText ($text) {

  $Vandaag = date('Y-m-d', current_time('timestamp'));
  $Nu = date('H:i', current_time('timestamp'));
  
  
  $baReplaceText = str_replace("\r\n", "__NEWLINERN__", $text);
  $baReplaceText = str_replace("\r", "__NEWLINER__", $baReplaceText);
  $baReplaceText = str_replace("\n", "__NEWLINEN__", $baReplaceText);
  
/* Controleer op <BEFORE> in de $text */ 
  preg_match_all("(<BEFORE .*?</BEFORE>)", $baReplaceText, $resultaatB, PREG_PATTERN_ORDER);
  
  if (is_array($resultaatB[0])) {
      foreach($resultaatB[0] as $tekstB => $b) {
	    
		$bDatum = substr($b, 8, 10);
		
		if (substr($b, 18, 1) == ">") {
           $bTekst = substr($b, 19, -9);
		   $bTijd = "00:00";
		  } else { 
		   $bTijd = substr($b, 19, 5);
		   $bTekst = substr($b, 25, -9);
		}
		
		if ($Vandaag < $bDatum) {
		   $baReplaceText = preg_replace("(<BEFORE .*?</BEFORE>)", $bTekst, $baReplaceText, 1);
		}
		
		if ($Vandaag == $bDatum) {
		  if ($Nu < $bTijd) {
		     $baReplaceText = preg_replace("(<BEFORE .*?</BEFORE>)", $bTekst, $baReplaceText, 1);
		   } else {
		     $baReplaceText = preg_replace("(<BEFORE .*?</BEFORE>)", null, $baReplaceText, 1); 
	       }
		}
	    
		if ($Vandaag > $bDatum) {
		   $baReplaceText = preg_replace("(<BEFORE .*?</BEFORE>)", null, $baReplaceText, 1);
		}
		
		
       }
   }  

/* Controleer op <AFTER> in de $text */ 
  preg_match_all("(<AFTER .*?</AFTER>)", $baReplaceText, $resultaatA, PREG_PATTERN_ORDER);
  
  if (is_array($resultaatA[0])) {
      foreach($resultaatA[0] as $tekstA => $a) {
	    
        $aDatum = substr($a, 7, 10);
		if (substr($a, 17, 1) == ">") {
           $aTekst = substr($a, 18, -8);
		   $aTijd = "23:59";
		  } else { 
		   $aTijd = substr($a, 18, 5);
		   $aTekst = substr($a, 24, -8);
		}
		
		if ($Vandaag > $aDatum) {
		   $baReplaceText = preg_replace("(<AFTER .*?</AFTER>)", $aTekst, $baReplaceText, 1);
		}
		
		if ($Vandaag == $aDatum) {
		  if ($Nu > $aTijd) {
		     $baReplaceText = preg_replace("(<AFTER .*?</AFTER>)", $aTekst, $baReplaceText, 1);
		   } else {
		     $baReplaceText = preg_replace("(<AFTER .*?</AFTER>)", null, $baReplaceText, 1); 
	       }
		}
	    
		if ($Vandaag < $aDatum) {
		   $baReplaceText = preg_replace("(<AFTER .*?</AFTER>)", null, $baReplaceText, 1);
		}
		
		
       }
   } 
   
/* Controleer op <SINGLE> in de $text */ 
   preg_match_all("(<SINGLE [0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9]>.*?</SINGLE>)", $baReplaceText, $resultaatO, PREG_PATTERN_ORDER);
   
   if (is_array($resultaatO[0])) {

      foreach($resultaatO[0] as $tekstO => $o) {
        $oDatum = substr($o, 8, 10);
        $oTekst = substr($o, 19, -9);
	
		if ($oDatum == $Vandaag) {
		   $baReplaceText = preg_replace("(<SINGLE [0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9]>.*?</SINGLE>)", $oTekst, $baReplaceText, 1);
		} else {
		   $baReplaceText = preg_replace("(<SINGLE [0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9]>.*?</SINGLE>)", null, $baReplaceText, 1);
		}

	 } 
   }

$baFinalText = str_replace("__NEWLINERN__", "\r\n", $baReplaceText);
$baFinalText = str_replace("__NEWLINER__", "\r", $baReplaceText);
$baFinalText = str_replace("__NEWLINEN__", "\n", $baReplaceText);

return $baFinalText;
}

add_filter("the_content", "baReplaceText");

?>