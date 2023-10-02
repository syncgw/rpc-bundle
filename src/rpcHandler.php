<?php
declare(strict_types=1);

/*
 * 	Wire Format Protocol handler class
 *
 *	@package	sync*gw
 *	@subpackage	Wire Format Protocol
 *	@copyright	(c) 2008 - 2023 Florian Daeumling, Germany. All right reserved
 * 	@license 	LGPL-3.0-or-later
 */

namespace syncgw\rpc;

use syncgw\lib\Config;
use syncgw\lib\XML;
use syncgw\lib\Server;
use syncgw\mapi\mapiWBXML;

class rpcHandler extends mapiWBXML {

    /**
     * 	Singleton instance of object
     * 	@var rpcHandler
     */
    static private $_obj = null;

    /**
	 *  Get class instance handler
	 *
	 *  @return - Class object
	 */
	public static function getInstance(): rpcHandler {

		if (!self::$_obj) {

            self::$_obj = new self();
			parent::getInstance();
		}

		return self::$_obj;
	}

    /**
	 * 	Collect information about class
	 *
	 * 	@param 	- Object to store information
	 */
	public function getInfo(XML &$xml): void {

		$xml->addVar('Name', 'Wire Format Protocol handler class');

		$xml->addVar('Opt', '<a href="https://learn.microsoft.Object/en-us/openspecs/exchange_server_protocols/ms-oxcrpc" target="_blank">[MS-OXCRPC]</a> '.
				      'Wire Format Protocol');
		$xml->addVar('Stat', 'v23.1');
	}

	/**
	 * 	Process RPC request / response
	 *
	 *	@param 	- XML document
	 * 	@return - true = Ok; false = Error
	 */
	public function Process(XML &$xml): bool {

 		$op   = $xml->savePos();
		$size = $xml->getVar('AuxiliaryBufferSize');
		$xml->restorePos($op);
		if (!$size)
			return true;

		$sub = new XML();
		if (!$sub->loadFile(Config::getInstance()->getVar(Config::ROOT).'rpc-bundle/assets/rpc.xml'))
		    return false;

		$rpc = new XML();

		// [MS-OXCRPC] 3.1.4.1.1.1.1 rgbAuxIn Input Buffer
		// [MS-OXCRPC] 2.2.2.1 RPC_HEADER_EXT Structure
		// [MS-OXCRPC] 2.2.2.2 AUX_HEADER Structure
		$sub->getVar('RPC_HEADER');
		$xml->append($sub, false);
		if (!self::Decode($xml, 'RPC_HEADER', true))
			return false;

		// RPC_HEADER processed
		$size -= 8;

		while ($size > 0) {

			$pos = parent::$_pos;
			$rpc->loadXML('<syncgw/>');
			$rpc->getVar('syncgw');

			// [MS-OXCRPC] 2.2.2.2 AUX_HEADER Structure
			$sub->getVar('AUX_HEADER');
			$rpc->append($sub, false);
			if (!self::Decode($rpc, 'AUX_HEADER', true))
				return false;

			if ($sub->getVar($tag = $rpc->getVar('AuxType')) !== null) {

				if ($tag == 'PERF_SESSIONINFO') {

					if ($rpc->getVar('AuxVersion') == 2)
						$tag .= '2';
					$rpc->updVar('AuxType', $tag);
				}

				$rpc->getVar('syncgw');
				$sub->getVar($tag);
				$rpc->append($sub, false);
				if (!self::Decode($rpc, $tag, true))
					return false;
			} else
				$size = 0;

			$rpc->getChild('syncgw');
			while($rpc->getItem() !== null)
				$xml->append($rpc, false, false);

			$size -= parent::$_pos - $pos;
		}

		return true;
	}

}
