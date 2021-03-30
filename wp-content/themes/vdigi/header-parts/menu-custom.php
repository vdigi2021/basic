<div class="menu-main">
    <ul id="menu-1" class="nav">
        <?php
        $menuLocations = get_nav_menu_locations();
        $menuID = $menuLocations['menu-1'];
        $primaryNav = wp_get_nav_menu_items($menuID);
        $id_parent = 0;
        foreach ($primaryNav as $navItem) {
            if ($navItem->menu_item_parent == $id_parent) {
                echo '<li class="menu-item-' . $navItem->ID . '"> <a href="' . $navItem->url . '"><img src=" ' . get_field('icon_menu', $navItem)['url'] . ' " alt="' . get_field('icon_menu', $navItem)['alt'] . '"><p>' . $navItem->title . '</p></a>';
                $sub = "";
                foreach ($primaryNav as $navItem2) {
                    if ($navItem2->menu_item_parent == $navItem->ID) {
                        $sub .= '<li class="menu-item-' . $navItem2->ID . '"> <a href="' . $navItem2->url . '">' . $navItem2->title . '</a>';
                        $sub2 = "";
                        foreach ($primaryNav as $navItem3) {
                            if ($navItem3->menu_item_parent == $navItem2->ID) {
                                $sub2 .= '<li class="menu-item-' . $navItem3->ID . '"> <a href="' . $navItem3->url . '">' . $navItem3->title . '</a></li>';
                            }
                        }
                        $sub2 ? $sub .= '<ul class="sub-2">' . $sub2 . '</ul>' : '';
                        $sub .= '</li>';
                    }
                }
                echo $sub ? '<ul class="sub-1">' . $sub . '</ul>' : '';
                echo '</li>';
            }
        }
        ?>
    </ul>
</div>