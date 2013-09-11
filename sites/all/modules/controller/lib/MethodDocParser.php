<?php
class ControllerMethodDocParser implements ControllerParserInterface {
  /**
   * @return array
   *
   * @throws ErrorException
   */
  public function parse($docs) {
    if (FALSE === $pos = strpos($docs, '@path')) {
      return array();
    }
    $chunks = preg_split('{^\\s*\\*[\\\\\\s]*@}mi', $docs);
    $items = array();
    $keys = array(
      // 2 new special items introduced by the 'controller' module.
      'path',
      'default',
      // Standard Drupal items.
      'title callback',
      'title arguments',
      'title',
      'description',
      'page callback',
      'page arguments',
      'access callback',
      'access arguments',
      'file path',
      'file',
      'load arguments',
      'weight',
      'menu_name',
      'tab_parent',
      'tab_root',
      'position',
      'type',
    );
    $regexp = '{^(' . implode('|', $keys) . ')\\s*=>\\s*(.*)}si';
    foreach ($chunks as $chunk) {
      $chunk = trim($chunk);
      if (preg_match($regexp, $chunk, $m)) {
        $value = array_pop($m);
        $key = array_pop($m);
        $value = preg_replace(array('{^[\s*]+}mi', '{[\s,;*/]+$}mi'), array('', ''), $value);

        if (substr($value, 0, 6) == 'self::') {
          $value = $this->className . '::' . substr($value, 6);
        }

        $items[$key] = eval("?><?php return $value;");
      }
    }
    return $items;
  }

  public function setClassName($class_name) {
    $this->className = $class_name;
    return $this;
  }
}
