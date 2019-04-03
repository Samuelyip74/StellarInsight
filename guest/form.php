<form id="my_form" action="http://example.com" method="post">
    <input type="hidden" name="name" value="<?php echo htmlspecialchars($name); ?>">
    <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
    <input type="hidden" name="etc" value="<?php echo htmlspecialchars($etc); ?>">
</form>
 
<script type="text/javascript">
    //Our form submission function.
    function submitForm() {
        document.getElementById('my_form').submit();
    }
    //Call the function submitForm() as soon as the page has loaded.
    window.onload = submitForm;
</script>
