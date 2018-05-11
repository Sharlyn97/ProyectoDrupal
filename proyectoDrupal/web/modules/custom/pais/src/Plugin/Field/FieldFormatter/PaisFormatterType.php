<?php

namespace Drupal\pais\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'pais_formatter_type' formatter.
 *
 * @FieldFormatter(
 *   id = "pais_formatter_type",
 *   label = @Translation("Pais formatter type"),
 *   field_types = {
 *     "pais_field_type"
 *   }
 * )
 */
class PaisFormatterType extends FormatterBase {

  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = ['#markup' => $this->viewValue($item)];
    }

    return $elements;
  }

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

    //arreglo de paises
    $paises = \Drupal::service('country_manager')->getList();

    //cuando llamo un arreglo le doy como el id o llave que necesita para traer el dato del arreglo
    $pais = $paises[$item->value];

    return $pais;
    //El $item -> value, trae la abreviatura del país
    //return nl2br(Html::escape($item->value));
  }

}
