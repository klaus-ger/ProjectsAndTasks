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
    
    
        
            
        //ToDoList: Hide done todos
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
        
        //WorkList: Hide invoiced work
        $('.jqHideInvoiceWork').click(function(e)  { 
            
            $('.projectListItem').each( function() { 
                var status = $(this).find('.status').html();
                status = status.replace(/ /g,'');
                if(status == 6)$(this).addClass('hidden');
                if(status == 1)$(this).addClass('hidden');
            });
        });
        
        //Work List: Show All
        $('.jqShowAllWork').click(function(e)  { 
            
            $('.projectListItem').each( function() { 
                $(this).removeClass('hidden');
            });
        });
        
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
                    controller: 'Todo', 
                    action:     'findTodoByAjax',
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
        
        
        console.log(uid);
    });
    
      
}); //End jquery

