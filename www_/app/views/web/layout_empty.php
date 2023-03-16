<!DOCTYPE html>
<html lang="ko">
<head>
    <?php $this->load->view( 'web/common/head', $this->data ); ?>
</head>
<body class="<?=!isset($body_class) || empty($body_class) ? "home" : "" ?> market <?=isset($main_stype) ? $main_stype : 'dap1'?>">
<div class="page-wrapper">

    <!-- Main -->
    <?php $this->load->view( $main_content, $this->data ); ?>
    <!-- Main -->

</div>



<!-- Plugins JS File -->
<script src="<?=WEB_RES?>/vendor/jquery/jquery.min.js"></script>
<script src="<?=WEB_RES?>/vendor/sticky/sticky.min.js"></script>
<script src="<?=WEB_RES?>/vendor/jquery.plugin/jquery.plugin.min.js"></script>

<script src="<?=WEB_RES?>/vendor/parallax/parallax.min.js"></script>
<script src="<?=WEB_RES?>/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="<?=WEB_RES?>/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="<?=WEB_RES?>/vendor/owl-carousel/owl.carousel.min.js"></script>
<script src="<?=WEB_RES?>/vendor/isotope/isotope.pkgd.min.js"></script>

<script src="<?=WEB_RES?>/vendor/elevatezoom/jquery.elevatezoom.min.js"></script>
<script src="<?=WEB_RES?>/vendor/jquery.countdown/jquery.countdown.min.js"></script>

<!-- Main JS File -->
<script src="<?=WEB_RES?>/js/main.js"></script>
<script src="<?=WEB_RES?>/js/dap_common.js"></script>

<!-- Add plugin -->
<link rel="stylesheet" href="<?=WEB_RES?>/vendor/jquery.alert/jquery.alert.css">
<script src="<?=WEB_RES?>/vendor/jquery.alert/jquery.alert.js"></script>
<script src="<?=WEB_RES?>/vendor/cookie.js"></script>

<?php
print(isset($ADD_SCRIPT) ? $ADD_SCRIPT : "");
print(isset($ADD_CSS) ? $ADD_CSS : "");

$script_str = "";
if (isset($JS_MODULE) && is_array($JS_MODULE)) {
    /*if (in_array('select2', $JS_MODULE)) {
        $script_str .= '<script src="/resource/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>' . PHP_EOL;
        $script_str .= '<script src="/resource/global_assets/js/plugins/forms/selects/select2.min.js"></script>' . PHP_EOL;
        $script_str .= '<script type="text/javascript">';
        $script_str .= '$(document).ready(function() { ' . PHP_EOL;
        $script_str .= '$(".select2").select2({ minimumResultsForSearch: Infinity});' . PHP_EOL;
        $script_str .= '});' . PHP_EOL;
        $script_str .= '</script>' . PHP_EOL;
    }*/

    if (in_array('Eng', $JS_MODULE)) {
        $script_str .= '<script src="'.WEB_RES.'/js/home/home.js"></script>' . PHP_EOL;
    }

    if (in_array('validate', $JS_MODULE)) {
        $script_str .= '<script src="/resource/global_assets/js/plugins/forms/validation/validate.min.js"></script>' . PHP_EOL;
    }

    if (in_array('join_member', $JS_MODULE)) {
        $script_str .= '<script src="'.WEB_RES.'/js/join/join_member.js"></script>' . PHP_EOL;
    }

    if (in_array('login', $JS_MODULE)) {
        $script_str .= '<script src="'.WEB_RES.'/js/login/login.js"></script>' . PHP_EOL;
    }

    if (in_array('mypage', $JS_MODULE)) {
        $script_str .= '<script src="'.WEB_RES.'/js/mypage/mypage.js"></script>' . PHP_EOL;
    }

    if (in_array('auction', $JS_MODULE)) {
        $script_str .= '<script src="'.WEB_RES.'/js/auction/auction.js"></script>' . PHP_EOL;
    }

    if (in_array('number', $JS_MODULE)) {
        $script_str .= '<script src="'.WEB_RES.'/js/jquery.number.js"></script>' . PHP_EOL;
    }

    if (in_array('datepicker', $JS_MODULE)) {
        $script_str .= '<script src="'.WEB_RES.'/vendor/jquery/jquery-ui.js"></script>' . PHP_EOL;
        $script_str .= '<link rel="stylesheet" href="'.WEB_RES.'/vendor/jquery/jquery-ui.css">' . PHP_EOL;
        $script_str .= '<script src="'.WEB_RES.'/vendor/jquery/jquery.ko.js"></script>' . PHP_EOL;
    }

    print($script_str);
}
?>

<?
if (isset($JS_MODULE) && is_array($JS_MODULE)) {
    if (in_array('photoswipe', $JS_MODULE)) {
        ?>
        <script src="<?=WEB_RES?>/vendor/photoswipe/photoswipe.min.js"></script>
        <script src="<?=WEB_RES?>/vendor/photoswipe/photoswipe-ui-default.min.js"></script>
        <?
    }
}
?>

<?php print(isset($this->buffer_script) ? $this->buffer_script : '');?>
</body>
</html>