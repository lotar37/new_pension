<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 09.11.2015
 * Time: 17:22
 */
class SearchController extends Controller
{
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('index','view'),
                'users'=>array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('create','setCookie'),
                'users'=>array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('admin','delete'),
                'users'=>array('admin'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    public function actionIndex()
    {

        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
    }


}