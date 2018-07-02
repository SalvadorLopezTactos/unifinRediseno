A lightweight javascript date library for parsing, validating, manipulating, and formatting dates.

# [Documentation](http://momentjs.com/docs/)


Port to ECMAScript 6 (version 2.10.0)
=====================================

Moment 2.10.0 does not bring any new features, but the code is now written in
ECMAScript 6 modules and placed inside `src/`. Previously `moment.js`, `locale/*.js`
and `test/moment/*.js`, `test/locale/*.js` contained the source of the project.
Now the source is in `src/`, temporary build (ECMAScript 5) files are placed under
`build/umd/` (for running tests during development), and the `moment.js` and `locale/*.js`
files are updated only on release.

If you want to use a particular revision of the code, make sure to run
`grunt transpile update-index`, so `moment.js` and `locales/*.js` are synced with
`src/*`. We might place that in a commit hook in the future.


Upgrading to 2.0.0
==================

There are a number of small backwards incompatible changes with version 2.11.2.

[See the full change log here](https://github.com/moment/moment/blob/develop/CHANGELOG.md)

* [1761](https://github.com/moment/moment/pull/1761): moments created without a language are no longer following
            the global language, in case it changes.
            Only newly created moments take the global language by default.
            In case you're affected by this, wait, comment on [1797](https://github.com/moment/moment/issues/1797)
            and wait for a proper reimplementation
* [1642](https://github.com/moment/moment/pull/1642): 45 days is no longer "a month" according to humanize,
            cutoffs for month, and year have changed.
            Hopefully your code does not depend on a particular answer from humanize (which it shouldn't anyway)
* [1784](https://github.com/moment/moment/pull/1784): if you use the human readable English datetime format in a
            weird way (like storing them in a database) that would break when the format changes you're at risk.

[See more incompatible changes and their descriptions here](https://gist.github.com/timrwood/e72f2eef320ed9e37c51#backwards-incompatible-changes)

* Changed language ordinal method to return the number + ordinal instead of just the ordinal.
* Changed two digit year parsing cutoff to match strptime.
* Removed `moment#sod` and `moment#eod` in favor of `moment#startOf` and `moment#endOf`.
* Removed `moment.humanizeDuration()` in favor of `moment.duration().humanize()`.
* Removed the lang data objects from the top level namespace.
* Duplicate `Date` passed to `moment()` instead of referencing it.

Travis Build Status
===================

Develop [![Build Status](https://travis-ci.org/moment/moment.png?branch=develop)](https://travis-ci.org/moment/moment)

Master [![Build Status](https://travis-ci.org/moment/moment.png?branch=master)](https://travis-ci.org/moment/moment)

For developers
==============

You need [node](http://nodejs.org/), use [nvm](https://github.com/creationix/nvm) or [nenv](https://github.com/ryuone/nenv) to install it.

Then, in your shell

```bash
git clone https://github.com/moment/moment.git
cd moment
npm install -g grunt-cli
npm install
git checkout develop  # all patches against develop branch, please!
grunt                 # this runs tests and jshint
```

Changelog
=========

### 2.11.2 [See changelog](https://gist.github.com/ichernev/8ec3ee25b749b4cff3c2)

* New languages

  * Sinhalese (si) [2119](https://github.com/moment/moment/pull/2119)
  * Montenegrin (me) [2136](https://github.com/moment/moment/pull/2136)
  * Javanese (ja) [2159](https://github.com/moment/moment/pull/2136)
  * Frisian (fy) [2104](https://github.com/moment/moment/pull/2104)
  * Tunisian Arabic (ar-tn) [2097](https://github.com/moment/moment/pull/2097)
  * Tibetan (bo) [1789](https://github.com/moment/moment/pull/1789)
  * Africaans (af) [1786](https://github.com/moment/moment/pull/1786)
  * Burmese (my) [1778](https://github.com/moment/moment/pull/1778)
  * Belarusian (be) [1727](https://github.com/moment/moment/pull/1727)
  * Bengali (bn) [1678](https://github.com/moment/moment/pull/1678)
  * Azerbaijani (az) [1628](https://github.com/moment/moment/pull/1628)
  * Arabic, Saudi Arabia (ar-sa) [1633](https://github.com/moment/moment/pull/1633)
  * Austrian German (de-at) [1648](https://github.com/moment/moment/pull/1648)
  * Serbian-Cyrillic (sr-cyr) [1529](https://github.com/moment/moment/pull/1529)
  * Khmer Cambodia (km) [1544](https://github.com/moment/moment/pull/1544),
    [1546](https://github.com/moment/moment/pull/1546)

* Features
  * [2939](https://github.com/moment/moment/pull/2939) Use full-string match to speed up aspnet regex match
  * [2624](https://github.com/moment/moment/pull/2624) Proper handling of invalid moments
  * [2634](https://github.com/moment/moment/pull/2634) Fix strict month parsing issue in cs,ru,sk
  * [2735](https://github.com/moment/moment/pull/2735) Reset the `locale` back to `en` after defining all locales in `min/locales.js`
  * [2702](https://github.com/moment/moment/pull/2702) Week rework
  * [2746](https://github.com/moment/moment/pull/2746) Changed September Abbreviation to "Sept" in locale-specific english files and default locale file
  * [2646](https://github.com/moment/moment/pull/2646) Fix #2645 - invalid dates pre-1970
  * [2641](https://github.com/moment/moment/pull/2641) Implement basic format and comma as ms separator in ISO 8601
  * [2665](https://github.com/moment/moment/pull/2665) Implement stricter weekday parsing
  * [2700](https://github.com/moment/moment/pull/2700) Add [Hh]mm and [Hh]mmss formatting tokens, so you can parse 123 with hmm for example
  * [2565](https://github.com/moment/moment/pull/2565) Expose arguments used for moment creation with `creationData`
          (fix [2443](https://github.com/moment/moment/issues/2443))
  * [2835](https://github.com/moment/moment/pull/2835) Expose arguments used for moment creation with `creationData`
          (fix [2443](https://github.com/moment/moment/issues/2443))
  * [2648](https://github.com/moment/moment/pull/2648) fix issue #2640: support `instanceof` operator
  * [2709](https://github.com/moment/moment/pull/2709) Add `isSameOrAfter` and `isSameOrBefore` comparison methods
  * [2721](https://github.com/moment/moment/pull/2721) Fix moment creation from object with strings values
  * [2740](https://github.com/moment/moment/pull/2740) Enable `d hh:mm:ss.sss` format for durations
  * [2766](https://github.com/moment/moment/pull/2766) Alternate Clock Source Support
  * [2833](https://github.com/moment/moment/pull/2833) Alternate Clock Source Support
  * [2357](https://github.com/moment/moment/pull/2357) Improve unit bubbling for ISO dates this fixes day to year conversions to work around end-of-year
          (~365 days). As a side effect 365 days is 11 months and 30 days, and 366 days is one year.
  * [2438](https://github.com/moment/moment/pull/2438) Fix inconsistent `moment.min` and `moment.max` results Return invalid result if any of the inputs is invalid
  * [2494](https://github.com/moment/moment/pull/2494) Fix two digit year parsing with YYYY format This brings the benefits of YY to YYYY
  * [2368](https://github.com/moment/moment/pull/2368) perf: use faster form of copying dates, across the board improvement
  * [2088](https://github.com/moment/moment/pull/2088) add `moment.fn.isBetween`
  * [2054](https://github.com/moment/moment/pull/2054) Call updateOffset when creating moment (needed for default timezone in moment-timezone)
  * [1893](https://github.com/moment/moment/pull/1893) Add `moment.isDate` method
  * [1825](https://github.com/moment/moment/pull/1825) Implement `toJSON` function on Duration
  * [1809](https://github.com/moment/moment/pull/1809) Allowing `moment.set()` to accept a hash of units
  * [2128](https://github.com/moment/moment/pull/2128) Add `firstDayOfWeek`, `firstDayOfYear` locale getters
  * [2131](https://github.com/moment/moment/pull/2131) Add quarter diff support
  * [2000](https://github.com/moment/moment/issues/2000) Add LTS localised format that includes seconds
  * [1960](https://github.com/moment/moment/issues/1960) added formatToken `x` for unix offset in milliseconds #1938
  * [1965](https://github.com/moment/moment/issues/1965) Support 24:00:00.000 to mean next day, at midnight.
  * [2002](https://github.com/moment/moment/issues/2002) Accept `date` key when creating moment with object
  * [2009](https://github.com/moment/moment/issues/2009) Use native `toISOString` when we can
  * [1663](https://github.com/moment/moment/pull/1663) configurable relative time thresholds
  * [1554](https://github.com/moment/moment/pull/1554) support anchor time in `moment.calendar`
  * [1693](https://github.com/moment/moment/pull/1693) support `moment.ISO_8601` as parsing format
  * [1637](https://github.com/moment/moment/pull/1637) add `moment.min` and `moment.max` and deprecate min/max instance methods
  * [1704](https://github.com/moment/moment/pull/1704) support string value in add/subtract
  * [1647](https://github.com/moment/moment/pull/1647) add spm support (package manager)
  * [1419](https://github.com/moment/moment/pull/1419), [1468](https://github.com/moment/moment/pull/1468),
    [1467](https://github.com/moment/moment/pull/1467), [1546](https://github.com/moment/moment/pull/14546)
    better handling of timezone-d moments around DST
  * [1462](https://github.com/moment/moment/pull/1462) add `weeksInYear` and `isoWeeksInYear`
  * [1475](https://github.com/moment/moment/pull/1475) support ordinal parsing
  * [1499](https://github.com/moment/moment/pull/1499) composer support
  * [1577](https://github.com/moment/moment/pull/1577), [1604](https://github.com/moment/moment/pull/1604)
    put Date parsing in `moment.createFromInputFallback` so it can be properly deprecated and controlled in the future
  * [1545](https://github.com/moment/moment/pull/1545) extract two-digit year parsing in `moment.parseTwoDigitYear`,
    so it can be overwritten
  * [1590](https://github.com/moment/moment/pull/1590) (see [1574](https://github.com/moment/moment/pull/1574))
    set AMD global before module definition to better support non AMD module dependencies used in AMD environment
  * [1589](https://github.com/moment/moment/pull/1589) remove global in Node.JS environment (was not working before,
    nobody complained, was scheduled for removal anyway)
  * [1586](https://github.com/moment/moment/pull/1586) support quarter setting and parsing


* Various bugfixes

### 2.5.1

* languages
  * [#1392](https://github.com/moment/moment/issues/1392) Armenian (hy-am)

* bugfixes
  * [#1429](https://github.com/moment/moment/issues/1429) fixes [#1423](https://github.com/moment/moment/issues/1423) weird chrome-32 bug with js object creation
  * [#1421](https://github.com/moment/moment/issues/1421) remove html entities from Welsh
  * [#1418](https://github.com/moment/moment/issues/1418) fixes [#1401](https://github.com/moment/moment/issues/1401) improved non-padded tokens in strict matching
  * [#1417](https://github.com/moment/moment/issues/1417) fixes [#1404](https://github.com/moment/moment/issues/1404) handle buggy moment object created by property cloning
  * [#1398](https://github.com/moment/moment/issues/1398) fixes [#1397](https://github.com/moment/moment/issues/1397) fix Arabic-like week number parsing
  * [#1396](https://github.com/moment/moment/issues/1396) add leftZeroFill(4) to GGGG and gggg formats
  * [#1373](https://github.com/moment/moment/issues/1373) use lowercase for months and days in Catalan

* testing
  * [#1374](https://github.com/moment/moment/issues/1374) run tests on multiple browser/os combos via SauceLabs and Travis

### 2.5.0 [See changelog](https://gist.github.com/ichernev/8104451)

* New languages
  * Luxemburish (lb) [1247](https://github.com/moment/moment/issues/1247)
  * Serbian (rs) [1319](https://github.com/moment/moment/issues/1319)
  * Tamil (ta) [1324](https://github.com/moment/moment/issues/1324)
  * Macedonian (mk) [1337](https://github.com/moment/moment/issues/1337)

* Features
  * [1311](https://github.com/moment/moment/issues/1311) Add quarter getter and format token `Q`
  * [1303](https://github.com/moment/moment/issues/1303) strict parsing now respects number of digits per token (fix [1196](https://github.com/moment/moment/issues/1196))
  * 0d30bb7 add jspm support
  * [1347](https://github.com/moment/moment/issues/1347) improve zone parsing
  * [1362](https://github.com/moment/moment/issues/1362) support merideam parsing in Korean

* 22 bugfixes

### 2.4.0

* **Deprecate** globally exported moment, will be removed in next major
* New languages
  * Farose (fo) [#1206](https://github.com/moment/moment/issues/1206)
  * Tagalog/Filipino (tl-ph) [#1197](https://github.com/moment/moment/issues/1197)
  * Welsh (cy) [#1215](https://github.com/moment/moment/issues/1215)
* Bugfixes
  * properly handle Z at the end of iso RegExp [#1187](https://github.com/moment/moment/issues/1187)
  * chinese meridian time improvements [#1076](https://github.com/moment/moment/issues/1076)
  * fix language tests [#1177](https://github.com/moment/moment/issues/1177)
  * remove some failing tests (that should have never existed :))
    [#1185](https://github.com/moment/moment/issues/1185)
    [#1183](https://github.com/moment/moment/issues/1183)
  * handle russian noun cases in weird cases [#1195](https://github.com/moment/moment/issues/1195)

### 2.3.1

Removed a trailing comma [1169] and fixed a bug with `months`, `weekdays` getters [#1171](https://github.com/moment/moment/issues/1171).

### 2.3.0 [See changelog](https://gist.github.com/ichernev/6864354)

Changed isValid, added strict parsing.
Week tokens parsing.

### 2.2.1

Fixed bug in string prototype test.
Updated authors and contributors.

### 2.2.0 [See changelog](https://gist.github.com/ichernev/00f837a9baf46a3565e4)

Added bower support.

Language files now use UMD.

Creating moment defaults to current date/month/year.

Added a bundle of moment and all language files.

### 2.1.0 [See changelog](https://gist.github.com/timrwood/b8c2d90d528eddb53ab5)

Added better week support.

Added ability to set offset with `moment#zone`.

Added ability to set month or weekday from a string.

Added `moment#min` and `moment#max`

### 2.0.0 [See changelog](https://gist.github.com/timrwood/e72f2eef320ed9e37c51)

Added short form localized tokens.

Added ability to define language a string should be parsed in.

Added support for reversed add/subtract arguments.

Added support for `endOf('week')` and `startOf('week')`.

Fixed the logic for `moment#diff(Moment, 'months')` and `moment#diff(Moment, 'years')`

`moment#diff` now floors instead of rounds.

Normalized `moment#toString`.

Added `isSame`, `isAfter`, and `isBefore` methods.

Added better week support.

Added `moment#toJSON`

Bugfix: Fixed parsing of first century dates

Bugfix: Parsing 10Sep2001 should work as expected

Bugfix: Fixed wierdness with `moment.utc()` parsing.

Changed language ordinal method to return the number + ordinal instead of just the ordinal.

Changed two digit year parsing cutoff to match strptime.

Removed `moment#sod` and `moment#eod` in favor of `moment#startOf` and `moment#endOf`.

Removed `moment.humanizeDuration()` in favor of `moment.duration().humanize()`.

Removed the lang data objects from the top level namespace.

Duplicate `Date` passed to `moment()` instead of referencing it.

### 1.7.2 [See discussion](https://github.com/timrwood/moment/issues/456)

Bugfixes

### 1.7.1 [See discussion](https://github.com/timrwood/moment/issues/384)

Bugfixes

### 1.7.0 [See discussion](https://github.com/timrwood/moment/issues/288)

Added `moment.fn.endOf()` and `moment.fn.startOf()`.

Added validation via `moment.fn.isValid()`.

Made formatting method 3x faster. http://jsperf.com/momentjs-cached-format-functions

Add support for month/weekday callbacks in `moment.fn.format()`

Added instance specific languages.

Added two letter weekday abbreviations with the formatting token `dd`.

Various language updates.

Various bugfixes.

### 1.6.0 [See discussion](https://github.com/timrwood/moment/pull/268)

Added Durations.

Revamped parser to support parsing non-separated strings (YYYYMMDD vs YYYY-MM-DD).

Added support for millisecond parsing and formatting tokens (S SS SSS)

Added a getter for `moment.lang()`

Various bugfixes.

There are a few things deprecated in the 1.6.0 release.

1. The format tokens `z` and `zz` (timezone abbreviations like EST CST MST etc) will no longer be supported. Due to inconsistent browser support, we are unable to consistently produce this value. See [this issue](https://github.com/timrwood/moment/issues/162) for more background.

2. The method `moment.fn.native` is deprecated in favor of `moment.fn.toDate`. There continue to be issues with Google Closure Compiler throwing errors when using `native`, even in valid instances.

3. The way to customize am/pm strings is being changed. This would only affect you if you created a custom language file. For more information, see [this issue](https://github.com/timrwood/moment/pull/222).

### 1.5.0 [See milestone](https://github.com/timrwood/moment/issues?milestone=10&page=1&state=closed)

Added UTC mode.

Added automatic ISO8601 parsing.

Various bugfixes.

### 1.4.0 [See milestone](https://github.com/timrwood/moment/issues?milestone=8&state=closed)

Added `moment.fn.toDate` as a replacement for `moment.fn.native`.

Added `moment.fn.sod` and `moment.fn.eod` to get the start and end of day.

Various bugfixes.

### 1.3.0 [See milestone](https://github.com/timrwood/moment/issues?milestone=7&state=closed)

Added support for parsing month names in the current language.

Added escape blocks for parsing tokens.

Added `moment.fn.calendar` to format strings like 'Today 2:30 PM', 'Tomorrow 1:25 AM', and 'Last Sunday 4:30 AM'.

Added `moment.fn.day` as a setter.

Various bugfixes

### 1.2.0 [See milestone](https://github.com/timrwood/moment/issues?milestone=4&state=closed)

Added timezones to parser and formatter.

Added `moment.fn.isDST`.

Added `moment.fn.zone` to get the timezone offset in minutes.

### 1.1.2 [See milestone](https://github.com/timrwood/moment/issues?milestone=6&state=closed)

Various bugfixes

### 1.1.1 [See milestone](https://github.com/timrwood/moment/issues?milestone=5&state=closed)

Added time specific diffs (months, days, hours, etc)

### 1.1.0

Added `moment.fn.format` localized masks. 'L LL LLL LLLL' [issue 29](https://github.com/timrwood/moment/pull/29)

Fixed [issue 31](https://github.com/timrwood/moment/pull/31).

### 1.0.1

Added `moment.version` to get the current version.

Removed `window !== undefined` when checking if module exists to support browserify. [issue 25](https://github.com/timrwood/moment/pull/25)

### 1.0.0

Added convenience methods for getting and setting date parts.

Added better support for `moment.add()`.

Added better lang support in NodeJS.

Renamed library from underscore.date to Moment.js

### 0.6.1

Added Portuguese, Italian, and French language support

### 0.6.0

Added _date.lang() support.
Added support for passing multiple formats to try to parse a date. _date("07-10-1986", ["MM-DD-YYYY", "YYYY-MM-DD"]);
Made parse from string and single format 25% faster.

### 0.5.2

Bugfix for [issue 8](https://github.com/timrwood/underscore.date/pull/8) and [issue 9](https://github.com/timrwood/underscore.date/pull/9).

### 0.5.1

Bugfix for [issue 5](https://github.com/timrwood/underscore.date/pull/5).

### 0.5.0

Dropped the redundant `_date.date()` in favor of `_date()`.
Removed `_date.now()`, as it is a duplicate of `_date()` with no parameters.
Removed `_date.isLeapYear(yearNumber)`. Use `_date([yearNumber]).isLeapYear()` instead.
Exposed customization options through the `_date.relativeTime`, `_date.weekdays`, `_date.weekdaysShort`, `_date.months`, `_date.monthsShort`, and `_date.ordinal` variables instead of the `_date.customize()` function.

### 0.4.1

Added date input formats for input strings.

### 0.4.0

Added underscore.date to npm. Removed dependencies on underscore.

### 0.3.2

Added `'z'` and `'zz'` to `_.date().format()`. Cleaned up some redundant code to trim off some bytes.

### 0.3.1

Cleaned up the namespace. Moved all date manipulation and display functions to the _.date() object.

### 0.3.0

Switched to the Underscore methodology of not mucking with the native objects' prototypes.
Made chaining possible.

### 0.2.1

Changed date names to be a more pseudo standardized 'dddd, MMMM Do YYYY, h:mm:ss a'.
Added `Date.prototype` functions `add`, `subtract`, `isdst`, and `isleapyear`.

### 0.2.0

Changed function names to be more concise.
Changed date format from php date format to custom format.

### 0.1.0

Initial release

License
=======

Moment.js is freely distributable under the terms of the MIT license.
