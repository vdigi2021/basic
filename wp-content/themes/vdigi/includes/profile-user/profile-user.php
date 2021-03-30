<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/assets/css/bootstrap.css' ?>">



<?php

$user_id = get_current_user_id();

$author_vnkings = get_user_by('id', $user_id);

$author_id = $author_vnkings->ID;

$current_user = wp_get_current_user();

?>

<div class="panel panel-default">

    <div class="panel-heading">

        <h1 style="font-size:1.8rem; font-weight: 700; text-align: center; margin: 35px 0;">THÔNG TIN TÀI KHOẢN</h1>

    </div>

    <div class="info_author col-md-8">

        <table width="100%" border="1" class="style-table-author">

            <tr>

                <td>Họ Tên:</td>

                <td>

                    <strong>

                        <?php

                        $vnkings_name = the_author_meta('nickname', $author_id);

                        if (isset($vnkings_name)) {

                            echo $vnkings_name;

                        }

                        ?>

                    </strong>

                </td>

            </tr>

            <tr>

                <td>Website:</td>

                <td>

                    <a rel="nofollow" href="<?php the_author_meta('user_url', $author_id); ?>">

                        <strong><?php the_author_meta('user_url', $author_id); ?></strong>

                    </a>

                </td>

            </tr>

            <tr>

                <td>Facebook:</td>

                <td>

                    <a rel="nofollow" href="<?php the_author_meta('facebook', $author_id); ?>">

                        <strong><?php the_author_meta('facebook', $author_id); ?></strong>

                    </a>

                </td>

            </tr>

            <tr>

                <td>Google+:</td>

                <td>

                    <a rel="nofollow" href="<?php the_author_meta('instagram', $author_id); ?>">

                        <strong><?php the_author_meta('instagram', $author_id); ?></strong>

                    </a>

                </td>

            </tr>

            <tr>

                <td>Twitter:</td>

                <td>

                    <a rel="nofollow" href="<?php the_author_meta('twitter', $author_id); ?>">

                       <strong> <?php the_author_meta('twitter', $author_id); ?></strong>

                    </a>

                </td>

            </tr>

<!--            <tr>-->

<!--                <td>Chia sẻ về tôi</td>-->

<!--                <td>-->

<!--                    --><?php //the_author_meta('description', $author_id); ?>

<!--                </td>-->

<!--            </tr>-->

        </table>

    </div>

</div>



<style>

    .style-table-author{

        border: 1px solid #ebebeb;

        border-spacing: 1px;

        background: #fff;

        margin: 0 auto;

    }

    .style-table-author tr td{

        padding: 10px 15px;

    }

    .info_author{

        margin: 0 auto;

    }

</style>