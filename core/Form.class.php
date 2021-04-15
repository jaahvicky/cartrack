<?php
class Form
{
    public static function validate($request, $rules, $model, $id = false)
    {
        $errors = [];
        foreach ($rules as $key => $value) {

            $fieldRules = explode('|', $value);
            foreach ($fieldRules as $fieldRule) {
                switch ($fieldRule) {
                    case 'required':
                        if (!isset($request[$key])) {
                            $errors[$key][] = "The field $key is required";
                        } else if (isset($request[$key]) && empty($request[$key])) {
                            $errors[$key][] = "The field $key is required";
                        }
                        break;
                    case 'unique':
                        if (!isset($request[$key])) {
                            $errors[$key][] = "The field $key is required";
                        } else if ($id != false) {
                            $record = $model->getByColumn($key, $request[$key]);
                            if ($record && $record['id'] != $id) {
                                $errors[$key][] = "The value $request[$key] is already in use";
                            }
                        } else if ($model->getByColumn($key, $request[$key])) {
                            $errors[$key][] = "The value $request[$key] is already in use";
                        }
                        break;
                    default:
                        break;
                }
            }
        }

        return (object) [
            'hasError' => (sizeof($errors) > 0 ? true : false),
            'errors' => (object) $errors,
        ];

    }
}