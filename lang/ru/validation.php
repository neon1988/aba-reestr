<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Поле :attribute должно быть принято.',
    'accepted_if' => 'Поле :attribute должно быть принято, когда :other равно :value.',
    'active_url' => 'Поле :attribute должно быть действительным URL.',
    'after' => 'Поле :attribute должно быть датой после :date.',
    'after_or_equal' => 'Поле :attribute должно быть датой после или равной :date.',
    'alpha' => 'Поле :attribute должно содержать только буквы.',
    'alpha_dash' => 'Поле :attribute должно содержать только буквы, цифры, дефисы и подчеркивания.',
    'alpha_num' => 'Поле :attribute должно содержать только буквы и цифры.',
    'array' => 'Поле :attribute должно быть массивом.',
    'ascii' => 'Поле :attribute должно содержать только однобайтовые алфавитно-цифровые символы и знаки.',
    'before' => 'Поле :attribute должно быть датой до :date.',
    'before_or_equal' => 'Поле :attribute должно быть датой до или равной :date.',
    'between' => [
        'array' => 'Поле :attribute должно содержать от :min до :max элементов.',
        'file' => 'Поле :attribute должно быть от :min до :max килобайт.',
        'numeric' => 'Поле :attribute должно быть между :min и :max.',
        'string' => 'Поле :attribute должно содержать от :min до :max символов.',
    ],
    'boolean' => 'Поле :attribute должно быть истинным или ложным.',
    'can' => 'Поле :attribute содержит неразрешенное значение.',
    'confirmed' => 'Поле :attribute не совпадает с подтверждением.',
    'contains' => 'Поле :attribute не содержит необходимое значение.',
    'current_password' => 'Пароль неверный.',
    'date' => 'Поле :attribute должно быть действительной датой.',
    'date_equals' => 'Поле :attribute должно быть датой, равной :date.',
    'date_format' => 'Поле :attribute должно соответствовать формату :format.',
    'decimal' => 'Поле :attribute должно содержать :decimal знаков после запятой.',
    'declined' => 'Поле :attribute должно быть отклонено.',
    'declined_if' => 'Поле :attribute должно быть отклонено, когда :other равно :value.',
    'different' => 'Поле :attribute и :other должны быть разными.',
    'digits' => 'Поле :attribute должно содержать :digits цифры.',
    'digits_between' => 'Поле :attribute должно содержать от :min до :max цифр.',
    'dimensions' => 'Поле :attribute имеет недопустимые размеры изображения.',
    'distinct' => 'Поле :attribute имеет дублирующееся значение.',
    'doesnt_end_with' => 'Поле :attribute не должно заканчиваться на одно из следующих значений: :values.',
    'doesnt_start_with' => 'Поле :attribute не должно начинаться с одного из следующих значений: :values.',
    'email' => 'Поле :attribute должно быть действительным адресом электронной почты.',
    'ends_with' => 'Поле :attribute должно заканчиваться на одно из следующих значений: :values.',
    'enum' => 'Выбранный :attribute недействителен.',
    'exists' => 'Выбранный :attribute недействителен.',
    'extensions' => 'Поле :attribute должно иметь одно из следующих расширений: :values.',
    'file' => 'Поле :attribute должно быть файлом.',
    'filled' => 'Поле :attribute должно иметь значение.',
    'gt' => [
        'array' => 'Поле :attribute должно содержать больше чем :value элементов.',
        'file' => 'Поле :attribute должно быть больше чем :value килобайтов.',
        'numeric' => 'Поле :attribute должно быть больше чем :value.',
        'string' => 'Поле :attribute должно содержать больше чем :value символов.',
    ],
    'gte' => [
        'array' => 'Поле :attribute должно содержать :value элементов или больше.',
        'file' => 'Поле :attribute должно быть больше или равно :value килобайт.',
        'numeric' => 'Поле :attribute должно быть больше или равно :value.',
        'string' => 'Поле :attribute должно содержать :value символов или больше.',
    ],
    'hex_color' => 'Поле :attribute должно быть действительным шестнадцатеричным цветом.',
    'image' => 'Поле :attribute должно быть изображением.',
    'in' => 'Выбранный :attribute недействителен.',
    'in_array' => 'Поле :attribute должно существовать в :other.',
    'integer' => 'Поле :attribute должно быть целым числом.',
    'ip' => 'Поле :attribute должно быть действительным IP-адресом.',
    'ipv4' => 'Поле :attribute должно быть действительным IPv4-адресом.',
    'ipv6' => 'Поле :attribute должно быть действительным IPv6-адресом.',
    'json' => 'Поле :attribute должно быть действительной строкой JSON.',
    'list' => 'Поле :attribute должно быть списком.',
    'lowercase' => 'Поле :attribute должно быть в нижнем регистре.',
    'lt' => [
        'array' => 'Поле :attribute должно содержать меньше чем :value элементов.',
        'file' => 'Поле :attribute должно быть меньше чем :value килобайтов.',
        'numeric' => 'Поле :attribute должно быть меньше чем :value.',
        'string' => 'Поле :attribute должно содержать меньше чем :value символов.',
    ],
    'lte' => [
        'array' => 'Поле :attribute не должно содержать более :value элементов.',
        'file' => 'Поле :attribute должно быть меньше или равно :value килобайт.',
        'numeric' => 'Поле :attribute должно быть меньше или равно :value.',
        'string' => 'Поле :attribute должно содержать не более :value символов.',
    ],
    'mac_address' => 'Поле :attribute должно быть действительным MAC-адресом.',
    'max' => [
        'array' => 'Поле :attribute не должно содержать более :max элементов.',
        'file' => 'Поле :attribute не должно быть больше :max килобайт.',
        'numeric' => 'Поле :attribute не должно быть больше :max.',
        'string' => 'Поле :attribute не должно содержать более :max символов.',
    ],
    'max_digits' => 'Поле :attribute не должно содержать более :max цифр.',
    'mimes' => 'Поле :attribute должно быть файлом типа: :values.',
    'mimetypes' => 'Поле :attribute должно быть файлом типа: :values.',
    'min' => [
        'array' => 'Поле :attribute должно содержать как минимум :min элементов.',
        'file' => 'Поле :attribute должно быть как минимум :min килобайт.',
        'numeric' => 'Поле :attribute должно быть как минимум :min.',
        'string' => 'Поле :attribute должно содержать как минимум :min символов.',
    ],
    'min_digits' => 'Поле :attribute должно содержать как минимум :min цифр.',
    'missing' => 'Поле :attribute должно отсутствовать.',
    'missing_if' => 'Поле :attribute должно отсутствовать, когда :other равно :value.',
    'missing_unless' => 'Поле :attribute должно отсутствовать, если :other не равно :value.',
    'missing_with' => 'Поле :attribute должно отсутствовать, когда :values присутствуют.',
    'missing_with_all' => 'Поле :attribute должно отсутствовать, когда :values присутствуют.',
    'multiple_of' => 'Поле :attribute должно быть кратно :value.',
    'not_in' => 'Выбранный :attribute недействителен.',
    'not_regex' => 'Формат поля :attribute недействителен.',
    'numeric' => 'Поле :attribute должно быть числом.',
    'password' => [
        'letters' => 'Поле :attribute должно содержать хотя бы одну букву.',
        'mixed' => 'Поле :attribute должно содержать хотя бы одну заглавную и одну строчную букву.',
        'numbers' => 'Поле :attribute должно содержать хотя бы одно число.',
        'symbols' => 'Поле :attribute должно содержать хотя бы один символ.',
        'uncompromised' => 'Указанное :attribute встречается в утечке данных. Пожалуйста, выберите другое :attribute.',
    ],
    'present' => 'Поле :attribute должно быть присутствовать.',
    'present_if' => 'Поле :attribute должно быть присутствовать, когда :other равно :value.',
    'present_unless' => 'Поле :attribute должно быть присутствовать, если :other не равно :value.',
    'present_with' => 'Поле :attribute должно быть присутствовать, когда :values присутствуют.',
    'present_with_all' => 'Поле :attribute должно быть присутствовать, когда :values присутствуют.',
    'prohibited' => 'Поле :attribute запрещено.',
    'prohibited_if' => 'Поле :attribute запрещено, когда :other равно :value.',
    'prohibited_unless' => 'Поле :attribute запрещено, если :other не находится в :values.',
    'prohibits' => 'Поле :attribute запрещает наличие :other.',
    'regex' => 'Формат поля :attribute недействителен.',
    'required' => 'Поле :attribute обязательно для заполнения.',
    'required_array_keys' => 'Поле :attribute должно содержать ключи для: :values.',
    'required_if' => 'Поле :attribute обязательно для заполнения, когда :other равно :value.',
    'required_if_accepted' => 'Поле :attribute обязательно для заполнения, когда :other принято.',
    'required_unless' => 'Поле :attribute обязательно для заполнения, если :other не равно :value.',
    'required_with' => 'Поле :attribute обязательно для заполнения, когда :values присутствуют.',
    'required_with_all' => 'Поле :attribute обязательно для заполнения, когда :values присутствуют.',
    'required_without' => 'Поле :attribute обязательно для заполнения, когда :values отсутствуют.',
    'required_without_all' => 'Поле :attribute обязательно для заполнения, когда ни одно из :values не присутствует.',
    'same' => 'Поле :attribute и :other должны совпадать.',
    'size' => [
        'array' => 'Поле :attribute должно содержать :size элементов.',
        'file' => 'Поле :attribute должно быть :size килобайт.',
        'numeric' => 'Поле :attribute должно быть :size.',
        'string' => 'Поле :attribute должно содержать :size символов.',
    ],
    'starts_with' => 'Поле :attribute должно начинаться с одного из следующих значений: :values.',
    'string' => 'Поле :attribute должно быть строкой.',
    'timezone' => 'Поле :attribute должно быть действительным часовым поясом.',
    'unique' => 'Поле :attribute уже занято.',
    'uploaded' => 'Поле :attribute не удалось загрузить.',
    'url' => 'Поле :attribute должно быть действительным URL.',
    'uuid' => 'Поле :attribute должно быть действительным UUID.',
    'phone' => 'Поле :attribute должно быть действительным номером телефона, начинающимся с "+" и содержать от :min до :max символов.',
    'inn' => 'Поле :attribute должно быть корректным ИНН.',
    'indisposable' => 'Одноразовые адреса электронной почты не допускаются.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
        'g-recaptcha-response' => [
            'required' => 'Пожалуйста, подтвердите, что вы не робот.',
            'captcha' => 'Ошибка при вводе капчи! повторите попытку позже',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
