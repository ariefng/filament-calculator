@props([
    'maxDigits' => 15,
    'maxDigitsMessage' => '',
    'invalidExpressionMessage' => '',
    'operatorButtonsColor' => 'gray',
    'defaultValue' => 'field',
    'currentValue' => null,
    'decimalSeparator' => 'locale',
    'locale' => 'en',
    'targetInputId' => null,
    'targetInputStatePath' => null,
])

@php
    $backspaceIcon = <<<'SVG'
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        <path d="M5.83 5.146a.5.5 0 0 0 0 .708L7.975 8l-2.147 2.146a.5.5 0 0 0 .707.708l2.147-2.147 2.146 2.147a.5.5 0 0 0 .707-.708L9.39 8l2.146-2.146a.5.5 0 0 0-.707-.708L8.683 7.293 6.536 5.146a.5.5 0 0 0-.707 0z"/>
        <path d="M13.683 1a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-7.08a2 2 0 0 1-1.519-.698L.241 8.65a1 1 0 0 1 0-1.302L5.084 1.7A2 2 0 0 1 6.603 1zm-7.08 1a1 1 0 0 0-.76.35L1 8l4.844 5.65a1 1 0 0 0 .759.35h7.08a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1z"/>
    </svg>
    SVG;
    $percentageIcon = <<<'SVG'
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        <path d="M13.442 2.558a.625.625 0 0 1 0 .884l-10 10a.625.625 0 1 1-.884-.884l10-10a.625.625 0 0 1 .884 0M4.5 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5m7 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
    </svg>
    SVG;
    $multiplyIcon = <<<'SVG'
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
    </svg>
    SVG;
    $minusIcon = <<<'SVG'
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8"/>
    </svg>
    SVG;
    $plusIcon = <<<'SVG'
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
    </svg>
    SVG;
    $toggleSignIcon = <<<'SVG'
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        <path d="m1.854 14.854 13-13a.5.5 0 0 0-.708-.708l-13 13a.5.5 0 0 0 .708.708M4 1a.5.5 0 0 1 .5.5v2h2a.5.5 0 0 1 0 1h-2v2a.5.5 0 0 1-1 0v-2h-2a.5.5 0 0 1 0-1h2v-2A.5.5 0 0 1 4 1m5 11a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5A.5.5 0 0 1 9 12"/>
    </svg>
    SVG;
    $divideIcon = <<<'SVG'
    <svg width="100%" height="100%" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M4 12H20M13 6C13 6.55228 12.5523 7 12 7C11.4477 7 11 6.55228 11 6C11 5.44772 11.4477 5 12 5C12.5523 5 13 5.44772 13 6ZM13 18C13 18.5523 12.5523 19 12 19C11.4477 19 11 18.5523 11 18C11 17.4477 11.4477 17 12 17C12.5523 17 13 17.4477 13 18Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    SVG;
    $equalIcon = <<<'SVG'
    <svg width="100%" height="100%" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M5 9H19M5 15H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    SVG;

    $buttons = [
        ['kind' => 'clear', 'label' => 'C', 'variant' => 'danger', 'ariaLabel' => __('filament-calculator::calculator.actions.clear')],
        ['kind' => 'backspace', 'icon' => $backspaceIcon, 'variant' => 'warning', 'ariaLabel' => __('filament-calculator::calculator.actions.backspace')],
        ['kind' => 'percentage', 'icon' => $percentageIcon, 'variant' => 'operator', 'ariaLabel' => __('filament-calculator::calculator.actions.percentage')],
        ['kind' => 'operator', 'value' => '/', 'icon' => $divideIcon, 'variant' => 'operator', 'ariaLabel' => __('filament-calculator::calculator.actions.divide')],
        ['kind' => 'digit', 'value' => '7', 'label' => '7', 'variant' => 'number'],
        ['kind' => 'digit', 'value' => '8', 'label' => '8', 'variant' => 'number'],
        ['kind' => 'digit', 'value' => '9', 'label' => '9', 'variant' => 'number'],
        ['kind' => 'operator', 'value' => '*', 'icon' => $multiplyIcon, 'variant' => 'operator', 'ariaLabel' => __('filament-calculator::calculator.actions.multiply')],
        ['kind' => 'digit', 'value' => '4', 'label' => '4', 'variant' => 'number'],
        ['kind' => 'digit', 'value' => '5', 'label' => '5', 'variant' => 'number'],
        ['kind' => 'digit', 'value' => '6', 'label' => '6', 'variant' => 'number'],
        ['kind' => 'operator', 'value' => '-', 'icon' => $minusIcon, 'variant' => 'operator', 'ariaLabel' => __('filament-calculator::calculator.actions.minus')],
        ['kind' => 'digit', 'value' => '1', 'label' => '1', 'variant' => 'number'],
        ['kind' => 'digit', 'value' => '2', 'label' => '2', 'variant' => 'number'],
        ['kind' => 'digit', 'value' => '3', 'label' => '3', 'variant' => 'number'],
        ['kind' => 'operator', 'value' => '+', 'icon' => $plusIcon, 'variant' => 'operator', 'ariaLabel' => __('filament-calculator::calculator.actions.plus')],
        ['kind' => 'toggle-sign', 'icon' => $toggleSignIcon, 'variant' => 'operator', 'ariaLabel' => __('filament-calculator::calculator.actions.toggle_sign')],
        ['kind' => 'digit', 'value' => '0', 'label' => '0', 'variant' => 'number'],
        ['kind' => 'decimal', 'label' => 'locale', 'variant' => 'number', 'ariaLabel' => __('filament-calculator::calculator.actions.decimal')],
        ['kind' => 'evaluate', 'icon' => $equalIcon, 'variant' => 'primary', 'ariaLabel' => __('filament-calculator::calculator.actions.evaluate')],
    ];
@endphp

<div>
    <div
        x-load-css="[@js(\Filament\Support\Facades\FilamentAsset::getStyleHref('calculator-styles', package: 'ariefng/filament-calculator'))]"
        data-max-digits="{{ $maxDigits }}"
        data-max-digits-message="{{ $maxDigitsMessage }}"
        data-invalid-expression-message="{{ $invalidExpressionMessage }}"
        data-default-value="{{ $defaultValue ?? '' }}"
        data-current-value="{{ $currentValue ?? '' }}"
        data-decimal-separator="{{ $decimalSeparator ?? '' }}"
        data-locale="{{ $locale }}"
        data-target-input-id="{{ $targetInputId ?? '' }}"
        data-target-input-state-path="{{ $targetInputStatePath ?? '' }}"
        style="{{ \Filament\Support\get_color_css_variables($operatorButtonsColor, [50, 100, 200, 300, 500, 700, 900, 950]) }}"
        x-data="{
            display: '0',
            result: '0',
            hasResult: true,
            currentValue: null,
            defaultValue: 'field',
            error: '',
            maxDigits: 15,
            maxDigitsMessage: '',
            invalidExpressionMessage: '',
            decimalSeparator: '.',
            thousandsSeparator: ',',
            locale: 'en',
            targetInputId: null,
            targetInputStatePath: null,
            init() {
                this.maxDigits = Number(this.$el.dataset.maxDigits || 15)
                this.maxDigitsMessage = this.$el.dataset.maxDigitsMessage || ''
                this.invalidExpressionMessage = this.$el.dataset.invalidExpressionMessage || ''
                this.defaultValue = this.$el.dataset.defaultValue || '0'
                this.currentValue = this.$el.dataset.currentValue || null
                this.locale = this.$el.dataset.locale || 'en'
                this.targetInputId = this.$el.dataset.targetInputId || null
                this.targetInputStatePath = this.$el.dataset.targetInputStatePath || null
                this.decimalSeparator = this.resolveDecimalSeparator(this.$el.dataset.decimalSeparator || '')
                this.thousandsSeparator = this.resolveThousandsSeparator(this.decimalSeparator)
                this.updateDisplay(this.resolveInitialDisplay())
            },
            isBlankValue(value) {
                return value === null || value === undefined || String(value).trim() === ''
            },
            readTargetInputValue() {
                const input = this.resolveTargetInputElement()

                return input ? input.value : null
            },
            getStoredOriginInput() {
                const input = window.filamentCalculatorOriginInput ?? null

                return input?.isConnected ? input : null
            },
            resolveTargetInputElement() {
                const storedOriginInput = this.getStoredOriginInput()

                if (storedOriginInput) {
                    return storedOriginInput
                }

                if (this.targetInputStatePath) {
                    const inputs = Array.from(document.querySelectorAll('input'))

                    const statePathMatchedInput = inputs.find((input) => Array.from(input.attributes).some((attribute) => {
                        return attribute.name.startsWith('wire:model') && attribute.value === this.targetInputStatePath
                    }))

                    if (statePathMatchedInput) {
                        return statePathMatchedInput
                    }
                }

                if (! this.targetInputId) {
                    return null
                }

                return document.getElementById(this.targetInputId)
            },
            resolveInitialDisplay() {
                const sources = this.defaultValue === '0'
                    ? ['0']
                    : [
                        this.readTargetInputValue(),
                        this.currentValue,
                        '0',
                    ]

                for (const source of sources) {
                    const normalized = this.normalizeInitialValue(source)

                    if (normalized !== null) {
                        return normalized
                    }
                }

                return '0'
            },
            normalizeInitialValue(value) {
                const standardizedValue = this.standardizeExternalValue(value)

                if (standardizedValue === null) {
                    return null
                }

                if (this.countDigits(standardizedValue) > this.maxDigits) {
                    return null
                }

                return this.decimalSeparator === ','
                    ? standardizedValue.replace('.', ',')
                    : standardizedValue
            },
            resolveDecimalSeparator(configuredSeparator) {
                if (configuredSeparator === '.' || configuredSeparator === ',') {
                    return configuredSeparator
                }

                try {
                    const parts = new Intl.NumberFormat(this.locale).formatToParts(1.1)
                    const decimalPart = parts.find((part) => part.type === 'decimal')

                    return decimalPart?.value === ',' ? ',' : '.'
                } catch (error) {
                    return '.'
                }
            },
            resolveThousandsSeparator(decimalSeparator) {
                try {
                    const parts = new Intl.NumberFormat(this.locale).formatToParts(1111.1)
                    const groupPart = parts.find((part) => part.type === 'group')

                    if (groupPart?.value && groupPart.value !== decimalSeparator) {
                        return groupPart.value
                    }
                } catch (error) {
                }

                return decimalSeparator === ',' ? '.' : ','
            },
            syncDisplayViewport() {
                const viewport = this.$refs.displayViewport

                if (! viewport) {
                    return
                }

                viewport.scrollLeft = viewport.scrollWidth
            },
            countDigits(value) {
                return (value.match(/\d/g) ?? []).length
            },
            getOperatorCharacters() {
                return ['+', '-', '*', '/']
            },
            isOperator(character) {
                return this.getOperatorCharacters().includes(character)
            },
            formatIntegerPartForDisplay(integerPart) {
                if (integerPart === '') {
                    return '0'
                }

                if (/^0\d+/.test(integerPart)) {
                    return integerPart
                }

                return integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, this.thousandsSeparator)
            },
            formatOperandForDisplay(operand) {
                if (operand === '') {
                    return ''
                }

                let sign = ''
                let unsignedOperand = operand

                if (['+', '-'].includes(unsignedOperand[0])) {
                    sign = unsignedOperand[0]
                    unsignedOperand = unsignedOperand.slice(1)
                }

                if (unsignedOperand === '') {
                    return sign
                }

                const hasDecimalSeparator = unsignedOperand.includes(this.decimalSeparator)
                const hasTrailingDecimalSeparator = unsignedOperand.endsWith(this.decimalSeparator)
                const [integerPart, fractionalPart = ''] = unsignedOperand.split(this.decimalSeparator)
                let formattedOperand = `${sign}${this.formatIntegerPartForDisplay(integerPart)}`

                if (hasTrailingDecimalSeparator) {
                    return `${formattedOperand}${this.decimalSeparator}`
                }

                if (hasDecimalSeparator) {
                    formattedOperand += `${this.decimalSeparator}${fractionalPart}`
                }

                return formattedOperand
            },
            formatExpressionForDisplay(value = this.display) {
                const segments = []
                let operand = ''

                for (let index = 0; index < value.length; index += 1) {
                    const character = value[index]
                    const isUnarySign = ['+', '-'].includes(character) && (index === 0 || this.isOperator(value[index - 1]))

                    if (! this.isOperator(character) || isUnarySign) {
                        operand += character

                        continue
                    }

                    if (operand !== '') {
                        segments.push(this.formatOperandForDisplay(operand))
                        operand = ''
                    }

                    segments.push(character)
                }

                if (operand !== '') {
                    segments.push(this.formatOperandForDisplay(operand))
                }

                return segments.join('')
            },
            normalizeDisplay(value = this.display) {
                return this.decimalSeparator === ','
                    ? value.replaceAll(',', '.')
                    : value
            },
            standardizeExternalValue(value) {
                if (this.isBlankValue(value)) {
                    return null
                }

                let standardizedValue = String(value)
                    .trim()
                    .replaceAll('\u00A0', '')
                    .replace(/\s+/g, '')

                const lastDotPosition = standardizedValue.lastIndexOf('.')
                const lastCommaPosition = standardizedValue.lastIndexOf(',')
                let decimalCharacter = null
                let groupingCharacter = null

                if (lastDotPosition !== -1 && lastCommaPosition !== -1) {
                    decimalCharacter = lastDotPosition > lastCommaPosition ? '.' : ','
                    groupingCharacter = decimalCharacter === '.' ? ',' : '.'
                } else if (lastCommaPosition !== -1) {
                    if (this.decimalSeparator === ',' || ! /^[-+]?\d{1,3}(,\d{3})+$/.test(standardizedValue)) {
                        decimalCharacter = ','
                    } else {
                        groupingCharacter = ','
                    }
                } else if (lastDotPosition !== -1) {
                    if (this.decimalSeparator === '.' || ! /^[-+]?\d{1,3}(\.\d{3})+$/.test(standardizedValue)) {
                        decimalCharacter = '.'
                    } else {
                        groupingCharacter = '.'
                    }
                }

                if (groupingCharacter) {
                    standardizedValue = standardizedValue.replaceAll(groupingCharacter, '')
                }

                if (decimalCharacter && decimalCharacter !== '.') {
                    standardizedValue = standardizedValue.replace(decimalCharacter, '.')
                }

                if (! /^[-+]?\d*(?:\.\d+)?$/.test(standardizedValue) || ['+', '-', '.', '+.', '-.'].includes(standardizedValue)) {
                    return null
                }

                return standardizedValue
            },
            normalizeInsertedValue(value) {
                return value.replace(this.decimalSeparator, '.')
            },
            normalizeCalculatedValue(value) {
                const precision = Math.min(this.maxDigits, 12)
                const factor = 10 ** precision
                const epsilon = value >= 0 ? Number.EPSILON : -Number.EPSILON

                return Math.round((value + epsilon) * factor) / factor
            },
            getSanitizedExpression(value = this.display) {
                let expression = this.normalizeDisplay(value).replace(/\s+/g, '')

                while (expression.endsWith('.')) {
                    expression = expression.slice(0, -1)
                }

                while (expression.length > 0 && this.isOperator(expression.slice(-1))) {
                    expression = expression.slice(0, -1)
                }

                return expression
            },
            tokenize(expression) {
                const tokens = []
                let index = 0

                while (index < expression.length) {
                    const character = expression[index]

                    if (/\d/.test(character) || character === '.') {
                        let number = character
                        index += 1

                        while (index < expression.length && (/\d/.test(expression[index]) || expression[index] === '.')) {
                            number += expression[index]
                            index += 1
                        }

                        if ((number.match(/\./g) ?? []).length > 1 || number === '.') {
                            return null
                        }

                        tokens.push({ type: 'number', value: Number(number) })

                        continue
                    }

                    if (this.isOperator(character)) {
                        tokens.push({ type: 'operator', value: character })
                        index += 1

                        continue
                    }

                    return null
                }

                return tokens
            },
            parseExpression(tokens) {
                const state = { index: 0 }

                const parsePrimary = () => {
                    const token = tokens[state.index]

                    if (! token || token.type !== 'number' || Number.isNaN(token.value)) {
                        return null
                    }

                    state.index += 1

                    return token.value
                }

                const parseUnary = () => {
                    const token = tokens[state.index]

                    if (token?.type === 'operator' && ['+', '-'].includes(token.value)) {
                        state.index += 1

                        const value = parseUnary()

                        if (value === null) {
                            return null
                        }

                        return token.value === '-' ? -value : value
                    }

                    return parsePrimary()
                }

                const parseProduct = () => {
                    let value = parseUnary()

                    if (value === null) {
                        return null
                    }

                    while (tokens[state.index]?.type === 'operator' && ['*', '/'].includes(tokens[state.index].value)) {
                        const operator = tokens[state.index].value
                        state.index += 1

                        const right = parseUnary()

                        if (right === null) {
                            return null
                        }

                        if (operator === '*') {
                            value = this.normalizeCalculatedValue(value * right)
                        }

                        if (operator === '/') {
                            if (right === 0) {
                                return null
                            }

                            value = this.normalizeCalculatedValue(value / right)
                        }
                    }

                    return value
                }

                const parseSum = () => {
                    let value = parseProduct()

                    if (value === null) {
                        return null
                    }

                    while (tokens[state.index]?.type === 'operator' && ['+', '-'].includes(tokens[state.index].value)) {
                        const operator = tokens[state.index].value
                        state.index += 1

                        const right = parseProduct()

                        if (right === null) {
                            return null
                        }

                        value = this.normalizeCalculatedValue(operator === '+' ? value + right : value - right)
                    }

                    return value
                }

                const value = parseSum()

                if (value === null || state.index !== tokens.length || ! Number.isFinite(value)) {
                    return null
                }

                return value
            },
            formatNumber(value) {
                const normalizedValue = Object.is(value, -0)
                    ? 0
                    : this.normalizeCalculatedValue(value)
                let formatted = normalizedValue.toLocaleString('en-US', {
                    useGrouping: false,
                    maximumFractionDigits: Math.min(this.maxDigits, 12),
                })

                if (formatted === '-0') {
                    formatted = '0'
                }

                return this.decimalSeparator === ','
                    ? formatted.replace('.', ',')
                    : formatted
            },
            evaluateExpression(value = this.display) {
                const expression = this.getSanitizedExpression(value)

                if (expression === '') {
                    return {
                        display: '0',
                        hasResult: true,
                        error: '',
                    }
                }

                const tokens = this.tokenize(expression)

                if (! tokens) {
                    return {
                        display: '',
                        hasResult: false,
                        error: this.invalidExpressionMessage,
                    }
                }

                const result = this.parseExpression(tokens)

                if (result === null) {
                    return {
                        display: '',
                        hasResult: false,
                        error: this.invalidExpressionMessage,
                    }
                }

                const formattedResult = this.formatNumber(result)

                if (this.countDigits(formattedResult) > this.maxDigits) {
                    return {
                        display: '',
                        hasResult: false,
                        error: this.maxDigitsMessage,
                    }
                }

                return {
                    display: formattedResult,
                    hasResult: true,
                    error: '',
                }
            },
            recalculate() {
                const evaluation = this.evaluateExpression()

                this.result = evaluation.display || '0'
                this.hasResult = evaluation.hasResult
                this.error = evaluation.error
            },
            insert(targetInputId) {
                const value = this.hasResult ? this.normalizeInsertedValue(this.result) : null

                if (! value) {
                    return
                }

                const input = this.resolveTargetInputElement()

                if (! input) {
                    return
                }

                input.value = value
                input.dispatchEvent(new Event('input', { bubbles: true }))
                input.dispatchEvent(new Event('change', { bubbles: true }))

                close()
            },
            updateDisplay(value) {
                if (this.countDigits(value) > this.maxDigits) {
                    this.error = this.maxDigitsMessage

                    return
                }

                this.display = value
                this.recalculate()

                this.$nextTick(() => this.syncDisplayViewport())
            },
            appendDigit(value) {
                const nextDisplay = this.display === '0'
                    ? value
                    : this.display === '-0'
                        ? `-${value}`
                        : this.display + value

                this.updateDisplay(nextDisplay)
            },
            appendOperator(value) {
                if (this.display === '0' && value !== '-') {
                    this.updateDisplay(`0${value}`)

                    return
                }

                if (this.isOperator(this.display.slice(-1))) {
                    this.updateDisplay(this.display.slice(0, -1) + value)

                    return
                }

                this.updateDisplay(this.display + value)
            },
            appendDecimal() {
                const bounds = this.getCurrentOperandBounds()
                const operand = this.display.slice(bounds.start, bounds.end)

                if (operand.includes(this.decimalSeparator)) {
                    return
                }

                if (operand === '' || operand === '-' || operand === '+') {
                    this.updateDisplay(`${this.display}0${this.decimalSeparator}`)

                    return
                }

                this.updateDisplay(`${this.display}${this.decimalSeparator}`)
            },
            clear() {
                this.updateDisplay('0')
            },
            backspace() {
                this.updateDisplay(this.display.length <= 1 ? '0' : this.display.slice(0, -1))
            },
            getCurrentOperandBounds() {
                let end = this.display.length
                let start = 0

                for (let index = this.display.length - 1; index >= 0; index -= 1) {
                    const character = this.display[index]

                    if (! this.isOperator(character)) {
                        continue
                    }

                    if ((character === '-' || character === '+') && (index === 0 || this.isOperator(this.display[index - 1]))) {
                        continue
                    }

                    start = index + 1
                    break
                }

                return { start, end }
            },
            toggleSign() {
                const bounds = this.getCurrentOperandBounds()
                const operand = this.display.slice(bounds.start, bounds.end)

                if (operand === '') {
                    this.updateDisplay(`${this.display}-`)

                    return
                }

                const replacement = operand.startsWith('-')
                    ? operand.slice(1)
                    : `-${operand}`

                this.updateDisplay(this.display.slice(0, bounds.start) + replacement)
            },
            applyPercentage() {
                const bounds = this.getCurrentOperandBounds()
                const operand = this.display.slice(bounds.start, bounds.end)

                if (! operand || operand === '-' || operand === '+') {
                    return
                }

                const normalizedOperand = this.decimalSeparator === ','
                    ? operand.replaceAll(',', '.')
                    : operand

                const numericOperand = Number(normalizedOperand)

                if (! Number.isFinite(numericOperand)) {
                    this.error = this.invalidExpressionMessage

                    return
                }

                const formattedOperand = this.formatNumber(numericOperand / 100)

                this.updateDisplay(this.display.slice(0, bounds.start) + formattedOperand)
            },
            evaluate() {
                if (! this.hasResult) {
                    return
                }

                this.updateDisplay(this.result)
            },
        }"
        x-on:calculator-insert-requested.window="targetInputId = $event.detail.targetInputId; targetInputStatePath = $event.detail.targetInputStatePath; insert($event.detail.targetInputId)"
        class="fc-calculator-container"
    >
        <div class="fc-calculator-display-wrapper">
            <div class="fc-calculator-display-viewport" x-ref="displayViewport">
                <div class="fc-calculator-display-stack">
                    <div
                        data-calculator-display
                        class="fc-calculator-display"
                        x-text="formatExpressionForDisplay(display)"
                    >
                        0
                    </div>

                    <div
                        class="fc-calculator-result"
                        x-show="hasResult"
                        x-text="`= ${formatExpressionForDisplay(result)}`"
                    >
                        = 0
                    </div>
                </div>
            </div>

            <p
                data-calculator-error
                class="fc-calculator-error"
                x-show="error"
                x-text="error"
            ></p>
        </div>

        <div class="fc-calculator-buttons-grid">
            @foreach ($buttons as $button)
                <button
                    type="button"
                    @if ($button['kind'] === 'digit')
                        x-on:click="appendDigit('{{ $button['value'] }}')"
                    @elseif ($button['kind'] === 'operator')
                        x-on:click="appendOperator('{{ $button['value'] }}')"
                    @elseif ($button['kind'] === 'clear')
                        x-on:click="clear()"
                    @elseif ($button['kind'] === 'backspace')
                        x-on:click="backspace()"
                    @elseif ($button['kind'] === 'percentage')
                        x-on:click="applyPercentage()"
                    @elseif ($button['kind'] === 'toggle-sign')
                        x-on:click="toggleSign()"
                    @elseif ($button['kind'] === 'decimal')
                        x-on:click="appendDecimal()"
                    @elseif ($button['kind'] === 'evaluate')
                        x-on:click="evaluate()"
                    @endif
                    class="fc-calculator-button fc-calculator-button-{{ $button['variant'] }}"
                    @if (isset($button['ariaLabel']))
                        aria-label="{{ $button['ariaLabel'] }}"
                        title="{{ $button['ariaLabel'] }}"
                    @endif
                >
                    @if ($button['kind'] === 'decimal')
                        <span x-text="decimalSeparator">.</span>
                    @elseif (isset($button['icon']))
                        <span class="fc-calculator-button-icon" aria-hidden="true">{!! $button['icon'] !!}</span>
                    @else
                        {{ $button['label'] }}
                    @endif
                </button>
            @endforeach
        </div>
    </div>
</div>
