<?php
/*$date="03/11/1897";
$timestamp=strtotime($date);
echo 'Timestamp '.$timestamp;
echo date('Y',$timestamp);
*/
global $wp_my_timeline_wpml_deafult_lang;
global $wp_v_my_timeline_has_wmpl;
global $wp_my_timeline_wpml_languages;
global $my_lang;
$my_has_id=false;
?>
<div class="wrap">
    <?php
    include_once($this->path . '/pages/vertical_default_settings.php');
    global $wpdb;
    global $wp_my_timeline_saved_options;
    $wp_my_timeline_saved_options=array();
    if(isset($_GET['id'])) {
        global $wpdb;
        $my_has_id=true;
        $vertical_timeline = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'vctimelines WHERE id='.$_GET['id']);
        $vertical_timeline = $vertical_timeline[0];
        $pageName = 'EDIT TIMELINE -';
        $title = $vertical_timeline->name;
        foreach(explode('||',$vertical_timeline->settings) as $val) {
            $expl = explode('::',$val);
            $settings[$expl[0]] = $expl[1];
        }
        $wp_my_timeline_saved_options=$settings;
        $my_cats_timeline=array();
        $my_cats_timeline=wp_v_my_timeline_get_timeline_cats($vertical_timeline->settings);
        if(!empty($settings['my_lang']))
            $my_lang=$settings['my_lang'];
        else unset($my_lang);
    }else if(isset($_GET['my_clone_s'])){
        global $wpdb;
        $my_has_id=false;
        $vertical_timeline = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'vctimelines WHERE id='.$_GET['my_clone_s']);
        $vertical_timeline = $vertical_timeline[0];
        $pageName = 'Ne timeline';
        $title = '';//$vertical_timeline->name;
        foreach(explode('||',$vertical_timeline->settings) as $val) {
            $expl = explode('::',$val);
            $settings[$expl[0]] = $expl[1];
        }
        $wp_my_timeline_saved_options=$settings;
        unset($vertical_timeline);
        if(!empty($settings['my_lang']))$my_lang=$settings['my_lang'];
        else unset($my_lang);

    }else if(isset($_GET['my_clone'])){
        global $wpdb;
        $my_has_id=false;
        $my_clone_posts=true;
        $vertical_timeline = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'vctimelines WHERE id='.$_GET['my_clone']);
        $vertical_timeline = $vertical_timeline[0];
        $pageName = 'NEW TIMELINE -';
        $title ='';// $vertical_timeline->name;
        foreach(explode('||',$vertical_timeline->settings) as $val) {
            $expl = explode('::',$val);
            $settings[$expl[0]] = $expl[1];
        }
        $wp_my_timeline_saved_options=$settings;
        $my_cats_timeline=array();
        $my_cats_timeline=wp_v_my_timeline_get_timeline_cats($vertical_timeline->settings);

        if(!empty($settings['my_lang']))$my_lang=$settings['my_lang'];
        else unset($my_lang);
    }
    else {
        $pageName = 'NEW TIMELINE -';
        $title = '';
    }

    ?>


    <input type="hidden" id="plugin-url" value="<?php echo $this->url; ?>"/>
    <h2><?php echo $pageName; ?>
        <a href="<?php echo admin_url( "admin.php?page=verticalcontenttimeline" ); ?>" class="add-new-h2">BACK TO TIMELINES</a>
        <?php if(isset($vertical_timeline)&&(!empty($settings['load-post-dynamic']))){?>
            <?php
            $my_id_12=@$_GET['id'];
            if(isset($_GET['my_clear_cache'])){
                $file_1=$this->path.'/tmp/update_'.$my_id_12.'.tmp';
                //echo $file_1;
                if(file_exists($file_1))unlink($file_1);
            }
            ?>
            &nbsp;<a href="<?php echo admin_url( "admin.php?page=verticalcontenttimeline_edit&id=".$my_id_12.'&my_clear_cache=1' ); ?>" class="add-new-h2">Clear Load post cache</a>
        <?php }?>
    </h2>
    <?php if(!empty($wp_v_my_timeline_has_wmpl)){
        ?>
        <div class="my_wpml_switcher_div">
            <?php
            //wp_v_my_timeline_debug_title("Langs", $wp_my_timeline_wpml_languages);
            //echo 'Current lang '.$my_lang;
            ?>
            <ul class="my_wpml_switcher">
                <?php
                if(!$my_has_id){
                    foreach( $wp_my_timeline_wpml_languages as $k123=>$v123){
                        ?>
                        <li>
                            <?php if($v123['code']!=$my_lang){?>
                                <a href="<?php echo admin_url( "admin.php?page=verticalcontenttimeline_edit&lang=".$v123['code']);?>"><?php echo $v123['display_name'];?></a>
                            <?php }else {?>
                                <span><?php echo __("Timeline language : ",'my_vertical_content_timeline').$v123['display_name'];?></span>
                            <?php }?>
                        </li>
                        <?php
                    }
                }else {
                    foreach( $wp_my_timeline_wpml_languages as $k123=>$v123){
                        if($v123['code']==$my_lang){

                            ?>
                            <li>
                                <span><?php echo __("Timeline language : ",'my_vertical_content_timeline').$v123['display_name'];?></span>
                            </li>
                            <?php
                        }
                    }


                }

                ?>
            </ul>
        </div>
    <?php }?>
    <div class="form_result"></div>
    <form name="post_form"  method="post" id="post_form">
        <?php if(!empty($wp_v_my_timeline_has_wmpl)){
            if(!empty($my_lang)){
                ?>
                <input type="hidden" name="my_lang" value="<?php echo $my_lang;?>"/>
            <?php }else {
                if(!empty($wp_my_timeline_wpml_languages)){
                    ?>
                    <h4><?php echo __("Select timeline language")?></h4>
                    <select id="my_langs_wpml" name="my_lang">
                        <?php foreach($wp_my_timeline_wpml_languages as $k12=>$v12){?>
                            <option value="<?php echo $v12['code']?>" <?php if($wp_my_timeline_wpml_deafult_lang==$v12['code'])echo 'selected="selected"'?>><?php echo $v12['display_name']?></option>
                        <?php }?>
                    </select>
                <?php }}?>
        <?php }?>
        <?php if(!empty($my_cats_timeline)){?>
            <?php foreach($my_cats_timeline as $key=>$val){?>
                <input type="hidden" name="my_timeline_cats[]" id="my_timeline_cats" value="<?php echo esc_attr($val);?>"/>
            <?php }?>
        <?php }else {?>

        <?php }?>
        <input type="hidden" name="vtimeline_id" id="vtimeline_id" value="<?php if(isset($_GET['id']))echo $_GET['id']; ?>" />
        <div id="poststuf">

            <div id="post-body" class="metabox-holder columns-2" style="margin-right:300px; padding:0;">

                <div id="post-body-content">
                    <div class="my_blue_header">
                        <h2><?php echo __("NAME YOUR TIMELINE",'my_vertical_content_timeline');?></h2>
                        <div id="titlediv">
                            <div id="titlewrap">
                                <label class="hide-if-no-js" style="visibility:hidden" id="title-prompt-text" for="title">Enter title here</label>
                                <input type="text" placeholder="<?php echo __("Type the name of your timeline here...",'my_vertical_content_timeline');?>" name="timeline_title" size="30" tabindex="1" value="<?php echo $title; ?>" id="title" autocomplete="off" />
                            </div>
                        </div>
                    </div>
                    <div class="my_blue_header">

                        <h2 class="" style="">TIMELINE ITEMS</h2>
                        <div class="my_inner_timeline" <?php if(isset($vertical_timeline)){?>style="display:none"<?php }?>>
                            <div class="my_add_item <?php if(isset($vertical_timeline)){?>set-timl-add<?php }?>">
                                <?php if(!isset($vertical_timeline)){?>
                                    <h3 id="my_add_first_item"><?php echo __("GET STARTED",'my_vertical_content_timeline');?></h3>
                                    <p id="my_p_explain"><!--shindiri studio-->
                                        <?php echo __("Before you start rockin' your",'my_vertical_content_timeline');?><br/>
                                        <?php echo __("new timeline you need some",'my_vertical_content_timeline');?><br/>
                                        <?php echo __("content. Add existing posts",'my_vertical_content_timeline');?><br/>
                                        <?php echo __("or entire categories as",'my_vertical_content_timeline');?><br/>
                                        <?php echo __("separate timeline cards",'my_vertical_content_timeline');?>
                                    </p>
                                    <a id="tsort-add-new" class="" style="display:block;" href="#">ADD NEW ITEM +</a><!--shindiri studio-->
                                <?php }?>
                                <div class="clear"></div>
                            </div>

                            <div class="clear"></div>

                        </div><!-- my_timeline_inner -->
                       <ul id="timeline-sortable" style="overflow:hidden; margin-top: 0px; padding-top: 20px; background: white;">
                            <?php if(isset($vertical_timeline)){?> <a id="tsort-add-new" class="set-timl-link1" style="display:block;" href="#"><p class="link-add-new">ADD NEW ITEM<span class="plus-sign">+</span></p></a><?php }?>
                            <?php

                            if (isset($vertical_timeline) && $vertical_timeline->items != '') {
                                $explode = explode('||',$vertical_timeline->items);
                                $itemsArray = array();

                                //wp_v_my_timeline_debug_title("Items data", $explode);
                                foreach ($explode as $it) {
                                    $ex2 = explode('::', $it);
                                    $key = substr($ex2[0],0,strpos($ex2[0],'-'));
                                    $subkey = substr($ex2[0],strpos($ex2[0],'-')+1);
                                    $itemsArray[$key][$subkey] = $ex2[1];
                                }
                                //wp_v_my_timeline_debug_title("Items data", $itemsArray);
                                $my_old_post_ids=array();
                                foreach ($itemsArray as $key => $arr) {
                                    $num = substr($key,4);
                                    ?>


                                    <li id="<?php echo $key; ?>" class="sortableItem" data-copy-counter="1">
                                        <div class="tsort-header"><span class="item-header">ITEM <?php echo $num; ?> <!--<small><i>- <?php echo $arr['item-title']; $arr['dataid'];  ?></i></small> &nbsp;--></span><a href="#" class="tsort-delete dashicons dashicons-editor-help"><!--<i>delete</i>--></a><span class="tsort-drag-item dashicons dashicons-move"></span><span class="tsort-copy-item dashicons dashicons-editor-help"></span><span class="tsort-plus dashicons dashicons-editor-help"></span></div>
                                        <div class="tsort-image-div"><img id="<?php echo $key; ?>-item-image1" src="<?php echo(($arr['item-image'] != '') ? vbro_images::get_image($arr['item-image'], 258, 130) : $this->url . 'images/no_image_small.jpg');?>" /><div class="starting-card" style="<?php if(array_key_exists('start-item', $arr)) echo 'display:block !important'; ?>">STARTING ITEM</div></div>
                                        <div class="tsort-info"><p class="date-info"><?php echo $arr['dataid']; ?></p><p class="post-info"><?php echo $arr['item-title']; $arr['dataid'];  ?></p></div>
                                        <div class="TBct_overlayBG TBct_card_overlay"></div>
                                        <div class="TBct_card_window" style="width:1000px; height:665px; opacity:0;">
                                            <!--<div class="TBct_card_title"><div class="TBct_cardAjaxWindowTitle"></div>-->
                                            <div class="TBct_cardCloseAjaxWindow"><a class="TBct_cardCloseWindowButton dashicons dashicons-editor-help" title="Close" href="#"><!--<img src="'+pluginUrl+'/images/tb-close.png" alt="X">--></a></div>
                                            <!--</div>-->
                                            <div class="tsort-content">
                                                <div class="tsort-dataid">
                                                    <div class="edit-header-title">EDIT ITEM <?php echo $num; ?><!--<small><i>- <?php echo $arr['item-title']; $arr['dataid'];  ?></i></small> &nbsp;--></div>
                                                    <input name="<?php echo $key?>-my-post-id" id="<?php echo $key;?>-my-post-id" class="" type="hidden" value="<?php echo esc_attr($arr['my-post-id'])?>"/>
                                                    <div class="check-back-color" style="<?php if(array_key_exists('start-item', $arr)) echo 'background-color:#F1592B'; ?>">
                                                        <input type="checkbox" id="<?php echo $key; ?>-start-item" name="<?php echo $key; ?>-start-item" class="tsort-start-item alignright" <?php if(array_key_exists('start-item', $arr)) echo 'checked="checked"'; ?> /><label for="<?php echo $key; ?>-start-item" class="alignright">STARTING ITEM &nbsp;</label></div>
                                                </div>
                                                <div class="tsort-text-title"><?php echo $arr['item-title']; $arr['dataid'];  ?>&nbsp;</div>
                                                <div class="tsort-card-select"><div class="item-options" style="padding-left:0; float:left;">ITEM OPTIONS</div><div class="active-item-options" style="padding-left:0; float: left; margin-left: 30px;">ACTIVE ITEM OPTIONS</div><div class="item-settings" style="padding-left:0; float: left; margin-left: 30px;">SETTINGS</div></div>
                                                <div class="tsort-item">
                                                    <!--<h3 style="padding-left:0;"><span class="timeline-help dashicons dashicons-editor-help"><span class="timeline-tooltip">Base item content (image, title and content).</span></span>ITEM OPTIONS</h3>-->
                                                    <div class="tsort-image"><img id="<?php echo $key; ?>-item-image" src="<?php echo(($arr['item-image'] != '') ? vbro_images::get_image($arr['item-image'], 500, 500) : $this->url . 'images/no_image_large.jpg');?>" />
                                                        <div class="card-image-overlay"></div>
                                                       <div class="image-option-change">
                                                           <a href="#" id="<?php echo $key; ?>-item-image-change" class="tsort-change">CHANGE IMAGE</a>
												<input id="<?php echo $key; ?>-item-image-input" name="<?php echo $key; ?>-item-image" type="hidden" value="<?php echo $arr['item-image']; ?>" />
                                                           <input id="<?php echo $key; ?>-item-image-input-photos" name="<?php echo $key; ?>-item-image-photos" type="hidden" value="<?php echo $arr['item-image-photos']; ?>" />
												<a href="#" id="<?php echo $key; ?>-item-image-remove" class="tsort-remove">REMOVE IMAGE</a>
                                                           <div class="add-more-pphoto">Add more images to activate prettyPhoto slider for this card</div>
                                                       </div>

                                                    </div>
                                                    <div class="item-info-wrapper">
                                                        <table style="width:93%; height: 98%; margin-top: 6px; border-spacing: 0px 4px; ">
                                                            <tr>
                                                                <td colspan="2">
                                                                    <span class="timeline-help dashicons dashicons-editor-help" style="margin-top: -2px;"><span class="timeline-tooltip">Title text that is displayed on the card</span></span><div class="tsort-title-div" style="margin-left: 27px;">TITLE:</div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <input class="tsort-title" name="<?php echo $key; ?>-item-title" value="<?php echo $arr['item-title']; ?>" type="text" />
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td colspan="2">
                                                                    <span class="timeline-help dashicons dashicons-editor-help" style="margin-top: -2px;"><span class="timeline-tooltip">Intro text that is displayed on the card</span></span><div class="tsort-contarea-title" style="margin-left: 27px;">EXCERPT:</div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <textarea style="" class="tsort-contarea" name="<?php echo $key; ?>-item-content"><?php echo $arr['item-content']; ?></textarea>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td style="width:120px;"><span class="timeline-help dashicons dashicons-editor-help" style="margin-top: -1px;"><span class="timeline-tooltip">"Photo URL can be image, video or site url. Leave it empty to link to full-size image.</span></span><label for="<?php echo $key; ?>-item-prettyPhoto" style="margin-left:7px; font-size:14px; font-weight:bold;">PHOTO URL:</label></td>
                                                                <td style="width:120px;"><span class="timeline-help dashicons dashicons-editor-help" style="margin-top: -1px; margin-left: 17px;"><span class="timeline-tooltip">Link to post or some other page. Leave it empty for default behavior. Set it to "#" to disable "Read more" button on individual items.</span></span><label for="<?php echo $key; ?>-item-prettyPhoto" style=" margin-left:7px;font-size:14px; font-weight:bold;">BUTTON URL:</label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><input class="tsort-prettyPhoto" name="<?php echo $key; ?>-item-prettyPhoto" placeholder="http://..."  value="<?php echo $arr['item-prettyPhoto']; ?>" type="text" style="width:91%;" /></td>
                                                                <td><input class="tsort-link" name="<?php echo $key; ?>-item-link" placeholder="http://..." value="<?php echo (isset($arr['item-link']) ? $arr['item-link'] : ''); ?>" type="text" style="width:91%; float: right;" /></td>
                                                            </tr>

                                                            <tr>
                                                                <td><span class="timeline-help dashicons dashicons-editor-help" style="margin-top: -1px;"><span class="timeline-tooltip">Argument by which are elements organised (date - dd/mm/yyyy, Category - full category name). Different field is used for different categorizing type.</span></span><label for="<?php echo $key; ?>-dataid" style="margin-left:7px; font-size:14px; font-weight:bold;">DATE:</label></td>
                                                                <td><span class="timeline-help dashicons dashicons-editor-help" style="margin-top: -1px; margin-left: 17px;"><span class="timeline-tooltip">Category that the post belongs to</span></span><label style="margin-left:7px; font-size:14px; font-weight:bold;" for="<?php echo $key; ?>-categoryid">CATEGORY:</label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><input style="width:91%;" id="<?php echo $key; ?>-dataid" name="<?php echo $key; ?>-dataid" value="<?php echo $arr['dataid']; ?>" type="text" class="data_id" /></td>
                                                                <td><input style="width:91%; float:right;" id="<?php echo $key; ?>-categoryid" name="<?php echo $key; ?>-categoryid" placeholder="Blog posts..." value="<?php echo $arr['categoryid']; ?>" class="category_id" type="text"/></td>
                                                            </tr>

                                                            <tr>
                                                                <td colspan="2">
                                                            <span class="timeline-help dashicons dashicons-editor-help" style="margin-top: -2px;"><span class="timeline-tooltip">Text that is displayed when the user hovers over the node in the timeline</span></span><label style="margin-left:27px; display:block; font-size:14px; font-weight:bold;" for="<?php echo $key; ?>-node-name">TITLE OF TIMELINE NODE (OPTIONAL):</label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                            <input class="title-optional" style="width:100%; color: #888888;" id="<?php echo $key; ?>-node-name" name="<?php echo $key; ?>-node-name" placeholder="Title goes here..." value="<?php echo $arr['node-name']; ?>" type="text" />
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                    <div class="tsort-itemopen">
                                                        <!--<h3 style="padding-left:0;"><span class="timeline-help dashicons dashicons-editor-help"><span class="timeline-tooltip">Opened item content (image, title and content).</span></span>ACTIVE ITEM OPTIONS</h3>-->
                                                        <div class="tsort-image-open"><img id="<?php echo $key; ?>-item-open-image" src="<?php echo(($arr['item-open-image'] != '') ? vbro_images::get_image($arr['item-open-image'], 500, 500) : $this->url . 'images/no_image_large.jpg'); ?>" />
                                                            <div class="card-image-overlay"></div>
                                                            <div class="image-open-option-change">
                                                                <a href="#" id="<?php echo $key; ?>-item-open-image-change" class="tsort-change-open">CHANGE IMAGE</a>
                                                            <input id="<?php echo $key; ?>-item-open-image-input" name="<?php echo $key; ?>-item-open-image" type="hidden" value="<?php echo $arr['item-open-image']; ?>" />
                                                            <a href="#" id="<?php echo $key; ?>-item-open-image-remove" class="tsort-remove-open">REMOVE IMAGE</a>
                                                            </div>
                                                        </div>
                                                        <div class="itemopen-info-wrapper">
                                                            <table style="width:93%; margin-top: 2px; border-spacing: 0px 12px;">
                                                                <tr style="border-spacing: 9px;">
                                                                    <td colspan="2">
                                                                        <span class="timeline-help dashicons dashicons-editor-help" style="margin-top: -2px;"><span class="timeline-tooltip">Title text for the active (opened) item</span></span><div class="tsort-title-div" style="margin-left: 27px">TITLE:</div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">
                                                                        <input class="tsort-title" name="<?php echo $key; ?>-item-open-title" value="<?php echo $arr['item-open-title']; ?>" type="text" />
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <div class="clear"></div>
                                                            <table style="width:93%; border-spacing: 0px 8px;">
                                                                <tr>
                                                                    <td colspan="2">
                                                                        <span class="timeline-help dashicons dashicons-editor-help" style="margin-top: -2px;"><span class="timeline-tooltip">Content that is displayed in an active (opened) item</span></span><div class="tsort-contarea-title" style="margin-left: 27px">CONTENT:</div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">
                                                                        <textarea class="tsort-contarea-open" name="<?php echo $key; ?>-item-open-content"><?php echo $arr['item-open-content']; ?></textarea>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table style="width:93%; margin-bottom: 9px; border-spacing: 0px 10px;">
                                                                <tr>
                                                                    <td style="width:120px;"><span class="timeline-help dashicons dashicons-editor-help" style="margin-top: -1px;"><span class="timeline-tooltip">"Photo URL can be image, video or site url. LEAVE IT EMPTY TO DiSPLAY FULL SIZED IMAGE.</span></span><label for="<?php echo $key; ?>-item-open-prettyPhoto" style="margin-left: 7px; font-size:14px; font-weight:bold;">PHOTO URL:</label></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input class="tsort-prettyPhoto" name="<?php echo $key; ?>-item-open-prettyPhoto" placeholder="http://..." value="<?php echo $arr['item-open-prettyPhoto']; ?>" type="text" style="width:100%;" /></td>
                                                                </tr>
                                                            </table>
                                                                <table style="width:93%; border-spacing: 0px 2px;">
                                                                <tr>
                                                                    <td>
                                                                        <input style="margin-left: 4px; margin-top: -1px;" type="checkbox" id="<?php echo $key; ?>-desable-scroll" class="disable-scroll" name="<?php echo $key; ?>-desable-scroll" <?php if(array_key_exists('desable-scroll',$arr)) echo 'checked="checked"'; ?> />
                                                                        <label for="<?php echo $key; ?>-desable-scroll" style="font-size:14px; font-weight:bold;">DISABLE SCROLL&nbsp;</label>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                    </div>
                                                    </div>
                                                <div class="tsort-item-settings">
                                                    <div class="preview-settings-wrapper" style="width:100%;height:100%;">
                                                        <div class="preview-card" style="float:left; width:200px; height:558px";>
                                                            <p class="preview-card-text">PREVIEW YOUR CARD</p>
                                                            <div class="single-item-preview" style=""></div>
                                                            <div class="expand-preview dashicons dashicons-editor-help" style="width:40px;height:40px; border-radius: 50%; background-color: #F1592B; position: absolute; top: 260px; left: 180px;"></div>
                                                        </div>
                                                        <div class="single-card-settings" style="float:right;width:800px; height:100%;">
                                                            <div class="table-item-settings" style="height:82%; padding-left: 100px; padding-right: 10px; padding-top: 10px;">
                                                                <div class="table-item-first-row" style="float:left; width:33%; height:100%;">
                                                                    <table class="setting-tables" style="width:100%; height:100%;">
                                                                        <tr>
                                                                            <td>
                                                                                <span class="item-settings-title">TITLE:</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <select class="settings-select-tag" id="select_title">
                                                                                    <option value="visible">Visible</option>
                                                                                    <option value="not_visible">Not Visible</option>
                                                                                </select>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <span class="item-settings-title">SUBTITLE/CATEGORY:</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <select class="settings-select-tag" id="select_sub_cat">
                                                                                    <option value="visible">Visible</option>
                                                                                    <option value="not_visible">Not Visible</option>
                                                                                </select>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <span class="item-settings-title">EXCERPT/INTRO TEXT:</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <select class="settings-select-tag" id="select_excerpt">
                                                                                    <option value="visible">Visible</option>
                                                                                    <option value="not_visible">Not Visible</option>
                                                                                </select>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <span class="item-settings-title">READ MORE:</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <!--<select class="settings-select-tag" id="select_read_more">
                                                                                    <option value="visible">Visible</option>
                                                                                    <option value="not_visible">Not Visible</option>
                                                                                </select>-->
                                                                                <input type="text" class="item_color_inputs" name="read-more-color" id="read-more-color">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <span class="item-settings-title">SHADOW:</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <input type="text" class="item_color_inputs" name="shadow-color" id="shadow-color">
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                                <div class="table-item-second-row" style="float:left; width:33%; height:100%;">
                                                                    <table class="setting-tables" style="width:100%; height:100%;">
                                                                        <tr>
                                                                            <td>
                                                                                <span class="item-settings-title">IMAGE:</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <select class="settings-select-tag" id="select_image">
                                                                                    <option value="visible">Visible</option>
                                                                                    <option value="not_visible">Not Visible</option>
                                                                                </select>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <span class="item-settings-title">LIKE:</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <select class="settings-select-tag" id="select_like">
                                                                                    <option value="visible">Visible</option>
                                                                                    <option value="not_visible">Not Visible</option>
                                                                                </select>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <span class="item-settings-title">SHARE:</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <select class="settings-select-tag" id="select_share">
                                                                                    <option value="visible">Visible</option>
                                                                                    <option value="not_visible">Not Visible</option>
                                                                                </select>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <span class="item-settings-title">BACKGROUND COLOR:</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <input type="text" class="item_color_inputs" name="background-color-item" id="background-color-item">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <span class="item-settings-title">TEXT COLOR:</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <input type="text" class="item_color_inputs" name="text-color-item" id=text-color-item">
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                                <div class="table-item-third-row" style="float:left; width:33%; height:100%;">
                                                                    <table class="setting-tables" style="width:100%; height:100%;">
                                                                        <tr>
                                                                            <td>
                                                                                <span class="item-settings-title">DATE:</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <select class="settings-select-tag" id="select_date">
                                                                                    <option value="text">Text</option>
                                                                                    <option value="circle">Circle</option>
                                                                                    <option value="none">None</option>
                                                                                </select>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <span class="item-settings-title">COMMENTS:</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <select class="settings-select-tag" id="select_comments">
                                                                                    <option value="text">Text</option>
                                                                                    <option value="button">Button</option>
                                                                                    <option value="none">None</option>
                                                                                </select>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <span class="item-settings-title">NODE COLOR:</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <input type="text" class="item_color_inputs" name="node-color" id="node-color">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <span class="item-settings-title">TITLE COLOR:</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <input type="text" class="item_color_inputs" name="title-color-item" id="title-color-item">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <span class="item-settings-title">TITLE HOVER COLOR:</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <input type="text" class="item_color_inputs" name="title-hover-color" id="title-hover-color">
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="default-settings-wrapper" style="height:18%;">
                                                                <div class="make-default-settings" style="width:60%; height:82%; float:right; padding: 20px 38px 0 0; text-align: right;">
                                                                    <input type="checkbox" class="def-settings-check alignright"><span class="def-settings-span">MAKE THESE SETTINGS DEFAULT SETTINGS FOR NEW ITEMS</span>
                                                                    <div style="font-style: italic; text-align: left; margin-left: 76px;">*All new items will be created with these settings as defaults</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </li>

                                    <?php
                                }
                            } ?>

                        </ul>
                       </div>
                    <div id="style_preview">


                    </div>

                </div>

                <div id="postbox-container-1" class="postbox-container">
                    <div class="postbox">
                        <div class="my_blue_header">
                            <!--<h2 class='hndle' style="cursor:auto"><span>Publish</span></h2>--><!--shindiri studio-->
                            <div class="inside">
                                <div id="save-progress" class="waiting ajax-saved" style="background-image: url(<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>)" ></div>
                                <input name="preview-timeline" id="preview-timeline" value="PREVIEW" class="alignleft" style="padding:3px 23px" type="submit" />
                                <button id="save-timeline" class="progress-button" data-style="rotate-side-down" data-perspective data-horizontal>SAVE TIMELINE</button>
                                <!--<img id="save-loader" src="<?php echo $this->url; ?>images/ajax-loader.gif" class="alignright" />-->
                                <!--<br class="clear" />-->
                            </div>
                        </div>
                    </div>
                    <div id="side-sortables" class="meta-box-sortables ui-sortable">
                        <?php
                        ob_start();
                        ?>
                        <div class="misc-pub-section timeline-pub-section">
                            <?php /*
								<h3 style="margin-top:0; background:transparent;"><span class="timeline-help">? <span class="timeline-tooltip">Options for categorizing your posts.</span></span>Chronological Options</h3>
								*/ ?>

                            <table class="fields-group">
                                <?php /*
								<tr class="field-row">
									<td>
										<label for="hide-years">Hide Years</label>
									</td>
									<td>
										<input id="hide-years" name="hide-years" value="true" type="checkbox" <?php echo (($settings['hide-years']) ? 'checked="checked"' : '');?> />
									</td>
								</tr>

								<tr class="field-row">
									<td>
										<span class="timeline-help">? <span class="timeline-tooltip">Organize posts by date or some other criteria.</span></span>
										<label for="cat-type">Type</label>
									</td>
									<td>
										<select id="cat-type" name="cat-type">
											<option value="months" <?php echo (($settings['cat-type'] == 'months') ? 'selected="selected"' : ''); ?> >Months</option>
											<option value="categories" <?php echo (($settings['cat-type'] == 'categories') ? 'selected="selected"' : ''); ?>>Categories</option>
										</select>

										<?php

?>
									</td>
								</tr>


								*/ ?>
                                <?php
                                /**
                                 * Render Global settings
                                 */
                                ?>

                                <tr class="cat-display">
                                    <td>
                                        <span class="timeline-help">? <span class="timeline-tooltip">Number of posts per category/month (default 30).</span></span>
                                        <label for="number-per-cat">Number of posts</label>
                                    </td>
                                    <td>
                                        <input id="number-of-posts" name="number-of-posts" value="<?php if(isset($settings['number-of-posts']))echo $settings['number-of-posts']; ?>" size="3" type="text">
                                    </td>
                                </tr>
                                <tr class="cat-display">
                                    <td colspan="2" style="width:100%;">
                                        <h4 style="margin:0 0 5px 0; font-size:14px; border-bottom:1px solid #dddddd;">Categories:</h4>
                                        <?php /*
									<?php
									global $wp_v_my_timeline_has_wmpl;
									global $wp_my_timeline_wpml_languages;
									global $wp_my_timeline_wpml_deafult_lang;
									//if($wp_v_my_timeline_has_wmpl){
									?>
									<input type="hidden" id="my-wpml-has-wmpl" value="<?php if(!empty($wp_v_my_timeline_has_wmpl))echo '1';else echo '0';?>"/>
									<?php
									if(!empty($wp_my_timeline_wpml_languages)){
										?>
										<select id="my_langs_wpml">
											<?php foreach($wp_my_timeline_wpml_languages as $k12=>$v12){?>
											<option value="<?php echo $v12->code?>" <?php if($wp_my_timeline_wpml_deafult_lang==$v12->code)echo 'selected="selected"'?>><?php echo $v12->display_naem?></option>
											<?php }?>
										</select>
									<?php foreach($wp_my_timeline_wpml_languages as $k12=>$v12){
											$categories=wp_v_my_timeline_getCatsWpml($v12->code);
											?>
											<select class="my_lang_codes_cats" data-lang="<?php echo $v12->code;?>">
											<?php foreach($categories as $k123=>$v123){?>
											<option value="<?php echo $v123->term_id;?>"><?php echo $v123->name?></option>
											<?php }?>

											</select>
											<?php
											$catString = '';
											foreach ($categories as $category) {
												$catString .= $category->name . '||';
												echo '
											<label for="cat-name-'.$category->term_id.'">'.$category->name.'</label>
											<input class="cat-name" name="cat-name-'.$category->term_id.'" value="'.$category->name.'" type="checkbox" '.((isset($settings['cat-name-'.$category->term_id]) && $settings['cat-name-'.$category->term_id]) ? 'checked="checked"' : '').'>';
											}
											if($catString != '') {
												echo '<input type="hidden" id="categories-hidden" value="'.substr($catString,0,strlen($catString)-2).'" />';
											}

										 }
									}else {*/
                                        ?>
                                        <?php
                                        $post_types=get_post_types('','names');
                                        $categories = array();
                                        foreach ($post_types as $post_type ) {
                                            if (!in_array($post_type, array('page', 'attachment', 'revision', 'nav_menu_item'))) {
                                                $newCats = get_categories(array('type' => $post_type));
                                                foreach ($newCats as $post_cat) {
                                                    if (!in_array($post_cat, $categories)) {
                                                        array_push($categories, $post_cat);
                                                    }
                                                }
                                            }
                                        }
                                        $catString = '';
                                        foreach ($categories as $category) {
                                            $catString .= $category->name . '||';
                                            echo '
											<label for="cat-name-'.$category->term_id.'">'.$category->name.'</label>
											<input class="cat-name" name="cat-name-'.$category->term_id.'" value="'.$category->name.'" type="checkbox" '.((isset($settings['cat-name-'.$category->term_id]) && $settings['cat-name-'.$category->term_id]) ? 'checked="checked"' : '').'>';
                                        }
                                        if($catString != '') {
                                            echo '<input type="hidden" id="categories-hidden" value="'.substr($catString,0,strlen($catString)-2).'" />';
                                        }

                                        ?>
                                        <?php //}?>
                                    </td>
                                </tr>
                                <tr class="cat-display">
                                    <td colspan="2" style="width:100%">
                                        <a href="#" id="cat-check-all" class="button button-highlighted alignleft" style="padding:0 27px" >Check all</a>
                                        <a href="#" id="cat-uncheck-all" class="button button-highlighted alignright" style="padding:0 27px" >Uncheck all</a>
                                        <div class="clear"></div>
                                    </td>
                                </tr>



                            </table>
                        </div>
                        <?php
                        global $wp_timeline_12_options;
                        $append=ob_get_clean();
                        wp_v_my_timeline_render_options($wp_timeline_12_options['global_settings'],__("GLOBAL SETTINGS",'my_vertical_content_timeline'),$append);
                        wp_v_my_timeline_render_options($wp_timeline_12_options['vertical_settings'],__("VERTICAL OPTIONS",'my_vertical_content_timeline'));


                        /**
                         * Render card item settings
                         */
                        wp_v_my_timeline_render_options($wp_timeline_12_options['card_settings'],__("CARD SETTINGS",'my_vertical_content_timeline'));
                        wp_v_my_timeline_render_options($wp_timeline_12_options['button_settings'],__("BUTTON SETTINGS",'my_vertical_content_timeline'));
                        wp_v_my_timeline_render_options($wp_timeline_12_options['text_settings'],__("FONT SETTINGS",'my_vertical_content_timeline'));
                        /**
                         * izmenio
                         */
                        wp_v_my_timeline_render_options($wp_timeline_12_options['responsive_settings'],__("RESPONSIVE SETTINGS",'my_vertical_content_timeline'));

                        wp_v_my_timeline_render_options($wp_timeline_12_options['search_settings'],__("SEARCH SETTINGS",'my_vertical_content_timeline'));
                        /**
                         * izmenio
                         */
                        ?>




                    </div>
                </div>

                <div id="postbox-container-2" class="postbox-container">
                    <div id="normal-sortables" class="meta-box-sortables ui-sortable"></div>
                </div>

                <br class="clear"/>

            </div>

        </div>
    </form>

</div>
