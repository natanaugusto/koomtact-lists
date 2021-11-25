<?php

interface Validatable
{
    /**
     * Return an array with the validation rules
     * @return array
     */
    public static function rules(): array;

    /**
     * Return an array with the validations messages
     * @return array
     */
    public static function messages(): array;
}
