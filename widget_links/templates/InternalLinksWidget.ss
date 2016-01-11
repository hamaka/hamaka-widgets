	<li class="widget">
		<div class="widget_links widget">
			<% if $BaseClass != 'HomePage' %><h3><%t Widget.Links.DESC "Zie ook" %></h3><% end_if %>

			<% if $getLinks %><ul><% loop $getLinks %>
				<li><a href="$URL" title="$Label">$Label</a></li>
			<% end_loop %></ul><% end_if %>

			<% if $BaseClass == 'HomePage' %><div class="bar">
				<span><%t Widget.Links.DESC "Zie ook" %></span>
			</div><% end_if %>
		</div>
	</li>