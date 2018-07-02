# How to Contribute to Sidecar Development

You will need [gulp-cli][gulp-cli] to build Sidecar.

```bash
$ npm install -g gulp-cli
```

## Building

You can build Sidecar by running `gulp`. This will minify all the JavaScript and output it in the minified
folder.

Additionally, to ease development, you can run `gulp watch` in the built folder in background and whenever
a change is done in any of the sidecarFiles, sidecar will be automatically rebuilt.

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

If you need to run in browsers that you don't have installed, please use the `--sauce` options to run:

```bash
$ SAUCE_USERNAME=<user> SAUCE_ACCESS_KEY=<access_key> gulp karma --sauce --browsers sl_ie,sl_safari,sl_firefox
```

Note that SAUCE_ACCESS_KEY is NOT the password, it's a token.

The browsers `sl_ie`, `sl_safari` and `sl_firefox` map to IE 11 (on Windows 7), Safari 9 (on OS X 10.11) and
Firefox 44 (on Linux) respectively.

If you don't specify `--browsers` to use, it will default to `sl_ie` (IE 11 on Windows 7).


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

To start the tests in manual mode, you can run it as follows:

```bash
$ gulp karma --manual
```

With this option, you can trigger the tests by launching any browser and visiting the URL where karma web server is listening (by default it is listening on 0.0.0.0:9876 HTTP). This is useful to test browsers like IE while running in virtual machines. Note that this parameter is not compatible with `--dev`, `--browsers` and `--sauce`.

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

We use [JSDoc][jsdoc] to write our API documentation.

### Generating the Documentation

```bash
$ gulp doc
```

There should NOT be any JSDoc errors. Please use the following command to check for them:

```bash
$ gulp doc 2>&1 | grep <file-you-changed>
```

If you see any errors, please fix them before submitting your PR. Also note that jscs also checks for jsdoc violations
and finds more problems than JSDoc itself does so please run that as well.

### Read the Documentation

Please ensure that you view the documentation after you generate it - documentation that does not generate any warnings
may nevertheless be visually unappealing or semantically incorrect.

[gulp-cli]: https://github.com/gulpjs/gulp-cli
[jsdoc]: http://usejsdoc.org
