<?php

/***************************************************************/
/* 
	SimplyHiredAPI - a Php class wrapper to access the SimplyHired API
	@author   Ronnie T. Dodger
	@url      http://webstractions.com
	@version  1.0 

	Software License Agreement (BSD License)

	Copyright (C) 2011, Webstractions Web Development.
	All rights reserved.
  
	Redistribution and use in source and binary forms, with or without
	modification, are permitted provided that the following conditions are met:

	 * Redistributions of source code must retain the above copyright
	   notice, this list of conditions and the following disclaimer.
	 * Redistributions in binary form must reproduce the above copyright
	   notice, this list of conditions and the following disclaimer in the
	   documentation and/or other materials provided with the distribution.
	 * Neither the name of Ronnie T. Dodger or Webstractions Web Development
	   may be used to endorse or promote products derived from this software 
	   without specific prior written permission of Edward Eliot.

	  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDER AND CONTRIBUTORS "AS IS" AND ANY
	  EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
	  WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
	  DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY
	  DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
	  (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
	  LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
	  ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
	  (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
	  SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

*/
/***************************************************************/
   

class SimplyHired_API {

	/* API Endpoint Uri */
	public $endpoint = 'http://api.simplyhired.com/a/jobs-api/xml-v2/';

	/* Publisher ID */
	public $pshid = '51735';
	
	/* Job-a-matic Url */
	public $jbd = 'eduportal.jobamatic.com';

	/* Client IP Address.  Needs to be captured and sent for each API call. */
	public $clip = '173.197.64.177';
	
	/* O*NET code to filter search results with */
	public $onet = '';
	
	/**/
	public $is_usa = '';
	
	/**/
	public $disable_tracking = false;

	/*
	 * API call variables for Query, Location, Page Number, Radius. 
	 *
	 */
	public $query    = '';
	public $location = '';
	public $pagenum  = 1;
	public $radius = 25;
	
	public $apicall  = '';
	public $results = '';
	
	function init( $pshid = false, $jbd = false ) {
		if( $pshid ){ 
			$this->pshid = $pshid;  	// Publisher ID assigned by SimplyHired
		}
		if( $jbd ) {
			$this->jbd = $jbd;		// Jobboard Url assigned by SimplyHired
		}
		$this->clip = $this->getClientIP();
        
	
	}

	function search( $number=100, $start=0 ) {
        
		if( isset($this->onet) )
			$onet_filter = 'onet:(' . $this->onet . ')+';
		//if( $this->is_usa ) 
			$ssty= '&ssty=2';
		//else 
		//	$ssty= '&ssty=3';		
		$apicall = $this->endpoint . 'q-'. $this->query . '/frag-' . 'false' .   '/l-' . $this->location . '/ws-' . $number . '/pn-' . $this->pagenum . '/sb-dd?pshid=' . $this->pshid .  $ssty . '&cflg=r&jbd=' . $this->jbd . '&clip=' . $this->clip;
		
		$this->apicall = $apicall;
        //echo $apicall;
		$xmlstr = @file_get_contents( $apicall );
        if( !$xmlstr == null ) 
			$xml = new SimpleXMLElement( $xmlstr );
		if( empty($xml) || $xml == null )
			return null;
		
		$this->results = $xml;
		return $xml;
	
	}
	
	function set_query( $query ) {
		$this->query = $query;
	}
	
	function set_onet( $code ) {
		$this->onet = $code;
	}

	function set_location( $location ) {
		$this->location = $location;
	}
	
	function set_is_usa( $bool ) {
		$this->is_usa = $bool;
	}

	function set_disable_tracking( $bool ) {
		$this->disable_tracking = $bool;
	}

	function get_disable_tracking() {
		return $this->disable_tracking;
	}

	function getClientIP() {
		$ip = '';
		if (getenv("HTTP_CLIENT_IP"))
		$ip = getenv("HTTP_CLIENT_IP");
		else if(getenv("HTTP_X_FORWARDED_FOR"))
		$ip = getenv("HTTP_X_FORWARDED_FOR");
		else if(getenv("REMOTE_ADDR"))
		$ip = getenv("REMOTE_ADDR");
		else
		$ip = "UNKNOWN";
		return $ip;
	} 
	
	function set_pagenum( $num ) {
		if ( $num > 1 ) {
			$this->pagenum = $num;
		}
	}
	
	/*
	 * Prints the Simply Hired attribution (per terms) to the screen
	 *
	 */
	 function print_attribution( $echo=true ) {
	 
		$output = '<div style="text-align: right;"><a style="text-decoration:none" href="http://www.simplyhired.com/" rel="nofollow"><span style="color: rgb(128, 128, 129);">Jobs</span></a> by <a style="text-decoration:none" href="http://www.simplyhired.com/"><span style="color: rgb(80, 209, 255); font-weight: bold;">Simply</span><span style="color: rgb(203, 244, 104); font-weight: bold;">Hired</span></a></div>';
		if ($echo)
			echo $output;
		else
			return $output;
	 }
	 
	 function get_footer_scripts() {
		$output = '
<!-- SimplyHired click tracking -->		
<script type="text/javascript" src="http://api.simplyhired.com/c/jobs-api/js/xml-v2.js"></script>
';
		return $output;
	 }
	 
	 function print_footer_scripts() {
		$output = '
<!-- SimplyHired click tracking -->		
<script type="text/javascript" src="http://api.simplyhired.com/c/jobs-api/js/xml-v2.js"></script>
';
		echo $output;
	 }
	 
	 function print_apicall( $echo=true ) {
	 
	 $html = '<span "apicall" style="float:right;"><a href="' . $this->apicall . '" target="_blank">View XML</a></span>';
	 
	 if ( $echo )
		echo $html; 
	 else 
		return $html; 

	}
	
	function print_results_totals( $echo=true ) {

		/* Total results display */
		$result_start = $this->results->rq->si + 1;
		$result_end = $this->results->rq->si + $this->results->rq->rpd;
		if( $result_end > $this->results->rq->tv )
			$result_end = $this->results->rq->tv;
		$result_num = $this->results->rq->tv;
		if( $result_num == '1000' ) {
			$result_num = 'over 1000 results';
		}
		else {
			$result_num .= ' total results';
		}
		
		$html = '<span "results-total">Displaying results ' . $result_start . '-' . $result_end . ' of ' . $result_num . '</span>';
		
		if ($echo)
			echo $html;
		else
			return $html;
	
	}
}

?>