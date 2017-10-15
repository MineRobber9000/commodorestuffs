<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>CBM Program Lister</title>
<style type="text/css">

.listing
{
	font-family: Courier-New, Courier;
	font-size: 15px;
	font-weight: normal;
	text-decoration: none;
}

</style>
</head>
<body>
<!--
	Copyright 2003-2012 David Viner (davidviner.com)

	Version 23.01.2008 		Added $expChrs array to simplify non-printable list.
							Fixed revText bug (cheers Diego!).
							Cleared up some non-compliant HTML.
							Fixed where '<' was causing problems.
			22.11.2008		Added error message when file couldn't be uploaded
			21.06.2012		Fixed PHP notices under PHP 5.3.x.
			26.06.2012		A few more tweaks.

-->

<?php

$mode	 = @$_REQUEST ['mode'];
$sel	 = @$_REQUEST ['sel'];
$revText = @$_REQUEST ['revText'];
$self	 = @$_SERVER ['PHP_SELF'];

$expChrs = array
(
	  5 => "{white}",
	 14 => "{lower}",
	 17 => "{down}",
	 18 => "{rvson}",
	 19 => "{home}",
	 20 => "{delete}",
	 28 => "{red}",
	 29 => "{right}",
	 30 => "{green}",
	 31 => "{blue}",
	 32 => "&nbsp;",
	129 => "{orange}",
	133 => "{fk1}",
	134 => "{fk3}",
	135 => "{fk5}",
	136 => "{fk7}",
	137 => "{fk2}",
	138 => "{fk4}",
	139 => "{fk6}",
	140 => "{fk8}",
	142 => "{upper}",
	144 => "{black}",
	145 => "{up}",
	146 => "{rvsoff}",
	147 => "{clr}",
	148 => "{ins}",
	149 => "{brown}",
	150 => "{lred}",
	151 => "{grey1}",
	152 => "{grey2}",
	153 => "{lgreen}",
	154 => "{lblue}",
	155 => "{grey3}",
	156 => "{purple}",
	157 => "{left}",
	158 => "{yellow}",
	159 => "{cyan}"
);

if ($mode == "list")
{
	$uName = $_FILES ['fname']['name'];
	$tmpName = $_FILES ['fname']['tmp_name'];
	$goConv = false;

	if (is_uploaded_file ($tmpName))	// Check it got here legally
	{
		print "<h3>Listing of: $uName</h3>\n";

		$f = fopen ($tmpName, "rb");

		if ($f)
		{
			$all = fread ($f, filesize ($tmpName));
			fclose ($f);

			if ($sel > 0)
			{
				// It's a program

				$basic4 = array (
					"END","FOR","NEXT","DATA","INPUT#","INPUT","DIM","READ","LET","GOTO",
					"RUN","IF","RESTORE","GOSUB","RETURN","REM","STOP","ON","WAIT","LOAD",
					"SAVE","VERIFY","DEF","POKE","PRINT#","PRINT","CONT","LIST","CLR",
					"CMD","SYS","OPEN","CLOSE","GET","NEW","TAB(","TO","FN","SPC(","THEN",
					"NOT","STEP","+","-","*","/","^","AND","OR",">","=","<","SGN","INT",
					"ABS","USR","FRE","POS","SQR","RND","LOG","EXP","COS","SIN","TAN",
					"ATN","PEEK","LEN","STR$","VAL","ASC","CHR$","LEFT$","RIGHT$","MID$",
					"GO","CONCAT","DOPEN","DCLOSE","RECORD","HEADER","COLLECT","BACKUP",
					"COPY","APPEND","DSAVE","DLOAD","CATALOG","RENAME","SCRATCH",
					"DIRECTORY","DCLEAR","BANK","BLOAD","BSAVE","KEY","DELETE","ELSE",
					"TRAP","RESUME","DISPOSE","PUDEF","USING","ERR$","INSTR","{e9}","{ea}",
					"{eb}","{ec}","{ed}","{ee}","{ef}","{f0}","{f1}","{f2}","{f3}","{f4}",
					"{f5}","{f6}","{f7}","{f8}","{f9}","{fa}","{fb}","{fc}","{fd}","{fe}",
					"{pi}");

				$basic7 = array (
					"END","FOR","NEXT","DATA","INPUT#","INPUT","DIM","READ","LET","GOTO",
					"RUN","IF","RESTORE","GOSUB","RETURN","REM","STOP","ON","WAIT","LOAD",
					"SAVE","VERIFY","DEF","POKE","PRINT#","PRINT","CONT","LIST","CLR",
					"CMD","SYS","OPEN","CLOSE","GET","NEW","TAB(","TO","FN","SPC(","THEN",
					"NOT","STEP","+","-","*","/","^","AND","OR",">","=","<","SGN","INT",
					"ABS","USR","FRE","POS","SQR","RND","LOG","EXP","COS","SIN","TAN",
					"ATN","PEEK","LEN","STR$","VAL","ASC","CHR$","LEFT$","RIGHT$","MID$",
					"GO","RGR","RCLR","RLUM","JOY","RDOT","DEC","HEX$","ERR$","INSTR",
					"ELSE","RESUME","TRAP","TRON","TROFF","SOUND","VOL","AUTO","PUDEF",
					"GRAPHIC","PAINT","CHAR","BOX","CIRCLE","GSHAPE","SSHAPE","DRAW",
					"LOCATE","COLOR","SCNCLR","SCALE","HELP","DO","LOOP","EXIT",
					"DIRECTORY","DSAVE","DLOAD","HEADER","SCRATCH","COLLECT","COPY",
					"RENAME","BACKUP","DELETE","RENUMBER","KEY","MONITOR","USING",
					"UNTIL","WHILE"," ","{pi}");

				$basic7fe = array (
					"BANK","FILTER","PLAY","TEMPO","MOVSPR","SPRITE","SPRCOLOR","RREG",
					"ENVELOPE","SLEEP","CATALOG","DOPEN","APPEND","DCLOSE","BSAVE",
					"BLOAD","RECORD","CONCAT","DVERIFY","DCLEAR","SPRSAV","COLLISION",
					"BEGIN","BEND","WINDOW","BOOT","WIDTH","SPRDEF","QUIT","STASH",
					" ","FETCH"," ","SWAP","OFF","FAST","SLOW");

				$basic7ce = array (	// Shared with BASIC 10
					"POT","BUMP","PEN","RSPPOS","RSPRITE","RSPCOLOR","XOR","RWINDOW",
					"POINTER");

				$basic10 = array (
					"END","FOR","NEXT","DATA","INPUT#","INPUT","DIM","READ","LET","GOTO",
					"RUN","IF","RESTORE","GOSUB","RETURN","REM","STOP","ON","WAIT","LOAD",
					"SAVE","VERIFY","DEF","POKE","PRINT#","PRINT","CONT","LIST","CLR",
					"CMD","SYS","OPEN","CLOSE","GET","NEW","TAB(","TO","FN","SPC(","THEN",
					"NOT","STEP","+","-","*","/","^","AND","OR",">","=","<","SGN","INT",
					"ABS","USR","FRE","POS","SQR","RND","LOG","EXP","COS","SIN","TAN",
					"ATN","PEEK","LEN","STR$","VAL","ASC","CHR$","LEFT$","RIGHT$","MID$",
					"GO","RGR","RCLR","RLUM","JOY","RDOT","DEC","HEX$","ERR$","INSTR",
					"ELSE","RESUME","TRAP","TRON","TROFF","SOUND","VOL","AUTO","PUDEF",
					"GRAPHIC","PAINT","CHAR","BOX","CIRCLE","PASTE","CUT","LINE",
					"LOCATE","COLOR","SCNCLR","SCALE","HELP","DO","LOOP","EXIT",
					"DIR","DSAVE","DLOAD","HEADER","SCRATCH","COLLECT","COPY",
					"RENAME","BACKUP","DELETE","RENUMBER","KEY","MONITOR","USING",
					"UNTIL","WHILE"," ","{pi}");

				$basic10fe = array (
					"BANK","FILTER","PLAY","TEMPO","MOVSPR","SPRITE","SPRCOLOR","RREG",
					"ENVELOPE","SLEEP","CATALOG","DOPEN","APPEND","DCLOSE","BSAVE",
					"BLOAD","RECORD","CONCAT","DVERIFY","DCLEAR","SPRSAV","COLLISION",
					"BEGIN","BEND","WINDOW","BOOT","WIDTH","SPRDEF","QUIT","DMA",
					" ","DMA"," ","DMA","OFF","FAST","SLOW", "TYPE","BVERIFY","ECTORY",
					"ERASE","FIND","CHANGE","SET","SCREEN","POLYGON","ELLIPSE","VIEWPORT",
					"GCOPY","PEN","PALETTE","DMODE","DPAT","PIC","GENLOCK","FOREGROUND",
					" ","BACKGROUND","BORDER","HIGHLIGHT");

				print "<p class=\"listing\">";

				// Move past load address

				$i = 2;

				while (true)
				{
					$pHi = ord ($all[$i]);
					$pLo = ord ($all[$i + 1]);

					if ($pHi + $pLo == 0)
					{
						print "\r\n<br/>";
						break;
					}

					$lHi = ord ($all[$i + 3]);
					$lLo = ord ($all[$i + 2]);
					$lNum = $lHi * 256 + $lLo;
					$i += 4;

					$first = true;
					$inQuote = false;
					print "\r\n<br/>$lNum ";

					while (true)
					{
						$ch = $all[$i++];
						$c = ord ($ch);

						if ($i == strlen ($all) - 1)
						{
							print "\r\n<br/>";
							break;
						}

						if ($c == 0)
						{
							$inQuote = false;
							break;
						}

						if ($inQuote or $c < 128)
						{
							if ($c == 34)
								$inQuote = !$inQuote;

							if ($c < 33 or $c > 127)
							{
								if (array_key_exists ($c, $expChrs))
									print $expChrs [$c];
								else
								if ($c >= 0xC1 and $c <= 0xDA)
								{
									$c -= 0x60;
									$ch = chr ($c);

									if ($revText)
									{
										if ($ch >= 'a' and $ch <= 'z')
											$ch = chr ($c - 32);
										else
										if ($ch >= 'A' and $ch <= 'Z')
											$ch = chr ($c + 32);
									}

									print $ch;
								}
								else
								if ($c == 0xa0)
									print " ";
								else
									printf ("{%02X}", $c);
							}
							else
							{
								if ($revText)
								{
									if ($ch >= 'a' and $ch <= 'z')
										$ch = chr ($c - 32);
									else
									if ($ch >= 'A' and $ch <= 'Z')
										$ch = chr ($c + 32);
								}

								if ($ch == '<')
									print "&lt;";
								else
									print $ch;
							}
						}
						else
						{
							$text = "^^^";

							switch ($sel)
							{
								case 4 :
									if ($goConv and $c == 0xCB)
										$c = 0xE1;

									$text = $basic4 [$c - 128];
									break;

								case 7 :
									if ($c == 0xFE or $c == 0xCE)
									{
										$c1 = ord ($all[$i++]);

										if ($c == 0xFE)
											$text = $basic7fe [$c1 - 2];
										else
											$text = $basic7ce [$c1 - 2];

										break;
									}

									// Drop though

								case 3 :
									$text = $basic7 [$c - 128];
									break;

								case 10 :
									if ($c == 0xFE or $c == 0xCE)
									{
										$c1 = ord ($all[$i++]);

										if ($c == 0xFE)
											$text = $basic10fe [$c1 - 2];
										else
											$text = $basic7ce [$c1 - 2];

										break;
									}

									$text = $basic10 [$c - 128];
							}

							if ($revText)
								$text = strtolower ($text);

							print str_replace ("<", "&lt;", $text);
						}

						$first = false;
					}
				}

				print "</p>\n";
			}
			else
			{
				// It's a text file

				for ($i = 0; $i < strlen ($all); $i++)
				{
					$c = $all[$i];

					if ($c >= "A" and $c <= "Z")
					{
						$c = chr (ord ($c) + 32);
					}
					else
					if (ord ($c) > 128)
					{
						$c = chr (ord ($c) - 128);
					}
					else
					if (ord ($c) == 128)
					{
						$c1 = ord ($all[$i + 1]);

						if ($c1 == 0xA3)
						{
							$c = " ";
							$i++;
						}
					}
					else
					if (ord ($c) == 13 or ord ($c) == 10)
						$c = "\r\n<br/>";

					print $c;
				}
			}
		}
		else
			print "<p>Couldn't open uploaded file.</p>";
	}
	else
		print "File not uploaded";
}
else
{
?>
<p>This utility will list out a Commodore BASIC program onto a new browser window. Useful
if you have some old CBM programs or files around but no longer own one of the computers.
Note that because a web page cannot display the special Commodore control codes these will be
displayed as words in braces such as {clr} and {left} instead. This convention is also used
for any of the graphic characters except that these are displayed as a two-character hex value.</p>

<table cellspacing="3" cellpadding="3">
<form action = "<?php print $self; ?>" target="_blank" method="post" enctype="multipart/form-data">
<input type="hidden" name="mode" value="list">
<tr>
	<td valign="top">
		Local File
	</td>
	<td valign="top">
		<input type="file" name="fname" size="40">
	</td>
</tr>
<tr>
	<td valign="top">
		Type
	</td>
	<td valign="top">
		<input type="radio" name="sel" value="4" checked>Basic 1/2/4 (PET, Vic-20, C64,
		CBM-5/6/700)<br/><input type="radio" name="sel" value="3">Basic 3.5 (C16, Plus/4,
		116, 264, 364)<br/><input type="radio" name="sel" value="7">Basic 7 (C128)<br/><input
		type="radio" name="sel" value="10">Basic 10 (C64DX, C65)<br/><input type="radio"
		name="sel" value="0">Text File
	</td>
</tr>
<tr>
	<td valign="top">
		Options
	</td>
	<td valign="top">
		<input type="checkbox" name="revText" value="1"> Reverse text case
	</td>
</tr>
<tr>
	<td>
		&nbsp;
	</td>
	<td>
		<input type="submit" value="Start Listing">
	</td>
</tr>
</form>
</table>
<?php
}

?>

</body>
</html>
