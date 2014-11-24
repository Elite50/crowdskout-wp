
<form class="cskt-email-form" data-cs="true" data-type="email">
    <?php if ($name_checkbox) {
        ?><input type="text" name="n" placeholder="Enter name"><?php
    } ?>
	<input type="text" name="e" placeholder="Enter email" data-validate="email,required">
	<input type="hidden" value="cskt_email_submit">
	<input type="submit" value="Submit">
    <p class="messages"></p>
</form>