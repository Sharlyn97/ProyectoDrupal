<?php

namespace Drupal\pais\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'pais_field_type' field type.
 *
 * @FieldType(
 *   id = "pais_field_type",
 *   label = @Translation("Pais field type"),
 *   description = @Translation("a"),
 *   default_widget = "pais_widget_type",
 *   default_formatter = "pais_formatter_type"
 * )
 */
class PaisFieldType extends FieldItemBase {


  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    // Prevent early t() calls by using the TranslatableMarkup.
    $properties['value'] = DataDefinition::create('string')
      ->setLabel( new TranslatableMarkup('pais') );
      //país le da referencia a lo que se esta trabajando.

    return $properties;
  }

  /**
   * {@inheritdoc}
   */

  //como se almacena la info
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    //obligatorio, que schema tenga un arreglo de columnas
    //value es el nombre del campo
    //
    $schema = [
      'columns' => [
        'value' => [
          'type' => 'varchar',
          'length' => 2,
          'description' => t('El nombre del pais'),
          'not null' => FALSE
        ],
      ],
    ];

    return $schema;
  }

  public function isEmpty(){
    $value = $this->get('value')->getValue();
    return $value === NULL || $value === '';
  }
}
