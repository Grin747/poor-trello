<?php


namespace app\controllers;

use app\models\forms\LoginForm;
use app\models\forms\RegisterForm;
use app\models\domain\User;
use Yii;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\Response;

class AuthController extends Controller
{
    /**
     * Displays login page.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout.
     *
     * @return Response|string
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays register page.
     *
     * @return Response|string
     */
    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegisterForm();

        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $user = new User();
            $user->username = $model->username;
            try {
                $user->password = Yii::$app->security->generatePasswordHash($model->password);
            } catch (Exception $e) {
                Yii::$app->session->setFlash('error', 'Error');
                return $this->redirect('/auth/register');
            }
            if($user->save()){
                Yii::$app->session->setFlash('success', 'You was registered');
                return $this->goHome();
            }
            else
            {
                Yii::$app->session->setFlash('error', 'Error');
                return $this->redirect('/auth/register');
            }
        }

        return $this->render('register', compact('model'));
    }
}