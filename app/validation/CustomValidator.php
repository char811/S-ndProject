<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 21.11.14
 * Time: 16:11
 */
namespace App\Validation;

class CustomValidator extends \Illuminate\Validation\Validator {

    public function validateAlphaSpaces($attribute, $value, $parameters) {
        if (preg_match('/^[a-zA-Z0-9]+$/', $value)) {
            return true;
        }
        return false;
    }
    public function validateMobileDash($attribute, $value, $parameters) {
        if (preg_match('/^[0-9()-]+$/', $value)) {
            return true;
        }
        return false;
    }
}
