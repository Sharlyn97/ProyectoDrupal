<?php

namespace Drupal\enlaceentityreference\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
//importamos cosas nuevas
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceFormatterBase;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Plugin implementation of the 'enlace_entity_reference_field_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "enlace_entity_reference_field_formatter",
 *   label = @Translation("Enlace para vista de actores y directores"),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class EnlaceEntityReferenceFieldFormatter extends EntityReferenceFormatterBase {

  /**
   * {@inheritdoc}
   */
  //contenido default
  public static function defaultSettings() {
    return [
      'enlace_vista' => ''
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  //hace el form
  public function settingsForm(array $form, FormStateInterface $form_state) {
    
    $formulario = parent::settingsForm($form, $form_state);

    $formulario['enlace_vista'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Ingresar path de vista'),
      '#default_value' => $this->getSetting('enlace_vista'),
      '#size' => 60,
      '#maxlength' => 128,
      '#required' => TRUE,
    );

    return $formulario;
  }

  /**
   * {@inheritdoc}
   */
  //resumen de la info del form
  public function settingsSummary() {
    $summary = [];

    $link = $this->getSetting('enlace_vista'); 
    //si el campo no esta vacio...
    if(!empty($link)){
      $summary[] = $this->t('El path de la vista es: @path', ['@path' => $link]);
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    //convierte al item en una entidad (items -> informacion que viene)
    $items = $this->getEntitiesToView($items, $langcode);

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
  //EntityInterface porque recibe una entidad
  protected function viewValue(EntityInterface $entity) {
    //url base 
    global $base_url;

    //obtenemos el nombre
    $label = $entity->label();
    $id = $entity->id();

    //http://localhost/drupal/proyectoDrupal/web/actores/id -> la url final

    $urlView = $base_url . '/' . $this->getSetting('enlace_vista') . '/' . $id;

    //objeto url que se encarga de ver que la url este bien formada
    $url = Url::fromUri($urlView);

    //crea la etiqueta <a href="$url"> $label </a>
    $link = Link::fromTextAndUrl($label, $url);

    return $link->toString();
  }

}
