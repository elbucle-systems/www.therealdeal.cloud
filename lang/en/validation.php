<?php

return [
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'email' => 'The :attribute field must be a valid email address.',
    'integer' => 'The :attribute field must be an integer.',
    'max' => [
        'numeric' => 'The :attribute field must not be greater than :max.',
        'string' => 'The :attribute field must not be greater than :max characters.',
    ],
    'min' => [
        'numeric' => 'The :attribute field must be at least :min.',
        'string' => 'The :attribute field must be at least :min characters.',
    ],
    'regex' => 'The :attribute field format is invalid.',
    'required' => 'The :attribute field is required.',
    'size' => [
        'string' => 'The :attribute field must be :size characters.',
    ],
    'string' => 'The :attribute field must be a string.',
    'unique' => 'The :attribute has already been taken.',
    'attributes' => [
        'current_password' => 'current password',
        'deadline_days' => 'deadline',
        'email' => 'email',
        'members_size_limit' => 'max members',
        'name' => 'league name',
        'password' => 'password',
        'points_per_result' => 'points for correct result',
        'points_per_score' => 'points for exact score',
        'predicted_score_a' => 'home score',
        'predicted_score_b' => 'away score',
        'unique_code' => 'invite code',
        'username' => 'username',
    ],
];
