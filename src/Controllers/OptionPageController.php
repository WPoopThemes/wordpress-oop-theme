<?php

namespace WPTheme\Controllers;

class OptionPageController extends ThemeController {

  public function render_view(string $view)
  {
    return require_once($this->views_path . 'theme-options/' . $view. '.php');
  }

  public function add_section_title(string $title)
  {
    echo $title;
  }

  public function sanitize(string $option, $input)
  {

    $output = get_option($option);

    if(isset($_POST['remove'])){

      unset($output[$_POST['remove']]);

      return $output;
    }


    if(empty($output)) {
      $output[$input['post_type']] = $input;

      return $output;
    }

    foreach ($output as $key => $value) {

      if ($input['post_type'] == $key) {
        $output[$key] = $input;
      } else {
        $output[$input['post_type']] = $input;
      }
    }

    return $output;
  }

  public function text_field($args)
  {
    $name = $args['label_for'];
    $option_name = $args['option_name'];
    $value = '';
    $is_disabled = '';

    if(isset($_POST['edit'])){
      $input = get_option($option_name);
      $value = $input[ $_POST['edit'] ][$name];
      if($name == 'post_type'){
        $is_disabled = 'disabled';
      }
    }

    echo "<input type='text' class='regular-text' name='{$option_name}[{$name}]' id='{$name}' value='{$value}' placeholder='{$args['placeholder']}' {$is_disabled}>";
  }

  public function checkbox_field($args)
  {
    $name = $args['label_for'];
    $option_name = $args['option_name'];
    $checkbox = get_option($option_name);
    $is_checked = false;

    if(isset($_POST['edit'])){
      $checked = isset($checkbox[$_POST['edit']][$name]) ? ($checkbox[$_POST['edit']][$name] ? true : false) : false;
      $is_checked = $checked ? 'checked' : '';
    }


    $classes = $args['class'];
    echo "<div class='{$classes}'><input type='checkbox' name='{$option_name}[{$name}]' id='{$name}' class='{$classes}' value='1' {$is_checked}><label for='{$name}' data-icon='check'>{$name}</label></div>";
  }
}