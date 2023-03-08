<!-- Footer -->
<div class="navbar navbar-expand-lg navbar-light">
    <div class="text-center d-lg-none w-100">
        <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
            <i class="icon-unfold mr-2"></i>
            Footer
        </button>
    </div>

    <div class="navbar-collapse collapse" id="navbar-footer">
        <span class="navbar-text">© 2021. <a href="#">PIXEL</a><a href="#;" target="_blank">CAST</a></span>
        <!--<ul class="navbar-nav ml-lg-auto">
            <li class="nav-item"><a href="https://kopyov.ticksy.com/" class="navbar-nav-link" target="_blank"><i class="icon-lifebuoy mr-2"></i> Support</a></li>
            <li class="nav-item"><a href="https://demo.interface.club/limitless/docs/" class="navbar-nav-link" target="_blank"><i class="icon-file-text2 mr-2"></i> Docs</a></li>
            <li class="nav-item"><a href="https://themeforest.net/item/limitless-responsive-web-application-kit/13080328?ref=kopyov" class="navbar-nav-link font-weight-semibold"><span class="text-pink"><i class="icon-cart2 mr-2"></i> Purchase</span></a></li>
        </ul>-->
    </div>
</div>
<!-- /footer -->

<div class="modal fade" id="modalBin" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modalBinM" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lgm">
        <div class="modal-content">

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modalBinLg" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="modalBinDefault" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="loading_dimmer">
    <div class="lds-css ng-scope">
        <div style="width:100%;height:100%" class="lds-wedges">
            <div>
                <div>
                    <div></div>
                </div>
                <div>
                    <div></div>
                </div>
                <div>
                    <div></div>
                </div>
                <div>
                    <div></div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
$script_str = "";
if (isset($JS_MODULE) && is_array($JS_MODULE)) {
    if (in_array('select2', $JS_MODULE)) {
        $script_str .= '<script src="/resource/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>' . PHP_EOL;
        $script_str .= '<script src="/resource/global_assets/js/plugins/forms/selects/select2.min.js"></script>' . PHP_EOL;
        $script_str .= '<script type="text/javascript">';
        $script_str .= '$(document).ready(function() { ' . PHP_EOL;
        $script_str .= '$(".select2").select2({ minimumResultsForSearch: Infinity});' . PHP_EOL;
        $script_str .= '});' . PHP_EOL;
        $script_str .= '</script>' . PHP_EOL;
    }

    if (in_array('datepicker', $JS_MODULE)) {
        $script_str .= '<script src="/resource/global_assets/js/plugins/ui/moment/moment.min.js"></script>' . PHP_EOL;
        $script_str .= '<script src="/resource/global_assets/js/plugins/ui/moment/moment_locales.min.js"></script>' . PHP_EOL;
        $script_str .= '<script src="/resource/global_assets/js/plugins/pickers/daterangepicker.js"></script>' . PHP_EOL;
        $script_str .= '<script src="/resource/custom/js/datepicker.js"></script>' . PHP_EOL;
    }

    if (in_array('validate', $JS_MODULE)) {
        $script_str .= '<script src="/resource/global_assets/js/plugins/forms/validation/validate.min.js"></script>' . PHP_EOL;
    }

    if (in_array('base64', $JS_MODULE)) {
        $script_str .= '<script src="/resource/global_assets/js/plugins/base64/jquery.base64.js"></script>' . PHP_EOL;
    }

    if (in_array('blockui', $JS_MODULE)) {
        $script_str .= '<script src="/resource/global_assets/js/plugins/loaders/blockui.min.js"></script>' . PHP_EOL;
    }
    echo $script_str;
}
?>

<script>

</script>
