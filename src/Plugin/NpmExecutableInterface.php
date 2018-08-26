<?php

namespace Drupal\npm\Plugin;

/**
 * Interface definition for node package manager plugins.
 */
interface NpmExecutableInterface {

  /**
   * Returns true if given plugin can be used (executable is available).
   *
   * @return bool
   */
  public function isAvailable();

  /**
   * Writes an empty package.json file at the specified location.
   *
   * @param string $path
   *   Location for the file.
   * @throws \Drupal\npm\Exception\NpmCommandFailedException
   */
  public function initPackageJson($path);

}