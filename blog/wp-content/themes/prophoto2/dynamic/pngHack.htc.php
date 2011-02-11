<?php
if (file_exists(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-load.php')) {
	require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-load.php'); // WP 2.6+
} else {
	require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-config.php'); // WP 2.5
}
@header('Content-type: text/xml');
?>
<public:component>
 <public:attach event="onpropertychange" for="element" onEvent="propertyChanged()" />
 <script language="JavaScript">

	var needHack = needHack();

	var transparentImage = "<?php bloginfo('template_url'); ?>/images/transparent.gif";

	pngHack();

	function propertyChanged()
	{
		if (event.propertyName == "src")
			pngHack();
	}

	function pngHack()
	{
		if (!needHack)
			return;

		var src = element.src;

		if (src.indexOf(transparentImage) != -1)
			return; // Already fixed

		if (src.indexOf("png") == -1) // There's got to be a better check than this!
		{
			element.runtimeStyle.filter = "";
			return;
		}

		element.src = transparentImage;
		element.runtimeStyle.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + src + "',sizingMethod='scale')";
	}

	function needHack()
	{
		var pos = navigator.userAgent.indexOf("MSIE ");

		if (pos == -1)
			return false;

		var version = navigator.userAgent.substring(pos + 5);

		return (((version.indexOf("5.5") == 0) || (version.indexOf("6") == 0)) && (navigator.platform == ("Win32")));
	}

 </script>
</public:component>
