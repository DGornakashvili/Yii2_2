$(document).ready(function () {
	'use strict';

	if (!window.WebSocket) {
		return false;
	}
	var webSocket = new WebSocket('ws://front.yii.local:8080?taskId=' + taskId);

	$('#comments-form').on('submit', function (e) {
			e.preventDefault();

			var data = {
				comment: $(this).find('#comments-comment').val(),
				task_id: $(this).find('#comments-task_id').val(),
				user_id: $(this).find('#comments-user_id').val(),
			};

			webSocket.send(JSON.stringify(data));

			$(this).find('#comments-comment').val('');
			return false;
		}
	);

	webSocket.onmessage = function (e) {
		var content = JSON.parse(e.data);

		if (!content.msg) {
			return false;
		}

		var $item = $(`<p><b><i>${content.user}:</i></b> ${content.msg}</p>`);

		$('.all-comments').append($item);
	};
});