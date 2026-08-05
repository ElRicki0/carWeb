<?php
// se incluye una case para validar los datos de entrada
require_once('../../helpers/validator.php');
// se incluye clase padre
require_once('../../models/handler/handler_user.php');
/*
 *  Clase para manejar el encapsulamiento de los datos de la tabla USUARIO.
 */
class UserData extends UserHandler
{
    // atributo genérico para manejo de errores
    private $data_error = null;
    private $filename = null;

    /*
     *  Métodos para validar y asignar valores de los atributos.
     */
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            $this->data_error = 'The user ID is incorrect';
            return false;
        }
    }

    // ? se valida el nombre del usuario como alfanumérico
    public function setUsername($value, $min = 2, $max = 50)
    {
        if (!Validator::validateAlphanumeric($value)) {
            $this->data_error = 'The username must be an alphabetical value';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->username = $value;
            return true;
        } else {
            $this->data_error = 'The username length must be between ' . $min . ' and ' . $max;
            return false;
        }
    }

    // ? se valida el correo electrónico
    public function setEmail($value, $min = 8, $max = 100)
    {
        if (!Validator::validateEmail($value)) {
            $this->data_error = 'The Email is incorrecta';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->email = $value;
            return true;
        } else {
            $this->data_error = 'The Email length must be between ' . $min . ' and ' . $max;
            return false;
        }
    }

    // ? se valida el archivo de imagen que pese menos de 2 megas y que sea formato .jpg o .png
    public function setPicture($file, $filename = null)
    {
        if (Validator::validateImageFile($file)) {
            $this->picture = Validator::getFileName();
            return true;
        } elseif (Validator::getFileError()) {
            $this->data_error = Validator::getFileError();
            return false;
        } elseif ($filename) {
            $this->picture = $filename;
            return true;
        } else {
            $this->picture = '404User.png';
            return true;
        }
    }

    // ? se valida el teléfono como tipo numérico con la estructura (7, 2, 6 xxx-xxx)
    public function setPhone($value)
    {
        if (Validator::validatePhone($value)) {
            $this->phone = $value;
            return true;
        } else {
            $this->data_error = 'The phone number must start in +1 (###) ###-####';
            // $this->data_error = 'El teléfono debe tener el formato (2, 6, 7)###-####';
            return false;
        }
    }

    // ? se valida el nombre como tipo alfabético
    public function setName($value, $min = 2, $max = 50)
    {
        if (!Validator::validateAlphabetic($value)) {
            $this->data_error = 'The name must be an alphabetical value';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->name = $value;
            return true;
        } else {
            $this->data_error = 'The name length must be between ' . $min . ' and ' . $max;
            return false;
        }
    }
}