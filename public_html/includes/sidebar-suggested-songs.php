<? if(isset($artistSimilarSongs)) { ?>
    <div id="artistDetailSuggestedSongs" class="left">
        <div id="topArtistTitle" class="center">
            SUGGESTED SONGS
        </div>
        <div id="suggestedSongList">    
			<?
                $count = 0;
                foreach ($artistSimilarSongs as &$artistSimilarSong) {
                    if($artistSimilarSong["tracks"][0]["release_image"] != "") {
                        $suggestedArtistSongSugHtml .= '<div id="suggestedArtist-' . $artistSimilarSong["id"]  . '" class="songItem left">';
                            $suggestedArtistSongSugHtml .= '<div class="songItemImg left">';
                                 $suggestedArtistSongSugHtml .= '<a href="/artist/' . str_replace("+","-",urlencode(preg_replace("~[\\\\/:*?'<>|]~","",$artistSimilarSong["artist_name"]))) . '/song/' . str_replace("+","-",urlencode(preg_replace("~[\\\\/:*?'<>|]~","",$artistSimilarSong["title"]))) . '"><img src="' . $artistSimilarSong["tracks"][0]["release_image"] . '" height="60" width="60" border="0"></a>';
                            $suggestedArtistSongSugHtml .= '</div>'; 
                            $suggestedArtistSongSugHtml .= '<div class="songItemTitle left">';
                                $suggestedArtistSongSugHtml .= $artistSimilarSong["title"] . '<br>';
                                $suggestedArtistSongSugHtml .= '<span class="songItemTitleFootnote">' . $artistSimilarSong["artist_name"] . "</span>";
                            $suggestedArtistSongSugHtml .= '</div>';   
                        $suggestedArtistSongSugHtml .= '</div>';	
                        $count++;
                        if($count >= 5) {
                            break;	
                        }
                    }										
                }
                echo $suggestedArtistSongSugHtml;
            ?>
        </div>               				
    </div>	
<? } ?>