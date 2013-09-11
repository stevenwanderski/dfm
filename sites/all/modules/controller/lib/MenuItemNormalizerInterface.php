<?php
interface ControllerMenuItemNormalizerInterface {
  function normalize($path, array $definition);

  function accept($path, array $definition);
}
