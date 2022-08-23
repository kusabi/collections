<?php

return [
    'minimum_target_php_version' => '7.2',
    'target_php_version' => '7.2',
    'directory_list' => [
        'src',
        'vendor/kusabi'
    ],
    "exclude_analysis_directory_list" => [
        'vendor/'
    ],
    'plugins' => [
        'AlwaysReturnPlugin',
        'AvoidableGetterPlugin',
        'ConstantVariablePlugin',
        'DollarDollarPlugin',
        'LoopVariableReusePlugin',
        'RedundantAssignmentPlugin',
        'RemoveDebugStatementPlugin',
        'ShortArrayPlugin',
        'SimplifyExpressionPlugin',
        'UnreachableCodePlugin',
        'UnsafeCodePlugin',
        'WhitespacePlugin',
    ],
];