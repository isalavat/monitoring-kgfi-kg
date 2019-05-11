<?php

class UserController {
    
    public function actionLogin(){
        $errors = false;
        if (isset($_POST['submit'])){
            $login = $_POST['login'];
            $password = $_POST['password'];
            $user = User::login($login, $password);
            if (is_array($user)){
                User::auth($user);
                
                if (strcmp($user['role'], 'admin') == 0){
                    
                        header("Location: /admin");
                }
                if (strcmp($user['role'], 'teacher') == 0){
                    
                        header("Location: /teacher");
                }
                if (strcmp($user['role'], 'student') == 0){
                    
                        header("Location: /");
                }

            }else{
                $errors[] = 'Не правильные данные для входа';
            }
        }
        include(ROOT.'/views/user/login.php');
    }
    public function actionLogout(){
        User::logout();
    }
    
    public function actionSaveNote(){
        User::saveNoteJson();
    }
    
}
