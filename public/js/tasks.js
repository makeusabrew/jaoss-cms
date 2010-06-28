var Tasks = {
	init: function() {
		$(".task").click(function(event) {
			event.preventDefault();
			$.post("/tasks/activate/"+$(this).attr("rel"), {}, function(response) {
				if (response.msg != "OK") {
					alert(response.msg);
					return;
				}
				alert("Task activated");
			}, "json");
		});
	}
};
