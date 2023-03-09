<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: dongsoo
 * Date: 2017. 7. 21.
 * Time: PM 12:07
 */
class CouchBase
{
    private $CI;
    protected $GP;
    protected $bucket;

    function __construct($type = '')
    {
        $this->CI =& get_instance();
        $this->CI->load->helper(array('array', 'string'));
        $this->CI->load->library('func','globals');
        $this->GP = $this->CI->load->get_vars();

        switch ($type) {
            case 'installed' :
                $bucketName = $this->GP['COUCHBASE_BUCKET']['installed'];
                break;

            case 'view' :
                $bucketName = $this->GP['COUCHBASE_BUCKET']['view'];
                break;

            case 'click' :
                $bucketName = $this->GP['COUCHBASE_BUCKET']['click'];
                break;

            case 'callback' :
                $bucketName = $this->GP['COUCHBASE_BUCKET']['callback'];
                break;

            case 'event' :
                $bucketName = $this->GP['COUCHBASE_BUCKET']['event'];
                break;
            default :
                $bucketName = $this->GP['COUCHBASE_BUCKET']['click'];
                break;
        }

        $id = $this->GP['COUCHBASE_INIT']['id'];
        $pwd = $this->GP['COUCHBASE_INIT']['password'];
        $host = "couchbase://" . $this->GP['COUCHBASE_INIT']['host'];

        // Establish username and password for bucket-access
        $authenticator = new \Couchbase\PasswordAuthenticator();
        $authenticator->username($id)->password($pwd);

        // Connect to Couchbase Server
        $cluster = new CouchbaseCluster($host);

        if (isset($cluster) && !empty($cluster)) {
            // Authenticate, then open bucket
            $cluster->authenticate($authenticator);
            $this->bucket = $cluster->openBucket($bucketName);

        }
    }

    // DESC :
    // DATE : Thu Jun 23 07:29:48 GMT 2016
    // PARAM : id
    function get ($id) {
        try {
            $val = $this->bucket -> get($id) -> value;
        } catch(CouchbaseException $e) {
//			die(json_encode(array('rst' => 'E10', 'err' => 'CouchBase No exist key')));
            return "";
        }

        return json_decode((($val) ? $val : false),true);
    }

    // DESC :
    // DATE : Thu Jun 23 07:29:48 GMT 2016
    // PARAM : id, data, option (expiry, flags)
    function set ($id, $data, $option = array()) {
        return (!$this->bucket -> upsert($id, json_encode($data), $option) -> value) ? true : false;
    }

    // DESC :
    // DATE : Thu Jun 23 07:29:48 GMT 2016
    // PARAM : id, option
    function delete ($id, $option = array()) {
        return (!$this->bucket -> remove($id, $option) -> value) ? true : false;
    }

    // DESC :
    // DATE : Thu Jun 23 09:01:43 GMT 2016
    // PARAM : $qry
    function sendQry ($qry) {
        $query = CouchbaseN1qlQuery::fromString($qry);

        $result = $this->bucket -> query($query);
        $data = json_decode(json_encode($result->rows), True);
        //$data = json_decode(json_encode($result), True);
        return $data;
    }

    // DESC :
    // DATE : Thu Jun 23 09:01:43 GMT 2016
    // PARAM : $qry
    function sendViewQry ($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $query = CouchbaseViewQuery::from($design, $view);

        if ( isset($skip) && $skip >= 0 ){
            $query = $query->skip( $skip );
        }

        if ( isset($limit) && $limit >= 0 ) {
            $query = $query->limit( $limit );
        }

        if( isset($skey) && isset($ekey)) {
            $query = $query -> range($skey,$ekey,true);
        }

        if( isset($key) ) {
            $query = $query->key($key);
        }

        if( isset($group_level) ) {
            $query = $query->group_level($group_level);
        }

        if( isset($group) ) {
            $query = $query->group($group);
        }


        if( isset($reduce) && $reduce > 0 ) {
            $query = $query->reduce(true);
        }else{
            $query = $query->reduce(false);
        }

        $result = $this -> bucket -> query($query);
        $data = json_decode(json_encode($result->rows), True);

        if(!array_key_exists('0', $data)){
            return 0;
        }else {
            return $data;
        }
    }



}