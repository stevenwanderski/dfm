<?php
/**
 * @file
 * Defines the ControllerMenuItemsNormalizer and utility classes.
 */

/**
 * Normalizes menu item definition to the notation that Drupal uses.
 */
class ControllerMenuItemNormalizer implements ControllerMenuItemNormalizerInterface {
  function accept($path, array $definition) {
    return TRUE;
  }

  /**
   * Normalizes menu item definition.
   *
   * @return array
   */
  function normalize($path, array $definition) {
    $this->checkDefinition($definition);

    $definition += $this->getDefaultItems();

    $definition['page callback'] = CONTROLLER_MENU_HANDLER;

    if (!isset($definition['page arguments'])) {
      $definition['page arguments'] = array();
    }

    $controller_class_name = $definition['controller'];
    $action_name = $definition['action'];
    unset($definition['action'], $definition['controller']);

    $definition['page arguments'] = array_merge(
      array(
        $controller_class_name
        . CONTROLLER_MENU_SEPARATOR
        . $action_name
        . CONTROLLER_MENU_SEPARATOR
        . $definition['module'],
      ),
      $definition['page arguments']
    );
    
    $definition['module'] = 'controller';

    return array($path => $definition);
  }

  /**
   * Returns menu type.
   */
  protected function getType() {
    return MENU_CALLBACK;
  }

  /**
   * Checks menu item definition. Should throw an exception
   * if something is invalid in it.
   */
  protected function checkDefinition(array $definition) {
    $this->checkRequiredKeys($this->getRequiredKeys(), $definition);
  }

  protected function checkRequiredKeys(array $keys, array $definition) {
    foreach ($keys as $key) {
      if (!isset($definition[$key])) {
        throw new RuntimeException("Missing required key '$key' in the menu item definition: " . print_r($definition, 1));
      }
    }
  }

  protected function getRequiredKeys() {
    return array('module', 'controller', 'action');
  }

  protected function getDefaultItems() {
    return array(
      'type' => $this->getType(),
      'weight' => 0,
    );
  }
}
