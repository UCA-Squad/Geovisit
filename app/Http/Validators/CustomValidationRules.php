<?php

/*
 * This file is a part of the OPGC Data Center project
 * 
 * Observatoire de Physique du Globe de Clermont-Ferrand
 * Campus Universitaire des Cezeaux
 * 4 Avenue Blaise Pascal
 * TSA 60026 - CS 60026
 * 63178 AUBIERE CEDEX FRANCE
 * 
 * Author: Yannick Guehenneux
 *         y.guehenneux [at] opgc.fr
 * 
 */

namespace App\Http\Validators;

use Illuminate\Validation\Validator;
use Hash;

class CustomValidationRules extends Validator {

    public function validateGt($attribute, $value, $parameters) {

        return floatval($value) > floatval($this->getValue($parameters[0]));
        
    }
    
    protected function replaceGt($message, $attribute, $rule, $parameters) {
        
        return str_replace([':other', ':value'], [$parameters[0], $this->getValue($parameters[0])], $message);
        
    }
    
    public function validateGte($attribute, $value, $parameters) {
        
        return floatval($value) >= floatval($this->getValue($parameters[0]));
        
    }
    
    public function replaceGte($message, $attribute, $rule, $parameters) {
        
        return str_replace([':other', ':value'], [$parameters[0], $this->getValue($parameters[0])], $message);
        
    }

    public function validateLt($attribute, $value, $parameters) {

        return floatval($value) < floatval($this->getValue($parameters[0]));
        
    }
    
    protected function replaceLt($message, $attribute, $rule, $parameters) {
        
        return str_replace([':other', ':value'], [$parameters[0], $this->getValue($parameters[0])], $message);
        
    }
    
    public function validateLte($attribute, $value, $parameters) {
        
        return floatval($value) <= floatval($this->getValue($parameters[0]));
        
    }
    
    protected function replaceLte($message, $attribute, $rule, $parameters) {
        
        return str_replace([':other', ':value'], [$parameters[0], $this->getValue($parameters[0])], $message);
        
    }

    public function validateHash($attribute, $value, $parameters) {
        
        return Hash::check($value, $parameters[0]);
        
    }
    
    public function validateMinif($attribute, $value, $parameters) {
        
        if (boolval($this->getValue($parameters[0]))) {
            return floatval($value) >= floatval($parameters[2]);
        } else {
            return floatval($value) >= floatval($parameters[1]);
        }
    }
    
    protected function replaceMinif($message, $attribute, $rule, $parameters) {
        
        if (boolval($this->getValue($parameters[0]))) {
            return str_replace([':value'], [$parameters[2]], $message);
        } else {
            return str_replace([':value'], [$parameters[1]], $message);
        }
        
    }
    
    public function validateMaxif($attribute, $value, $parameters) {
        
        if (boolval($this->getValue($parameters[0]))) {
            return floatval($value) <= floatval($parameters[2]);
        } else {
            return floatval($value) <= floatval($parameters[1]);
        }
        
    }
    
    protected function replaceMaxif($message, $attribute, $rule, $parameters) {
        
        if (boolval($this->getValue($parameters[0]))) {
            return str_replace([':value'], [$parameters[2]], $message);
        } else {
            return str_replace([':value'], [$parameters[1]], $message);
        }
        
    }

}
