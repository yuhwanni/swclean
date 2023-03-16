<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view( 'web/common/head', $this->data ); ?>
    <script src="/resource/custom/js/common.js"></script>
</head>

<body>
<div class="body <?=FOLDER?>">

    <?php $this->load->view( 'web/common/header', $this->data ); ?>

    <!-- Main -->
    <?php $this->load->view( $main_content, $this->data ); ?>
    <!-- Main -->

    <!-- FOOTER -->
    <?php $this->load->view( 'web/common/footer', $this->data ); ?>
    <!-- FOOTER -->
</div>


<!-- Vendor -->
<script src="/web/vendor/jquery/jquery.min.js"></script>
<script src="/web/vendor/jquery.appear/jquery.appear.min.js"></script>
<script src="/web/vendor/jquery.easing/jquery.easing.min.js"></script>
<script src="/web/vendor/jquery.cookie/jquery.cookie.min.js"></script>
<script src="/web/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/web/vendor/jquery.validation/jquery.validate.min.js"></script>
<script src="/web/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
<script src="/web/vendor/jquery.gmap/jquery.gmap.min.js"></script>
<script src="/web/vendor/lazysizes/lazysizes.min.js"></script>
<script src="/web/vendor/isotope/jquery.isotope.min.js"></script>
<script src="/web/vendor/owl.carousel/owl.carousel.min.js"></script>
<script src="/web/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="/web/vendor/vide/jquery.vide.min.js"></script>
<script src="/web/vendor/vivus/vivus.min.js"></script>
<script src="/web/vendor/kute/kute.min.js"></script>

<!-- Theme Base, Components and Settings -->
<script src="/web/assets/js/theme.js"></script>

<!-- Demo -->
<script src="/web/assets/js/auto-services.js"></script>

<!-- Theme Custom -->
<script src="/web/assets/js/custom.js"></script>

<!-- Theme Initialization Files -->
<script src="/web/assets/js/theme.init.js"></script>

<!-- Theme Custom -->
<script src="/web/assets/js/custom.js"></script>
<script src="/resource/global_assets/js/plugins/notifications/bootbox.min.js"></script>

<?php
$script_str = "";
if (isset($JS_MODULE) && is_array($JS_MODULE)) {

    if (in_array('validate', $JS_MODULE)) {
        $script_str .= '<script src="/resource/global_assets/js/plugins/forms/validation/validate.min.js"></script>' . PHP_EOL;
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


<?php print(isset($this->buffer_script) ? $this->buffer_script : '');?>
</body>
</html>