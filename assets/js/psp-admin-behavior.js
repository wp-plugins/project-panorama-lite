jQuery(function() {  
        
        jQuery(".datepicker").datepicker(); 
        jQuery(".task-row :checked").each(function() { 
            jQuery(this).parent().parent().addClass('completed'); 
            jQuery(this).addClass('completed');
        });
        jQuery(".task-row :checkbox").change(function() { 
            if(jQuery(this).hasClass('completed')) { 
                jQuery(this).removeClass('completed'); 
                jQuery(this).parent().parent().removeClass('completed');
            } else { 
                jQuery(this).parent().parent().addClass('completed');
                jQuery(this).addClass('completed');    
            }
        });		
	
		var psp_uploader;
 
		jQuery('#psp_upload_image_button').click(function(e) {
 
		        e.preventDefault();
 
		        //If the uploader object has already been created, reopen the dialog
		        if (psp_uploader) {
		            psp_uploader.open();
		            return;
		        }
  
		        //Extend the wp.media object
		        psp_uploader = wp.media.frames.file_frame = wp.media({
		            title: 'Choose Image',
		            button: {
		                text: 'Choose Image'
		            },
		            multiple: false
		        });
				

		        //When a file is selected, grab the URL and set it as the text field's value
		        psp_uploader.on('select', function() {
		            attachment = psp_uploader.state().get('selection').first().toJSON();
		            jQuery('#psp_logo').val(attachment.url);
		        });
 
		        //Open the uploader dialog
		        psp_uploader.open();
 
		    });
});  



function PopulatePspSingleShortcode() {
	
	jQuery('.psp-loading').show();
	
	data = { 
		action: 'psp_get_projects'
	}
	
	jQuery.post(ajaxurl, data, function (response) { 
	
		response = response.slice(0,-1);
		console.log(response);
			
		jQuery('#psp-single-project-list').html(response);
		jQuery('.psp-loading').hide();
	
	});
	
	
}

function InsertPspProject() { 


	pspId = jQuery('#psp-single-project-id').val();
	pspStyle = jQuery('input[name="psp-display-style"]:checked').val();

	if(pspStyle == 'full') {
	
		pspOverview = jQuery('#psp-single-overview').val();
            if(pspOverview.length) { pspOverviewAtt = 'overview="'+pspOverview+'"'; }

		pspMilestones = jQuery('#psp-single-milestones').val();
		    if(pspMilestones.length) { pspMilestonesAtt = 'milestones="'+pspMilestones+'"'; }

        pspPhases = jQuery('#psp-single-phases').val();
            if(pspPhases.length) { pspPhasesAtt = 'phases="'+pspPhases+'"'; }

		pspTasks = jQuery('#psp-single-tasks').val();
		    if(pspTasks.length) { pspTasksAtt = 'tasks="'+pspTasks+'"'; }

        pspProgress = jQuery('#psp-single-progress').val();
            if(pspProgress.length) { pspProgressAtt = 'progress="'+pspProgress+'"'; }
	
    	shortcode = '[project_status id="'+pspId+'" '+pspProgressAtt+' '+pspOverviewAtt+' '+pspMilestonesAtt+' '+pspPhasesAtt+' '+pspTasksAtt+']';
		
	} else { 
	
		pspPart = jQuery('#psp-part-display').val();
		
		if(pspPart == 'overview') { 
		
	    	shortcode = '[project_status_part id="'+pspId+'" display="overview"]';
			
		} else if (pspPart == 'documents') {
			
			shortcode = '[project_status_part id="'+pspId+'" display="documents"]';
			
		} else if (pspPart == 'progress') {
			
			pspPartStyle = jQuery('#psp-part-overview-progress-select').val();
			shortcode = '[project_status_part id="'+pspId+'" display="progress" style="'+pspPartStyle+'"]';
			
		} else if (pspPart == 'phases') {
			
			pspPartStyle = jQuery('#psp-part-phases-select').val();
			shortcode = '[project_status_part id="'+pspId+'" display="phases" style="'+pspPartStyle+'"]';
			
		} else if (pspPart == 'tasks') {
			
			pspPartStyle = jQuery('#psp-part-tasks-select').val();
			shortcode = '[project_status_part id="'+pspId+'" display="tasks" style="'+pspPartStyle+'"]';
			
		}
	
	}
	
	tinymce.activeEditor.execCommand('mceInsertContent', false, shortcode);

	tb_remove(); return false;

}

function InsertPspProjectList() { 

	pspListTax = jQuery('#psp-project-taxonomy').val();
	pspListStatus = jQuery('#psp-project-status').val();
    pspUserAccess = jQuery('#psp-user-access').val();

    if(pspUserAccess == 'on') {
        pspAccess = 'user';
    } else {
        pspAccess = 'all';
    }
	
	shortcode = '[project_list type="'+pspListTax+'" status="'+pspListStatus+'" access="'+pspAccess+'" ]';
	
	tinymce.activeEditor.execCommand('mceInsertContent', false, shortcode);
	
	tb_remove(); return false;

}
