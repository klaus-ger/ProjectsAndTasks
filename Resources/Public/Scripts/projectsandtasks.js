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
    
    
        //Shows the hidden Edit / New Form on List View
        $('.form').hide();
        $('.jqShowForm').click(function(e)  {  
            $('.form').show();
            $('html, body').animate({
                scrollTop: 0
            });
            });
            
        //ToDoList: Hide done todos
        $('.jqHideDoneTodos').click(function(e)  { 
            
            $('.projectListItem').each( function() { 
                var status = $(this).find('.status').html();
                if( status > 5){
                $(this).addClass('hidden');
                }
           });
        });
        
        //ToDo List: Show All
         $('.jqShowAllTodos').click(function(e)  { 
            
            $('.projectListItem').each( function() { 
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
        
        
        
    });



      
}); //End jquery

