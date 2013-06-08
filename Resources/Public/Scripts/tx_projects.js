jQuery("document").ready(function(){
      // Datepicker, used in forms
    jQuery(function($){
        $.datepicker.regional['de'] = {
            clearText: 'löschen', 
            clearStatus: 'aktuelles Datum löschen',
            closeText: 'schließen', 
            closeStatus: 'ohne Änderungen schließen',
            prevText: '<zurück', 
            prevStatus: 'letzten Monat zeigen',
            nextText: 'Vor>', 
            nextStatus: 'nächsten Monat zeigen',
            currentText: 'heute', 
            currentStatus: '',
            monthNames: ['Januar','Februar','März','April','Mai','Juni',
            'Juli','August','September','Oktober','November','Dezember'],
            monthNamesShort: ['Jan','Feb','Mär','Apr','Mai','Jun',
            'Jul','Aug','Sep','Okt','Nov','Dez'],
            monthStatus: 'anderen Monat anzeigen', 
            yearStatus: 'anderes Jahr anzeigen',
            weekHeader: 'Wo', 
            weekStatus: 'Woche des Monats',
            dayNames: ['Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'],
            dayNamesShort: ['So','Mo','Di','Mi','Do','Fr','Sa'],
            dayNamesMin: ['So','Mo','Di','Mi','Do','Fr','Sa'],
            dayStatus: 'Setze DD als ersten Wochentag', 
            dateStatus: 'Wähle D, M d',
            dateFormat: 'dd.mm.yy', 
            firstDay: 1, 
            initStatus: 'Wähle ein Datum', 
            isRTL: false
        };
        $.datepicker.setDefaults($.datepicker.regional['de']);
    });

    $(function() {
        $( ".datepicker" ).datepicker();
        $( "#datepicker2" ).datepicker(); 
    
        $( ".button" ).button();
        
    //loadAjax();    

    function loadAjax(uid) {  
        if(uid==null)uid='1';
        $.ajax({
            async: 'false',
            url: 'index.php',       
            type: 'POST',  
          
            data: {
                eID: "ajaxDispatcher",   
                request: {
                    extensionName:  'projectsAndTasks',
                    pluginName:     'Pi1',
                    controllerName: 'PlanBoard', 
                    actionName:     'ajaxResponse',
                    arguments: {
                        'uid': uid,
                        'storagePid': '94'
                    }
                } 
            },
            dataType: "json",       
            
            success: function(result) {
                console.log(result);
                
                writeMenu(result.menu);
                writePlan(result.plan);
                writeComments(result.comments);
                writeBugs(result.bug);
                writeTime(result.time);
                
                $('#commentForm').addClass('hidden');
                $('#bugForm').addClass('hidden');
                
                
            },
            error: function(error) {
               
                console.log(error);                
            }
        });
    };
           
    function writeMenu(menu) {
        $('#menu').html(menu);
    
        //the click event, in the write function because it will live append""
        $('.menulink').click(function(e)  {    
            menuid = $(this).attr("id");
            substr = menuid.split('_');
            planUid = substr[1];
            loadAjax(planUid);
        });
    }
  
    function writePlan(plan) {
        $('#jqPlanText').val(plan.text);
        $('#jqStagetitle').html(plan.title);
        $('#jqPlanUid').html(plan.uid);
        $('#jqPlanShort').val(plan.short);
    
    
        $('#jqPlanText').elasticArea();
    }
   
    function writeBugs(bugs) {
        buglist = ''
        $.each(bugs, function(i, row) {
        
            var status = getStatus(row.status);

            buglist += '<div class="bugListHeader" id="bugUid_' + row.uid + '">';
            buglist += '<span class="bugListPlan hidden" id="bugListPlanId_' + row.uid + '">' + row.plan + '</span>';
            buglist += '<span class="bugListStatus hidden" id="bugListStatusId_' + row.uid + '">' + row.status + '</span>';
       
            buglist += '<span class="bugListNo" id="bugListNoId_' + row.uid + '">' + row.no + '</span>';
            buglist += '<span class="bugListReferenzInline">' + '[' + row.referenz + ']&nbsp;' + '</span>'; 
            buglist += '<span class="bugListTitel" id="bugListTitelId_' + row.uid + '">' +  row.title + '</span>';
            buglist += '<span class="bugListStatus">' + status + '</span>';
            buglist += '</div>';
        
            if(row.status == '6')buglist += '<div class="bugListDeteails hidden" id="bugListDetails_' + row.uid + '">';
            if(row.status != '6')buglist += '<div class="bugListDeteails" id="bugListDetails_' + row.uid + '">';
            buglist += '<div class="bugListDescription" id="bugListDescriptionId_' + row.uid + '">' + row.description + '</div>';
            buglist += '<div class="bugListComment" id="bugListCommentId_' + row.uid + '">' + row.comment + '</div>';
            buglist += '<div class="bugListFooter">';
            buglist += '<span class="bugListReferenz" id="bugListReferenzId_' + row.uid + '">' + row.referenz + '</span>';
            buglist += '<span class="bugListType" id="bugListTypeId_' + row.uid + '">' + row.type + '</span>';
            buglist += '<span class="bugListTime" id="bugListTimeId_' + row.uid + '">' + row.time + '</span>';
            buglist += '<span class="bugListEdit" id="bugListEditId_' + row.uid + '">' + 'edit' + '</span>';
            buglist += '</div>';
            buglist += '</div>';
            buglist += '<div class="stageItemTableDivider"></div>';
        
        });
     
     
        $('#jqTaskList').html(buglist);
        if(bugs == 'noItems')$('#jqTaskList').html('Kein Eintrag');
     
        //show / hide Bug Details
        $('.bugListHeader').click(function(e)  {    
            bugId = $(this).attr("id");
            substr = bugId.split('_');
            bugUid = substr[1];
        
            var bugDetails = '#bugListDetails_' + bugUid;
            if($(bugDetails).hasClass('hidden')){
                $(bugDetails).removeClass('hidden');
            }else {
                $(bugDetails).addClass('hidden');
            }
        });
    
        // set the values to the bug Form
        $('.bugListEdit').on("click", function(event){
            bugId = $(this).attr("id");
            substr = bugId.split('_');
            bugUid = substr[1];
        
            $('#jqBugFormUid').val(bugUid);
            $('#jqBugFormPlan').val($('#bugListPlanId_' + bugUid).html());
            $('#jqBugFormNo').val($('#bugListNoId_' + bugUid).html());
            $('#jqBugFormReferenz').val($('#bugListReferenzId_' + bugUid).html());
            $('#jqBugFormTitel').val($('#bugListTitelId_' + bugUid).html());
            $('#jqBugFormDescription').val($('#bugListDescriptionId_' + bugUid).html());
            $('#jqBugFormComment').val($('#bugListCommentId_' + bugUid).html());
            $('#jqBugFormStatus').val($('#bugListStatusId_' + bugUid).html());
            $('#jqBugFormType').val($('#bugListTypeId_' + bugUid).html());
            $('#jqBugFormTime').val($('#bugListTimeId_' + bugUid).html());
        
            $('#bugForm').removeClass('hidden');
            $('html, body').animate({
                scrollTop: 0
            }, 'slow');

        });
     
    }
 
    function writeComments(comments) {
    
        comment = '';
        if(comments != null) {
            $.each(comments, function(i, row) {
                var status = getStatus(row.status);
                comment += '<div class="commentListHeader" id="bugUid_' + row.uid + '">';
        
                //hidden fields
                comment += '<span class="commentListPlan hidden" id="commentListPlanId_' + row.uid + '">' + row.plan + '</span>';
                comment += '<span class="commentListStatus hidden" id="commentListStatusId_' + row.uid + '">' + row.status + '</span>';
        
                //header
                comment += '<span class="commentListDate" id="commentListDateId_' + row.uid + '">' + row.date + '</span>';
                comment += '<span class="commentListTitle" id="commentListTitleId_' + row.uid + '">' + row.title + '</span>';
                comment += '<span class="commentListTyp" id="commentListTypId_' + row.uid + '">' + row.typ + '</span>';
                comment += '<span class="commentListStatus" id="commentListStatusId_' + row.uid + '">' + status + '</span>';
                comment += '</div>';

                //content
                comment += '<div class="commentListDeteails hidden" id="commentListDetails_' + row.uid + '">';
                comment += '<span class="commentListText" id="commentListTextId_' + row.uid + '">' + row.text + '</span>';
                comment += '<br /><span class="commentListEdit" id="commentListEditId_' + row.uid + '">' + 'edit' + '</span>';
                comment += '</div>';
                comment += '<div class="stageItemTableDivider"></div>';
        
            });
        }
        $('#jqPlanComments').html(comment);
    
        //show / hide Bug Details
        $('.commentListHeader').click(function(e)  {    
            bugId = $(this).attr("id");
            substr = bugId.split('_');
            bugUid = substr[1];
        
            var commentDetails = '#commentListDetails_' + bugUid;
            if($(commentDetails).hasClass('hidden')){
                $(commentDetails).removeClass('hidden');
            }else {
                $(commentDetails).addClass('hidden');
            }
        });
    
        // set the values to the Comment Form
        $('.commentListEdit').on("click", function(event){
            commentId = $(this).attr("id");
            substr = bugId.split('_');
            commentUid = substr[1];
        
            $('#jqCommentFormUid').val(commentUid);
            $('#jqCommentFormPlan').val($('#commentListPlanId_' + commentUid).html());
            $('#jqCommentFormTitel').val($('#commentListTitleId_' + commentUid).html());
            $('#jqCommentFormDatum').val($('#commentListDateId_' + commentUid).html());
            $('#jqCommentFormTyp').val($('#commentListTypId_' + commentUid).html());
            $('#jqCommentFormStatus').val($('#commentListStatusId_' + commentUid).html());
            $('#jqCommentFormText').val($('#commentListTextId_' + commentUid).html());
            $('#commentForm').removeClass('hidden');
            $('html, body').animate({
                scrollTop: 0
            }, 'slow');
        });
    };
 
 
 function writeTime(time) {
    
        times = '';
        if(time != null) {
            times += '<div class="stageItemTableDivider"></div>';
            $.each(time, function(i, row) {
                var status = getStatus(row.status);
                times += '<div class="timeListHeader" id="timeUid_' + row.uid + '">';
        
                //hidden fields
                times += '<span class="timeListPlan hidden" id="timeListPlanId_' + row.uid + '">' + row.plan + '</span>';
                times += '<span class="timeListStatus hidden" id="timeListStatusId_' + row.uid + '">' + row.status + '</span>';
        
                //header
                times += '<span class="timeListDate" id="timeListDateId_' + row.uid + '">' + row.date + '</span>';
                times += '<span class="timeListTitle" id="timeListTitleId_' + row.uid + '">' + row.title + '</span>';
                times += '<span class="timeListWorktime" id="timeListStatusId_' + row.uid + '">' + row.worktime + ' min</span>';
                times += '</div>';

                //content
                times += '<div class="timeListDeteails hidden" id="timeListDetails_' + row.uid + '">';
                times += '<span class="timeListText" id="timeListTextId_' + row.uid + '">' + row.description + '</span>';
                times += '<br /><span class="timeListEdit" id="timeListEditId_' + row.uid + '">' + 'edit' + '</span>';
                times += '</div>';
                times += '<div class="stageItemTableDivider"></div>';
        
            });
            $('#jqPlanTime').html(times);
        } else {
            $('#jqPlanTime').html('kein Eintrag');
        }
 };
            
            
            
    //Shows the Bug Form for a new Bug
    $('.jqNewBug').click(function(e)  { 
     
        //reset the form
        $('#jqBugFormUid').val('');
        $('#jqBugFormPlan').val('');
        $('#jqBugFormNo').val('');
        $('#jqBugFormReferenz').val('');
        $('#jqBugFormTitel').val('');
        $('#jqBugFormDescription').val('');
        $('#jqBugFormComment').val('');
        $('#jqBugFormStatus').val('');
        $('#jqBugFormType').val('');
        $('#jqBugFormTime').val('');
        // set plan uid
        $('#jqBugFormPlan').val($('#jqPlanUid').html());
     
        $('#bugForm').removeClass('hidden');
    });

    //Shows the Comment Form for a new Comment
    $('.jqNewComment').click(function(e)  { 
     
        //reset the form
        $('#jqCommentFormUid').val('');
        $('#jqCommentFormUid').val('');
        $('#jqCommentFormPlan').val('');
        $('#jqCommentFormTitel').val('');
        $('#jqCommentFormDatum').val('');
        $('#jqCommentFormTyp').val('');
        $('#jqCommentFormStatus').val('');
        $('#jqCommentFormText').val('');
        // set plan uid
        $('#jqCommentFormPlan').val($('#jqPlanUid').html());
     
        $('#commentForm').removeClass('hidden');
    });
    
    //shows the Time Form for a new Timeentry
    $('.jq-form-time-new-click').click(function(e)  { 
        //reset the form
        
        //set plan uid
        $('#jqTimeFormPlan').val($('#jqPlanUid').html());
        //show form
        $('#timeForm').removeClass('hidden');
    });

    function getStatus(statusid) {
        var status = '?';
        if(statusid == '1')var status = 'offen';
        if(statusid == '3')var status = 'zu klären';
        if(statusid == '6')var status = 'erledigt';
    
        return status;
    
    } 

    //Toggel Tabs Task - Notes - Time
    $('#jqtabtask').click(function(e)  { 
        $('#jqtabtask').addClass('active');
        $('#jqtabnote').removeClass('active');
        $('#jqtabtime').removeClass('active');
            
        $('#jq-tab-task-stage').removeClass('hidden');
        $('#jq-tab-note-stage').addClass('hidden');
        $('#jq-tab-time-stage').addClass('hidden');
    });

    $('#jqtabnote').click(function(e)  { 
        $('#jqtabnote').addClass('active');
        $('#jqtabtask').removeClass('active');
        $('#jqtabtime').removeClass('active');
            
        $('#jq-tab-note-stage').removeClass('hidden');
        $('#jq-tab-task-stage').addClass('hidden');
        $('#jq-tab-time-stage').addClass('hidden');
    });
    
    $('#jqtabtime').click(function(e)  { 
        $('#jqtabtime').addClass('active');
        $('#jqtabtask').removeClass('active');
        $('#jqtabnote').removeClass('active');
            
        $('#jq-tab-time-stage').removeClass('hidden');
        $('#jq-tab-task-stage').addClass('hidden');
        $('#jq-tab-note-stage').addClass('hidden');
    });

    //*****************************************************/
    // Forms Processing : Plan
    //*****************************************************/

    $(".jqSendPlanForm").focusout(function() {
        console.log('focus out');
        sendAjaxPlanForm();
    });
 
    function sendAjaxPlanForm(uid) {  
        if(uid==null)uid='1';
        $.ajax({
            async: 'false',
            url: 'index.php',       
            type: 'POST',  
          
            data: {
                eID: "ajaxDispatcher",   
                request: {
                    extensionName:  'projectsAndTasks',
                    pluginName:     'Pi1',
                    controllerName: 'PlanBoard', 
                    actionName:     'ajaxPlanUpdate',
                    arguments: {
                        'planUid': $('#jqPlanUid').html(),
                        'storagePid': '94',
                        'planShort' : $('#jqPlanShort').val(),
                        'planDescription' : $('#jqPlanText').val()
                    }
                } 
            },
            dataType: "json",       
            
            success: function(result) {
                console.log(result);

                
            },
            error: function(error) {
               
                console.log(error);                
            }
        });
    };


    //*****************************************************/
    // Allgemeine Funktionen
    //*****************************************************/

    jQuery.fn.elasticArea = function() {
        return this.each(function(){
            function resizeTextarea() {
                this.style.height = this.scrollHeight/10 + 'px';
                this.style.height = this.scrollHeight + 'px';
            }
            $(this).keypress(resizeTextarea)
            .keydown(resizeTextarea)
            .keyup(resizeTextarea)
            .css('overflow','hidden');
            resizeTextarea.call(this);
        });
    };
 


    //*****************************************************/
    //     PLUGIN Elemente                                //
    //****************************************************//

    //HTML Editor, used in forms
    $("#editor").cleditor({
        width: 500, // width not including margins, borders or padding
        height:       250, // height not including margins, borders or padding
        controls:     // controls to add to the toolbar
        "bold italic underline strikethrough subscript superscript | " +
    " removeformat | bullets numbering | outdent " +
    "indent | alignleft center alignright justify |  " +
    "rule | pastetext source"
    });

    $("#editors").cleditor({
        width: 500, // width not including margins, borders or padding
        height:       250, // height not including margins, borders or padding
        controls:     // controls to add to the toolbar
        "bold italic underline strikethrough subscript superscript | " +
    " removeformat | bullets numbering | outdent " +
    "indent | alignleft center alignright justify |  " +
    "rule | pastetext source"
    });

    $("#editorNewActivity").cleditor({
        width: 500, // width not including margins, borders or padding
        height:       250, // height not including margins, borders or padding
        controls:     // controls to add to the toolbar
        "bold italic underline strikethrough subscript superscript | " +
    " removeformat | bullets numbering | outdent " +
    "indent | alignleft center alignright justify |  " +
    "rule | pastetext source"
    });

    $("#ticketEdit-PlanText").cleditor({
        width: 380, // width not including margins, borders or padding
        height:       250, // height not including margins, borders or padding
        controls:     // controls to add to the toolbar
        "bold italic subscript superscript | " +
        "bullets numbering | outdent " +
        "indent | alignleft alignright justify |  " +
        "rule | pastetext source",
        bodyStyle:    // style to assign to document body contained within the editor
        "margin:4px; font:11px 'LatoRegular',Verdana; cursor:text; color:#666666; "
    });


      

        //Dialog Edit Plan ///////////////////////////////
        $( ".dialog" ).dialog({
            autoOpen: false,
            width: 600
        });

        // Link to open the dialog
        $( ".dialog-link" ).click(function( event ) {
            $("#dialog" + this.id).dialog('open');
            //$( "#dialog" ).dialog( "open" );
            //event.preventDefault();
            $("#editors").cleditor()[0].refresh();
            $("#editorNewActivity").cleditor()[0].refresh();
        });
      
        $( ".dialog-close" ).click(function(event) { 
            $(".dialog").dialog("close");

        });

    
    
    }); //end function
    
    
    

	

    //*****************************************************/
    //     normal jQuery                                  //
    //****************************************************//

    var result;
    var uid ='0';
    var uidsub ='0';


    $(".leftItem").click(
        function(e)  {
        
            uidactive = uid; 
            uid = $(this).attr("id");
    
            //verhindert beim Rücksprung inerhalb des Frames das sich die stage selber löscht
            if (uid == uidactive) {
                uidactive= '0';
            }
         
            //Funktionen left Menu 
            $("#leftItemFrame"+uid).addClass("active");
            $("#leftSubItems_" + uid).removeClass("hidden");
          
            $("#leftItemFrame"+uidactive).removeClass("active");
            $("#leftSubItems_" + uidactive).addClass("hidden");
        });  

     
     
    $(".leftItemFirst").click(
        function(e)  {
            $("#stagecontent_"+uid).addClass("hidden");
            $("#stagecontent_first").removeClass("hidden");
        });
   
    $(".ajaxlink").click(
        function(e)  {
            uid = $(this).attr("id");
            loadAjax(uid);
        });

    function loadAjaxxxxxx()  {
        //zurücksetzen der Queryvariabeln, sonst wird letztes Ergebnis ausgegeben
        var result = '';  
        storagePid = $("#ajaxStoragePid").html();
    
        $.ajax({
            async: 'true',
            url: 'index.php',       
            type: 'POST',  
          
            data: {
                eID: "ajaxDispatcher",   
                request: {
                    extensionName:  'Projects',
                    pluginName:     'pi1',
                    controllerName: 'Plan', 
                    actionName:     'ajaxResponse',
                    arguments: {
                        'uid': uid,
                        'storagePid': storagePid
                    }
                } 
            },
            dataType: "json",       
            
            success: function(result) {
                var new_activities = '';
                var planActivity = '';
                var new_subactivities = '';
                var new_effort = '';
                new_effort = '';
                var new_progress ='';
                new_progress = '';
                
                baseUrl = $("#ajaxBaseurl").html();
                absolutePath = getAbsolutePath();
                
                $("#ajaxStageNav").html(result.planTyp + ": " +result.planTitle);                                         
                                              
                $("#planShort").html(result.planShort);
                $("#planText").html(result.planText);
                //$("#ajaxPlanStorys").html("User Storys: " + result.planStorys + " | erledigt: " + result.planStorysDone);
                $("#ajaxCreateItemLink").html('<a href="'+ absolutePath + '?tx_projects_pi1[uid]='
                    + result.uid + '&tx_projects_pi1[action]=newPlan&tx_projects_pi1[controller]=Plan">' +
                    '⊳ neuen SubPlan hinzufügen' +
                    '</a>'
                    );
                

                
                $.each(result.activities.subsincluded, function(i, row) {
                    new_subactivities += '<div class="rowActivities"><b>';
                    
                    new_subactivities += row.actDate + ' | ' + row.actUser + ' ' + row.actTitel + '</b>';
                    if(row.actText) new_subactivities += '<br />' + row.actText;
                    new_subactivities += '<br /><hr />';
                    new_subactivities += '</div>';
                });
                
                // Stage planActivity
                $.each(result.activities.current, function(i, row) {
                    planActivity+= '<div class="rowActivities"><b>';
                    planActivity+= row.actDate + ' | ' + row.actUser + ' ' + row.actTitel + '</b>';
                    if(row.actText !== 0) planActivity+= '<br />' + row.actText;
                    planActivity+= '<br /><hr />';
                    planActivity+= '</div>';
                });
                 
                 
                // Stage Effort
                $.each(result.effort, function(i, row) {
                    //Calculating Time
                    var worktime = '';
                    worktime = parseInt(row.workTime);
                    if(worktime < 3600) worktime = worktime/60 + 'min';
                    if(worktime > 3599) worktime = worktime/3600 + ' h';
                    
                    new_effort += '<div class="rowActivities"><b>';
                    new_effort += '<span id="effort-'+ row.uid + '" class="lightboxEditEffort_trigger">' + row.workNumber + '</span></b>';
                    new_effort += ' | <span class="type-effort-' + row.uid  + '">' + row.workType + '</span>';
                    new_effort += ' | <span class="title-effort-' + row.uid  + '">' + row.workTitle + '</span>';
                    new_effort += ' | <span class="date-effort-' + row.uid  + '">' + row.workDate + '</span>';
                    new_effort += ' | <span class="time-effort-' + row.uid  + '">' + worktime + '</span><br />';
                    new_effort += '<span class="text-effort-' + row.uid  + '">' + row.workText + '</span>';
                    new_effort += '<br /><hr />';
                    new_effort += '</div>';
                });

                
                // Stage Progress
                new_progress+= '<div class="stageitemTop"><div class="stageitemTopText"> Progress </div></div>';
                //new_progress+= 'Progress';
                //new_progress+= '</div>';
                new_progress+= '<div class="stageitemTable">';
                new_progress+= '<div class="stageitemLabel">Status:</div>';
                new_progress+= '<div class="stageitemResult">' + getStatusFlag(result.planStatus) + '  ' + result.planStatusText + '</div>';
                new_progress+= '<div class="stageitemBorder"></div>';
                new_progress+= '<div class="stageitemLabel">Erstellt am:</div>';
                new_progress+= '<div class="stageitemResult">' + result.planCreate + '</div>';
                if(result.planTyp != 'User Story') {
                    new_progress+= '<div class="stageitemBorder"></div>';
                    new_progress+= '<div class="stageitemLabel">User Storys:</div>';
                    new_progress+= '<div class="stageitemResult">' + result.planStorys + ' | erledigt: ' + result.planStorysDone + '</div>';
                }
                if(result.planTyp == 'User Story') {
                    new_progress+= '<div class="stageitemBorder"></div>';
                    new_progress+= '<div class="stageitemLabel">Sprint:</div>';
                    new_progress+= '<div class="stageitemResult">' + result.sprint + '</div>';
                } 
                new_progress+= '</div>';
                 
                
                //set new Content
                $("#stageSubActivity").html(new_subactivities);
                $("#ajaxStagePlanactivity").html(planActivity);
                $("#ajaxStageEfforts").html(new_effort);
                $("#ajaxStageProgress").html(new_progress);
                
                //set new Content to Lightbox Plan Edit
                $("#formPlanUid").val(result.uid);
                $("#formPlanTitle").val(result.planTitle);
                $("#formPlanStatus").val(result.planStatus);
                $("#formPlanShort").val(result.planShort);
                $('#formPlanSprint option').removeAttr('selected');
                $("#formPlanSprint option[value=" + result.sprintUid + "]").attr("selected", true);
                $("#editors").val(result.planText);
                $("#editors").cleditor()[0].refresh();
                
                //set new Content to Lightbox New Activity
                $("#formActiUid").val(result.uid);
                $("#formActiPlantitel").val(result.planTitle);
                $(".formActiTitel").html(result.planTitle);
                $("#formActiUser").val(result.loggedInUser);
                
                //set new Content to Lightbox New Effort
                $("#formEffortUid").val(result.uid);
                $(".formEffortTitel").html(result.planTitle);
                $("#formEffortUser").val(result.loggedInUser);
                
                console.log('done');
                console.log(result);
                
                //we need this here because the trigger is set via ajax
                $(document).on("click",".lightboxEditEffort_trigger",function(e){
                     
                    effortuid = $(this).attr("id");
                    effortid = $(this).html();
                    effortType  = $('.type-' + effortuid ).html();
                    effortTitle = $('.title-' + effortuid ).html();
                    effortDate  = $('.date-' + effortuid ).html();
                    effortTime  = $('.time-' + effortuid ).html();
                    effortText  = $('.text-' + effortuid ).html();
                       
                    var substr = effortuid.split('-');
                    workID = substr[1];
                       
                    $('#workID').val(workID);
                    $('#effort-id').html(effortid);
                    $('.effortType').html(effortType);
                    $('#effortTitle').html(effortTitle);
                    $('.effortDate').html(effortDate);
                    $('.effortTime').html(effortTime);
                    $('.effortText').val(effortText);
                    //$(this).parent().next().find("a").css('background', 'none');
                    $('#lightboxEditEffort').show();
                    $("#ticketEdit-PlanText").cleditor()[0].refresh();
                       
                    $( "#datepicker" ).datepicker().refresh();
                });
            },
            error: function(error) {
               
                console.log(error);                
            }
        });
    
    } // end function ajax load

    function getStatusFlag(status) {
        vari = status;
    
        imageLinkStart = '<img width="15" height="15" src="' +baseUrl +  '/typo3conf/ext/projects/Resources/Public/Img/';
        imageLinkEnd   = '.png" alt="flag">';
 
        if(status == 1) { //wishlist
            vari = imageLinkStart + 'icon_flag_grey15' + imageLinkEnd;
        }
    
        if(status == 4) { //ongoing
            vari = imageLinkStart + 'icon_flag_green15' + imageLinkEnd;
        }
    
        if(status == 7) { //done
            vari = imageLinkStart + 'icon_flag_dark15' + imageLinkEnd;
        }
    
        return vari;
    }

    //Lightboxen Form Edits

    $('#lightboxPlanEdit').hide();
    $('#lightboxNewActivity').hide();
    $('#lightboxNewEffort').hide();
    $('#lightboxEditEffort').hide();
    $('#lightboxTicketEdit').hide();
   
    $('.lightboxPlanEdit_trigger').click(function(e) {
        e.preventDefault();
        $('#lightboxPlanEdit').show();
        $("#editors").cleditor()[0].refresh();
    });

    $('.lightboxNewActivity_trigger').click(function(e) {
        e.preventDefault();
        $('#lightboxNewActivity').show();
        $("#editorNewActivity").cleditor()[0].refresh();
    });

    $('.lightboxNewEffort_trigger').click(function(e) {
        e.preventDefault();
        $('#lightboxNewEffort').show();
        $("#editorNewActivity").cleditor()[0].refresh();
    });

    $('.lightboxEditEffort_trigger').click(function(e) {
        e.preventDefault();
        console.log('lightbog edit');
        $('#lightboxEditEffort').show();
    //$("#editorEditActivity").cleditor()[0].refresh();
    });


    $('.lightboxTicketEdit_trigger').click(ticketedit);

    $('.lightbox-close').click(function(e) {
        $('#lightboxPlanEdit').hide();
        $('#lightboxNewActivity').hide();
        $('#lightboxNewEffort').hide();
        $('#lightboxEditEffort').hide();
        $('#lightboxTicketEdit').hide();
    });

    function ticketedit() {
        ticketUid = $(this).attr("id");
        storagePid = $("#ajaxStoragePid").html();
        result = '';
        $.ajax({
            async: 'true',
            url: 'index.php',       
            type: 'POST',  
          
            data: {
                eID: "ajaxDispatcher",   
                request: {
                    extensionName:  'Projects',
                    pluginName:     'pi1',
                    controllerName: 'Sprint', 
                    actionName:     'ajaxResponse',
                    arguments: {
                        'uid': ticketUid,
                        'storagePid': storagePid
                    }
                } 
            },
            dataType: "json",       
            
            success: function(result) {
                $("#ticketEdit-PlanPath").html(result.plan.path);
                $("#ticketEdit-PlanTitel").html(result.plan.titel);
                $("#ticketEdit-PlanShort").html(result.plan.short);
                $("#ticketEdit-PlanText").val(result.plan.text);
                $("#ticketEdit-PlanStatus").val(result.plan.status);
                $("#ticketEdit-PlanUid").val(result.plan.uid);
                $("#ticketEdit-SprintTitel").html(result.sprint.titel);
                $("#ticketEdit-TicketUid").val(result.ticket.uid);
                $("#ticketEdit-TicketStatus").val(result.ticket.status);
                $("#ticketEdit-PlanText").cleditor()[0].refresh();
            //console.log(result);
                
            }
        });
    
    
        //console.log(ticketUid);
        $('#lightboxTicketEdit').show();
        $("#ticketEdit-PlanText").cleditor()[0].refresh();
    }
    
    
    function getAbsolutePath() {
        var loc = window.location;
        var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
        return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
    }

    function getBasePath() {

        return window.location.host;
    }




      
}); //End jquery

