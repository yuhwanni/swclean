<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );
/**
 * Class Member
 *
 * @property Member_mcb $member_mcb
 */
class Editor extends FW_Controller
{

    public $GP = "";

    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('url', 'security', 'common'));
        $this->load->library(array('globals', 'func'));
        $this->GP = $this->load->get_vars();

        $this->post = $this->security->xss_clean($this->input->post());
        $this->get = $this->security->xss_clean($this->input->get());

        $this->data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
    }

    public function _remap($method)
    {
        if (method_exists($this, $method)) {
            $this->{$method}();
        } else {
            $this->index();
        }
    }


    public function index()
    {
        $this->func->putMsgAndBack('찾으시는 페이지가  존재하지 않습니다.');
    }

    public function editor_photo_insert()
    {
        $url = $_REQUEST["callback"] . '?callback_func=' . $_REQUEST["callback_func"];
        $cd = $_REQUEST['b_code'];

        $bSuccessUpload = is_uploaded_file($_FILES['Filedata']['tmp_name']);

        if ($bSuccessUpload) {

            if($cd == "popup") {
                $upload_path = $this->GP['POPUP_IMG_DIR'];
                $upload_url = $this->GP['POPUP_IMG_URL'];
            }else {
                $upload_path = $this->GP['EDIT_UPLOAD_DIR'] . $cd . "/";
                $upload_url = $this->GP['EDIT_UPLOAD_URL'] . $cd . "/";
            }

            //파일업로드 옵션 (이미지)
            $config = array(
                'upload_path' => $upload_path,
                'overwrite' => TRUE,
                'allowed_types' => 'gif|jpg|png|jpeg',
                'encrypt_name' => TRUE,
                'remove_spaces' => TRUE,
            );


            if ($_FILES['Filedata']['name']) {
                //파일업로드 시작
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload("Filedata")) {
                    $error = array('error' => $this->upload->display_errors());
                    $url .= '&errstr=' . $error['error'];
                } else {
                    $uploadRst = $this->upload->data();

                    $sFileName = urlencode(urlencode($uploadRst['file_name']));
                    $sFileURL = $upload_url . urlencode(urlencode($uploadRst['file_name']));

                    $url .= "&bNewLine=true";
                    $url .= "&sFileName=" . $sFileName;
                    $url .= "&sFileURL=" . $sFileURL;
                    $url .= "&sFileAlt=" . urldecode($_REQUEST['FiledataAlt']);
                }
            }
        } else {
            $url .= '&errstr=error';
        }

        header('Location: ' . $url);
    }
}