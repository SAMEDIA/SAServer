<?php
	require_once '/home/songabou/songabout_lib/models/SongAboutVerifiedArtist.php';

	session_start();

	if(!isset($_SESSION['user_id'])) {
		header('Location: http://www.songabout.fm/');
		exit;
	} else if($_SESSION['user_id'] != 8) {
		header('Location: http://www.songabout.fm/');
		exit;
	}
	
	$pageTitle = "SongAbout.FM | Discover what a song is about.";
	$page = "Homepage";
	$showSearch = true;	
	
	// This is the main infromation API
	$echoNestAPIKey = 'NQDRAK60G9OZIAAFL';
	require_once '/home/songabou/lib/EchoNest/Autoloader.php';
	EchoNest_Autoloader::register();
	$songAboutEchonest = new EchoNest_Client();
	$songAboutEchonest->authenticate($echoNestAPIKey);	
	
	require_once '/home/songabou/www/includes/staffPicksVar.php';
	
	$allVerifiedArtistObj = new SongAboutVerifiedArtist();
	$allVerifiedArtist = $allVerifiedArtistObj->fetchAllVerfied(1, 30, '', $orderBySQL = "  artist_name DESC");			
?>
<?php 	include '/home/songabou/www/includes/header.php'; ?>
    <div id="contentWrapper" class="left"> 
        <div id="songAboutContent" class="center">   
            <div id="songAboutBase" class="center">
                <div id="songAboutBaseTitle" class="center">
                    Dashboard
                </div>
                
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="verifedArtistDash" width="100%">
                    <thead>
                        <tr>
                            <th>Artist</th>
                            <th>User Wanting Verification</th>
                            <th>Status</th>
                            <th>Approve</th>
                            <th>Disapprove</th>
                            <th>Delete</th>
                        </tr>
                    </thead>  
                    <tbody> 
                        <?php
							$indexResultsHtml .= '';
							if(count($allVerifiedArtist)) {								
								foreach ($allVerifiedArtist as $result) {
									$indexResultsHtml .= '<tr class="odd">';
										$indexResultsHtml .= '<td>' . $result->artist_name . '</td>';
										$indexResultsHtml .= '<td>' . $result->user_claiming_name . '</td>';
										$indexResultsHtml .= '<td class="' . str_replace(" ","",$result->status) . '">' . $result->status . '</td>';
										$indexResultsHtml .= '<td class="center"><a href="/~songabou/dashboard/action.php?action=approve&verifiedArtistId=' . $result->verified_artist_id . '" onclick="return confirm(\'Are you sure you want to accept this users request.  The user will be able to edit artist information.\');"><img src="/~songabou/images/icons/approveIcon.gif" title="Approve Artist" width="16" height="16" border="0"/></a></td>';
										$indexResultsHtml .= '<td class="center"><a href="/~songabou/dashboard/action.php?action=deny&verifiedArtistId=' . $result->verified_artist_id . '" onclick="return confirm(\'Are you sure you want to deny this users request.\');"><img src="/~songabou/images/icons/dissapproveIcon.png"  title="Deny Artist"   width="16" height="16"  border="0"/></a></td>';
										$indexResultsHtml .= '<td class="center"><a href="/~songabou/dashboard/action.php?action=delete&verifiedArtistId=' . $result->verified_artist_id . '" onclick="return confirm(\'Are you sure you want to delete this users request\');"><img src="/~songabou/images/icons/iconDelete.png" title="Deny Artist" width="16" height="16"  border="0"/></a></td>';
												
									$indexResultsHtml .= '</tr>';
								}
							}
							echo $indexResultsHtml;
						?>
                	</tbody>                                 
                </table>
           </div>
            <span class="clear"></span>
		</div>
    </div>
	<span class="clear"></span>
<?php 	include '/home/songabou/www/includes/footer.php'; ?>
	<script src="http://utah.stormfrontproductions.net/~songabou/scripts/DataTables-1.9.4/js/jquery.dataTables.min.js"></script>
	<script language="javascript">
		$(document).ready(function() {
			$('#verifedArtistDash').dataTable();
		} );	
	</script>  
    <link rel="stylesheet" type="text/css" media="all" href="http://utah.stormfrontproductions.net/~songabou/styles/dash.css" />
    <link rel="stylesheet" type="text/css" media="all" href="http://utah.stormfrontproductions.net/~songabou/scripts/DataTables-1.9.4/css/jquery.dataTables.css" />
    <link rel="stylesheet" type="text/css" media="all" href="http://utah.stormfrontproductions.net/~songabou/scripts/DataTables-1.9.4/css/smoothness/jquery.dataTables.css" />
     
