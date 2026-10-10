# libpf

`libpf` is a ReinfyTeam-maintained Virion library for detecting and filtering profanity in text. It provides static helpers for matching configured words, replacing matches, normalizing common Unicode lookalikes and retrieving the built-in English word list.

The library is intended to be included in a PocketMine-MP plugin or another compatible consumer. It is not a standalone plugin and does not provide a PHAR release by itself.

## Requirements and compatibility

- PHP 8.1 or newer for development and analysis.
- A consumer that can package or load the Virion library.
- The current `virion.yml` metadata lists Virion APIs `1.0.0` through `4.0.0`. Do not infer PocketMine-MP API 5 support from this library alone; verify the consuming plugin separately.

## Installation

The repository declares the Composer package name `reinfyteam/libpf`, but a Packagist listing was not verified. Configure the repository as a VCS/path dependency or include it through the consumer's supported Virion packaging flow. The [libpf-ExamplePlugin](https://github.com/ReinfyTeam/libpf-ExamplePlugin) repository demonstrates integration in a PocketMine-MP plugin.

## Usage

The public class is `ReinfyTeam\libpf\libpf`:

```php
use ReinfyTeam\libpf\libpf;

$words = ["example"];

if (libpf::detectProfanity($message, $words)) {
    $filtered = libpf::removeProfanity($message, $words);
}
```

The available helpers are:

- `detectProfanity(string $message, array $words): bool` checks whether a configured word matches.
- `removeProfanity(string $message, array $words, string $replacementCharacter = "#"): string` replaces matched words.
- `removeUnicode(string $text, bool $include_unicode = false): string` normalizes common lookalike characters and, when requested, removes the additional byte range handled by the current implementation.
- `defaultProfanity(): list<string>` returns the built-in English word list.

Use a listener in the consuming plugin when filtering chat, and make the moderation policy explicit to server administrators. The library does not cancel events, send messages or choose a punishment policy on behalf of the consumer.

## Build and test

Install the locked development dependencies and run the repository's maximum-level analysis:

```sh
composer install
composer analyse
```

This is a library/virion package, so packaging and runtime behavior must be verified through an appropriate consumer. Do not create a standalone plugin PHAR from this checkout or claim consumer compatibility from PHPStan alone.

## Support and contributing

For reproducible library issues, open an [issue](https://github.com/ReinfyTeam/libpf/issues) with the library revision, consumer project, PHP/runtime versions and a minimal input demonstrating the problem. Preserve upstream attribution and the existing public namespace when contributing compatibility fixes.

## Credits and license

`libpf` is maintained by [ReinfyTeam](https://github.com/ReinfyTeam). The project is licensed under [LGPL-2.1-only](LICENSE).
