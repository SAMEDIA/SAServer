<? if(isset($artistSimilar)) { ?>
	<div id="artistDetailSuggestedArtist" class="left">
        <div id="topArtistTitle" class="center">SUGGESTED ARTISTS</div>
        <div id="suggestedArtistList">
            <?
                $count = 0;
                foreach ($artistSimilar as &$artistSimilar) {
                    if($artistSimilar["images"]["0"]["url"] != "") {
                        $suggestedArtistHtml .= '<div id="suggestedArtist-' . $artistSimilar["id"]  . '" class="songItem left"><div class="songItemImg left"><a href="/artist/' . str_replace("+","-",urlencode(preg_replace("~[\\\\/:*?'<>|]~","",$artistSimilar["name"])))  . '"><img src="' . $artistSimilar["images"]["0"]["url"] . '" height="60" width="60" border="0"></a></div><div class="songItemTitle left">' . $artistSimilar["name"] . '<br></div></div>';	
                        $count++;
                        if($count >= 5) {
                            break;	
                        }
                    }										
                }
                echo $suggestedArtistHtml 						
            ?>
        </div> 
    </div>	                
<? } ?>