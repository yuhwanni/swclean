<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );


/**
 * Class Ads
 *
 * @property
 */
class Main extends FW_Controller
{

    public $GP = "";

    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('url', 'security', 'common'));
        $this->load->library('globals');
        $this->load->library('func');
        $this->GP = $this->load->get_vars();

        $this->post = $this->security->xss_clean($this->input->post());
        $this->get = $this->security->xss_clean($this->input->get());

        $this->data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
    }

    function _remap($method)
    {
        if(method_exists($this, $method))
        {
            $this->{$method}();
        }
        else
        {
            $this->index();
        }
    }

    function index() {
        redirect("/web/kor");
    }
}