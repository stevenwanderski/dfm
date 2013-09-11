<?php
/**
 * @file
 * Hooks provided by the Controller module.
 */

/**
 * If the 'controller_use_ns' variable is set to 1 and you don't
 * want to use namespaces in your module 'mymodule', just implement
 * the hook_controller_no_ns().
 *
 * @return string|array
 *   A string or an array of module names that don't use namespaces.
 */
function hook_controller_no_ns() {
  return 'mymodule';
}

/**
 * The 'controller' module can build information from Controller classes
 * by himself, by parsing annotations, defined in a Controller class.
 * To do that define the hook_controller_api() function in your module.
 *
 * @return mixed
 *   The function return any value or return nothing. It used only to
 *   inform the 'controller' module about existence of your module.
 */
function hook_controller_api() {
}
