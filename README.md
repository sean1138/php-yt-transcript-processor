# php-yt-transcript-processor
turn a youtube video transcript into html

yet another simple tool from chatgpt that took less than an hour to get something not completely awful.  we lazymaxxing out here with this one!

The index.php file can be considered the mvp or version 1.  it works fine.

The no-php.html file is a standalone file that updates the coverted outputs anytime the textarea input changes, no more convert/submit button to click.  It also has an optional text input for a URL - typing or pasting anything into this input turns the output transcript's timestamps into links with a `?t=n` format parameter (n = time in seconds) appended to the end which is youtube's timestamped link parameter.

![no-php.html screenshot](no-php.jpg?raw=true)
