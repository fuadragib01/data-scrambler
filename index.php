<?php
/**
 * Choose encoding or decoding
 */
$task = 'encode';
if ( isset( $_POST['task'] ) && $_POST['task'] != '' ) {
	$task = $_POST['task'];
}
/**
 * Generate and set the key
 */
$key = '';
if ( isset( $_GET['task'] ) && 'key' === $_GET['task'] ) {
	$originalKey = 'abcdefghijklmnopqrstuvwxyz1234567890';
	$keyArray = str_split( $originalKey );
	shuffle( $keyArray );
	$key = implode( $keyArray );
} elseif ( isset( $_POST['key'] ) && $_POST['key'] != '' ) {
	$key = $_POST['key'];
}
/**
 * Encode the given data
 */
$scrambledData = '';
$data = '';
if ( 'encode' == $task && isset( $_POST['data'] ) ) {
	$data = strtolower( $_POST['data'] );
	$length = strlen( $data );
	$originalKey = 'abcdefghijklmnopqrstuvwxyz1234567890';
	for ( $i = 0; $i < $length; $i++ ) {
		$currentChar = $data[$i];
		$position = strpos( $originalKey, $currentChar );
		if ( $position !== false ) {
			$scrambledData .= $key[$position];
		} else {
			$scrambledData .= $currentChar;
		}
	}
}
/**
 * Decode the encoded data
 */
if ( 'decode' == $task && isset( $_POST['data'] ) ) {
	$data = strtolower( $_POST['data'] );
	$length = strlen( $data );
	$originalKey = 'abcdefghijklmnopqrstuvwxyz1234567890';
	for ( $i = 0; $i < $length; $i++ ) {
		$currentChar = $data[$i];
		$position = strpos( $key, $currentChar );
		if ( $position !== false ) {
			$scrambledData .= $originalKey[$position];
		} else {
			$scrambledData .= $currentChar;
		}
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Data Scrambler</title>
	<!-- Google Fonts -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
	<!-- CSS Reset -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
	<!-- Milligram CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">
	<!-- You should properly set the path from the main file. -->
	<style>
		.header {
			text-align: center;
		}
		.header p a:hover {
			text-decoration: underline;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="header column column-60 column-offset-20">
				<h2>Data Scrambler</h2>
				<p>Scramble your data with this application</p>
				<p><a href="index.php?task=key">Generate Key</a></p>
				<p>
					<input form="myform" type="radio" name="task" value="encode" <?php if($task=='encode') echo 'checked'; ?>> Encode
				</p>
				<p>
					<input form="myform" type="radio" name="task" value="decode" <?php if($task=='decode') echo 'checked'; ?>> Decode
				</p>
			</div>
		</div>
		<div class="row">
			<div class="column column-60 column-offset-20">
				<form action="index.php" method="post" id="myform">
					<label>Key</label>
					<input type="text" name="key" value="<?php echo $key; ?>">
					<label>Data</label>
					<textarea name="data"><?php echo $data; ?></textarea>
					<label>Result</label>
					<textarea name="result"><?php echo $scrambledData; ?></textarea>
					<button type="submit">Do It For Me</button>
				</form>
			</div>
		</div>
	</div>
</body>
</html>