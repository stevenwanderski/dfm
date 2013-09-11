<?php
/**
 * Represents extended version of the ControllerMenuItemNormalizer that
 * can handle the 'default' item.
 */
class ControllerDefaultMenuItemNormalizer extends ControllerMenuItemNormalizer {
  public function accept($path, array $definition) {
    return isset($definition['default']);
  }

  /**
   * Normalizes menu item definition.
   *
   * @return array
   */
  public function normalize($path, array $definition) {
    $definition += array(
      'type' => MENU_NORMAL_ITEM,
    );
    $parent_definition = parent::normalize($path, $definition);
    $parent_path = $path;

    // Get title and path from the parent item if neccessary.
    $default_item = $parent_definition[$parent_path]['default'];
    $path = $parent_path . '/' . trim(key($default_item), '/');
    $title = reset($default_item);
    unset($parent_definition[$parent_path]['default']);

    $definition = array(
      $path => array_merge(
        $this->getDefaultItems(),
        array(
          'title' => $title,
          'type' => MENU_DEFAULT_LOCAL_TASK,
          'file' => $parent_definition[$parent_path]['file'],
          'module' => $parent_definition[$parent_path]['module'],
        )
      ),
    );

    return array_merge($parent_definition, $definition);
  }

  /**
   * Checks menu item definition. Should throw an exception
   * if something is invalid in it.
   */
  protected function checkDefinition(array $definition) {
    parent::checkDefinition($definition);
    if (!is_array($definition['default'])) {
      throw new RuntimeException("Invalid format the menu item: " . print_r($definition, 1));
    }
  }
}
