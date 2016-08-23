<?php

/**
 * Modulo del modelo post.
 * Gestiona el borrado de posts.
 */

namespace SoftnCMS\models\admin;

use SoftnCMS\controllers\DBController;
use SoftnCMS\models\admin\Post;

/**
 * Clase que gestiona el borrado de posts.
 *
 * @author Nicolás Marulanda P.
 */
class PostDelete {

    /** @var array Lista con los indices, valores y tipos de datos para la consulta. */
    private $prepareStatement;

    /** @var int Identificador. */
    private $id;

    /**
     * Constructor.
     * @param int $id Identificador.
     */
    public function __construct($id) {
        $this->prepareStatement = [];
        $this->id = $id;
    }

    /**
     * Metodo que borra el post de la base de datos.
     * @return bool Si es TRUE, todo se realizo correctamente.
     */
    public function delete() {
        $db = DBController::getConnection();
        $table = Post::getTableName();
        $where = 'ID = :' . Post::ID;
        $this->prepare();

        return $db->delete($table, $where, $this->prepareStatement);
    }
    
    /**
     * Metodo que establece los datos a preparar.
     */
    private function prepare() {
        $this->addPrepare(':' . Post::ID, $this->id, \PDO::PARAM_INT);
    }

    /**
     * Metodo que guarda los datos establecidos.
     * @param string $parameter Indice a buscar. EJ: ":ID"
     * @param string $value Valor del indice.
     * @param int $dataType Tipo de dato. EJ: \PDO::PARAM_*
     */
    private function addPrepare($parameter, $value, $dataType) {
        $this->prepareStatement[] = DBController::prepareStatement($parameter, $value, $dataType);
    }

}
