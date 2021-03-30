<script src="<?php echo get_template_directory_uri() . '/assets/js/slider/jssor.slider.min.js' ?>"></script>
<script type="text/javascript">
    jssor_1_slider_init = function () {

        var jssor_1_SlideshowTransitions = [
            {$Duration:500,$Delay:30,$Cols:8,$Rows:4,$Clip:15,$SlideOut:false,$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Assembly:2049,$Easing:$Jease$.$OutQuad},
            {$Duration:500,$Delay:80,$Cols:8,$Rows:4,$Clip:15,$SlideOut:false,$Easing:$Jease$.$OutQuad},
            {$Duration:1000,x:-0.2,$Delay:40,$Cols:12,$SlideOut:false,$Formation:$JssorSlideshowFormations$.$FormationStraight,$Assembly:260,$Easing:{$Left:$Jease$.$InOutExpo,$Opacity:$Jease$.$InOutQuad},$Opacity:2,$Outside:false,$Round:{$Top:0.5}},
            {$Duration:2000,y:-1,$Delay:60,$Cols:15,$SlideOut:false,$Formation:$JssorSlideshowFormations$.$FormationStraight,$Easing:$Jease$.$OutJump,$Round:{$Top:1.5}},
            {$Duration:1200,x:0.2,y:-0.1,$Delay:20,$Cols:8,$Rows:4,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Assembly:260,$Easing:{$Left:$Jease$.$InWave,$Top:$Jease$.$InWave,$Clip:$Jease$.$OutQuad},$Round:{$Left:1.3,$Top:2.5}}
        ];

        var jssor_1_options = {
            $AutoPlay: 1,
            $SlideshowOptions: {
                $Class: $JssorSlideshowRunner$,
                $Transitions: jssor_1_SlideshowTransitions,
                $TransitionsOrder: 1
            },
            $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$
            },
            $BulletNavigatorOptions: {
                $Class: $JssorBulletNavigator$
            }
        };

        var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

        /*#region responsive code begin*/

        var MAX_WIDTH = 1920;

        function ScaleSlider() {
            var containerElement = jssor_1_slider.$Elmt.parentNode;
            var containerWidth = containerElement.clientWidth;

            if (containerWidth) {

                var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);

                jssor_1_slider.$ScaleWidth(expectedWidth);
            }
            else {
                window.setTimeout(ScaleSlider, 30);
            }
        }

        ScaleSlider();

        $Jssor$.$AddEvent(window, "load", ScaleSlider);
        $Jssor$.$AddEvent(window, "resize", ScaleSlider);
        $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
        /*#endregion responsive code end*/
    };
</script>
<div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:980px;height:380px;overflow:hidden;visibility:hidden;">
    <!-- Loading Screen -->
    <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
        <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="<?php echo IMAGE_URL . 'spin.svg' ?>" />
    </div>
    <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:980px;height:380px;overflow:hidden;">
        <?php
        if (have_rows('slider-home', 'option')):
            while (have_rows('slider-home', 'option')) : the_row();
                $image = get_sub_field('image_slider', 'option');
                $name = get_sub_field('name_slider', 'option');
                $link = get_sub_field('link_images', 'option'); ?>
                <div>
                    <a href="<?php echo $link; ?>" style="z-index: 8; position: relative; ">
                        <img src="<?php echo $image['url']; ?>" alt="<?php echo $name; ?>" title="slide-home"/>
                    </a>
                </div>
            <?php
            endwhile;
        endif; ?>
    </div>
    <!-- Bullet Navigator -->
    <div data-u="navigator" class="jssorb053" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
        <div data-u="prototype" class="i" style="width:16px;height:16px;">
            <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                <path class="b" d="M11400,13800H4600c-1320,0-2400-1080-2400-2400V4600c0-1320,1080-2400,2400-2400h6800 c1320,0,2400,1080,2400,2400v6800C13800,12720,12720,13800,11400,13800z"></path>
            </svg>
        </div>
    </div>
    <!-- Arrow Navigator -->
    <div data-u="arrowleft" class="jssora093" style="width:50px;height:50px;top:0px;left:30px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
        <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
            <circle class="c" cx="8000" cy="8000" r="5920"></circle>
            <polyline class="a" points="7777.8,6080 5857.8,8000 7777.8,9920 "></polyline>
            <line class="a" x1="10142.2" y1="8000" x2="5857.8" y2="8000"></line>
        </svg>
    </div>
    <div data-u="arrowright" class="jssora093" style="width:50px;height:50px;top:0px;right:30px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
        <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
            <circle class="c" cx="8000" cy="8000" r="5920"></circle>
            <polyline class="a" points="8222.2,6080 10142.2,8000 8222.2,9920 "></polyline>
            <line class="a" x1="5857.8" y1="8000" x2="10142.2" y2="8000"></line>
        </svg>
    </div>
</div>
<script type="text/javascript">jssor_1_slider_init();</script>

