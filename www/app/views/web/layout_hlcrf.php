<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view( 'web/common/head', $this->data ); ?>
    <script src="/resource/custom/js/common.js"></script>
</head>
<body>
<div>
    <div class="site-container">
        <?php $this->load->view( 'web/common/header', $this->data ); ?>
        <!-- Main -->
        <?php $this->load->view( $main_content, $this->data ); ?>
        <!-- Main -->
        <!-- FOOTER -->
        <?php $this->load->view( 'web/common/footer', $this->data ); ?>
        <!-- FOOTER -->
    </div>
    <a href="#top" class="scroll-top animated-element template-arrow-vertical-3" title="Scroll to top"></a>
    <div class="background-overlay"></div>
</div>


<!--js-->
<script type="text/javascript" src="/web/assets/js/jquery-3.6.0.min.js"></script>
<!--slider revolution-->
<script type="text/javascript" src="/web/assets/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
<script type="text/javascript" src="/web/assets/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
<script type="text/javascript" src="/web/assets/js/jquery.ba-bbq.min.js"></script>
<script type="text/javascript" src="/web/assets/js/jquery-ui-1.12.1.custom.min.js"></script>
<script type="text/javascript" src="/web/assets/js/jquery.ui.touch-punch.min.js"></script>
<script type="text/javascript" src="/web/assets/js/jquery.isotope.min.js"></script>
<script type="text/javascript" src="/web/assets/js/jquery.easing.1.4.1.min.js"></script>
<script type="text/javascript" src="/web/assets/js/jquery.carouFredSel-6.2.1-packed.js"></script>
<script type="text/javascript" src="/web/assets/js/jquery.touchSwipe.min.js"></script>
<script type="text/javascript" src="/web/assets/js/jquery.transit.min.js"></script>
<script type="text/javascript" src="/web/assets/js/jquery.timeago.js"></script>
<script type="text/javascript" src="/web/assets/js/jquery.hint.min.js"></script>
<script type="text/javascript" src="/web/assets/js/jquery.costCalculator.min.js"></script>
<script type="text/javascript" src="/web/assets/js/jquery.parallax.min.js"></script>
<script type="text/javascript" src="/web/assets/js/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="/web/assets/js/jquery.qtip.min.js"></script>
<script type="text/javascript" src="/web/assets/js/jquery.blockUI.min.js"></script>
<script type="text/javascript" src="/web/assets/js/jquery.imagesloaded-packed.js"></script>
<script type="text/javascript" src="/web/assets/js/main.js"></script>
<script type="text/javascript" src="/web/assets/js/odometer.min.js"></script>

<?php
    $script_str = "";
    if (isset($JS_MODULE) && is_array($JS_MODULE)) {
        /*
        if (in_array('validate', $JS_MODULE)) {
            $script_str .= '<script src="/resource/global_assets/js/plugins/forms/validation/validate.min.js"></script>' . PHP_EOL;
        }
        if (in_array('datepicker', $JS_MODULE)) {
            $script_str .= '<script src="'.WEB_RES.'/vendor/jquery/jquery-ui.js"></script>' . PHP_EOL;
            $script_str .= '<link rel="stylesheet" href="'.WEB_RES.'/vendor/jquery/jquery-ui.css">' . PHP_EOL;
            $script_str .= '<script src="'.WEB_RES.'/vendor/jquery/jquery.ko.js"></script>' . PHP_EOL;
        }
        print($script_str);
        */
    }
?>


<?php print(isset($this->buffer_script) ? $this->buffer_script : '');?>
</body>
</html>