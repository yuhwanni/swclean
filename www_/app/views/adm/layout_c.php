<!DOCTYPE html>
<html lang="en">
<?php $this->load->view( 'adm/common/head', $this->data ); ?>
<body>

<!-- Page content -->
<div class="page-content">

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Inner content -->
        <div class="content-inner">


            <!-- Content area -->
            <div class="content d-flex justify-content-center align-items-center">

                <?php
                /** @noinspection PhpUndefinedVariableInspection */
                $this->load->view( $main_content, $this->data );
                ?>

            </div>
            <!-- /content area -->


        </div>
        <!-- /inner content -->

    </div>
    <!-- /main content -->

</div>
<!-- /page content -->

</body>

</html>