<?php

namespace Drupal\lunacodesnippet\Plugin\Filter;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;
use Drupal\filter\Plugin\FilterInterface;
use Drupal\filter\Attribute\Filter;

#[Filter(
  id: 'filter_codesnippet',
  title: new TranslatableMarkup('Process CodeSnippet elements'),
  type: FilterInterface::TYPE_TRANSFORM_REVERSIBLE,
)]
class CodeSnippet extends FilterBase {

  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode): FilterProcessResult {

    $result = new FilterProcessResult($text);
    if (stristr($text, '<code') === FALSE || stristr($text, 'language-') === FALSE) {
      return $result;
    }

    // Add needed assets.
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
