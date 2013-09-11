<?php
/**
 * @file
 * Defines the ControllerMyFooController
 */

class ControllerMyFooController {
  const SOME_CONST_PATH = 'my/path/example';

  /**
   * @path => 'foo',
   * @title => 'My title 1',
   */
  function myAction() {
  }

  /**
   * @path => self::SOME_CONST_PATH,
   * @title => 'My title 2',
   * @type => MENU_CALLBACK,
   */
  function myActionWithConstPath() {

  }

  /**
   * Usual method (not action)
   */
  function actionWithoutPath() {
  }

  /**
   * @path => 'bar/baz',
   * @title => 'My page title',
   * @page arguments => array('foo' => 'bar'),
   * @type => MENU_NORMAL_ITEM,
   * @default => array('test' => 'My default page'),
   */
  function myOtherAction() {
  }
}
