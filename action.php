<?php

if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'action.php');

class action_plugin_messagemanager extends DokuWiki_Action_Plugin {

	var $Vc_Message 	= 'My default Message';
	var $Vc_TypeMessage = 'Warning';

	function action_plugin_messagemanager () {
		// enable direct access to language strings
		$this->setupLocale();
	}

	function getInfo(){
		return confToHash(dirname(__FILE__).'/info.txt');
	}

	function register(Doku_Event_Handler $controller){
		$controller->register_hook(
				'TPL_ACT_RENDER',
				'BEFORE',
				$this,
				'_messagemanagerMessage',
				array()
		);
	}

	function iptocountry($ip) {
		$numbers = preg_split( "/\./", $ip);
		include("ip_files/".$numbers[0].".php");
		$code=($numbers[0] * 16777216) + ($numbers[1] * 65536) + ($numbers[2] * 256) + ($numbers[3]);
		foreach($ranges as $key => $value){
			if($key<=$code){
				if($ranges[$key][0]>=$code){
					$two_letter_country_code=$ranges[$key][1];break;
				}
			}
		}
		if ($two_letter_country_code==""){
			$two_letter_country_code="unkown";
		}
		return $two_letter_country_code;
	}

	/**
	 * Main function; dispatches the visual comment actions
	 */
	function _messagemanagerMessage(&$event, $param) {

		global $ID;

		if ( time( ) < strtotime( "2012-2-7" ) ) {
			// current time is greater than 05/15/2010 4:00PM

			$IPaddress=$_SERVER['REMOTE_ADDR'];
			//$IPaddress='193.173.53.8';
			$two_letter_country_code=$this->iptocountry($IPaddress);

			if ($two_letter_country_code=="NL"){

				$INFO = $this->getInfo();
				if ($this->Vc_TypeMessage == 'Classic') {
					ptln('<div class="messageclassic">');
				} else {
					ptln('<div class="messagewarning">');
				}
					
				// print $this->lang['mymessage'];
				// print '<div class="managerreference">'.$this->lang['message_come_from'].' <a href="'.$INFO['url'].'" class="urlextern" title="'.$INFO['desc'].'"  rel="nofollow">'.$INFO['name'].'</a>.</div>' ;
					
				print '<a href="http://www.hotitem.nl/preview.shtml" class="media" title="http://www.hotitem.nl/preview.shtml"  rel="nofollow"><img src="http://gerardnico.com/wiki/_media/temp/logo_hotitem.gif" class="medialeft" align="left" alt="" /></a>
				<a href="http://www.hotitem.nl/preview.shtml" class="media" title="http://www.hotitem.nl/preview.shtml"  rel="nofollow"><img src="http://gerardnico.com/wiki/_media/temp/logo_bootcamp.jpg" class="mediaright" align="right" alt="" /></a>
				Vanwege de sterk groeiende vraag naar onze diensten op het gebied van Performance Improvement, starten wij in mei met de Hot ITem Consultancy Bootcamp 2012. Een intensief programma, speciaal bedoeld voor professionals die
				vanuit hun BI-achtergrond, ook sales en business consultancy vaardigheden willen ontwikkelen. Na een opleidingsprogramma van zes weken ga je aan de slag in onze multidisciplinaire projectteams om de prestaties van onze klanten te verbeteren.
				Sneak preview op <a href="http://www.hotitem.nl/preview.shtml" class="urlextern" title="http://www.hotitem.nl/preview.shtml"  rel="nofollow">dinsdagavond 7 februari</a>.';
					
				ptln('</div>');
			}
		}
			
	}

}
