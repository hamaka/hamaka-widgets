	<li class="widget widget-text clearfix">
		<h2 class="color-cat">$Header</h2>
		<div class="content typography">
			<div class="widget-text-body">$Body</div>
			<% if $LinkTxt && $LinkType != "none" %>
				<div class="bar">
					<a href="$getWidgLink" class="btn btn-bar1 bgcolor-cat continue<% if $LinkType == "external" %> external<% end_if %>" title="$LinkTxt">$LinkTxt&nbsp;&nbsp;<span class="arrow">&#9656;</span></a>
				</div>
			<% end_if %>
		</div>
	</li>
