<?php

namespace Drupal\new_email_formatter\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

//importamos el elemento
use Drupal\Core\Url;
use Drupal\Core\Link;

/**
 * Plugin implementation of the 'new_email_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "new_email_formatter",
 *   label = @Translation("New email formatter"),
 *   field_types = {
 *     "email"
 *   }
 * )
 */
class NewEmailFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#markup' => $this->viewValue($item)
      ];
    }

    return $elements;
  }

  /*
  *
  *[
  *   "email" => "correo@gmail.com"
  * "email" - es $delta
  * "correo@gmail" - es $item
  *]
  *
  */

  /**
   * Generate the output appropriate for one field item.
   *
   * @param \Drupal\Core\Field\FieldItemInterface $item
   *   One field item.
   *
   * @return string
   *   The textual output generated.
   */
  protected function viewValue(FieldItemInterface $item) {
    // The text value has no text format assigned to it, so the user input
    // should equal the output, including newlines.

    //generamos la url, recordemos importar la clase arriba
    $url = Url::fromUri('mailto:' . $item->value);
    $link = Link::fromTextAndUrl($this->t('Enviar correo'), $url); // esta clase recibe el texto y la url

    return $link->toString(); //este retorn retorna una etiqueta, pero formato texto
  }

}
