<?php

namespace WPTheme\Core;

use WPTheme\Controllers\ACFController;
use WPTheme\Controllers\AdminController;
use WPTheme\Controllers\OptionPageController;
use WPTheme\Controllers\ThemeController;

class Admin extends ThemeController
{

  //public $ACF;
  public $admin;
  public $optionPage;

  public $pages = array();
  public $subpages = array();

  public function init()
  {

    if (!$this->registered('theme_options')) {
      return;
    }

    //$this->ACF = new ACFController();
    $this->admin = new AdminController();
    $this->optionPage = new OptionPageController();


    $this->ACF->set_options_page(
      array(
        'page_title' => 'Theme Options',
        'menu_title' => 'Theme Options',
        'slug' => 'options-page',
        'capabilities' => 'edit_posts',
        'redirect' => false
      )
    )->register();

    $this->set_pages();
    $this->set_subpages();

    $this->set_settings();
    $this->set_sections();
    $this->set_fields();

    $this->admin->add_settings_pages($this->pages)
      ->with_subpage('Dashboard')
      ->add_subpages($this->subpages)
      ->register();

      //$this->admin->add_subpages($this->subpages)->register();
  }

  public function set_pages()
  {
    $this->pages = array(
      [
        'page_title' => 'Theme Options',
        'menu_title' => 'Theme Options',
        'capability' => 'manage_options',
        'menu_slug' => 'theme_options',
        'callback' => function() {
          $this->optionPage->render_view('dashboard');
        },
        'icon_url' => 'dashicons-hammer',
        'position' => 110

      ]
    );
  }

  public function set_subpages()
  {
    $this->subpages = array(
      [
        'parent_slug' => 'theme_options',
        'page_title' => 'Custom post types',
        'menu_title' => 'CPT',
        'capability' => 'manage_options',
        'menu_slug' => 'theme_options_cpt',
        'callback' => function() {
          $this->optionPage->render_view('cpt');
        },
      ],
    );
  }

  public function set_settings()
  {
    $args = array(
      [
        'option_group' => 'theme_options_cpt_settings',
        'option_name' => 'theme_options_cpt',
        'callback' => function() {
          $this->optionPage->sanitize('theme_options_cpt');
        }
      ]
    );

    $this->admin->set_settings($args);
  }

  public function set_sections()
  {
    $args = array(
      [
        'id' => 'options_cpt_index',
        'title' => 'CPT Manager',
        'callback' => function() {
          $this->optionPage->add_section_title('Manage your CPTs');
        },
        'page' => 'theme_options_cpt'
      ]
    );

    $this->admin->set_sections($args);
  }

  public function set_fields()
  {
    $args = array(
      [
        'id' => 'post_type',
        'title' => 'CPT ID',
        'callback' => array($this->cpt_callbacks, 'text_field'),
        'page' => 'theme_options_cpt',
        'section' => 'options_cpt_index',
        'args' => array(
          'option_name' => 'theme_options_cpt',
          'label_for' => 'post_type',
          'placeholder' => 'Example: products, my-products'
        )
      ],
      [
        'id' => 'singular_name',
        'title' => 'Singular name',
        'callback' => array($this->cpt_callbacks, 'text_field'),
        'page' => 'theme_options_cpt',
        'section' => 'options_cpt_index',
        'args' => array(
          'option_name' => 'theme_options_cpt',
          'label_for' => 'singular_name',
          'placeholder' => 'Example: Product'
        )
      ],
      [
        'id' => 'plural_name',
        'title' => 'Plural name',
        'callback' => array($this->cpt_callbacks, 'text_field'),
        'page' => 'theme_options_cpt',
        'section' => 'options_cpt_index',
        'args' => array(
          'option_name' => 'theme_options_cpt',
          'label_for' => 'plural_name',
          'placeholder' => 'Example: Products'
        )
      ],
      [
        'id' => 'public',
        'title' => 'Public',
        'callback' => array($this->cpt_callbacks, 'checkbox_field'),
        'page' => 'theme_options_cpt',
        'section' => 'options_cpt_index',
        'args' => array(
          'option_name' => 'theme_options_cpt',
          'label_for' => 'public',
          'class' => ''
        )
      ],
      [
        'id' => 'has_archive',
        'title' => 'Has archive',
        'callback' => array($this->cpt_callbacks, 'checkbox_field'),
        'page' => 'theme_options_cpt',
        'section' => 'options_cpt_index',
        'args' => array(
          'option_name' => 'theme_options_cpt',
          'label_for' => 'has_archive',
          'class' => ''
        )
      ],
    );

    $this->admin->set_fields($args);
  }
}
