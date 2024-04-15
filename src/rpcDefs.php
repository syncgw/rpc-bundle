<?php
declare(strict_types=1);

/*
 * 	Constant definitions
 *
 *	@package	sync*gw
 *	@subpackage	Wire Format Protocol
 *	@copyright	(c) 2008 - 2024 Florian Daeumling, Germany. All right reserved
 * 	@license 	LGPL-3.0-or-later
 */

namespace syncgw\rpc;

class rpcDefs {

	// [MS-OXCRPC] 2.2.2.2.20 AUX_ENDPOINT_CAPABILITIES Auxiliary Block Structure
	const AUX_CAPABILITIES			= [
		'SingleEndpoint'			=> 0x00000001,	// The server supports Objectbined Directory Service Referral
													// interface (RFRI), name service provider interface (NSPI),
													// and EMSMDB interface on a single HTTP endpoint
	];

	// MS-OXCRPC] 2.2.2.2.4 AUX_PERF_CLIENTINFO Auxiliary Block Structure
	const AUX_CLIENT_MODE		 	= [
		'Unknown'					=> 0x00,	// Client is not designating a mode of operation
		'Classic'					=> 0x01,	// Client is running in classic online mode
		'Cached'					=> 0x02,	// Client is running in cached mode
	];

	// [MS-OXCRPC] 2.2.2.2 AUX_HEADER Structure
	const AUX_TYPE					= [
		'PERF_REQUESTID'			=> 0x01,
		'PERF_CLIENTINFO'			=> 0x02,
		'PERF_SERVERINFO'			=> 0x03,
		'PERF_SESSIONINFO'			=> 0x04,
		'PERF_DEFMDB_SUCCESS'		=> 0x05,
		'PERF_DEFGC_SUCCESS'		=> 0x06,
		'PERF_MDB_SUCCESS'			=> 0x07,
		'PERF_GC_SUCCESS'			=> 0x08,
		'PERF_FAILURE'				=> 0x09,
		'CLIENT_CONTROL'			=> 0x0a,
		'PERF_PROCESSINFO'			=> 0x0b,
		'PERF_BG_DEFMDB_SUCCESS'	=> 0x0c,
		'PERF_BG_DEFGC_SUCCESS'		=> 0x0d,
		'PERF_BG_MDB_SUCCESS'		=> 0x0e,
		'PERF_BG_GC_SUCCESS'		=> 0x0f,
		'PERF_BG_FAILURE'			=> 0x10,
		'PERF_FG_DEFMDB_SUCCESS'	=> 0x11,
		'PERF_FG_DEFGC_SUCCESS'		=> 0x12,
		'PERF_FG_MDB_SUCCESS'		=> 0x13,
		'PERF_FG_GC_SUCCESS'		=> 0x14,
		'PERF_FG_FAILURE'			=> 0x15,
		'OSVERSIONINFO'				=> 0x16,
		'EXORGINFO'					=> 0x17,
		'PERF_ACCOUNTINFO'			=> 0x18,
		'SERVER_CAPABILITIES'		=> 0x46,
		'ENDPOINT_CAPABILITIES'		=> 0x48,
		'CLIENT_CONNECTION_INFO'	=> 0x4a,
		'SERVER_SESSION_INFO'		=> 0x4b,
		'PROT_DEVICE_IDENTIFICATION'=> 0x4e,
		'UNKNOWN'					=> 0x52,
	];

	// [MS-OXCRPC] 2.2.2.2.5 AUX_PERF_SERVERINFO Auxiliary Block Structure
	const AUX_SERVER_TYPE			= [
		'Unknown'					=> 0x00,		// Unknown server type.
		'Private'					=> 0x01,		// Client/server connection servicing private mailbox data.
		'Public'					=> 0x02,		// Client/server connection servicing public folder data.
		'Directory'					=> 0x03,		// Client/server connection servicing directory data.
		'Referral'					=> 0x04,		// Client/server connection servicing referrals.
	];

}
