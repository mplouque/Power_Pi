/*$(function()
{
	$("#controller").submit(function(e)
	{
		// stop the form from submitting for now
		e.preventDefault();

		var params;
		var q_str;

		// check the form and modify the query string
		if ($("#team1").is(":checked"))
			params = { team1:"on", checksum:168 };
		else
			params = { team1:"off", checksum:167 };
		q_str = jQuery.param(params);

		window.location.href = $(this).attr("action") + "?" + q_str;
	});
});*/

function toggleState(teamString) {
	fetch(`/capstone/webpage/form_processor.php?team=${teamString}`)
		.then(res => {
			res.text().then(text => {
				console.log(text);
			});
			//console.log(res.text());
			//if (res.json() == 0) {
			//	window.location.reload();
			//}
		})
		.catch(err => {
			console.log(err);
		});
}
