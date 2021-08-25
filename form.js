$(document).ready(function () {
	$('form').submit(function (event) {
		$('.form-group').removeClass('has-error');
		$('.help-block').remove();
		$('#not_user').remove();

  		var formData = {
      		name: $('#name').val(),
      		surname: $('#surname').val(),
      		email: $('#email').val(),
      		password: $('#password').val(),
      		confirm_password: $('#confirm_password').val()
    	};

    $.ajax({
    	type: 'POST',
    	url: 'process.php',
    	data: formData,
    	dataType: 'json',
    	encode: true,
    }).done(function (data) {
      	console.log(data);

    	if (!data.success) {
    		var isUser = true;
    		if (data.message.email) {
    			$('#email_group').addClass('has-error');
    			$('#email_group').append('<div class="help-block">' + data.message.email + '</div>');
    			isUser = false;
    		}
    		if (data.message.password) {
    			$('#password_group').addClass('has-error');
    			$('#confirm_password_group').addClass('has-error');
    			$('#confirm_password_group').append('<div class="help-block">' + data.message.password + '</div>');
    			isUser = false;
    		}
    		if (isUser) {
    			$('form').before('<div id="not_user" class="alert alert-danger">' + data.message + '</div>');
    		}
	
    	} else {
    		$('form').html('<div class="alert alert-success">' + data.message + '</div>');
    	}
    	}).fail(function (data) {
    		$('form').html('<div class="alert alert-danger">Could not reach server, please try again later.</div>');
    	});
    	event.preventDefault();
  	});
});