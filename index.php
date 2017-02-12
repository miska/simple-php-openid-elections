<?php
require_once "common.php";
require_once "members.php";

if(($_POST['action'] == 'vote') && isset($_SESSION['login'])) {
   if(in_array($_SESSION['login'], $members)) {
   if(count($_POST['response']) > 2) {
      $error = "Too many votes, you can choose only two candidates";
   } else {
      file_put_contents(dirname(__FILE__) . "/votes/" . md5($_SESSION['login']), "voted:" . implode(':', $_POST['response']) . "\n");
      $success = "Your vote has been casted! You can change your mind till the end of ellection.";
   }} else {
      $error = "You are not a member";
   }
}

global $pape_policy_uris;
?>
<html>
  <head><title>openSUSE Board elections 2017</title></head>
  <style type="text/css">
      * {
        font-family: verdana,sans-serif;
      }
      body {
        width: 50em;
        margin: 1em;
      }
      div {
        padding: .5em;
      }
      table {
        margin: none;
        padding: none;
      }
      .alert {
        border: 1px solid #e7dc2b;
        background: #fff888;
      }
      .success {
        border: 1px solid #669966;
        background: #88ff88;
      }
      .error {
        border: 1px solid #ff0000;
        background: #ffaaaa;
      }
      #verify-form {
        border: 1px solid #777777;
        background: #dddddd;
        margin-top: 1em;
        padding-bottom: 0em;
      }
  </style>
  <body>
    <h1>openSUSE Board elections 2017</h1>
    <p>Welcome to the election of the 2017 openSUSE board. &nbsp;The board consists of one appointed chairperson and 5 elected members who may serve up to 2 consecutive terms on the board.<br>Two seats are contested in this election, meaning each openSUSE member has two votes to cast.</p>
    <p><strong>To clarify - Each openSUSE member has TWO VOTES they can use for this election</strong></p>
    <p>Note that no single organization or company can control more than 40 percent of the electable board seats (more than 2 seats). Please read the&nbsp;<a href="http://en.opensuse.org/openSUSE:Board_election_rules" title="openSUSE:Board election rules">full description of the election process</a></p>

    <?php if (isset($msg)) { print "<div class=\"alert\">$msg</div>"; } ?>
    <?php if (isset($error)) { print "<div class=\"error\">$error</div>"; } ?>
    <?php if (isset($success)) { print "<div class=\"success\">$success</div>"; } ?>

    <?php if(!isset($_SESSION['login'])) { ?>
    <div id="verify-form">
      <form method="get" action="try_auth.php">
        <input type="hidden" name="action" value="verify" />
        <input type="hidden" name="openid_identifier" value="https://www.opensuse.org/openid/user/" />

        <input type="submit" value="Login" />
      </form>
    </div>
    <?php } else { ?>
    <div id="vote-form">
      <form method="post" action="index.php">
        Cast up to 2 options as <?php print $_SESSION['login']; ?>:<br/>
        <label><input type="checkbox" value="aaron" name="response[]" />Aaron Luna <a href="https://lists.opensuse.org/opensuse-project/2016-12/msg00078.html">announcement</a> <a href="https://en.opensuse.org/User:Aaronluna75">profile</a> <a href="http://www.opensusemexico.com/">platform</a></label><br/>
        <label><input type="checkbox" value="sarah" name="response[]" />Sarah Julia Kriesch <a href="https://lists.opensuse.org/opensuse-project/2016-12/msg00076.html">announcement</a> <a href="https://connect.opensuse.org//pg/profile/AdaLovelace">profile</a> <a href="https://sarah-julia-kriesch.eu/2016/12/28/running-for-the-opensuse-board/">platform</a></label><br/>
	<label><input type="checkbox" value="christian" name="response[]" />Christian Boltz <a href="https://lists.opensuse.org/opensuse-project/2016-12/msg00081.html">announcement</a> <a href="https://connect.opensuse.org/pg/profile/cboltz">profile</a> <a href="http://blog.cboltz.de/archives/73-Another-openSUSE-Board-candidate-;.html">platform</a></label><br/>
        <label><input type="checkbox" value="andrew" name="response[]" />Andrew Wafaa  <a href="">announcement</a> <a href="https://connect.opensuse.org/pg/profile/FunkyPenguin">profile</a> <a href="">platform</a></label><br/>
        <input type="hidden" name="action" value="vote" />
        <input type="submit" value="Vote" />
      </form>
    </div>
    <?php } ?>
  </body>
</html>
