<?php
/*
Plugin Name: No Trademark Fetcher Widget
Plugin URI: https://github.com/mostafa272/Instagram-Fetcher-Widget
Description: The No Trademark Fetcher Widget is a Plugin to show your Instagram posts on your website.
Version: 1.0
Author: Mostafa Shahiri<mostafa2134@gmail.com>
Author URI: https://github.com/mostafa272/
*/
/*  Copyright 2009  Mostafa Shahiri(email : mostafa2134@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

add_action("widgets_init", function () { register_widget("NoTrademarkFetcherWidget"); });
class NoTrademarkFetcherWidget extends WP_Widget
{
    public function __construct() {
        parent::__construct("notrademark_fetcher_widget", "No Trademark Fetcher Widget",
            array("description" => "A simple widget to show Instagram Images"));
            add_action( 'wp_enqueue_scripts',array($this,'no_trademark_fetcher_scripts') );

    }
    public function form($instance) {
    $title="";
    $token = "";
    $count = "5";
    $like="0";
    $comment="0";
    $createdate="0";
    $caption="0";
    $customcaption="";
    $limitcaption="0";
    $imagestyle="1";
    // if instance is defined, populate the fields
    if (!empty($instance)) {
        $title=$instance["title"];
        $token = $instance["token"];
        $count = $instance["count"];
        $like = $instance["like"];
        $comment = $instance["comment"];
        $createdate = $instance["createdate"];
        $caption = $instance["caption"];
        $customcaption = $instance["customcaption"];
        $limitcaption = $instance["limitcaption"];
        $imagestyle = $instance["imagestyle"];
    }
    //access token field.It's necessary for fetching data from Instagram
    $titleId = $this->get_field_id("title");
    $titleName = $this->get_field_name("title");
    echo '<label for="'.$titleId.'">Title:</label><br>';
    echo '<input id="'.$titleId.'" type="text" name="'.$titleName.'" value="'.$title.'"><br>';
    $tokenId = $this->get_field_id("token");
    $tokenName = $this->get_field_name("token");
    echo '<label for="'.$tokenId.'">Access Token to Instagram:</label><br>';
    echo '<input id="'.$tokenId.'" type="text" name="'.$tokenName.'" value="'.$token.'"><br>';
        //count field
    $countId = $this->get_field_id("count");
    $countName = $this->get_field_name("count");
    echo '<label for="'.$countId.'">Number of posts:</label><br>';
    echo '<input id="'.$countId.'" type="number" min="1" step="1" name="'.$countName .'" value="'.$count.'"><br>';
        //Show number of like fields
   $likeId = $this->get_field_id("like");
    $likeName = $this->get_field_name("like");
    echo '<label for="'.$likeId.'">Show number of likes?</label><br>';
    ?><input id="<?php echo $likeId; ?>" type="radio" name="<?php echo $likeName;?>" value="1" <?php checked( $like,1 );?>/>Yes
    <input id="<?php echo $likeId; ?>" type="radio" name="<?php echo $likeName;?>" value="0" <?php checked( $like,0 );?> />No
   <?php echo '<br/>';
     //Show number of comments fields
    $commentId = $this->get_field_id("comment");
    $commentName = $this->get_field_name("comment");
    echo '<label for="'.$commentId.'">Show number of comments?</label><br>';
    ?><input id="<?php echo $commentId; ?>" type="radio" name="<?php echo $commentName; ?>" value="1" <?php checked( 1, $comment ); ?>/>Yes
    <input id="<?php echo $commentId; ?>" type="radio" name="<?php echo $commentName; ?>" value="0" <?php checked( 0, $comment ); ?>/>No
    <?php echo '<br/>';
    //show created date fields
    $createdateId = $this->get_field_id("createdate");
    $createdateName = $this->get_field_name("createdate");
    echo '<label for="'.$createdateId.'">Show Created date?</label><br>';
    ?><input id="<?php echo $createdateId; ?>" type="radio" name="<?php echo $createdateName; ?>" value="1" <?php checked( 1, $createdate); ?> />Yes
    <input id="<?php echo $createdateId; ?>" type="radio" name="<?php echo $createdateName; ?>" value="0" <?php checked( 0, $createdate ); ?> />No
    <?php echo '<br/>';
    //Show captions fields
    $captionId = $this->get_field_id("caption");
    $captionName = $this->get_field_name("caption");
    echo '<label for="'.$captionId.'">Show Caption?</label><br>';
    ?><input id="<?php echo $captionId; ?>" type="radio" name="<?php echo $captionName; ?>" value="1" <?php checked( 1, $caption ); ?>/>Yes
    <input id="<?php echo $captionId; ?>" type="radio" name="<?php echo $captionName; ?>" value="0" <?php checked( 0, $caption ); ?>/>No
    <?php echo '<br/>';
    //custom captions field
    $customcaptionId = $this->get_field_id("customcaption");
    $customcaptionName = $this->get_field_name("customcaption");
    echo '<label for="'.$customcaptionId.'">Custom Captions:</label><br>';
    echo '<textarea id="'.$customcaptionId.'" name="'.$customcaptionName.'" rows="15" cols="20">'.$customcaption.'</textarea><br/>';
    //limit captions length field
    $limitcaptionId = $this->get_field_id("limitcaption");
    $limitcaptionName = $this->get_field_name("limitcaption");
    echo '<label for="'.$limitcaptionId.'">Limit Captions length:</label><br>';
    echo '<input id="'.$limitcaptionId.'" type="number" min="0" step="1" name="'.$limitcaptionName .'" value="'.$limitcaption.'"><br>';
    //select style for images
    $imagestyleId = $this->get_field_id("imagestyle");
    $imagestyleName = $this->get_field_name("imagestyle");
    echo '<label for="'.$imagestyleId.'">Images style:</label><br>';
    echo '<select id="'.$imagestyleId.'" name="'.$imagestyleName.'">';
    echo '<option value="1" '.selected( '1', $imagestyle ).'>Zoom</option>';
    echo '<option value="2" '.selected( '2', $imagestyle ).'>Rotate</option>';
    echo '<option value="3" '.selected( '3', $imagestyle ).'>Thumbnail</option>';
    echo '<option value="4" '.selected( '4', $imagestyle ).'>Opacity</option>';
    echo '<option value="5" '.selected( '5', $imagestyle ).'>Brightness</option>';
    echo '</select>';
}
public function update($newInstance, $oldInstance) {
    $values = array();
    $values["title"] = sanitize_text_field($newInstance["title"]);
    $values["token"] = sanitize_text_field($newInstance["token"]);
    $values["count"] = intval($newInstance["count"]);
    $values["like"] = $newInstance["like"];
    $values["comment"] = $newInstance["comment"];
    $values["createdate"] = $newInstance["createdate"];
    $values["caption"] = $newInstance["caption"];
    $values["customcaption"] = sanitize_text_field($newInstance["customcaption"]);
    $values["limitcaption"] = intval($newInstance["limitcaption"]);
    $values["imagestyle"] = $newInstance["imagestyle"];
    return $values;
}
function no_trademark_fetcher_scripts() {
         wp_register_style( 'notrademark-fetcher-style', plugins_url( 'css/notrademarkfetcher.css', __FILE__ ) );
}
public static function FetchData(&$params){
  $token=$params["token"];
  $customcaption=$params["custom"];
  $url="https://api.instagram.com/v1/users/self/media/recent/?access_token=$token";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_TIMEOUT, 20);
  $result = curl_exec($ch);
  curl_close($ch);
  $result = json_decode($result);
  $post = $result->data;
 if(trim($customcaption)!="")
 {
 $custom=explode('@#',$customcaption);
   for($i=0;$i<count($post);$i++)
   {
   $post[$i]->caption->text=$custom[$i];
   }
 }
  return $post;
}
public function widget($args, $instance) {
wp_enqueue_style( 'notrademark-fetcher-style');
  $title=$instance["title"];
  $count=$instance["count"];
  $like=$instance["like"];
  $comment=$instance["comment"];
  $createdate=$instance["createdate"];
  $caption=$instance["caption"];
  $limitcaption=$instance["limitcaption"];
  $imagestyle = $instance["imagestyle"];
  $limitcaption=4;
    if($imagestyle=='1')
{$style="insta-style1";
}
elseif($imagestyle=='2')
{ $style="insta-style2";
}
elseif($imagestyle=='3')
{ $style="insta-style3";
}
elseif($imagestyle=='4')
{ $style="insta-style4";
}
elseif($imagestyle=='5')
{ $style="insta-style5";
}
  $post=$this->FetchData($instance);
  echo $args['before_widget'];
  if(!empty($title))
  {	echo $args['before_title'];
    echo esc_html($title);
  	echo $args['after_title'];
  }
 echo '<div class="insta-list">';

 for($i=0; $i<$count; $i++) {
    echo '<div class="insta-padding">
  <a class="" href="'.$post[$i]->link.'" target="_blank"><div class="insta-item '.$style.'" style="background:url('.$post[$i]->images->standard_resolution->url.');background-repeat: no-repeat;background-size: cover;background-position: center center;">';
 if($like=='1')
 {
  echo '<div class="insta-like">'.$post[$i]->likes->count.'</div>';
  }
  if($comment=='1')
  {
   echo '<div class="insta-comment">'.$post[$i]->comments->count.'</div>';
   }
   if($createdate=='1')
  {
   echo '<div class="insta-createdate">'.date_i18n(get_option('date_format'),$post[$i]->created_time).'</div>';
   }
  echo '</div>  </a>';
  if($caption=='1')
  {
  echo '<div class="insta-caption">'.wp_trim_words($post[$i]->caption->text,$limitcaption,'...').'</div>';
  }
  echo '<div class="insta-caption">';
  echo ($limitcaption==0)?'this is for test the truncating words':wp_trim_words('this is for test the truncating words',$limitcaption,'...');
  echo '</div>';

  }

 echo  '</div>';
 echo $args['after_widget'];
}
}
