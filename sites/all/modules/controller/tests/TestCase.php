<?php
/**
 * @file
 * Defines test case for the 'controller' module.
 */

require_once drupal_get_path('module', 'controller') . '/controller.module';
require_once dirname(__FILE__) . '/../lib/CodeFormatter.php';
require_once dirname(__FILE__) . '/../lib/MenuItemNormalizerInterface.php';
require_once dirname(__FILE__) . '/../lib/MenuItemNormalizer.php';
require_once dirname(__FILE__) . '/../lib/DefaultMenuItemNormalizer.php';
require_once dirname(__FILE__) . '/../lib/StubMenuItemNormalizer.php';
require_once dirname(__FILE__) . '/../lib/ParserInterface.php';
require_once dirname(__FILE__) . '/../lib/MethodDocParser.php';
require_once dirname(__FILE__) . '/../lib/MenuItemsCollector.php';

class ControllerTestCase extends DrupalUnitTestCase {
}

