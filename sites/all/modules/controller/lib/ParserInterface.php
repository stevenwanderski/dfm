<?php
interface ControllerParserInterface {
  public function parse($val);

  public function setClassName($class_name);
}
