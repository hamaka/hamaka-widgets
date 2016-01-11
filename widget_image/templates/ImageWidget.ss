	<li class="widget">
		<div class="widget-image widget">
			<figure>
				<% if $getWidgLink %><a href="$getWidgLink" <% if $LinkExternalUrl %>class="external"<% end_if %> title="$LinkTxt"><% end_if %>
				$Img.SetWidth(280)
				<% if $getWidgLink %></a><% end_if %>
				<% if $LinkTxt %>
					<figcaption>
						<% if $getWidgLink %><a href="$getWidgLink" <% if $LinkExternalUrl %>class="external"<% end_if %> title="$LinkTxt"><% end_if %>{$LinkTxt}<% if $getWidgLink %></a><% end_if %>
					</figcaption>
				<% end_if %>
			</figure>
		</div>
	</li>