<?php declare(strict_types=1);


$config = new PhpCsFixer\Config();
$config
    ->setUsingCache(false)
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'ordered_imports' => true,
        'no_unused_imports' => true,
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude(['config', 'vendor'])
            ->in(__DIR__)
    );

return $config;