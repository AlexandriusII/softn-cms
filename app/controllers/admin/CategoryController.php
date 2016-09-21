<?php

/**
 * Modulo del controlador de la pagina de categorías.
 */

namespace SoftnCMS\controllers\admin;

use SoftnCMS\controllers\BaseController;
use SoftnCMS\controllers\Messages;
use SoftnCMS\controllers\Pagination;
use SoftnCMS\models\admin\Categories;
use SoftnCMS\models\admin\Category;
use SoftnCMS\models\admin\CategoryDelete;
use SoftnCMS\models\admin\CategoryInsert;
use SoftnCMS\models\admin\CategoryUpdate;
/**
 * Clase del controlador de la pagina de categorías.
 *
 * @author Nicolás Marulanda P.
 */
class CategoryController extends BaseController {

    /**
     * Metodo llamado por la función INDEX.
     * @param array $data Lista de argumentos.
     * @return array
     */
    protected function dataIndex($data) {
        $output = [];
        $countData = Categories::count();
        $pagination = new Pagination($data['paged'], $countData);
        $limit = $pagination->getBeginRow() . ',' . $pagination->getRowCount();
        $categories = Categories::selectByLimit($limit);
        
        $pagination->concatUrl('admin/category');

        if ($categories !== \FALSE) {
            $output = $categories->getAll();
        }

        return [
            'categories' => $output,
            'pagination' => $pagination
        ];
    }

    /**
     * Metodo llamado por la función INSERT.
     * @return array
     */
    protected function dataInsert() {
        global $urlSite;

        if (filter_input(\INPUT_POST, 'publish')) {
            $dataInput = $this->getDataInput();
            $insert = new CategoryInsert($dataInput['categoryName'], $dataInput['categoryDescription']);

            if ($insert->insert()) {
                Messages::addSuccess('Categoría publicada correctamente.');
                //Si todo es correcto se muestra la pagina de edición.
                header("Location: $urlSite" . 'admin/category/update/' . $insert->getLastInsertId());
                exit();
            }
            Messages::addError('Error al publicar categoría');
        }

        return [
            //Datos por defecto a mostrar en el formulario.
            'category' => Category::defaultInstance(),
            /*
             * Booleano que indica si muestra el encabezado
             * "Publicar nuevo" si es FALSE 
             * o "Actualizar" si es TRUE
             */
            'actionUpdate' => \FALSE
        ];
    }

    /**
     * Metodo llamado por la función UPDATE.
     * @param array $data Lista de argumentos.
     * @return array
     */
    protected function dataUpdate($data) {
        global $urlSite;

        $category = Category::selectByID($data['id']);

        //En caso de que no exista.
        if (empty($category)) {
            Messages::addError('Error. La categoría no existe.');
            header("Location: $urlSite" . 'admin/category');
            exit();
        }

        if (filter_input(\INPUT_POST, 'update')) {
            $dataInput = $this->getDataInput();
            $update = new CategoryUpdate($category, $dataInput['categoryName'], $dataInput['categoryDescription']);

            //Si ocurre un error la función "$update->update()" retorna FALSE.
            if ($update->update()) {
                Messages::addSuccess('Categoría actualizada correctamente.');
                $category = $update->getDataUpdate();
            } else {
                Messages::addError('Error al actualizar la categoría.');
            }
        }

        return [
            //Instancia Category
            'category' => $category,
            /*
             * Booleano que indica si muestra el encabezado
             * "Publicar nuevo" si es FALSE 
             * o "Actualizar" si es TRUE
             */
            'actionUpdate' => \TRUE
        ];
    }

    /**
     * Metodo llamado por la función DELETE.
     * @param array $data Lista de argumentos.
     * @return array
     */
    protected function dataDelete($data) {
        /*
         * Ya que este metodo no tiene modulo vista propio
         * se carga el modulo vista INDEX, asi que se retornan los datos
         * para esta vista.
         */

        $delete = new CategoryDelete($data['id']);
        $output = $delete->delete();

        if ($output) {
            Messages::addSuccess('Categoría borrada correctamente.');
        } elseif ($output === 0) {
            Messages::addWarning('La Categoría no existe.');
        } else {
            Messages::addError('Error al borrar la categoría.');
        }

        $this->namePage = 'category';
    }

    /**
     * Metodo que obtiene los datos de los campos INPUT del formulario.
     * @return array
     */
    protected function getDataInput() {
        return [
            'categoryName' => \filter_input(\INPUT_POST, 'categoryName'),
            'categoryDescription' => \filter_input(\INPUT_POST, 'categoryDescription'),
        ];
    }

}
