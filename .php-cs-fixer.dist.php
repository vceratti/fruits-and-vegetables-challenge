<?php

declare(strict_types=1);

$excludedDirs = ['.github', '.idea', 'docker', 'var', 'vendor'];

$finder = PhpCsFixer\Finder::create()->in(__DIR__)->exclude($excludedDirs);

/** @see https://mlocati.github.io/php-cs-fixer-configurator/#version:3.82 for details/examples of configuration */
$rules = [
    '@PSR12' => true,
    'declare_strict_types' => true,
    'fully_qualified_strict_types' => true,
    'array_syntax' => ['syntax' => 'short'],
    'blank_line_before_statement' => ['statements' => ['return']],
    'no_blank_lines_after_phpdoc' => true,
    'single_line_comment_style' => ['comment_types' => ['asterisk']],
    'single_quote' => ['strings_containing_single_quote_chars' => true],
    'modernize_types_casting' => true,
    'native_function_casing' => true,
    'native_type_declaration_casing' => true,
    'no_empty_comment' => true,
    'no_empty_statement' => true,
    'no_extra_blank_lines' => true,
    'no_leading_import_slash' => true,
    'no_leading_namespace_whitespace' => true,
    'no_null_property_initialization' => true,
    'no_short_bool_cast' => true,
    'no_spaces_around_offset' => true,
    'no_unneeded_control_parentheses' => true,
    'no_unneeded_braces' => true,
    'no_unreachable_default_argument_value' => true,
    'no_unused_imports' => true,
    'no_useless_return' => true,
    'no_whitespace_in_blank_line' => true,
    'pow_to_exponentiation' => true,
    'protected_to_private' => true,
    'trim_array_spaces' => true,
    'phpdoc_trim_consecutive_blank_line_separation' => true,
    'phpdoc_trim' => true,
    'no_empty_phpdoc' => true,
    'general_phpdoc_annotation_remove' => ['annotations' => ['package']],
    'no_superfluous_phpdoc_tags' => [
        'allow_mixed' => false,
        'allow_unused_params' => false,
        'remove_inheritdoc' => true
    ],
    'phpdoc_single_line_var_spacing' => true,
    'phpdoc_line_span' => ['const' => 'single' , 'property' => 'single', 'method' => 'single'],
    'php_unit_strict' => true,
    'strict_comparison' => true,
    'ordered_imports' => true,
    'new_expression_parentheses' => true
];

return new PhpCsFixer\Config()
    ->setRiskyAllowed(true)
    ->setRules($rules)
    ->setFinder($finder)
    ->setCacheFile(__DIR__ . '/var/cache/php-cs-fixer.cache');
