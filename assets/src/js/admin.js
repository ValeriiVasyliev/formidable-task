const { __ } = wp.i18n;

jQuery(document).ready(function($){

		const getCredentials = () => {
			const baseUrl = (templateSettings.apiSettings.root ?? "");
			const nonce = (templateSettings.apiSettings.nonce ?? "");

			return {
				baseUrl,
				nonce
			}
		}

		const get_formidable_task_table = function(action) {

			const { baseUrl, nonce } = getCredentials();

			const path = '/formidable-task/' + action;

			if (!baseUrl) {
				console.error(__('HTTP Client is not properly configured', 'formidable-task'));
			}

			jQuery.ajax({
					method: 'GET',
					url: `${baseUrl}${path}`,
					contentType: 'application/json; charset=utf-8',
					beforeSend: function ( xhr ) {
						xhr.setRequestHeader( 'X-WP-Nonce', nonce );
					},
					success: function ( response ) {
						if (response.code == 'ok') {
							jQuery('#frmchal-list').html(response.html);
						} else {
							console.error(__('An error has ocurred, please try again.', 'formidable-task'));
						}
					},
					error: function(response) {
						console.error(__('An error has ocurred, please try again.', 'formidable-task'));
					}
				});
		};

		jQuery(".frm_top_left a#refresh").click(function() {
			get_formidable_task_table('refresh');
		});

		get_formidable_task_table('read');
});
