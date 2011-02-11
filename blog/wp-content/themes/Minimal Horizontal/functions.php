<?php
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'before_widget' => '<div class="block">',
        'after_widget' => '</div>',
        'before_title' => '<h5>',
        'after_title' => '</h5>',
    ));
?>

<?php
function completeTheme(){
echo '<div id="arrows">
     	<ul>
		<li class="lb"><a href="#container" title="Home">Home</a></li>
		<li id="left" class="lb"><a href="javascript://" title="go left">&lt;</a></li>
		<li id="right" class="lb"><a href="javascript://" title="go right">&gt;</a></li>
		<li><a href="#subcontent" title="Footer">Navigate</a></li>
	</ul>	
</div>
<div id="footer"><b>Designed by: </b><a href="http://www.gregponchak.com">Greg Ponchak</a> | <b>Sponsored by: </b><a href="http://www.gossipbingo.co.uk
">Free Bingo, </a><a href="http://www.moonbingo.com
">Bingo, </a><a href="http://www.lordbingo.co.uk/gala-bingo.html
">&amp; Gala Bingo</a></div>
</div>
 </body>
 </html>';
}
?>