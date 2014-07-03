<?
	$alphabetStringHtml = "<div id=\"alphbetWrapper\">";
		$alphabetStringHtml .= '<a href="#">#</a>';
		foreach(range('a','z') as $i) {
			$alphabetStringHtml .= '<a href="/artist.php?letter=' . strtoupper($i) . '">' . strtoupper($i) . '</a>';
		}
	$alphabetStringHtml .= '</div>';
	echo $alphabetStringHtml;
?>