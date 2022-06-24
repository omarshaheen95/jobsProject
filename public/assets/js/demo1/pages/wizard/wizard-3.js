"use strict";

// Class definition
var KTWizard3 = function () {
	// Base elements
	var wizardEl;
	var formEl;
	var validator;
	var wizard;

	// Private functions
	var initWizard = function () {
		// Initialize form wizard
		wizard = new KTWizard('kt_wizard_v3', {
			startStep: 1,
            clickableSteps: false,
		});

		// Validation before going to next page
		wizard.on('beforeNext', function(wizardObj) {
			if (validator.form() !== true) {
				wizardObj.stop();  // don't go to the next step
			}
		})

		// Change event
		wizard.on('change', function(wizard) {
			KTUtil.scrollTop();
		});
	}

	var initValidation = function() {
		validator = formEl.validate({
			// Validate only visible fields
			ignore: ":hidden",

			// Validation rules
			rules: {
				//= Step 1
                name: {
					required: true
				},
				job_uuid: {
					required: true
				},
                position_id: {
					required: true
				},
				start_at: {
					required: true
				},
				end_at: {
					required: true
				},
				publish_at: {
					required: true
				},

				degree_id: {
					required: true
				},

			},
            messages: {
                name: "يرجى تحديد اسم العرض الوظيفي",
                job_uuid: "يرجى تحديد رقم العرض الوظيفي",
                position_id: "يرجى تحديد العنوان الوظيفي",
                start_at: "يرجى تحديد تاريخ بدء التقديم",
                end_at: "يرجى تحديد تاريخ انتهاء التقديم",
                publish_at: "يرجى تحديد تاريخ نشر العرض الوظيفي",
                degree_id: "يرجى تحديدالتخصص المطلوب",
            },

			// Display error
			invalidHandler: function(event, validator) {
				KTUtil.scrollTop();

				swal.fire({
                    confirmButtonText: 'موافق',
					"title": "",
					"text": "هناك بعض الأخطاء في تقديمك. يرجى تصحيحها.",
					"type": "error",
					"confirmButtonClass": "btn btn-secondary"
				});
			},

			// Submit valid form
			submitHandler: function (form) {

			}
		});
	}

	var initSubmit = function() {
		var btn = formEl.find('[data-ktwizard-type="action-submit"]');

		btn.on('click', function(e) {
			e.preventDefault();

			if (validator.form()) {
				// See: src\js\framework\base\app.js
				KTApp.progress(btn);
				//KTApp.block(formEl);

                var form = $('#kt_form');
                $.ajax({
                    type: "post",
                    // dataType: "html",
                    url: form.attr("action"),
                    data: form.serialize(),
                    success: function(res){
                        console.log(res);
                        if(res.success){
                            showToastify(res.message, 'success', res.data.route);
                        } else {
                            showToastify(res.message, 'error');
                        }

                        KTApp.unprogress(btn);
                    },
                    error: function(response) {
                        KTApp.unprogress(btn);
                        var messages = Object.values(response.responseJSON.errors);
                        console.log(messages)
                        if (messages.length > 0)
                        {
                            showToastify(messages[0],  'error');
                        }else{
                            showToastify(response.responseJSON.message,  'error');
                        }

                    }
                });
			}
		});
	}

	return {
		// public functions
		init: function() {
			wizardEl = KTUtil.get('kt_wizard_v3');
			formEl = $('#kt_form');

			initWizard();
			initValidation();
			initSubmit();
		}
	};
}();

jQuery(document).ready(function() {
	KTWizard3.init();
});
