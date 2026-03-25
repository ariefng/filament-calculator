# Changelog

All notable changes to this project will be documented in this file.

## [1.2.0] - 2026-03-25

### Changed
- Reworked the calculator keypad into a 4-column by 5-row layout with dedicated clear, backspace, percentage, sign toggle, decimal, and equals controls.
- Replaced the string-based expression execution with a parser-based evaluator to avoid executing arbitrary code inside the browser.
- Calculator display now shows the current expression and a live computed result aligned to the right, and the Insert action now inserts the live result directly.
- Calculator now reopens with the current field value when available, with `initial_value` controlling either existing-field-or-zero behavior or always-zero behavior.
- Removed the `00` and `000` buttons and their related input behavior.
- Added locale-aware decimal separator handling with optional config override via `decimal_separator`.
- Improved targeting for `TextInput` components inside `Repeater` items by storing the clicked origin input before opening the calculator modal.
- Enlarged the modal Insert action and refreshed README documentation for the new calculator workflow.

## [1.1.0] - 2026-03-22

### Changed
- Removed Dependabot configuration from the repository.
- Calculator operator and evaluate buttons now use the Filament gray color palette by default.
- Added `operator_buttons.color` configuration to override the calculator operator palette.
- Calculator display now keeps long expressions inside the viewport without overflowing the visible screen.
- Refined package description and README to focus on Filament panel forms and Filament 4/5 support.

## [1.0.0] - 2026-03-14

### Added
- Initial release
- Calculator modal action for Filament TextInput
- Supports Filament Admin Panel