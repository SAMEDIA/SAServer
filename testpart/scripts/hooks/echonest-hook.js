var combination = 'NQDRAK60G9OZIAAFL';

function fetchGenres() {
    var url = 'http://developer.echonest.com/api/v4/artist/list_genres';
    var args = {
        api_key: combination
    };
    //info("Fetching genre");
    $.getJSON(url, args,
            function(data) {
                var genres = data.response.genres;
                alert(genres);
            });
}


function fetchHotttestArtists(genre, start) {
    var url = 'http://developer.echonest.com/api/v4/artist/top_hottt';
    var hotttnesssFloor = 1;

    // do it in 2 calls, so the first 10 appear fast.
    if (start == 0) {
        $("#results").empty();
        results = 10;
        //setUrl(genre);
        //info("Fetching hotttest artists for " + genre);
        if (genre) {
            //$("#results").append( $("<h2>").html("Hotttest " + genre + " artists"));
        } else {
            //$("#results").append( $("<h2>").html("Hotttest overall" + " artists"));
        }
        //fetchSongsForGenre(genre, .4);
    } else {
        results = 90;
    }

    var args = {
        api_key: combination,
        bucket : ['hotttnesss', 'images', 'biographies'],
        start: start,
        results: results
    };

    if (genre) {
        args['genre'] = genre;
    }


    $.getJSON(url, args, 
        function(data) {
            var artists = data.response.artists;
            $.each(data.response.artists, function(index, artist) {
                $("#results").append(format(index + start, artist));
                if (artist.hotttnesss < hotttnesssFloor) {
                    hotttnesssFloor = artist.hotttnesss;
                }
            });
            if (start == 0) {
                info("");
                //fetchHotttestArtists(genre, 10);
            } else {
                var roundedHotttnesssFloor = Math.round(hotttnesssFloor * 100 + 1) / 100;
                // fetchSongsForGenre(genre, roundedHotttnesssFloor);
            }
        },

        function() {
            error("trouble getting top hot artists");
        }
    );
}

function getHottestArtist(start) {
	/*var numOfResults = "12";
	var url = 'http://developer.echonest.com/api/v4/artist/top_hottt';
	
	var args = {
        api_key: combination,
        bucket : ['hotttnesss', 'images', 'biographies'],
        start: start,
        results: numOfResults
    };

	$.getJSON(url, args,
		function(data) {
			var genres = data.response.genres;
			alert(genres);
		}
	);

 	$.getJSON(url, args, 
        function(data) {
            var songs = data.response.songs
            alert(songs);
			
			if (songs.length == 0) {
                error("NO rdio songs for " + artistName);
            } else {
                $.each(songs, function(index, song) {
                    if (isGoodSong(song)) {
                        var div = format(songList.length, song)
                        song.div = div;
                        tbody.append(div);
                        songList.push(song);
                    }
                });

                if (songList.length  < maxSongs) {
                    if (start == 0) {
                        player.addSongs(songList, false);
                    }
                    fetchSongs(start + songs.length, 100);
                } 
            }
        },

        function() {
            error("trouble getting songs for " + artistName);
        }
    );*/
	
	
	$.ajax({
		url: "http://developer.echonest.com/api/v4/song/search",
		dataType: "html",
		data: {
			results: 12,
			api_key: combination,
			'sort': 'song_hotttnesss-desc',
			bucket:'song_hotttnesss'
		},
		success: function( data ) {
			alert(data);
			/*response( $.map( data.response.artists, function(item) {
				return {
					label: item.name,
					value: item.name,
					id: item.id
				}
			}));*/
		}
	});
}