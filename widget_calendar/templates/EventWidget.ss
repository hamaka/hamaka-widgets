	<li class="widget">
		<div class="widget_events widget">
			<% if $BaseClass != 'HomePage' %><h3>$Header</h3><% end_if %>

			<ul class="eventswidget-list"><% loop $CalendarTopList %>
				<li class="clearfix">
					<span class="date">$StartDate.Nice</span>
					<a href="$Link" title="$Title.XML">$Title</a>
				</li>
			<% end_loop %></ul>

			<% if $LinkTxt %><a href="$FirstCalendarHolder.Link" class="continue" title="$LinkTxt">
				<% if $BaseClass == 'HomePage' %>$Header - $LinkTxt<% else %><span class="entity-arr">&#9658;</span> $LinkTxt<% end_if %>
			</a><% end_if %>
		</div>
	</li>