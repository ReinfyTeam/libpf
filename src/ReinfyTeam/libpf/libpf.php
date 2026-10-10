<?php

/*
 *
 *  ____           _            __           _____
 * |  _ \    ___  (_)  _ __    / _|  _   _  |_   _|   ___    __ _   _ __ ___
 * | |_) |  / _ \ | | | '_ \  | |_  | | | |   | |    / _ \  / _` | | '_ ` _ \
 * |  _ <  |  __/ | | | | | | |  _| | |_| |   | |   |  __/ | (_| | | | | | | |
 * |_| \_\  \___| |_| |_| |_| |_|    \__, |   |_|    \___|  \__,_| |_| |_| |_|
 *                                   |___/
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author ReinfyTeam
 * @link https://github.com/ReinfyTeam/
 *
 *
 */

declare(strict_types=1);

namespace ReinfyTeam\libpf;

use Exception;
use function mb_strlen;
use function preg_quote;
use function preg_match;
use function preg_replace;
use function sizeof;
use function str_repeat;
use function str_replace;
use function strlen;

final class libpf {
	/**
	 * Whether to detect message on provided words.
	 *
	 * @param list<string> $words
	 */
	public static function detectProfanity(string $message, array $words) : bool {
		$filterCount = sizeof($words);
		for ($i = 0; $i < $filterCount; $i++) {
			$condition = preg_match("/" . preg_quote($words[$i], "/") . "/iu", $message) > 0;
			if ($condition) {
				return true;
			}
		}
		return false;
	}

	/**
	 * It is being used to remove profanities on message.
	 * Returns string convert to #### characters.
	 *
	 * @param list<string> $words
	 */
	public static function removeProfanity(string $message, array $words, string $replacementCharacter = "#") : string {
		if (strlen($replacementCharacter) < 1) {
			throw new Exception("Cannot replace character longer than 1 character.");
		}
		foreach ($words as $profanity) {
			$message = self::replace("/" . preg_quote($profanity, "/") . "/iu", str_repeat($replacementCharacter, mb_strlen($profanity, "utf8")), $message);
		}
		return $message;
	}

	private static function replace(string $pattern, string $replacement, string $subject) : string {
		return preg_replace($pattern, $replacement, $subject) ?? $subject;
	}

	/**
	 * Remove Unicodes and Other Non-Printable ASCII Characters from text.
	 *
	 * TODO: Improve this blocking in future...
	 */
	public static function removeUnicode(string $text, bool $include_unicode = false) : string {
		// Single Characters
		$text = self::replace("/[∂άαáàâãªä]/u", "a", $text);
		$text = self::replace("/[∆лДΛдАÁÀÂÃÄ]/u", "A", $text);
		$text = self::replace("/[ЂЪЬБъь]/u", "b", $text);
		$text = self::replace("/[βвВ]/u", "B", $text);
		$text = self::replace("/[çς©с]/u", "c", $text);
		$text = self::replace("/[ÇС]/u", "C", $text);
		$text = self::replace("/[δ]/u", "d", $text);
		$text = self::replace("/[éèêëέëèεе℮ёєэЭ]/u", "e", $text);
		$text = self::replace("/[ÉÈÊË€ξЄ€Е∑]/u", "E", $text);
		$text = self::replace("/[₣]/u", "F", $text);
		$text = self::replace("/[НнЊњ]/u", "H", $text);
		$text = self::replace("/[ђћЋ]/u", "h", $text);
		$text = self::replace("/[ÍÌÎÏ]/u", "I", $text);
		$text = self::replace("/[íìîïιίϊі]/u", "i", $text);
		$text = self::replace("/[Јј]/u", "j", $text);
		$text = self::replace("/[ΚЌК]/u", 'K', $text);
		$text = self::replace("/[ќк]/u", 'k', $text);
		$text = self::replace("/[ℓ∟]/u", 'l', $text);
		$text = self::replace("/[Мм]/u", "M", $text);
		$text = self::replace("/[ñηήηπⁿ]/u", "n", $text);
		$text = self::replace("/[Ñ∏пПИЙийΝЛ]/u", "N", $text);
		$text = self::replace("/[óòôõºöοФσόо]/u", "o", $text);
		$text = self::replace("/[ÓÒÔÕÖθΩθОΩ]/u", "O", $text);
		$text = self::replace("/[ρφрРф]/u", "p", $text);
		$text = self::replace("/[®яЯ]/u", "R", $text);
		$text = self::replace("/[ГЃгѓ]/u", "r", $text);
		$text = self::replace("/[Ѕ]/u", "S", $text);
		$text = self::replace("/[ѕ]/u","s", $text);
		$text = self::replace("/[Тт]/u", "T", $text);
		$text = self::replace("/[τ†‡]/u", "t", $text);
		$text = self::replace("/[úùûüџμΰµυϋύ]/u", "u", $text);
		$text = self::replace("/[√]/u", "v", $text);
		$text = self::replace("/[ÚÙÛÜЏЦц]/u", "U", $text);
		$text = self::replace("/[Ψψωώẅẃẁщш]/u", "w", $text);
		$text = self::replace("/[ẀẄẂШЩ]/u", "W", $text);
		$text = self::replace("/[ΧχЖХж]/u", "x", $text);
		$text = self::replace("/[ỲΫ¥]/u", "Y", $text);
		$text = self::replace("/[ỳγўЎУуч]/u", "y", $text);
		$text = self::replace("/[ζ]/u", "Z", $text);

		// Punctuation
		$text = self::replace("/[‚‚]/u", ",", $text);
		$text = self::replace("/[`‛′’‘]/u", "'", $text);
		$text = self::replace("/[″“”«»„]/u", '"', $text);
		$text = self::replace("/[—–―−–‾⌐─↔→←]/u", '-', $text);
		$text = self::replace("/[  ]/u", ' ', $text);

		$text = str_replace("…", "...", $text);
		$text = str_replace("≠", "!=", $text);
		$text = str_replace("≤", "<=", $text);
		$text = str_replace("≥", ">=", $text);
		$text = self::replace("/[‗≈≡]/u", "=", $text);

		// Exciting combinations
		$text = str_replace("ыЫ", "bl", $text);
		$text = str_replace("℅", "c/o", $text);
		$text = str_replace("₧", "Pts", $text);
		$text = str_replace("™", "tm", $text);
		$text = str_replace("№", "No", $text);
		$text = str_replace("Ч", "4", $text);
		$text = str_replace("‰", "%", $text);
		$text = self::replace("/[∙•]/u", "*", $text);
		$text = str_replace("‹", "<", $text);
		$text = str_replace("›", ">", $text);
		$text = str_replace("‼", "!!", $text);
		$text = str_replace("⁄", "/", $text);
		$text = str_replace("∕", "/", $text);
		$text = str_replace("⅞", "7/8", $text);
		$text = str_replace("⅝", "5/8", $text);
		$text = str_replace("⅜", "3/8", $text);
		$text = str_replace("⅛", "1/8", $text);
		$text = self::replace("/[‰]/u", "%", $text);
		$text = self::replace("/[Љљ]/u", "Ab", $text);
		$text = self::replace("/[Юю]/u", "IO", $text);
		$text = self::replace("/[ﬁﬂ]/u", "fi", $text);
		$text = self::replace("/[зЗ]/u", "3", $text);
		$text = str_replace("£", "(pounds)", $text);
		$text = str_replace("₤", "(lira)", $text);
		$text = self::replace("/[‰]/u", "%", $text);
		$text = self::replace("/[↨↕↓↑│]/u", "|", $text);
		$text = self::replace("/[∞∩∫⌂⌠⌡]/u", "", $text);

		if ($include_unicode) {
			// Remove Unicode Characters
			$text = self::replace('/[\x00-\x1F\x80-\xFF]/', '', $text);
		}

		return $text;
	}

	/**
	 * Returns array batch in english default profanity.
	 */
	/** @return list<string> */
	public static function defaultProfanity() : array {
		return [
			"anal",
			"anus",
			"arse",
			"ass",
			"ballsack",
			"balls",
			"bastard",
			"bitch",
			"biatch",
			"bloody",
			"blowjob",
			"blow job",
			"bollock",
			"bollok",
			"boner",
			"boob",
			"bugger",
			"bum",
			"butt",
			"buttplug",
			"clitoris",
			"cock",
			"coon",
			"crap",
			"cunt",
			"damn",
			"dick",
			"dildo",
			"dyke",
			"fag",
			"feck",
			"fellate",
			"fellatio",
			"felching",
			"fuck",
			"f u c k",
			"fudgepacker",
			"fudge packer",
			"flange",
			"Goddamn",
			"God damn",
			"hell",
			"homo",
			"jerk",
			"jizz",
			"knobend",
			"knob end",
			"labia",
			"muff",
			"nigger",
			"nigga",
			"penis",
			"piss",
			"prick",
			"pube",
			"pussy",
			"queer",
			"scrotum",
			"shit",
			"s hit",
			"sh1t",
			"slut",
			"smegma",
			"spunk",
			"tit",
			"tosser",
			"turd",
			"twat",
			"vagina",
			"wank",
			"whore",
			"wtf",
		];
	}
}
