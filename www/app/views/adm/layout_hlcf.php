<!DOCTYPE html>
<html lang="en">
<?php $this->load->view( 'adm/common/head', $this->data ); ?>
<body>
<?php $this->load->view( 'adm/common/header', $this->data ); ?>

<!-- Page content -->
<div class="page-content">

    <!-- Main sidebar -->
    <div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">

        <!-- Sidebar content -->
        <div class="sidebar-content">

            <!-- User menu -->
            <?php $this->load->view( 'adm/common/left_top', $this->data ); ?>
            <!-- /user menu -->

            <!-- Main navigation -->
            <div class="sidebar-section">
                <?php
                $this->load->view( 'adm/common/left_menu', $this->data );
                ?>
            </div>
            <!-- /main navigation -->

        </div>
        <!-- /sidebar content -->

    </div>
    <!-- /main sidebar -->


    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Inner content -->
        <div class="content-inner">

            <!-- Page header -->
            <div class="page-header">
                <div class="page-header-content header-elements-lg-inline">
                    <div class="page-title d-flex">
                        <h4><i class="icon-arrow-right6 mr-2"></i> <span class="font-weight-semibold"><?=$title?></span></h4>
                        <!--<a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>-->
                    </div>

                    <!--<div class="header-elements d-none mb-3 mb-lg-0">
                        <div class="d-flex justify-content-center">
                            <a href="#" class="btn btn-link btn-float text-body"><i class="icon-bars-alt"></i><span>Statistics</span></a>
                            <a href="#" class="btn btn-link btn-float text-body"><i class="icon-calculator"></i> <span>Invoices</span></a>
                            <a href="#" class="btn btn-link btn-float text-body"><i class="icon-calendar5"></i> <span>Schedule</span></a>
                        </div>
                    </div>-->
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content pt-0">

                <div class="mb-3">
                    <h6 class="mb-0 font-weight-semibold">
                        <?=$sub_title?>
                    </h6>
                </div>

                <?php
                /** @noinspection PhpUndefinedVariableInspection */
                $this->load->view( $main_content, $this->data );
                ?>

            </div>
            <!-- /content area -->

            <?php $this->load->view( 'adm/common/foot', $this->data ); ?>

        </div>
        <!-- /inner content -->

    </div>
    <!-- /main content -->

</div>
<!-- /page content -->

<?php
print(isset($ADD_SCRIPT) ? $ADD_SCRIPT : "");
print(isset($ADD_CSS) ? $ADD_CSS : "");
?>
<?php print(isset($this->buffer_script) ? $this->buffer_script : '');?>
</body>
</html>