<?php

namespace app\controllers;

use app\models\Comentarios;

/**
 * ComentariosController extends actions for Comentarios model.
 */
class ComentariosController extends
      \yii2mod\comments\controllers\DefaultController
{

    /**
     * Deletes an existing Comentarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionEliminar($id)
    {
        \Yii::$app->db->createCommand(
            'DELETE FROM comment WHERE "parentId" = ' . $id
        )->execute();

        //Comentarios::deleteAll('"parentId" = ' . $id);

        //$this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
}
