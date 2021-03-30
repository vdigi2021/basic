<?php ob_start(); ?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/assets/css/bootstrap.css' ?>">

<div class="panel panel-default">

    <div class="container pl-0">

        <div class="panel-heading">

            <h1 style="font-size:1.8rem; font-weight: 700; margin: 70px 0 25px; " class="text-uppercase text-center">Chỉnh sửa thông tin</h1>

        </div>

        <div class="panel-body">

            <?php

            $user_id    = get_current_user_id();

            $author_vnkings = get_user_by( 'id', $user_id );

            $author_id = $author_vnkings->ID;

            $current_user = wp_get_current_user();

            if($user_id == $author_id) { ?>

                <?php

                if( isset( $_POST['user_profile_nonce_field'] ) && wp_verify_nonce( $_POST['user_profile_nonce_field'], 'user_profile_nonce' ) ) {

                    if ( !empty( $_POST['user_url'] ) ){

                        wp_update_user( array( 'ID' => $current_user->ID, 'user_url' => esc_url( $_POST['user_url'] ) ) );

                    }

                    if ( !empty( $_POST['nickname'] ) ) {

                        update_user_meta( $current_user->ID, 'nickname', esc_attr( $_POST['nickname'] ) ); }

                    if ( !empty( $_POST['twitter'] ) ) {

                        update_user_meta( $current_user->ID, 'twitter', esc_attr( $_POST['twitter'] ) ); }

                    if ( !empty( $_POST['googleplus'] ) ) {

                        update_user_meta( $current_user->ID, 'googleplus', esc_attr( $_POST['googleplus'] ) ); }

                    if ( !empty( $_POST['facebook'] ) ) {

                        update_user_meta( $current_user->ID, 'facebook', esc_attr( $_POST['facebook'] ) ); }

                    if ( !empty( $_POST['description'] ) ){

                        update_user_meta( $current_user->ID, 'description', esc_attr( $_POST['description'] ) ); }

                    echo '<div class="alert alert-success"><strong>Bạn đã sửa thông tin cá nhân thành công!</strong></div>';

                }

                ?>

                <form role="form" action="" id="user_profile" method="POST">

                    <?php wp_nonce_field('user_profile_nonce', 'user_profile_nonce_field'); ?>

                    <div class="row">

                        <div class="form-group col-md-6">

                            <label for="nickname">Họ Tên</label>

                            <input type="text" class="form-control" id="nickname" name="nickname" placeholder="Họ Tên" value="<?php the_author_meta( 'nickname', $author_id ); ?>">

                        </div>

                        <div class="form-group col-md-6">

                            <label for="email">Email</label>

                            <input disabled type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?php the_author_meta( 'user_email', $author_id ); ?>">

                        </div>

                        <div class="form-group col-md-6">

                            <label for="user_url">Website</label>

                            <input type="text" class="form-control" id="user_url" name="user_url" placeholder="Website của bạn" value="<?php the_author_meta( 'user_url', $author_id ); ?>">

                        </div>

                        <div class="form-group col-md-6">

                            <label for="facebook">Facebook</label>

                            <input type="text" class="form-control" id="facebook" name="facebook" placeholder="Facebook của bạn" value="<?php the_author_meta( 'facebook', $author_id ); ?>">

                        </div>

                        <div class="form-group col-md-6">

                            <label for="instagram">Instagram</label>

                            <input type="text" class="form-control" id="instagram" name="instagram" placeholder="Instagram của bạn" value="<?php the_author_meta( 'instagram', $author_id ); ?>">

                        </div>

                        <div class="form-group col-md-6">

                            <label for="twitter">Twitter</label>

                            <input type="text" class="form-control" id="twitter" name="twitter" placeholder="Twitter của bạn" value="<?php the_author_meta( 'twitter', $author_id ); ?>">

                        </div>

                        <div class="form-group col-md-12"><button type="submit" class="btn btn-success">Cập nhật</button></div>

                    </div>

                </form>

            <?php } ?>

        </div>

    </div>

</div>



<?php ob_end_flush(); ?>

