jQuery("document").ready(function(){
    
    //**********************************************************************/
    // General Settings**************** ************************************/
    //**********************************************************************/ 
    
    
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

    $("#editor").cleditor({
        width:        680, // width not including margins, borders or padding
        height:       250, // height not including margins, borders or padding
        controls:     // controls to add to the toolbar
                      "bold italic bullets numbering |",
        bodyStyle:    // style to assign to document body contained within the editor
                      "margin:10px; font:12px/21px 'Lato',​Arial,​Helvetica,​sans-serif; cursor:text; color:#384953; "
    });




    $(function() {
        $( ".datepicker" ).datepicker();
        $( "#datepicker2" ).datepicker(); 
    
        //**********************************************************************/
        // Actions on InBox -> Project Page ************************************/
        //**********************************************************************/
        
        
        //Inbox Project List: Toggle sub projects
        $('.jqToggleProjects').click(function(e)  { 
            var category = $(this).closest('li');
            //toggle function
            var subcategories = category.find('ul');
            subcategories.toggle();
            if(subcategories.hasClass('hidden'))subcategories.removeClass('hidden') ;
            //change Icon
            var icon  = category.find('.jqToggleProjects');
             
            if(icon.hasClass('toggle-icon-plus')){
                icon.removeClass('toggle-icon-plus');
                icon.addClass('toggle-icon-minus');
            } else {
                icon.removeClass('toggle-icon-minus');
                icon.addClass('toggle-icon-plus');
            }

        });
        
        // Show All Projects
        $('.jqShowAllProjects').click(function(e)  { 
            $('ul').each( function() { 
                $(this).removeClass('hidden');
                //toggle icon
                var category = $(this).closest('li');
                var icon  = category.find('.jqToggleProjects');
                icon.removeClass('toggle-icon-plus');
                icon.addClass('toggle-icon-minus');
            });
        });
        
        // Hide All Sub Projects
        $('.jqHideSubProjects').click(function(e)  { 
            $('ul ul').each( function() { 
                $(this).addClass('hidden');
            });
            //toggle Icon
            $('ul').each( function() { 
                var category = $(this).closest('li');
                var icon  = category.find('.jqToggleProjects');
                icon.removeClass('toggle-icon-minus');
                icon.addClass('toggle-icon-plus');
            });
        });
    
        //**********************************************************************/
        // Actions on Projects -> ToDo Page ************************************/
        //**********************************************************************/ 
         
        //ToDoList: Hide done todos
        $('.jqLoadTodo').each( function() { 
            var status = $(this).find('.status').html();
            status = status.replace(/ /g,'');
            if( status > 5){
                $(this).addClass('hidden');
            }
                
        });
        
        
        $('.jqHideDoneTodos').click(function(e)  { 
            $('.jqLoadTodo').each( function() { 
                var status = $(this).find('.status').html();
                status = status.replace(/ /g,'');
                if( status > 5){
                    $(this).addClass('hidden');
                }
            });
        });
        
        //ToDo List: Show All
        $('.jqShowAllTodos').click(function(e)  { 
            
            $('.jqLoadTodo').each( function() { 
                $(this).removeClass('hidden');
            });
        });
        
        //Shows the hidden Edit / New Form on List View
        $('.form').hide();
        $('.jqShowForm').click(function(e)  {  
            $('.form').show();
            $('html, body').animate({
                scrollTop: 80
            });
            var todoList = $('.jqTodoList').html();
            $('.jqTodoFormUid').val('');
            $('.jqTodoFormList').val(todoList);
            $('.jqTodoFormTitle').val('');
            $('.jqTodoFormDescription').val('');
            $('.jqTodoFormComment').val('');
            $('.jqTodoFormStatus').val('');
            $('.jqTodoFormTyp').val('');
            $('.jqTodoFormUser').val('');
            $('.jqTodoFormPlantime').val('');
            $('.jqTodoFormStartdate').val('');
            $('.jqTodoFormEnddate').val('');
        });
        
        
        //Load ToDo from List into Form
        $('.jqLoadTodo').click(function(e)  { 
        
            var uid = $(this).find('.jqtodo_uid').html();
            var storagePid = $('.jqStoragePid').html();
        
            $.ajax({
                async: 'true',
                url: 'index.php',       
                type: 'POST',  
          
                data: {
                    eID: "ajaxDispatcher",   
                    request: {
                        extensionName:  'ProjectsAndTasks',
                        pluginName:     'patsystem',
                        controller:     'Project', 
                        action:         'todoByAjax',
                        arguments: {
                            'uid': uid,
                            'storagePid': storagePid
                        }
                    } 
                },
                dataType: "json",       
            
                success: function(result) {
                    $('.form').show();
                    $('html, body').animate({
                        scrollTop: 80
                    });
                    var todoList = $('.jqTodoList').html();
                    $('.jqTodoFormUid').val(result.uid);
                    $('.jqTodoFormList').val(todoList);
                    $('.jqTodoFormTitle').val(result.todoTitel);
                    $('.jqTodoFormDescription').val(result.todoDescription);
                    $('.jqTodoFormComment').val(result.todoComment);
                    $('.jqTodoFormStatus').val(result.todoStatus);
                    $('.jqTodoFormTyp').val(result.todoTyp);
                    $('.jqTodoFormUser').val(result.todoAssigned);
                    $('.jqTodoFormPlantime').val(result.todoPlantime);
                    $('.jqTodoFormStartdate').val(result.todoDate);
                    $('.jqTodoFormEnddate').val(result.todoEnd);
                    console.log(result);
                
                },
                error: function(error) {
               
                    console.log(error);                
                }
            });
        

        });
    
        //Loads an other ToDolist (select change in Submenu)
        $('.jqSelectTodoList').change(function(e)  { 
         $('#todoListSelect').submit();
          });
        
        //Shows the ToDo LIST Form for editing
        $('.listform').hide();
        $('.jqEditTodoList').click(function(e)  { 
            $('.jqTodoListForm').show();
        });
        
        //Shows the ToDo LIST Form for creating a new TodoList
        $('.jqNewTodoList').click(function(e)  { 
            $('.jqTodoListFormUid').val('');
            $('.jqTodoListFormTitle').val('');
            $('.jqTodoListFormShortTitle').val('');
            $('.jqTodoListFormDescription').val('');
            $('.jqTodoListFormStatus').val('');
            $('.jqTodoListFormOwner').val('');
            
            $('.jqTodoListForm').show();
        });
        
        //**********************************************************************/
        // Actions on Project -> Efforts Page **********************************/
        //**********************************************************************/
        
        //WorkList: Hide invoiced work
        $('.jqHideInvoiceWork').click(function(e)  { 
            
            $('.jqLoadEffort').each( function() { 
                var status = $(this).find('.status').html();
                status = status.replace(/ /g,'');
                if(status == 6)$(this).addClass('hidden');
                if(status == 1)$(this).addClass('hidden');
            });
        });
        
        //Work List: Show All
        $('.jqShowAllWork').click(function(e)  { 
            
            $('.jqLoadEffort').each( function() { 
                $(this).removeClass('hidden');
            });
        });
        
        //Shows the hidden Edit / New Form on List View
        $('.form').hide();
        $('.jqShowForm').click(function(e)  {  
            $('.form').show();
            $('html, body').animate({
                scrollTop: 80
            });
            var project = $('.jqEffortProjectUid').html();
            $('.jqEffortFormUid').val('');
            $('.jqEffortFormProject').val(project);
            $('.jqEffortFormTitle').val('');
            $('.jqEffortFormText').val('');
            $('.jqEffortFormStatus').val('');
            //$('.jqEffortFormUser').val(''); 
            $('.jqEffortFormDate').val('');
            $('.jqEffortFormStart').val('');
            $('.jqEffortFormEnd').val('');
        });
        
        
        //Load Effort from List into Form
        $('.jqLoadEffort').click(function(e)  { 
        
            var uid = $(this).find('.jqEffort_uid').html();
            var storagePid = $('.jqStoragePid').html();
        
            $.ajax({
                async: 'true',
                url: 'index.php',       
                type: 'POST',  
          
                data: {
                    eID: "ajaxDispatcher",   
                    request: {
                        extensionName:  'ProjectsAndTasks',
                        pluginName:     'patsystem',
                        controller:     'Project', 
                        action:         'effortByAjax',
                        arguments: {
                            'uid':        uid,
                            'storagePid': storagePid
                        }
                    } 
                },
                dataType: "json",       
            
                success: function(result) {
                    $('.form').show();
                    $('html, body').animate({
                        scrollTop: 80
                    });
                    //var project = $('.jqTodoList').html();
                    $('.jqEffortFormUid').val(result.uid);
                    $('.jqEffortFormProject').val(result.effortProject);
                    $('.jqEffortFormTitle').val(result.effortTitel);
                    $('.jqEffortFormText').val(result.effortDescription);
                    $('.jqEffortFormStatus').val(result.effortStatus);
                    $('.jqEffortFormUser').val(result.effortUser);
                    $('.jqEffortFormDate').val(result.effortDate);
                    $('.jqEffortFormStart').val(result.effortStart);
                    $('.jqEffortFormEnd').val(result.effortEnd);
                    
                    
                    console.log(result);
                
                },
                error: function(error) {
               
                    console.log(error);                
                }
            });
        
        
            console.log(uid);
        });
        
        
    });

 
    
      
}); //End jquery

