<?php

/**
 * Modulo del modelo de categorías.
 * Gestiona grupos de categorías.
 */

namespace SoftnCMS\models\admin;

use SoftnCMS\models\admin\Category;
use SoftnCMS\models\admin\base\Models;

/**
 * Clase que gestiona grupos de categorías.
 *
 * @author Nicolás Marulanda P.
 */
class Categories extends Models {

    /**
     * Constructor.
     */
    public function __construct() {
        parent::__construct(Category::getTableName(), __CLASS__);
    }

    /**
     * Metodo que obtiene todas las categorías de la base de datos.
     * @return Categories|bool Si es FALSE, no hay datos.
     */
    public static function selectAll() {
        $select = self::select(Category::getTableName());

        return self::getInstanceData($select);
    }

    /**
     * Metodo que obtiene un número limitado de datos.
     * @param string $limit 
     * @return Categories|bool Si es FALSE, no hay datos.
     */
    public static function selectByLimit($limit) {
        $select = self::select(Category::getTableName(), '', [], '*', $limit);

        return self::getInstanceData($select);
    }

    /**
     * Metodo que recibe un lista de datos y retorna un instancia.
     * @param array $data Lista de datos.
     * @return Categories|bool Si es FALSE, no hay datos.
     */
    public static function getInstanceData($data) {
        return parent::getInstance($data, __CLASS__);
    }

    /**
     * Metodo que obtiene el número total de datos.
     * @return int
     */
    public static function count() {
        return parent::countData(Category::getTableName());
    }

    /**
     * Metodo que obtiene un array con los datos de las categorías y los agrega a la lista.
     * @param array $data
     */
    public function addData($data) {
        foreach ($data as $value) {
            $this->add(new Category($value));
        }
    }

}
