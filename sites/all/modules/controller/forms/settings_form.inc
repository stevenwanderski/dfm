<?php
/**
 * @file
 * Defines the 'controller_settings_form' module.
 */

/**
 * Provides form definition.
 */
function controller_settings_form() {
  $form = array();
  $form['controller_use_ns'] = array(
    '#type' => 'checkbox',
    '#title' => t('Use PHP namespaces'),
    '#description' => t('Requires PHP >= 5.3.'),
    '#default_value' => variable_get('controller_use_ns', 0),
  );
  $form = system_settings_form($form);
  return $form;
}
