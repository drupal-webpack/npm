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
   * Writes an empty package.json file.
   *
   * @return \Symfony\Component\Process\Process
   *
   * @throws \Drupal\npm\Exception\NpmCommandFailedException
   */
  public function initPackageJson();

  /**
   * Requires given packages.
   *
   * @param String[] $packages
   *   An array of packages to require.
   * @param string $type
   *   Type of dependencies. One of ('prod', 'dev', 'optional').
   * @return \Symfony\Component\Process\Process
   *
   * @throws \Drupal\npm\Exception\NpmCommandFailedException
   */
  public function addPackages($packages, $type = 'prod');

  /**
   * Executes a script synchronously.
   *
   * @param array $args
   *   An array of arguments starting with the script name.
   * @return \Symfony\Component\Process\Process
   *
   * @throws \Drupal\npm\Exception\NpmCommandFailedException
   */
  public function runScript($args);

}
