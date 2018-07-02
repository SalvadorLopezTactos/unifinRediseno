# How to Contribute to Sidecar Development

You will need [gulp-cli][gulp-cli] to build Sidecar.

```bash
$ npm install -g gulp-cli
```

## Building

You can build Sidecar by running `gulp`. This will minify all the JavaScript and output it in the minified
folder.

## Working with the minified files

If you run the build script, you will change the minified files. Please do not commit these - leave that job to the
team leaders.

## Testing

Before submitting, please run the test suite:

```bash
$ gulp karma
```

If any tests fail, you need to fix them before submitting.

If you are having trouble getting tests to pass, you can run the suite in developer mode:

```bash
$ gulp karma --dev
```

You'll also have to click the "Debug" button and then open up your developer tools on the new tab that results.

If you are worried that your code might fail in certain browsers, you can run the test suite in them:

```bash
$ gulp karma --browsers Firefox,Chrome # PhantomJS is also an option
```

If you are developing a new module, please ensure your unit tests give decent code coverage for it.
To test:

```bash
$ gulp karma --coverage
```

HTML files will be dumped into a subdirectory of your OS's temporary folder by default.
This can be overridden with the `--path` option:

```bash
$ gulp karma --coverage --path <path>
```

## Linting

You should also run jscs and jshint:

```bash
$ gulp lint
```

Our code is not yet completely compliant with jscs yet. Until all of our files are completely compliant, this is
the recommended procedure to ensure that your changes are as compliant as possible:

```bash
# make your changes
$ gulp jscs # count the number of errors reported
$ git stash
$ gulp jscs # verify that the numbers of errors are greater than the numbers from before
$ git stash pop
```
### Don't commit new jshint violations
As of 7.9, Sidecar is completely jshint-compliant (although it is not compliant at this time on 7.7 or 7.8).
So please ensure any new code you commit on 7.7 or 7.8 is jshint-compliant, because otherwise it will fail the build
when it is merged into 7.9. (The existing violations do not cause a problem because they have already been fixed on 7.9)

## Documentation

We use [JSDuck][jsduck] to write our API documentation.

If you've never used JSDuck specifically before, be sure to read their [wiki][jsduck-wiki]. JSDuck shares many tags
with JSDoc and similar tools, but their meaning is sometimes different - so please make sure you're following the spec!

### Generating the Documentation

```bash
$ gulp jsduck
```

You will probably see a number of warnings. If you changed a file, please confirm that that file does not have any
JSDuck warnings:

```bash
$ gulp jsduck 2>&1 | grep <file-you-changed>
```

It's okay if there are warnings for that file - just make sure you don't add any more. Please file an improvement
ticket to fix up any documentation you find. (Be sure to check for duplicates first).

### Read the Documentation
Please ensure that you view the documentation after you generate it - documentation that does not generate any warnings
may nevertheless be visually unappealing or semantically incorrect.

[gulp-cli]: https://github.com/gulpjs/gulp-cli
[jsduck]: https://github.com/senchalabs/jsduck/
[jsduck-wiki]: https://github.com/senchalabs/jsduck/wiki
