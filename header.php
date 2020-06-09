<?php
	session_start();
	include_once 'includes/dbh.inc.php';
?>


<!DOCTYPE html>
<html>
<head>
	<title>The Ten Charity Challenge</title>
	<link rel="stylesheet" type="text/css" href="style.css"></link>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="javascript/scripts.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Montserrat|Noto+Serif+JP" rel="stylesheet"></link>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
</head>
<body>

<header>
	<nav>
		<div class="main-wrapper">
		      <span class="menu-icon">
				<span class="menu-line menu-line-1"></span>
				<span class="menu-line menu-line-2"></span>
				<span class="menu-line menu-line-3"></span>
			</span>
			<div class="navlink">
				<div id="header-items">
					<div id="logoandtitle"><img src="https://tencharity.s3-us-west-2.amazonaws.com/images/logos/10CC.png"></img><p>Ten Charity Challenge</p></div>
						<?php
							if (isset($_SESSION['u_id'])){
								echo '<div id="friendrequestsicon"><img src="https://community.cengage.com/Chilton2/utility/anonymous.gif">';
			
								$sql = "SELECT * FROM `relationships` WHERE (`user_one_id` = '".$_SESSION['u_id']."' OR `user_two_id` = '".$_SESSION['u_id']."') AND `status` = 0 AND `action_user_id` != '".$_SESSION['u_id']."'";
								$result = mysqli_query($conn, $sql);
								$totalFriendRequests = mysqli_num_rows($result);
			
								if ($totalFriendRequests > 0) {
									echo '<span id="alertcount" class="alertcount">' . $totalFriendRequests . '</span>';
								}
			
								$sql = "SELECT user_first, user_last, user_id FROM users INNER JOIN relationships ON relationships.action_user_id = users.user_id WHERE (user_one_id = '".$_SESSION['u_id']."' OR user_two_id = '".$_SESSION['u_id']."') AND action_user_id !='".$_SESSION['u_id']."' AND status = 0";
								$result = mysqli_query($conn, $sql);
								$resultCheck = mysqli_num_rows($result);

								if ($resultCheck > 0) {
									echo '<div id="friendrequestpopup"><ul>';
									while ($row = mysqli_fetch_assoc($result)) {
										$userid = $row['user_id'];
										$firstname = $row['user_first'];
										$lastname = $row['user_last'];

									//Profile Image
									echo '<li id="friendrequest'.$userid.'"><div class="requestprofilepic requestitem">';
									$sqlImg = "SELECT * FROM profilepicturelocation WHERE user_id = '".$row['user_id']."' AND current = 1;";
									$resultImg = mysqli_query($conn, $sqlImg);
									$rowresults = mysqli_num_rows($resultImg);
									if ($rowresults > 0) {
										while ($row = mysqli_fetch_assoc($resultImg)){
											echo "<img id='profileimage' src='https://tencharity.s3-us-west-2.amazonaws.com/profilepicture/" . $userid .  "/". $row['uniq_id']. $row['image_name'] . "'>";
										}
									} else {
										echo "<img id='profileimage' src='uploads/profiledefault.jpg'>";
									}
									echo '</div>';

									echo '<a class="requestitem" href="https://www.tencharitychallenge.com/user/' . $userid . '">' . $firstname. ' ' . $lastname . '</a>' . 
									'<form class="requestitem" action="/confirmfriend.php" class="confirmfriend" method="post" />
									<input type="hidden" name="userid" value="'. $userid.'"/>
									<input id="'.$userid.'" class="modifyfriend" type="submit" name="confirmfriend" value="Confirm Friend" />
									</form>' .
									'<form class="requestitem" action="/rejectfriend.php" class="rejectfriend" method="post" />
                                        				<input type="hidden" name="userid" value="'. $userid.'"/>
                                        				<input id="'.$userid.'" class="modifyfriend" type="submit" name="rejectfriend" value="Reject Friend" />
                                  	 				</form>';
									}
									echo '</li></div>';
								}
							echo '</ul></div>';

							echo '<div id="eventrequestsicon"><img src="https://community.cengage.com/Chilton2/utility/anonymous.gif">';

							$sql = "SELECT * FROM inviterelationships WHERE invited_user_id = '".$_SESSION['u_id']."' AND invite = 1";
							$result = mysqli_query($conn, $sql);
							$totalEventRequests = mysqli_num_rows($result);

							//Convert to user local time
							$now = date('Y-m-d h:i:s');

							if ($totalEventRequests > 0) {
								echo '<span id="eventalertcount" class="eventalertcount">' . $totalEventRequests . '</span>';
							}

							$sql = "SELECT events.event_id, users.user_id, user_first, user_last, event_avenue, datetime_local, invited_user_id, invite FROM users INNER JOIN inviterelationships ON inviterelationships.user_id = users.user_id INNER JOIN events ON events.event_id = inviterelationships.event_id WHERE (invited_user_id = '".$_SESSION['u_id']."') AND invite = 1";
								$result = mysqli_query($conn, $sql);
								$resultCheck = mysqli_num_rows($result);

								if ($resultCheck > 0) {
									echo '<div id="eventrequestpopup"><ul>';
									while ($row = mysqli_fetch_assoc($result)) {
										$eventid = $row['event_id'];
                                                                                $firstname = $row['user_first'];
                                                                                $lastname = $row['user_last'];
										$eventavenue = $row['event_avenue'];
										$datetime = $row['datetime_local'];

										if(date($datetime) > $now){
											echo '<li id="eventrequest'.$eventid.'">';
											echo '<a class="requestitem" href="https://www.tencharitychallenge.com/event/' . $eventid . '">' . $eventavenue. ' : ' . $datetime . '</a>';
											echo '</li>';
										}
									}
									echo '</ul></div>';
								}

							echo '</div>';

							echo '<div class="nav-login"><p id="headergreeting">Hello, ' . $_SESSION['u_first'] . '</p>';
							echo '<form action="includes/logout.inc.php" method="POST">
							<button type="submit" name="submit">Logout</button>
							</form>';
							} else {
								echo '<div class="nav-login"><div id="loginbox">
									<form action="includes/login.inc.php" method="POST">
									<table>
										<tr>
											<td><input type="text" name="uid" placeholder="Username/email"></input></td>
											<td><input type="password" name="pwd" placeholder="Password"></input></td>
											<td><button type="submit" name="submit">Login</button></td>
										</tr>
										<tr>
											<td></td>
											<td><a href="https://tencharitychallenge.com/passwordreset.php">Forgot your password?</a></td>
											<td></td>
										</tr>
									</table>
								</div>
									</form>
					</div>
				</div>';
					}
				?>
			</div>
		</div>
	</nav>
</header>
