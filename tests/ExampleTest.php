<?php

use Ariefng\FilamentCalculator\Actions\CalculatorAction;
use Filament\Forms\Components\TextInput;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Enums\Size;
use Filament\Support\Enums\Width;

it('configures the calculator action modal', function () {
    $action = CalculatorAction::make();

    expect($action->getName())->toBe('calculator')
        ->and($action->getModalHeading())->toBe(__('filament-calculator::calculator.title'))
        ->and($action->getModalDescription())->toBe(__('filament-calculator::calculator.description'))
        ->and($action->getIcon())->toBe('heroicon-o-calculator')
        ->and($action->getColor())->toBe('gray')
        ->and($action->getModalWidth())->toBe(Width::Small)
        ->and($action->getAlpineClickHandler())->toContain('$wire.mountAction(\'calculator\'');
});

it('renders calculator blade with digit limit messaging', function () {
    $html = view('filament-calculator::action.calculator-action', [
        'maxDigits' => 15,
        'maxDigitsMessage' => __('filament-calculator::calculator.max_digits_reached', ['max' => 15]),
        'invalidExpressionMessage' => __('filament-calculator::calculator.invalid_expression'),
        'defaultValue' => 'field',
        'currentValue' => '100',
        'decimalSeparator' => ',',
        'locale' => 'id',
        'targetInputId' => 'amount',
        'targetInputStatePath' => 'data.repeater_test.record-1.amount',
    ])->render();

    expect($html)->toContain('data-max-digits="15"')
        ->and($html)->toContain(e(__('filament-calculator::calculator.max_digits_reached', ['max' => 15])))
        ->and($html)->toContain(e(__('filament-calculator::calculator.invalid_expression')))
        ->and($html)->toContain('--color-50:var(--gray-50)')
        ->and($html)->toContain('data-default-value="field"')
        ->and($html)->toContain('data-current-value="100"')
        ->and($html)->toContain('data-decimal-separator=","')
        ->and($html)->toContain('data-locale="id"')
        ->and($html)->toContain('data-target-input-id="amount"')
        ->and($html)->toContain('data-target-input-state-path="data.repeater_test.record-1.amount"')
        ->and($html)->toContain('x-ref="displayViewport"')
        ->and($html)->toContain('window.filamentCalculatorOriginInput ?? null')
        ->and($html)->toContain('resolveInitialDisplay()')
        ->and($html)->toContain('normalizeInitialValue(source)')
        ->and($html)->toContain('standardizeExternalValue(value)')
        ->and($html)->toContain('resolveTargetInputElement()')
        ->and($html)->toContain("attribute.name.startsWith('wire:model')")
        ->and($html)->toContain('syncDisplayViewport()')
        ->and($html)->toContain('evaluateExpression(value = this.display)')
        ->and($html)->toContain('resolveThousandsSeparator(decimalSeparator)')
        ->and($html)->toContain('formatExpressionForDisplay(display)')
        ->and($html)->toContain('normalizeInsertedValue(this.result)')
        ->and($html)->toContain('normalizeCalculatedValue(value)')
        ->and($html)->toContain('value = this.normalizeCalculatedValue(value * right)')
        ->and($html)->toContain("value = this.normalizeCalculatedValue(operator === '+' ? value + right : value - right)")
        ->and($html)->toContain("normalizedValue.toLocaleString('en-US'")
        ->and($html)->toContain('calculator-insert-requested')
        ->and($html)->toContain('data-calculator-display')
        ->and($html)->toContain("appendDigit('0')")
        ->and($html)->not->toContain("appendDigit('00')")
        ->and($html)->not->toContain("appendDigit('000')")
        ->and($html)->not->toContain('Function(`');
});

it('makes the insert modal action full width', function () {
    $action = CalculatorAction::make();
    $reflection = new ReflectionProperty($action, 'extraModalFooterActions');
    $reflection->setAccessible(true);
    $extraModalFooterActions = $reflection->getValue($action);
    $component = new class('amount') extends TextInput
    {
        public function getId(): string
        {
            return 'amount';
        }

        public function getStatePath(bool $isAbsolute = true): string
        {
            return 'data.amount';
        }
    };

    $insertAction = $extraModalFooterActions($action, $component)[0];

    expect($insertAction->getExtraAttributes())
        ->toMatchArray(['class' => 'fc-calculator-insert-action'])
        ->and($insertAction->getSize())->toBe(Size::Large);
});

it('uses the configured calculator action options', function () {
    config()->set('filament-calculator.action.icon', 'heroicon-o-bolt');
    config()->set('filament-calculator.action.color', 'success');
    config()->set('filament-calculator.action.modal_width', 'md');
    config()->set('filament-calculator.initial_value', 'zero');
    config()->set('filament-calculator.decimal_separator', 'comma');
    config()->set('filament-calculator.insert_action.color', 'danger');
    config()->set('filament-calculator.insert_action.icon', 'heroicon-o-arrow-left');
    config()->set('filament-calculator.insert_action.icon_position', 'before');
    config()->set('filament-calculator.operator_buttons.color', 'warning');

    $action = CalculatorAction::make();
    $reflection = new ReflectionProperty($action, 'extraModalFooterActions');
    $reflection->setAccessible(true);
    $extraModalFooterActions = $reflection->getValue($action);
    $component = new class('amount') extends TextInput
    {
        public function getId(): string
        {
            return 'amount';
        }

        public function getState(): mixed
        {
            return '100';
        }

        public function getStatePath(bool $isAbsolute = true): string
        {
            return 'data.repeater_test.record-1.amount';
        }
    };

    $insertAction = $extraModalFooterActions($action, $component)[0];
    $modalContent = getRenderedModalContent($action, $component);

    expect($action->getIcon())->toBe('heroicon-o-bolt')
        ->and($action->getColor())->toBe('success')
        ->and($action->getModalWidth())->toBe(Width::Medium)
        ->and($insertAction->getColor())->toBe('danger')
        ->and($insertAction->getIcon())->toBe('heroicon-o-arrow-left')
        ->and($insertAction->getIconPosition())->toBe(IconPosition::Before)
        ->and($modalContent)->toContain('--color-50:var(--warning-50)')
        ->and($modalContent)->toContain('data-decimal-separator=","')
        ->and($modalContent)->toContain('data-default-value="0"')
        ->and($modalContent)->toContain('data-current-value="100"')
        ->and($modalContent)->toContain('data-target-input-id="amount"')
        ->and($modalContent)->toContain('data-target-input-state-path="data.repeater_test.record-1.amount"');
});

it('treats locale decimal separator config as auto detection', function () {
    config()->set('filament-calculator.decimal_separator', 'locale');

    $action = new class('calculator') extends CalculatorAction
    {
        public function configuredDecimalSeparator(): ?string
        {
            return $this->getConfiguredDecimalSeparator();
        }
    };

    expect($action->configuredDecimalSeparator())->toBeNull();
});

function getRenderedModalContent(CalculatorAction $action, TextInput $component): string
{
    $reflection = new ReflectionProperty($action, 'modalContent');
    $reflection->setAccessible(true);

    $modalContent = $reflection->getValue($action);

    return $modalContent($component)->render();
}
