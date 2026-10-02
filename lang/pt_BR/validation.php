<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Mensagens das regras usadas no login e no cadastro. Regras sem tradução
    | aqui usam o idioma de fallback (en).
    |
    */

    'confirmed' => 'A confirmação de :attribute não confere.',
    'current_password' => 'A senha atual está incorreta.',
    'email' => 'Informe um :attribute válido.',
    'max' => [
        'string' => 'O campo :attribute deve ter no máximo :max caracteres.',
    ],
    'min' => [
        'string' => 'O campo :attribute deve ter pelo menos :min caracteres.',
    ],
    'password' => [
        'letters' => 'A :attribute deve conter pelo menos uma letra.',
        'mixed' => 'A :attribute deve conter letras maiúsculas e minúsculas.',
        'numbers' => 'A :attribute deve conter pelo menos um número.',
        'symbols' => 'A :attribute deve conter pelo menos um símbolo.',
        'uncompromised' => 'Esta :attribute apareceu em um vazamento de dados. Escolha outra.',
    ],
    'required' => 'O campo :attribute é obrigatório.',
    'string' => 'O campo :attribute deve ser um texto.',
    'unique' => 'Este :attribute já está em uso.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    */

    'attributes' => [
        'name' => 'nome',
        'email' => 'email',
        'password' => 'senha',
        'password_confirmation' => 'confirmação de senha',
    ],

];
