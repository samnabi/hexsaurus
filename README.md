Hexsaurus: The Thesaurus for Hexadecimal Strings
================================================

**Goal:** Turn any hexadecimal string, like PHP's `uniqid()`, into pronounceable "words" of alternating consonant and vowel sounds. Also, we want to be able to convert the words back into the original hexadecimal string.

These words are meant to be easily transcribed or dictated over the phone, so all words are made up of lowercase letters. Some easily confused letters, like q, g, and l, are excluded.

Each of the 16 hexadecimal characters is mapped to a consonant or vowel sound. Some of the vowel sounds have two letters. Each "word" has up to 7 letters.

This function does not produce a uniform length string. For example, a 13-character hexadecimal string like PHP's uniqid() could result in a 15 - 20 character pronounceable string (including separators). Although this is longer than uniqid(), it is easier to pronounce and remember.


Usage
=====

```php
require_once('hexsaurus.php');

hexsaurus('0a1b2c3d4f')->toWords();        // 'bocoad-taiwayz'
hexsaurus('bocoad-taiwayz')->toHex();      // '0a1b2c3d0ef'

hexsaurus('not a hex string')->toWords();  // '' (blank string)
hexsaurus('something invalid')->toHex();   // 'ba75c48882' (toHex() will translate hexadecimal characters, ignoring the rest)
```
