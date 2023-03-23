<?php
declare(strict_types=1);

namespace Utils\PHPStan\Tests\NoBusinessLogicInController;

use PHPStan\Rules\Rule;
use Utils\PHPStan\DeterminationBasedOnSuffix;
use Utils\PHPStan\NoBusinessLogicInController;

final class NoBusinessLogicInControllerTest extends \PHPStan\Testing\RuleTestCase
{
    public function testSkipControllerWithNothingInIt(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixtures/skip-controller-if-everything-ok.php',
            ],
            [
                // we expect no errors
            ]
        );
    }

    public function testSkipLogicInNotController(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixtures/skip-if-something-in-base-class.php',
            ],
            [
                // we expect no errors
            ]
        );
    }

    public function testFoundErrorInForLoop(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixtures/method-has-for-loop.php',
            ],
            [
                ['Method index in controller ErrorsController contains business logic. Move it to a dedicated service or repository.', 4]
            ],
        );
    }

    public function testFoundErrorInIfStatement(): void
    {
        $this->analyse(
            [
                __DIR__ . '/Fixtures/method-has-if-statement.php',
            ],
            [
                ['Method index in controller ErrorsWithIfController contains business logic. Move it to a dedicated service or repository.', 4]
            ],
        );
    }

    /**
     * @inheritDoc
     */
    protected function getRule(): Rule
    {
        return new NoBusinessLogicInController(new DeterminationBasedOnSuffix());
    }
}