<?php

namespace Drupal\lunacodesnippet\Plugin\CKEditorPlugin;

use Drupal\ckeditor\CKEditorPluginBase;
use Drupal\ckeditor\CKEditorPluginConfigurableInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\editor\Entity\Editor;

/**
 * Defines the "codesnippet" plugin.
 *
 * @CKEditorPlugin(
 *   id = "codesnippet",
 *   label = @Translation("Luna CodeSnippet"),
 * )
 */
class CodeSnippet extends CKEditorPluginBase implements CKEditorPluginConfigurableInterface {

  /**
   * {@inheritdoc}
   */
  public function getFile() {
    return 'libraries/codesnippet/plugin.js';
  }

  /**
   * {@inheritdoc}
   */
  public function getConfig(Editor $editor) {
    $settings = $editor->getSettings();
    if (!empty($settings['plugins']['codesnippet']['highlight_languages'])) {
      $languages = array_filter($settings['plugins']['codesnippet']['highlight_languages']);
    }
    else {
      $languages = $this->getLanguages();
    }

    return [
      'codeSnippet_theme' => 'dark',
      'codeSnippet_languages' => $languages,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getButtons() {
    return [
      'codesnippet' => [
        'label' => $this->t('codesnippet'),
        'image' => 'libraries/codesnippet/icons/codesnippet.png',
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state, Editor $editor) {
    $settings = $editor->getSettings();
    $languages = $this->getLanguages();
    natcasesort($languages);

    $form['#attached']['library'][] = 'lunacodesnippet/admin';

    $form['highlight_languages'] = [
      '#type' => 'checkboxes',
      '#title' => 'Supported Languages',
      '#options' => $languages,
      '#description' => $this->t('Enter languages you want to have as options in the editor dialog. To add a language not in this list, please see the README.txt of this module.'),
      '#default_value' => $settings['plugins']['codesnippet']['highlight_languages'] ?? $this->getDefaultLanguages(),
    ];

    return $form;
  }

  /**
   * Return an array of languages.
   *
   * This is used to set the list of checkboxes to be set as all TRUE when first
   * configuring the plugin. Language names like C++ or C# don't quite work well
   * with array_map for the checkboxes element since the value and key do not
   * match up.
   *
   * @return array
   *   Default programming languages.
   */
  private function getDefaultLanguages() {
    $languages = array_keys($this->getLanguages());
    return array_combine($languages, $languages);
  }

  /**
   * Return an array of languages.
   *
   * This should be used when presenting language options to the user in a form
   * element.
   *
   * Unlike getDefaultLanguages(), this provides human friendly names for
   * languages (ex. C++ instead of cpp).
   *
   * These languages are provided as options by the module because these are the
   * languages that come with HighlightJS in the CodeSnippet CKEditor plugin.
   *
   * To add more languages, users can easily implement hook_form_alter() and add
   * to the options array.
   *
   * @return array
   *   Set of programming languages.
   */
  private function getLanguages() {
    return [
      'apache' => 'Apache',
      'bash' => 'Bash',
      'coffeescript' => 'CoffeeScript',
      'cpp' => 'C++',
      'cs' => 'C#',
      'css' => 'CSS',
      'diff' => 'Diff',
      'html' => 'HTML',
      'http' => 'HTTP',
      'ini' => 'INI',
      'java' => 'Java',
      'javascript' => 'JavaScript',
      'json' => 'JSON',
      'makefile' => 'Makefile',
      'markdown' => 'Markdown',
      'nginx' => 'Nginx',
      'objectivec' => 'Objective-C',
      'perl' => 'Perl',
      'php' => 'PHP',
      'python' => 'Python',
      'ruby' => 'Ruby',
      'sql' => 'SQL',
      'vbscript' => 'VBScript',
      'xhtml' => 'XHTML',
      'xml' => 'XML',
    ];
  }

}