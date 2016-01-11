
    <div id="result">$FormResult</div>
    <% if $FormFeedbackFromSession %>
      <% if $FormFeedbackFromSession == 'success'%>
				<div class="box">
					<h3>$Header</h3>
					<p>Thanks, your submission has been received. We will keep you posted.</p>
					<p></p>
				</div>
      <% else %>
        <p>Something went wrong. Please try again.</p>
        $SubscribeNewsletterForm
      <% end_if %>
    <% else %>
      $SubscribeNewsletterForm
    <% end_if %>