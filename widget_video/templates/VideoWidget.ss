	<li class="widget">
		<div class="widget_video widget">
			<% if $BaseClass != 'HomePage' && $Header %><h3><%t Widget.Video.LBL_PREFIX "Video" %>: $Header</h3><% end_if %>

			<div class="videowidget-youtube">
				<iframe title="<%t Widget.Video.IFRAME_TITLE "YouTube video-speler" %>" width="312" height="195" src="http://www.youtube.com/embed/{$YouTubeURL}?rel=0&wmode=opaque" frameborder="0" allowfullscreen></iframe>
			</div>

			<% if $BaseClass == 'HomePage' && $Header %><div class="bar">
				<span><%t Widget.Video.LBL_PREFIX "Video" %>: $Header</span>
			</div><% end_if %>
		</div>
	</li>