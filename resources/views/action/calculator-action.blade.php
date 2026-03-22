@props([
    'maxDigits' => 15,
    'maxDigitsMessage' => '',
    'invalidExpressionMessage' => '',
    'operatorButtonsColor' => 'gray',
])

<div>
    <div
        x-load-css="[@js(\Filament\Support\Facades\FilamentAsset::getStyleHref('calculator-styles', package: 'ariefng/filament-calculator'))]"
        data-max-digits="{{ $maxDigits }}"
        data-max-digits-message="{{ $maxDigitsMessage }}"
        data-invalid-expression-message="{{ $invalidExpressionMessage }}"
        style="{{ \Filament\Support\get_color_css_variables($operatorButtonsColor, [50, 100, 200, 300, 500, 700, 900, 950]) }}"
        x-data="{
            display: '0',
            error: '',
            maxDigits: 15,
            maxDigitsMessage: '',
            invalidExpressionMessage: '',
            init() {
                this.maxDigits = Number(this.$el.dataset.maxDigits || 15)
                this.maxDigitsMessage = this.$el.dataset.maxDigitsMessage || ''
                this.invalidExpressionMessage = this.$el.dataset.invalidExpressionMessage || ''

                this.$nextTick(() => this.syncDisplayViewport())
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
            insert(targetInputId, invalidMessage, maxDigits, maxDigitsMessage) {
                const isNumeric = /^-?(?:\d+|\d*\.\d+)$/.test(this.display)

                this.error = ''

                if (this.countDigits(this.display) > maxDigits) {
                    this.error = maxDigitsMessage

                    return
                }

                if (! isNumeric) {
                    this.error = invalidMessage

                    return
                }

                const input = document.getElementById(targetInputId)

                if (! input) {
                    return
                }

                input.value = this.display
                input.dispatchEvent(new Event('input', { bubbles: true }))
                input.dispatchEvent(new Event('change', { bubbles: true }))

                close()
            },
            append(value) {
                this.error = ''

                const nextDisplay = (this.display === '0' && value !== '.')
                    ? value
                    : ['+', '-', '*', '/'].includes(value) && ['+', '-', '*', '/'].includes(this.display.slice(-1))
                        ? this.display.slice(0, -1) + value
                        : this.display + value

                if (this.countDigits(nextDisplay) > this.maxDigits) {
                    this.error = this.maxDigitsMessage

                    return
                }

                if (this.display === '0' && value !== '.') {
                    this.updateDisplay(value)

                    return
                }

                if (['+', '-', '*', '/'].includes(value)) {
                    const endsInOperator = ['+', '-', '*', '/'].includes(this.display.slice(-1))

                    if (endsInOperator) {
                        this.updateDisplay(this.display.slice(0, -1) + value)

                        return
                    }
                }

                this.updateDisplay(this.display + value)
            },
            clear() {
                this.updateDisplay('0')
                this.error = ''
            },
            backspace() {
                this.updateDisplay(this.display.length <= 1 ? '0' : this.display.slice(0, -1))
                this.error = ''
            },
            evaluate() {
                const expression = this.display.replace(/[^0-9.+\-*/]/g, '')
                this.error = ''

                if (expression === '') {
                    this.updateDisplay('0')

                    return
                }

                try {
                    const result = Function(`'use strict'; return (${expression})`)()

                    if (Number.isFinite(result)) {
                        if (this.countDigits(String(result)) > this.maxDigits) {
                            this.error = this.maxDigitsMessage
                            this.updateDisplay('0')

                            return
                        }

                        this.updateDisplay(String(result))

                        return
                    }
                } catch (e) {
                }

                this.error = this.invalidExpressionMessage
                this.updateDisplay('0')
            },
            updateDisplay(value) {
                this.display = value

                this.$nextTick(() => this.syncDisplayViewport())
            },
        }"
        x-on:calculator-insert-requested.window="insert($event.detail.targetInputId, $event.detail.invalidMessage, $event.detail.maxDigits, $event.detail.maxDigitsMessage)"
        class="fc-calculator-container"
    >
        <div class="fc-calculator-display-wrapper">
            <div class="fc-calculator-display-viewport" x-ref="displayViewport">
                <div
                    data-calculator-display
                    class="fc-calculator-display"
                    x-text="display"
                >
                    0
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
            @foreach (['7', '8', '9', '+', '4', '5', '6', '-', '1', '2', '3', '*', '0', '00', '000', '/'] as $token)
                <button
                    type="button"
                    x-on:click="append('{{ $token }}')"
                    class="fc-calculator-button {{ in_array($token, ['+', '-', '*', '/']) ? 'fc-calculator-button-operator' : 'fc-calculator-button-number' }}"
                >
                    {{ $token }}
                </button>
            @endforeach
        </div>

        <div class="fc-calculator-actions-grid">
            <button type="button" x-on:click="clear()" class="fc-calculator-action-button">{{ __('filament-calculator::calculator.actions.clear') }}</button>
            <button type="button" x-on:click="backspace()" class="fc-calculator-action-button fc-calculator-action-button-amber">{{ __('filament-calculator::calculator.actions.backspace') }}</button>
            <button type="button" x-on:click="evaluate()" class="fc-calculator-action-button fc-calculator-action-button-primary">{{ __('filament-calculator::calculator.actions.evaluate') }}</button>
        </div>
    </div>
</div>
