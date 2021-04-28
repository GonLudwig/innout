<?php
class Login extends Model {

    public function validate() {
        $errors = [];

        if(!$this->email) {
            $errors['email'] = 'Informe o E-mail.';
        }

        if(!$this->password) {
            $errors['password'] = 'Informe a senha';
        }

        if(count($errors) > 0) {
            throw new ValidationException($errors);
        }
    }

    public function checkLogin() {
        $this->validate();
        $user = User::getOne(['email' => $this->email]);
        if($user) {
            if ($user->end_date) {
                throw new AppException('Usuario esta desligado da emprasa.');
            }

            if (password_verify($this->password, $user->password)) {
                return $user;
            }
        }
        throw new AppException('Usuario ou Senha Invalidos.');
    }
}