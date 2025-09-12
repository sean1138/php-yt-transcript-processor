<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$text = $_POST['transcript'] ?? '';

		$lines = preg_split("/\r\n|\n|\r/", trim($text));
		$output = "";

		$currentTime = "";
		$currentParagraph = "";
		$expectContinuation = false;

		foreach ($lines as $line) {
				$line = trim($line);

				// Check if this line is a timestamp (mm:ss or hh:mm:ss)
				if (preg_match('/^\d{1,2}:\d{2}(?::\d{2})?$/', $line)) {
						// If we already have a paragraph in progress AND we’re not expecting continuation
						if (!empty($currentParagraph) && !$expectContinuation) {
								$output .= "<p><time datetime=\"$currentTime\">$currentTime</time> $currentParagraph</p>\n";
								$currentParagraph = "";
						}

						// Normalize timestamp to HH:MM:SS
						$parts = explode(':', $line);
						if (count($parts) === 2) {
								$line = "00:$line";
						}

						$currentTime = $line;
				}
				else {
						// Normal spoken text
						$currentParagraph .= ($currentParagraph === "" ? "" : " ") . $line;

						// Does this line end with sentence punctuation?
						if (preg_match('/[.!?]["\')]*$/', $line)) {
								$expectContinuation = false;
						} else {
								$expectContinuation = true;
						}
				}
		}

		// Flush last paragraph
		if (!empty($currentParagraph)) {
				$output .= "<p><time datetime=\"$currentTime\">$currentTime</time> $currentParagraph</p>\n";
		}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Transcript Converter</title>
<style>
textarea { width: 100%; height: 200px; }
pre { background: #f5f5f5; padding: 1em; white-space: pre-wrap; }
</style>
</head>
<body>
<h1>Transcript to HTML Converter</h1>

<form method="post">
	<textarea name="transcript" placeholder="Paste transcript text here..."><?php echo $_POST['transcript'] ?? ''; ?></textarea>
	<br>
	<button type="submit">Convert</button>
</form>

<?php if (!empty($output)): ?>
	<h2>Converted HTML:</h2>
	<pre class="language-html" style="height: 32vh;"><code class="language-html"><?php echo htmlspecialchars($output); ?></code></pre>
	<h2>Rendered HTML:</h2>
	<div class="rendered">
		<?php echo $output; ?>
	</div>
<?php endif; ?>
<!-- code syntax highlighting https://prismjs.com -->
<link rel="stylesheet" href="prism.css" />
<script src="prism.js"></script>
<style>
	button[type="submit"] {
	  background: #FF0000;
	  color: #fff;
	  font-size: 1rem;
	  font-weight: bold;
	  padding: 0.7em 1.6em;
	  border: none;
	  border-radius: 2em; /* pill shape */
	  cursor: pointer;
	  transition: background 0.25s ease, transform 0.1s ease, box-shadow 0.2s ease;
	  box-shadow: 0 3px 8px rgba(0, 0, 0, 0.3);
	  position: relative;
	}

	button[type="submit"]:hover {
	  background: #cc0000;
	  transform: translateY(-2px);
	  box-shadow: 0 5px 12px rgba(0, 0, 0, 0.35);
	}

	button[type="submit"]:active {
	  background: #a60000;
	  transform: translateY(0);
	  box-shadow: 0 3px 8px rgba(0, 0, 0, 0.3);
	}

	button[type="submit"]:focus {
	  outline: 2px solid #ffcccc;
	  outline-offset: 2px;
	}

	/* Optional: add a white play icon inside the button */
	button[type="submit"]::before {
	  content: "";
	  display: inline-block;
	  margin-right: 0.5em;
	  border-style: solid;
	  border-width: 0.5em 0 0.5em 0.9em;
	  border-color: transparent transparent transparent white;
	  vertical-align: middle;
	}

	.rendered{
		margin: 0 auto;
		width: 100ch;
		font-size:calc(100% + .125vw);
		line-height: 1.5;
		word-spacing: 0.16em;
		time{
			font-weight:bold;
		}
	}
</style>
</body>
</html>
