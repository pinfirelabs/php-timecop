# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Overview

PHP Timecop is a PHP extension that provides time travel and time freezing capabilities for testing time-dependent code. It works by overriding PHP's built-in time functions and DateTime classes.

## Build Commands

### Manual Build (Unix/Linux/macOS)
```bash
phpize
./configure
make
make test
sudo make install
```

### Installation via Package Managers
```bash
# Homebrew (macOS)
brew install homebrew/php/php56-timecop

# PECL
pecl install timecop
```

### Running Tests
```bash
# Run all tests
make test

# Run specific test
make test TESTS=tests/core_005.phpt

# Run tests with verbose output
make test TESTS="-v tests/core_005.phpt"
```

## Architecture

### Core Components

1. **Time Modes** (timecop_globals.h):
   - `TIMECOP_MODE_REALTIME` (0): Normal time behavior
   - `TIMECOP_MODE_FREEZE` (1): Time is frozen at specific point
   - `TIMECOP_MODE_TRAVEL` (2): Time offset applied to current time

2. **Function Override System**:
   - `timecop_func_override.c`: Implements function interception mechanism
   - Overrides ~20 PHP time functions including `time()`, `date()`, `strtotime()`
   - Uses PHP's internal function table manipulation

3. **DateTime Integration**:
   - `timecop_datetime.c`: Extended DateTime/DateTimeImmutable classes
   - Provides TimecopDateTime and TimecopDateTimeImmutable classes
   - Integrates time travel into OOP interface

4. **Version-Specific Implementations**:
   - `php5/`: PHP 5.x compatible implementation
   - `php7/`: PHP 7.x/8.x compatible implementation
   - Selected at compile time based on PHP version

### Key Functions

- `timecop_freeze(DateTime|string|int $time)`: Freeze time at specific point
- `timecop_travel(DateTime|string|int $time)`: Set time offset from current time
- `timecop_return()`: Return to real time
- `timecop_scale(float $scale)`: Speed up/slow down time passage

## Common Development Tasks

### Adding New Function Override
1. Add function to override list in `timecop_func_override.c`
2. Implement override handler following existing patterns
3. Add tests in appropriate test category
4. Update version if needed

### Debugging Test Failures
- Check PHP version-specific behavior in `php5/` vs `php7/` directories
- Review timezone handling - many issues relate to timezone assumptions
- Use `TIMECOP_DEBUG` environment variable for debug output

## Testing Strategy

Tests are organized by category:
- `tests/core_*.phpt`: Core functionality tests
- `tests/date_*.phpt`: DateTime integration tests
- `tests/func_*.phpt`: Function override tests
- `tests/immutable_*.phpt`: DateTimeImmutable tests
- `tests/issue_*.phpt`: Regression tests for specific issues

## CI/CD Pipeline

Multiple CI platforms are configured:
- Travis CI: Linux builds (`.travis.yml`)
- CircleCI: Additional Linux testing (`circle.yml`)
- AppVeyor: Windows builds (`appveyor.yml`)
- Wercker: Container-based testing (`wercker.yml`)

## Important Notes

1. **Version Management**: Version is maintained in multiple places:
   - `version.h`
   - `timecop.h`
   - `package.xml`
   - All must be updated for releases

2. **Platform Differences**: Windows uses `config.w32` instead of `config.m4`

3. **Time Precision**: Microsecond support varies by PHP version and platform

4. **Thread Safety**: Extension is designed to be thread-safe (ZTS compatible)