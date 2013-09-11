<?php
/**
 * @file
 * Defines the ControllerMenuItemsCollector and utility classes.
 */

/**
 * This Collector collects menu items that were defined
 * in Controllers.
 */
class ControllerMenuItemsCollector {
  private $methodDocParser;

  private $menuItemNormalizers = array();

  protected $validOptions = array(
    'addDefaultMenuItemNormalizers',
  );

  protected static $moduleListWithoutNs;

  public function __construct(array $options = array()) {
    if (count(array_diff_key($options, array_flip($this->validOptions))) > 0) {
      throw new \InvalidArgumentException('Invalid options were provided.');
    }
    $options += array(
      'addDefaultMenuItemNormalizers' => TRUE,
    );
    if ($options['addDefaultMenuItemNormalizers']) {
      $this->addDefaultMenuItemNormalizers();
    }
  }

  /**
   * @return array
   */
  public function getMenuItemsForModuleDir($module_name, $dir_path) {
    $module_dir_path = drupal_get_path('module', $module_name);
    $module_dir_path_length = strlen($module_dir_path);
    $options = array(
      'recurse' => TRUE,
    );
    $mask = '{\.php$}si';
    $controllers_dir_path = $module_dir_path . '/' . ltrim($dir_path, '\\/');
    $files = file_scan_directory($controllers_dir_path, $mask, $options);
    $menu_items = array();
    foreach ($files as $file) {
      try {
        $new_menu_items = $this->getMenuItemsForFile($controllers_dir_path, $file, $module_name);

        foreach ($new_menu_items as $path => $menu_item) {
          $menu_item['file path'] = $module_dir_path;
          $menu_item['file'] = substr_replace($file->uri, '', 0, $module_dir_path_length + 1);
          $menu_item['module'] = $module_name;
          $menu_items = array_merge($menu_items, $this->normalizeMenuItem($path, $menu_item));
        }
      }
      catch (RuntimeException $e) {
        $message = $e->getMessage();
        watchdog(CONTROLLER_WATCHDOG_ID, $message, array(), WATCHDOG_ERROR);
        drupal_set_message($message, 'error');
        continue;
      }
    }
    return $menu_items;
  }

  /**
   * @return array
   */
  public function getMenuItemsForModule($module_name) {
    return $this->getMenuItemsForModuleDir($module_name, CONTROLLER_DIR_NAME);
  }

  public function setMethodDocParser(ControllerParserInterface $parser) {
    $this->methodDocParser = $parser;
  }

  public function getMethodDocParser() {
    if (NULL === $this->methodDocParser) {
      $this->methodDocParser = new ControllerMethodDocParser();
    }
    return $this->methodDocParser;
  }

  public function addMenuItemNormalizer(ControllerMenuItemNormalizerInterface $normalizer) {
    $this->menuItemNormalizers[] = $normalizer;
  }

  /**
   * Resets all inner caches.
   */
  public static function resetCache() {
    self::$moduleListWithoutNs = NULL;
  }

  /**
   * Returns list of menu items retrieved from $file.
   *
   * @return array
   */
  protected function getMenuItemsForFile($base_dir_path, stdClass $file, $module_name) {
    $full_class_name = $this->createFullClassName($base_dir_path, $file, $module_name);
    require_once DRUPAL_ROOT . '/' . $file->uri;
    if (!class_exists($full_class_name)) {
      $vars = array(
        '%fileName' => $file->filename,
        '%className' => $full_class_name,
      );
      $message = t("The controller class '%className' was not found in the file '%fileName'.", $vars);
      throw new RuntimeException($message);
    }
    $class_meta = $this->createClassMeta($full_class_name);
    $menu_items = array();
    foreach ($class_meta->getMethods(ReflectionMethod::IS_PUBLIC) as $method_meta) {
      $item_definition = $this->collectMenuItemFromMethod($method_meta, $full_class_name);
      if (!isset($item_definition['path'])) {
        // It is not action-method.
        continue;
      }
      $path = $item_definition['path'];
      unset($item_definition['path']);

      $item_definition['action'] = $method_meta->getName();
      $item_definition['controller'] = $full_class_name;

      $menu_items[$path] = $item_definition;
    }
    return $menu_items;
  }

  /**
   * Creates the meta object for class.
   */
  protected function createClassMeta($full_class_name) {
    return new ControllerClassMeta($full_class_name);
  }

  /**
   * Allows to collect menu items that defined as php comments.
   */
  protected function collectMenuItemFromMethod(ReflectionMethod $method_meta, $full_class_name) {
    $php_docs = $method_meta->getDocComment();
    $items = $this
      ->getMethodDocParser()
      ->setClassName($full_class_name)
      ->parse($php_docs);
    return $items;
  }

  /**
   * Makes normalization of menu items.
   */
  protected function normalizeMenuItem($path, array $definition) {
    $new_definition = array();
    foreach ($this->menuItemNormalizers as $menuItemNormalizer) {
      if ($menuItemNormalizer->accept($path, $definition)) {
        $new_definition = array_merge(
          $new_definition,
          $menuItemNormalizer->normalize($path, $definition)
        );
        break;
      }
    }
    return $new_definition;
  }

  protected function addDefaultMenuItemNormalizers() {
    $this->menuItemNormalizers[] = new ControllerDefaultMenuItemNormalizer();
    $this->menuItemNormalizers[] = new ControllerMenuItemNormalizer();
  }

    /**
   * Creates a full class name.
   */
  static function createFullClassName($base_dir_path, stdClass $file, $module_name) {
    $chunks = explode('/', $file->uri);
    // Strip filename
    array_pop($chunks);
    $ns = array(self::camelize($module_name, TRUE));
    $file_dir_path = implode('/', $chunks);
    while (count($chunks) && $base_dir_path != $file_dir_path) {
      $ns[] = self::camelize(array_pop($chunks), TRUE);
      $file_dir_path = implode('/', $chunks);
    }
    $ns[] = $file->name;
    if (self::nsShouldBeUsed($module_name)) {
      $full_class_name = '\\' . implode('\\', $ns);
    }
    else {
      $full_class_name = implode('', $ns);
    }
    return $full_class_name;
  }

  /**
   * Does camelization of string.
   */
  protected static function camelize($string, $pascal_case = FALSE) {
    $string = str_replace(array('-', '_'), ' ', $string);
    $string = ucwords($string);
    $string = str_replace(' ', '', $string);

    if (!$pascal_case) {
      return lcfirst($string);
    }
    return $string;
  }

  /**
   * Returns either namespace should be used or not.
   */
  protected static function nsShouldBeUsed($module_name) {
    $use_namespaces = variable_get('controller_use_ns', 0);
    if (!$use_namespaces) {
      return FALSE;
    }
    if (NULL === self::$moduleListWithoutNs) {
      self::$moduleListWithoutNs = array_unique(array_merge(
        module_invoke_all('controller_no_ns'),
        array('controller')
      ));
    }
    return !in_array($module_name, self::$moduleListWithoutNs);
  }
}

/**
 * Used to provide meta for the specified controller class.
 */
class ControllerClassMeta extends ReflectionClass {
  private $fullName;

  public function __construct($full_name) {
    parent::__construct($full_name);
    $this->fullName = $full_name;
  }

  public function getFullName() {
    return $this->fullName;
  }
}
