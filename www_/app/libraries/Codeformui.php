<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Codeformui {
    protected $GP;
    protected $CI;
    private $db2 = "";
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->library('globals');
        $this->GP =  $this->CI->load->get_vars();
        $this->db2 = $this->CI->load->database('select', TRUE);
    }

    //코드 -> DB -> SELECTBOX
    function codeMakeSelect ($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $code_grp_id = element('code_grp_id', $args, '');
        $menu_id = element('menu_id', $args, '');
        $not_code = element('not_code', $args, '');

        if($code_grp_id) {

            $where_add = "";
            if($not_code == true) {
                $where_add .= " AND code_full_cd != '$not_code' ";
            }

            $qry = " 
                SELECT 
                    code_full_cd , 
                    code_name
                FROM TB_CODE_DETAIL
                WHERE  
                    code_grp_id = '$code_grp_id' AND use_yn = 'Y' $where_add
            ";

            $list = $this->db2->query($qry)->result_array();
            $select_arr = array();
            foreach ($list as $v) {
                $select_arr[$v['code_full_cd']]  = $v['code_name'];
            }
        } else if($menu_id) {
            $qry = " 
                SELECT 
                    menu_id , 
                    menu_name
                FROM TB_ADMIN_MENU
                WHERE  
                    lvl = '1' 
            ";

            $list = $this->db2->query($qry)->result_array();
            $select_arr = array();
            foreach ($list as $v) {
                $select_arr[$v['menu_id']]  = $v['menu_name'];
            }
        }

        $add_str = isset($add_str) ? $add_str : '';
        $etc = isset($etc) ? $etc : '';
        $sort = isset($sort) ? $sort : '';
        $arr_type = isset($arr_type) ? $arr_type : '';

        if (isset($view_model)) {
            $add_str = " v-model=\"$view_model\" ";
        }
        if (isset($etc)) {
            $etc = $etc;
        }

        $str = "<select $add_str $etc>";
        if (isset($basic)) {
            $str .= "<option value=''>$basic</option>";
        }

        if (count($select_arr) && is_array($select_arr)) {
            if ($sort != 'none_sort') {
                asort($select_arr);
            }

            foreach ($select_arr as $key => $value) {
                $option_value = "";
                $option_name = "";
                $option_value = ($arr_type == 'by_value')? $value : $key;
                $option_name = ($value)? $value : $key;
                $selected = "";
                //if($vals != '' && $vals == $option_value && isset($vals)) $selected = "selected";
                $str .= "<option value='$option_value' $selected>$option_name</option>";
            }

        }
        $str .= "</select>";

        return $str;
    }

    //코드 -> DB -> codeYnSelect
    function codeYnSelect ($args = array()) {
        if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

        $s_type = isset($s_type) ? $s_type : "";
        if($s_type == "") {
            $select_arr = array("Y"=>"사용", "N"=>"미사용");
        } else if($s_type == "permission") {
            $select_arr = array("미설정"=>"","Y"=>"Y", "N"=>"N");
            $etc = isset($etc) ? $etc : "class='form-control td_select'";
        }

        $add_str = isset($add_str) ? $add_str : '';
        $etc = isset($etc) ? $etc : "";
        $sort = isset($sort) ? $sort : '';
        $arr_type = isset($arr_type) ? $arr_type : '';
        if (isset($view_model)) $add_str = " v-model=\"$view_model\" ";
        if (isset($etc)) $etc = $etc;
        $str = "<select $add_str $etc>";
        if (isset($basic)) $str .= "<option value=''>$basic</option>";
        if (count($select_arr) && is_array($select_arr)) {
            if ($sort != 'none_sort') {
                asort($select_arr);
            }
            foreach ($select_arr as $key => $value) {
                $option_value = "";
                $option_name = "";
                $option_value = ($arr_type == 'by_value')? $value : $key;
                $option_name = ($value)? $value : $key;
                $selected = "";
                //if($vals != '' && $vals == $option_value && isset($vals)) $selected = "selected";
                $str .= "<option value='$option_value' $selected>$option_name</option>";
            }
        }
        $str .= "</select>";

        return $str;
    }


    //코드 -> DB -> codeYnSelect
    function codeOption ($type) {
        if($type == "YN") {
            $select_arr = array("Y"=>"Y", "N"=>"N");
        }
        $str = "";
        if (count($select_arr) && is_array($select_arr)) {
            $sort = isset($sort) ? $sort : '';
            if ($sort != 'none_sort') {
                asort($select_arr);
            }
            foreach ($select_arr as $key => $value) {
                $arr_type = isset($arr_type) ? $arr_type : '';
                $option_value = ($arr_type == 'by_value')? $value : $key;
                $option_name = ($value)? $value : $key;
                $str .= "<option value='$option_value'>$option_name</option>";
            }
        }
        return $str;
    }

}