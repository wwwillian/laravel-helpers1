<?php

if (! function_exists('dot_to_square_brackets')) {
    function dot_to_square_brackets($string, $hasQuotes = false)
    {
        $string = preg_replace('/\*/', '', $string);
        $relations = explode('.', $string);
        $model = array_shift($relations);
        $string = $model;
        $quotes = $hasQuotes ? '"':'';
        if(count($relations) > 0) {
            $string .= '[' . $quotes . implode($quotes . '][' . $quotes, $relations) . $quotes . ']';
        }
        return $string;
    }
}

if (! function_exists('auth_routes')) {
    function auth_routes(array $options = [])
    {
        // Authentication Routes...
        Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
        Route::post('login', 'Auth\LoginController@login');
        Route::post('logout', 'Auth\LoginController@logout')->name('logout');

        // Registration Routes...
        if ($options['register'] ?? true) {
            Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
            Route::post('register', 'Auth\RegisterController@register');
        }

        // Password Reset Routes...
        Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

        // Email Verification Routes...
        if ($options['verify'] ?? false) {
            Route::get('email/verify', 'Auth\VerifyEmailController@show')->name('verification.notice');
            Route::get('email/verify/{id}', 'Auth\VerifyEmailController@verify')->name('verification.verify');
            Route::get('email/resend', 'Auth\VerifyEmailController@resend')->name('verification.resend');
        }
    }
}

if (! function_exists('is_many_array')) {
    function is_many_array($array)
    {
        if(!is_array($array) || count($array) < 1) {
            return false;
        }
        foreach($array as $key => $item) {
            if(!is_int($key)){
                return false;
            }
        }
        return true;
    }
}

if (! function_exists('str_lower')) {
    function str_lower($word)
    {
        return mb_strtolower($word);
    }
}

if (! function_exists('to_currency')) {
    function to_currency($value)
    {
        return number_format($value, 2, ',', '.');
    }
}

if (! function_exists('to_cep')) {
    function to_cep($value)
    {
        return !empty($value) ? substr($value, 0, 5) . '-' . substr($value, 5, 3) : '';
    }
}

if (! function_exists('to_cpf')) {
    function to_cpf($value)
    {
        return  !empty($value) ? substr($value, 0, 3) . '.' . substr($value, 3, 3) . '.' . substr($value, 6, 3) . '-' . substr($value, 9, 2) : '';
    }
}

if (! function_exists('to_cnpj')) {
    function to_cnpj($value)
    {
        return  !empty($value) ? substr($value, 0, 2) . '.' . substr($value, 2, 3) . '.' . substr($value, 5, 3) . '/' . substr($value, 8, 4) . '-' . substr($value, 12, 2) : '';
    }
}

if (! function_exists('to_cpfcnpj')) {
    function to_cpfcnpj($value)
    {
        if(empty($value)) {
            return '';
        }
        return strlen($value) === 11 ? to_cpf($value) : to_cnpj($value);
    }
}

if (! function_exists('to_percent')) {
    function to_percent($value)
    {
        return is_numeric($value) ? number_format($value, 2, '.', '') . '%' : 0;
    }
}

if (! function_exists('to_phonenumber')) {
    function to_phonenumber($value)
    {
        if(empty($value)) {
            return '';
        }

        switch(strlen($value)) {
            case 10:
                return '55 ' . substr($value, 0, 2) . ' ' . substr($value, 2, 4) . '-' . substr($value, 6);
            case 11:
                return '55 ' . substr($value, 0, 2) . ' ' . substr($value, 2, 5) . '-' . substr($value, 7);
            case 12:
                return substr($value, 0, 2) . ' ' . substr($value, 2, 2) . ' ' . substr($value, 4, 5) . '-' . substr($value, 8);
            case 13:
                return substr($value, 0, 2) . ' ' . substr($value, 2, 2) . ' ' . substr($value, 4, 5) . '-' . substr($value, 9);
        }
    }
}

if (! function_exists('array_diff_assoc_recursive')) {
    function array_diff_assoc_recursive($array1, $array2)
    {
        foreach ($array1 as $key => $value) {
            if (is_array($value)) {
                if (!isset($array2[$key])) {
                    $difference[$key] = $value;
                } elseif (!is_array($array2[$key])) {
                    $difference[$key] = $value;
                } else {
                    $new_diff = array_diff_assoc_recursive($value, $array2[$key]);
                    if ($new_diff != false) {
                        $difference[$key] = $new_diff;
                    }
                }
            } elseif (!array_key_exists($key, $array2) || $array2[$key] != $value) {
                $difference[$key] = $value;
            }
        }
        return !isset($difference) ? 0 : $difference;
    }
}

if (! function_exists('replace_variables')) {
    function replace_variables($patterns, $replaces, $message) {
        foreach($patterns as $key => $pattern) {
            if (array_key_exists($key, $replaces)) {
                $message = preg_replace("/\{\{" . $pattern . "\}\}/", $replaces[$key], $message);
                $message = preg_replace("/\:" . $pattern . "/", $replaces[$key], $message);

            }
        }

        return $message;
    }
}
