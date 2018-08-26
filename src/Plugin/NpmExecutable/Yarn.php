<?php

namespace Drupal\npm\Plugin\NpmExecutable;

use Drupal\npm\Exception\NpmCommandFailedException;
use Drupal\npm\Plugin\NpmExecutablePluginBase;
use Symfony\Component\Process\Process;

/**
 * Yarn NPM plugin.
 *
 * @NpmExecutable(
 *   id = "yarn",
 *   label = @Translation("Yarn"),
 *   description = @Translation("Yarn executable for NPM."),
 *   weight = -10,
 * )
 */
class Yarn extends NpmExecutablePluginBase {

  /**
   * {@inheritdoc}
   */
  public function isAvailable() {
    $process = $this->createProcess();
    $process->run();
    return $process->isSuccessful();
  }

  /**
   * {@inheritdoc}
   */
  public function initPackageJson($path) {
    $process = $this->createProcess(['init', '-yp'], $path);
    $process->run();
    if (!$process->isSuccessful()) {
      throw new NpmCommandFailedException($process);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function addPackages($packages, $type = 'prod') {
    $args = ['add'];
    if (in_array($type, ['dev', 'optional'])) {
      $args[] = "--$type";
    }
    $args = array_merge($args, $packages);
    $process = $this->createProcess($args);
    $process->run();
    if (!$process->isSuccessful()) {
      throw new NpmCommandFailedException($process);
    }
  }

  /**
   * Creates a yarn process.
   *
   * @param array $args
   *   Arguments to pass to the yarn command.
   *
   * @param string|null $cwd
   *   The working directory for the process.
   *
   * @return \Symfony\Component\Process\Process
   */
  protected function createProcess($args = [], $cwd = NULL) {
    if ($cwd) {
      array_unshift($args, "--cwd=$cwd");
    }
    array_unshift($args, 'yarn');
    // Drupal 8.4 come with symfony/process 3.2.8 (3.4.14 in 8.5). Array
    // arguments were introduced in 3.3.
    // TODO: Delete this line after dropping support for drupal 8.4.
    $args = implode(' ', $args);
    return new Process($args);
  }

}
