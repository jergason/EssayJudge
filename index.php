<?php session_start();
require_once("config/config.inc.php");
require_once("config/functions.inc.php");

?>

<html>
<head>
<meta name="verify-v1" content="0g8MARreCVfj81JFV4wNrTwsJ/6pcKxbmxsdQvkYI4c=" />

<META NAME="Keywords" CONTENT="Essay Review, Free essay reviews, expert essay review, essay help, writing help, peer reviews">
<META NAME="Description" CONTENT="Free essay reviews by experts for students who want help writing essays">

<link rel="stylesheet" type="text/css" href="style.css" />
<title>Essay Judge - Free Essay Reviews by Experts</title>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-22923970-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>
   <div class="container">
      <?php include("header.inc.php")?>
      <?php include("topdoclist1.inc.php")?>
		<div id="main">
			<iframe src="http://www.facebook.com/plugins/like.php?href=www.essayjudge.com&amp;send=true&amp;layout=standard&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=verdana&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:35px;" allowTransparency="true"></iframe>
			<br>
			<br>
			EssayJudge offers <b>free essay reviews</b> from a Professor of English Literature, with a PhD in English. Don't feel bad about taking advantage of his time. He's up for it! Your essay review will usually be posted within a day.
			<br>
			The best way to <b>improve your grade</b> is to revise your essay before you turn it in.
			Hint: Include your last name and course code to prove it's your work.'
			<div id="button"><a href="register.php">Sign up now!</a></div>
			<div id="subheading">Example review: </div>
		   	<i>Your first paragraph reads like an application to undergraduate institution, not a graduate program. I am assuming that you are not writing to a university-wide admissions committee but to a committee comprised of members of the actual program you want to join. Treat such a committee as a group of experts interested primarily in quickly finding out what you want do and whether you are capable of doing it. You don't need a narrative about your life journey, at least not in the opening paragraph. That doesn't mean you can't say "I've been programming since 7th grade, and programming in C since 9th grade"--but that is pretty much all you should say. Your reader will deduce that your commitment to the field is entrenched. Basically, I think your first paragraph should just say something like this: "Dear X, I write to apply to your MS program in CS. I've been programming since 7th grade, etc (as above). I now wish to specialize in AI research." That's all.</i>
			
<!--
         <?php include("topdoclist2.inc.php")?>
-->
   </div>

 <?php include("footer.inc.php")?>
</body>
</html>