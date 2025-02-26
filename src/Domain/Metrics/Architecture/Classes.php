<?php

declare(strict_types=1);

namespace NunoMaduro\PhpInsights\Domain\Metrics\Architecture;

use NunoMaduro\PhpInsights\Domain\Collector;
use NunoMaduro\PhpInsights\Domain\Contracts\HasInsights;
use NunoMaduro\PhpInsights\Domain\Contracts\HasValue;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenNormalClasses;
use ObjectCalisthenics\Sniffs\Files\ClassTraitAndInterfaceLengthSniff;
use ObjectCalisthenics\Sniffs\Metrics\MethodPerClassLimitSniff;
use ObjectCalisthenics\Sniffs\Metrics\PropertyPerClassLimitSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Files\OneClassPerFileSniff;
use PHP_CodeSniffer\Standards\PSR1\Sniffs\Classes\ClassDeclarationSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Classes\ValidClassNameSniff;
use PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer;
use PhpCsFixer\Fixer\ClassNotation\SingleClassElementPerStatementFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\Import\SingleImportPerStatementFixer;
use SlevomatCodingStandard\Sniffs\Classes\SuperfluousAbstractClassNamingSniff;
use SlevomatCodingStandard\Sniffs\Classes\SuperfluousInterfaceNamingSniff;

final class Classes implements HasValue, HasInsights
{
    public function getValue(Collector $collector): string
    {
        return sprintf('%d', $collector->getClasses());
    }

    /**
     * {@inheritdoc}
     */
    public function getInsights(): array
    {
        return [
            ForbiddenNormalClasses::class,
            ValidClassNameSniff::class,
            ClassDeclarationSniff::class,
            ClassTraitAndInterfaceLengthSniff::class,
            MethodPerClassLimitSniff::class,
            PropertyPerClassLimitSniff::class,
            OneClassPerFileSniff::class,
            SuperfluousInterfaceNamingSniff::class,
            SuperfluousAbstractClassNamingSniff::class,
            SingleClassElementPerStatementFixer::class,
            SingleImportPerStatementFixer::class,
            OrderedClassElementsFixer::class,
            OrderedImportsFixer::class,
        ];
    }

    public function getPercentage(Collector $collector): float
    {
        return count($collector->getFiles()) > 0 ? ($collector->getClasses() / count($collector->getFiles())) * 100 : 0;
    }
}
