<?php
/**
 * @file
 * Page controller to handle settings of the 'controller' module.
 */

class ControllerSettingsController {
  /**
   * @path => 'admin/config/development/controller',
   * @description => 'Settings for Controllers.',
   * @access arguments => array(CONTROLLER_CHANGE_SETTINGS_PERM),
   * @title => 'Controller',
   * @default => array('default' => 'Settings'),
   */
  public function indexAction() {
    require_once drupal_get_path('module', 'controller') . '/forms/settings_form.inc';
    return drupal_get_form('controller_settings_form');
  }

  /**
   * @path => 'admin/config/development/controller/hook-menu'
   * @access arguments => array(CONTROLLER_CHANGE_SETTINGS_PERM),
   * @title => 'Show hook_menu()',
   * @type => MENU_LOCAL_TASK,
   * @weight => 2,
   */
  public function exportAction() {
    require_once drupal_get_path('module', 'controller') . '/forms/export_form.inc';
    return drupal_get_form('controller_export_form');
  }

  /**
   * @path => 'admin/config/development/controller/dsm'
   * @access arguments => array(CONTROLLER_CHANGE_SETTINGS_PERM),
   * @title => 'Show dsm()',
   * @type => MENU_LOCAL_TASK,
   * @weight => 1,
   */
  public function dsmAction() {
    if (!module_exists('devel') || !function_exists('dsm')) {
      drupal_set_message(t("The 'devel' module should be enabled to properly work of this tab."), 'warning');
    }
    else {
      dsm(controller_get_menu_items());
    }
    return '';
  }
}
