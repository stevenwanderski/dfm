<?php
/**
 * @file
 * Defines the 'controller_export_form'.
 */

/**
 * Provides form definition.
 */
function controller_export_form() {
  $form = array();
  $module_list = controller_get_module_list();
  foreach ($module_list as $module_name) {
    $form[$module_name] = array(
      '#type' => 'fieldset',
      '#title' => check_plain($module_name),
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
    );
    $code = var_export(controller_get_menu_items($module_name), TRUE);
    $form[$module_name]['menu_item_list'] = array(
      '#type' => 'textarea',
      '#default_value' => '$items = ' . ControllerCodeFormatter::formatVarExport($code),
      '#rows' => 30,
    );
  }
  return $form;
}
