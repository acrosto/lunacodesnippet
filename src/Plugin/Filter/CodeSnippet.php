<?php

namespace Drupal\lunacodesnippet\Plugin\Filter;

use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;

/**
 * Provides a filter to attach needed assets for codesnippet.
 *
 * @Filter(
 *   id = "filter_codesnippet",
 *   title = @Translation("Process CodeSnippet elements"),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_TRANSFORM_REVERSIBLE
 * )
 */
class CodeSnippet extends FilterBase {

  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode) {

    $result = new FilterProcessResult($text);
    if (stristr($text, '<code') === FALSE || stristr($text, 'language-') === FALSE) {
      return $result;
    }

    // Add needed JS.
    $result->addAttachments([
      'library' => [
        'lunacodesnippet/prismjs',
      ],
    ]);

    return $result;
  }

  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    return $this->t('Add codesnippet assets');
  }

}
