<?php
class ControllerStubMenuItemNormalizer implements ControllerMenuItemNormalizerInterface {
  public function accept($path, array $definition) {
    return TRUE;
  }

  public function normalize($path, array $definition) {
    return array($path => $definition);
  }
}
