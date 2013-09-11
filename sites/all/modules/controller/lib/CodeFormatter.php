<?php
/**
 * @file
 * Defines the ControllerCodeFormatter class.
 */

/**
 * The ControllerCodeFormatter class is responsible for
 * formatting of code.
 */
class ControllerCodeFormatter {
  /**
   * Formats the var_export() output.
   */
  static function formatVarExport($string) {
    $string = preg_replace(
      array(
        '{=>\s+array}si',
        '{array \(}si',
      ),
      array(
        '=> array',
        'array(',
      ),
      $string
    );
    $string = rtrim($string, ';') . ';';
    return $string;
  }
}
