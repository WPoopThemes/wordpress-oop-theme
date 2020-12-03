<?php

namespace WPTheme\Core;

use WPTheme\Controllers\ActionsController;
use WPTheme\Controllers\ThemeController;

class Actions extends ThemeController
{

  public $actions;

  public function init()
  {
    $this->actions = new ActionsController();

    $this->actions->set_actions(
      array(
        [
          'name' => 'render-pagination',
          'callback' => array($this, 'render_pagination')
        ]
      )
    )->register();
  }

  public function render_pagination()
  {
    global $wp_query;
    $big = 999999999; // need an unlikely integer
    $total = $wp_query->max_num_pages;
    if ($total > 1) {
      // Get the current page
      if (!$current_page = get_query_var('paged')) {
        $current_page = 1;
      }
      // Structure of “format” depends on whether we’re using pretty permalinks
      $permalinks = get_option('permalink_structure');
      $format = empty($permalinks) ? '&page=%#%' : '?paged=%#%';

      echo paginate_links(array(
        'base' => preg_replace('/\?.*/', '', get_pagenum_link(1)) . '%_%',
        'format' => $format,
        'current' => $current_page,
        'total' => $total,
        'mid_size' => 2,
        'type' => 'list',
        'prev_text' => __('&lt;'),
        'next_text' => __('&gt;'),
      ));
    }
  }

  //add_action('admin_post_add_review', 'post_review');
  //add_action('admin_post_nopriv_add_review', 'post_review');
  //<input name="action" value="add_review" type="hidden">

  public function post_review()
  {
    if (empty($_POST) || !isset($_POST['action'])) {
      wp_redirect(get_home_url());
    } else {
      $name = $_POST['user'];
      $date = date('d/m/Y');
      $rating = $_POST['rating'];
      $review = $_POST['review'];
      $author_id = $_POST['author'];
      $user = get_user_by('id', $author_id);
      $user_link = get_home_url() . '/user/' . $user->user_nicename;

      $new_post = array(
        'post_title'    => $name . '-' . wp_strip_all_tags(wp_trim_words($review, 7)) ,
        'post_content'  => $review,
        'post_status'   => 'publish',
        'post_type' => 'reviews'
      );
      //save the new post
      $pid = wp_insert_post($new_post);
      $bound_posts = null;
      $bound_ratings = null;
      
      if(isset($_POST['escort'])){

        $bound_posts = get_field('reviews', 'user_' . $author_id);
        $bound_ratings = get_field('ratings', 'user_' . $author_id);
      }
      if(isset($_POST['date'])){

        $bound_posts = get_field('date_reviews', 'user_' . $author_id);
        $bound_ratings = get_field('date_ratings', 'user_' . $author_id);
      }

      if(!empty($bound_posts)){

        if(isset($_POST['escort'])){
          $posts_array = explode(',', $bound_posts);
          $ratings_array = explode(',', $bound_ratings);
    
          array_push($posts_array, $pid);
          array_push($ratings_array, $rating);
    
          $new_posts_array = implode(',', $posts_array);
          $new_ratings_array = implode(',', $ratings_array);
    
          //updates the reviews & ratings field into the user's profile
          update_field('reviews', $new_posts_array, 'user_' . $author_id);
          update_field('ratings', $new_ratings_array, 'user_' . $author_id);
        }

        if(isset($_POST['date'])){
          $posts_array = explode(',', $bound_posts);
          $ratings_array = explode(',', $bound_ratings);
    
          array_push($posts_array, $pid);
          array_push($ratings_array, $rating);
    
          $new_posts_array = implode(',', $posts_array);
          $new_ratings_array = implode(',', $ratings_array);
    
          //updates the reviews & ratings field into the user's profile
          update_field('date_reviews', $new_posts_array, 'user_' . $author_id);
          update_field('date_ratings', $new_ratings_array, 'user_' . $author_id);
        }

      } else {
        if(isset($_POST['escort'])){
        //updates the reviews & ratings field into the user's profile
        update_field('reviews', $pid, 'user_' . $author_id);
        update_field('ratings', $rating, 'user_' . $author_id);
        }
        if(isset($_POST['date'])){
        //updates the reviews & ratings field into the user's profile
        update_field('date_reviews', $pid, 'user_' . $author_id);
        update_field('date_ratings', $rating, 'user_' . $author_id);
        }
      }

      //adds required informations to the post after its creation
      update_field('reviewer_name', $name, $pid);
      update_field('review_rating', intval($rating), $pid);
      update_field('review_date', $date, $pid);

      wp_redirect($user_link);
    }
  }
}
