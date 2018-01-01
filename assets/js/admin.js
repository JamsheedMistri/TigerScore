$("#belt_price input").keydown(function (e) {
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
       (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
       (e.keyCode >= 35 && e.keyCode <= 40)) {
       return;
}
if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
   e.preventDefault();
}
});

$("#reset_tigerscore").click(function() {
	var answer = confirm ("Are you SURE you want to reset TigerScore? This will delete ALL data and reset it to installation. Data that will NOT be saved includes belt data, curriculum data, passwords, and ANYTHING else.");
	if (answer) {
		window.location.replace("admin_bridge.php?reset_tigerscore");
	} else {
		return;
	}
});

var toolbarOptions = [
    ['bold', 'italic', 'underline'],

    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
    [{ 'indent': '-1'}, { 'indent': '+1' }],

    [{ 'size': ['small', false, 'large', 'huge'] }],

    [{ 'color': [] }],
    [{ 'align': [] }],

    ['clean']
];

var receipt = new Quill('#receipt', {
    theme: 'tigerscore',
    placeholder: 'Type message here',
    modules: {
        toolbar: toolbarOptions
    }
});

var payment_validation_email = new Quill('#payment_validation_email', {
    theme: 'tigerscore',
    placeholder: 'Type message here',
    modules: {
        toolbar: toolbarOptions
    }
});

$("#receipt-save").click(function() {
    $.post("admin_bridge.php", {"update_receipt": null, "data": receipt.container.firstChild.innerHTML}, function(response) {
        if (response == "success") alert("Success!");
        else alert("Something went wrong. Please try again later.");
    });
});

$("#payment-validation-email-save").click(function() {
    $.post("admin_bridge.php", {"update_payment_validation_email": null, "data": payment_validation_email.container.firstChild.innerHTML}, function(response) {
        if (response == "success") alert("Success!");
        else alert("Something went wrong. Please try again later.");
    });
});