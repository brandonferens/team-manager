<?php

/**
 * php-cs-fixer - configuration file
 * http://cs.sensiolabs.org/
 */

use Symfony\CS\FixerInterface;

$finder = PhpCsFixer\Finder::create()
    ->exclude('bootstrap/cache')
    ->exclude('bower_components')
    ->exclude('node_modules')
    ->exclude('database')
    ->exclude('public/admin/server')
    ->exclude('storage')
    ->exclude('vendor')
    ->notName('*.xml')
    ->notName('*.yml')
    ->notName('*.lock')
    ->notName('*.json')
    ->in(__DIR__)
;

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setUsingCache(true)
    ->setRules([
        // Standard
        '@PSR2' => true,

        // Configuration
        'array_syntax' => [
            'syntax' => 'short'
        ],
        'binary_operator_spaces' => [
            'align_double_arrow' => true,
            'align_equals' => true,
        ],
        'blank_line_before_return' => true,
        'cast_spaces' => true,
        'concat_space' => [
            'spacing' => 'one'
        ],
        'new_with_braces' => true,
        'no_blank_lines_after_class_opening' => true,
        'no_extra_consecutive_blank_lines' => true,
        'no_leading_import_slash' => true,
        'no_short_echo_tag' => true,
        'no_trailing_comma_in_singleline_array' => true,
        'no_unused_imports' => true,
        'not_operator_with_successor_space' => true,
        'object_operator_without_whitespace' => true,
        'self_accessor' => true,
        'single_quote' => true,
        'standardize_not_equals' => true,
        'ternary_operator_spaces' => true,
        'trailing_comma_in_multiline_array' => true,
        'trim_array_spaces' => true,
        'unary_operator_spaces' => true,
        'no_trailing_whitespace' => true,
        'no_trailing_whitespace_in_comment' => true,
        'no_whitespace_in_blank_line' => true,

        // PHPDoc
        'phpdoc_indent' => true,
        'phpdoc_inline_tag' => true,
        'phpdoc_no_access' => true,
        'phpdoc_no_empty_return' => true,
        'phpdoc_no_package' => true,
        'phpdoc_align' => true,
        'phpdoc_scalar' => true,
        'phpdoc_separation' => true,
        'phpdoc_trim' => true,
        'phpdoc_order' =>true,
        'phpdoc_var_without_name' => true,
    ])
    ->setFinder($finder);
