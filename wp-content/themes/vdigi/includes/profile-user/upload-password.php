<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/assets/css/bootstrap.css' ?>">

<div class="panel panel-default width-upload-pass">

    <div class="container pl-0">

        <div class="panel-heading">

            <h1 style="font-size:1.8rem; font-weight: 700; margin: 70px 0 25px; " class="text-center text-uppercase">Cập nhật mật khẩu</h1>

        </div>

        <div class="panel-body">

            <?php

            $user_id = get_current_user_id();

            $author_vnkings = get_user_by('id', $user_id);

            $author_id = $author_vnkings->ID;

            $current_user = wp_get_current_user();

            if ($user_id == $author_id) {

                if (isset($_POST['user_profile_nonce_field']) && wp_verify_nonce($_POST['user_profile_nonce_field'], 'user_profile_nonce')) {

                    if ($_POST['pass1'] == null || $_POST['pass2'] == null) {

                        echo $error[] = '<div class="bg-danger text-white alert">'.__('Vui lòng không bỏ trống những thông tin bắt buộc!', 'profile').'</div>';

                    } elseif ($_POST['pass1'] <> $_POST['pass2']) {

                        echo $error[] = '<div class="bg-danger text-white alert">'. __('2 mật khẩu không giống nhau!.').'</div>';

                    } else {

                        if ($_POST['pass1'] == $_POST['pass2']) {

                            ob_start();

                            wp_update_user(array('ID' => $current_user->ID, 'user_pass' => esc_attr($_POST['pass1'])));

                            echo '<div class="alert alert-success">Cập nhật mật khẩu thành công, Vui lòng <a href="'.home_url('wp-admin').'">đăng nhập</a> lại !</div>';

                            ob_end_flush();

                        }

                    }

                }

                ?>

                <form role="form" action="" id="user_profile" method="POST">

                    <?php wp_nonce_field('user_profile_nonce', 'user_profile_nonce_field'); ?>

                    <div class="row">

                        <div class="form-group col-md-12">

                            <label for="pass1">Mật khẩu</label>

                            <input type="password" class="form-control" id="pass1" name="pass1" placeholder="mật khẩu">

                        </div>

                        <div class="form-group col-md-12">

                            <label for="pass2">Nhập lại mật khẩu</label>

                            <input type="password" class="form-control" id="pass2" name="pass2"

                                   placeholder="Nhập lại mật khẩu">

                        </div>

                        <div class="form-group col-md-12">

                            <button type="submit" class="btn btn-success">Cập nhật</button>

                        </div>

                    </div>

                </form>

            <?php } ?>

        </div>

    </div>

</div>



<style>

    .width-upload-pass {

        width: 50%;

        margin: 0 auto;

    }

</style>