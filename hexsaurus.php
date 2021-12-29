<?php 

/*

HEXSAURUS: THE THESAURUS FOR HEXADECIMAL STRINGS
================================================

Goal: Turn any hexadecimal string, like PHP's `uniqid()`, into pronounceable "words" of alternating consonant and vowel sounds. Also, we want to be able to convert the words back into the original hexadecimal string.

These words are meant to be easily transcribed or dictated over the phone, so all words are made up of lowercase letters. Some easily confused letters, like q, g, and l, are excluded.

Each of the 16 hexadecimal characters is mapped to a consonant or vowel sound. Some of the vowel sounds have two letters. Each "word" has up to 7 letters.

This function does not produce a uniform length string. For example, a 13-character hexadecimal string like PHP's uniqid() could result in a 15 - 20 character pronounceable string (including separators). Although this is longer than uniqid(), it is easier to pronounce and remember.


USAGE
=====

require_once('hexsaurus.php');

hexsaurus('0a1b2c3d4f')->toWords(); // 'bocoad-taiwayz'
hexsaurus('bocoad-taiwayz')->toHex(); // '0a1b2c3d0ef'

hexsaurus('not a hex string')->toWords(); // '' (blank string)
hexsaurus('something invalid')->toHex(); // 'ba75c48882' (toHex() will translate hexadecimal characters, ignoring the rest)

*/

class hexsaurus {
	
	// Careful! If you change $consonants or $vowels, you won't be able to work with any previously-translated strings!
	private $consonants = ['0'=>'b','1'=>'c','2'=>'d','3'=>'f','4'=>'h','5'=>'j','6'=>'k','7'=>'m','8'=>'n','9'=>'p','a'=>'r','b'=>'s','c'=>'t','d'=>'w','e'=>'y','f'=>'z'];
	private $vowels = ['0'=>'a','1'=>'aa','2'=>'ae','3'=>'ai','4'=>'ay','5'=>'e','6'=>'ey','7'=>'ee','8'=>'i','9'=>'ie','a'=>'o','b'=>'oa','c'=>'oi','d'=>'oo','e'=>'oy','f'=>'u'];

	function __construct ($string, $separator = '-') {
		$this->string = $string;
		$this->separator = $separator;
	}

	public function toWords() {
		// Check that the string is a valid hexadecimal key
		if (!ctype_xdigit($this->string)) return '';

		// If the separator is one of the consonants or vowels, revert to dash
		if (in_array($this->separator, $this->vowels) or in_array($this->separator, $this->consonants)) {
			$this->separator = '-';
		}

		$result = [];
		foreach (str_split($this->string, 5) as $chunk) {
			if (isset($chunk[0])) $result[] = $this->consonants[$chunk[0]];
			if (isset($chunk[1])) $result[] = $this->vowels[$chunk[1]];
			if (isset($chunk[2])) $result[] = $this->consonants[$chunk[2]];
			if (isset($chunk[3])) $result[] = $this->vowels[$chunk[3]];
			if (isset($chunk[4])) $result[] = $this->consonants[$chunk[4]];
			$result[] = $this->separator;
		}

		return trim(implode($result), $this->separator);
	}

	public function toHex() {

		// Add a comma before and after each consonant sound
		// We can reliably pick out consonant sounds because they only have one letter
		foreach ($this->consonants as $c) {
			$this->string = str::replace($this->string, $c, ",$c,");
		}

		// Convert vowels and consonants to hex values. Ignore other characters.
		$hex = '';
		foreach (str::split($this->string) as $sound) {
			$isVowel = array_search($sound, $this->vowels);
			$isConsonant = array_search($sound, $this->consonants);
			if ($isVowel !== false) {
				$hex .= $isVowel;
			} else if ($isConsonant !== false) {
				$hex .= $isConsonant;
			}
		}

		return $hex;
	}
}

// A function with the same name as the class lets us call t
function hexsaurus ($string, $separator = '-') {
	return new hexsaurus($string, $separator);
}
