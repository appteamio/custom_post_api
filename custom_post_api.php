<?php
/**
 * Plugin Name: Custom Post Type Api
 * Description: 
 * Version: 0.1
 * Author: appteam
 * Author URI: http://appteam.io
 */
add_filter( 'json_prepare_post', function ($data, $post) {
	/* Edit the response based on Request Cateory*/
	if($data['type'] == 'lunch' || $data['type'] == 'dinner'|| $data['type'] == 'wine'|| $data['type'] == 'specials'|| $data['type'] == 'dessert' || $data['type'] == 'catering'){
		$tempData = $data;
		/*$data will be the response object that can be modified as needed*/
		$data = null;
		$data = array(
			'ID' => $tempData['ID'],
			'title' => html_entity_decode($tempData['title']),
			'desc' => html_entity_decode($tempData['content']),
			'price' =>   get_post_meta( $post['ID'], 'price', true )
		);/*decoding some special characters so that angular doesnt have to do it----better performance!*/
	}elseif($data['type'] == 'deals' || $data['type'] == 'rewards'){
		$data['clean_content'] = html_entity_decode(strip_tags($data['content']));
		$data['code'] = html_entity_decode(get_post_meta( $post['ID'], 'code', true ));
		$data['deal_image'] = get_post_meta( $post['ID'], 'deal_image', true );
		$data['image_url'] = wp_get_attachment_url($data['deal_image']);;
	}
	/*Custom App Landing page infos*/
	elseif($data['type'] == 'home'){
		$tempData = $data;
		$data = null;
		$data['review_1'] = html_entity_decode(get_post_meta( $tempData['ID'], 'review_1', true ));
		$data['review_2'] = html_entity_decode(get_post_meta( $tempData['ID'], 'review_2', true ));
		$data['review_3'] = html_entity_decode(get_post_meta( $tempData['ID'], 'review_3', true ));
		$data['review_4'] = html_entity_decode(get_post_meta( $tempData['ID'], 'review_4', true ));
         // Instead of returning the image file name return the whole file path
         //First get the location
		$slide_image_1 = get_post_meta( $tempData['ID'], 'slide_image_1', true );
		$slide_image_2 = get_post_meta( $tempData['ID'], 'slide_image_2', true );
		$slide_image_3 = get_post_meta( $tempData['ID'], 'slide_image_3', true );
		$slide_image_4 = get_post_meta( $tempData['ID'], 'slide_image_4', true );
         //then add it by including the full url
		$data['slide_image_1'] = wp_get_attachment_url($slide_image_1);
		$data['slide_image_2'] = wp_get_attachment_url($slide_image_2);
		$data['slide_image_3'] = wp_get_attachment_url($slide_image_3);
		$data['slide_image_4'] = wp_get_attachment_url($slide_image_4);
		$data['slide_id_1'] = $slide_image_1;
		$data['slide_id_2'] = $slide_image_2;
		$data['slide_id_3'] = $slide_image_3;
		$data['slide_id_4'] = $slide_image_4;
	}

	return $data;
}, 10, 3 );
?>