# php-yt-transcript-processor
Turn a youtube video transcript into html!

Yet another simple tool from chatgpt that took less than an hour to get something not completely awful.  we lazymaxxing out here with this one!

My initial request to chatgeebeedee included "is there a way we can automate joining sentences together instead of having them broken into different lines because of the timestamps? I want to keep the timestamps where a sentence, paragraph, or topic/idea starts or changes" and that's what it does.  It doesn't just output the exact same formatting from the plaintext you give it and timestamp accuraccy may be a little bit off because of that.

The index.php file can be considered the mvp or version 1.  It works fine.

The no-php.html file is a standalone file that updates the coverted outputs anytime the textarea input changes, **no convert/submit button to click**.  It also has an optional text input for a URL - typing or pasting anything into this input turns the output transcript's timestamps into links with a `?t=n` format parameter (n = time in seconds) appended to the end which is youtube's timestamped link parameter.

The optional gap detection looks for gaps in the timestamps and inserts an H2 element where it finds them.

![no-php.html screenshot](no-php.jpg?raw=true)

[demo]([url](https://yt-transcript-proc.netlify.app/no-php.html))
