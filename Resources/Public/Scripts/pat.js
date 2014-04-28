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
            dateFormat: 'yy-mm-dd', 
            firstDay: 1, 
            initStatus: 'Wähle ein Datum', 
            isRTL: false
        };
        $.datepicker.setDefaults($.datepicker.regional['de']);
    });

    //Graph on inbox
    var chartDate   = $('.chartDate').text().split(',');
    var chartTime   = $('.chartTime').text().split(',');
    var chartTicket = $('.chartTicket').text().split(',');
    var chartAge    = $('.chartAge').text().split(',');
   
    var data = {
        labels : chartDate,
        datasets : [
        {
            fillColor : "rgba(220,220,220,0.1)",
            strokeColor : "rgba(220,220,220,1)",
            pointColor : "rgba(220,220,220,1)",
            pointStrokeColor : "#fff",
            data : $('.chartTicket').text().split(',')
            //data : [78,78,78,79,81,82,84]
        },
        {
            fillColor : "rgba(151,187,205,0.0)",
            strokeColor : "rgba(151,187,205,0)",
            pointColor : "rgba(151,187,205,0)",
            pointStrokeColor : "#fff",
            data : [0,0,0,0,0,0,0,0,0,0]
        },
        {
            fillColor : "rgba(151,187,205,0.1)",
            strokeColor : "rgba(151,187,205,1)",
            pointColor : "rgba(151,187,205,1)",
            pointStrokeColor : "#fff",
            data : $('.chartAge').text().split(',')
        },
        
        {
            fillColor : "rgba(151,187,205,0.1)",
            strokeColor : "rgba(255,150,50,0.5)",
            pointColor : "rgba(255,150,50,0.5)",
            pointStrokeColor : "#fff",
            data : $('.chartTime').text().split(',')
        }
        
        ]
    }
    
    var options = {
				
	//Boolean - If we show the scale above the chart data			
	scaleOverlay : false,
	
	//Boolean - If we want to override with a hard coded scale
	scaleOverride : true,
	
	//** Required if scaleOverride is true **
	//Number - The number of steps in a hard coded scale
	scaleSteps : 5,
	//Number - The value jump in the hard coded scale
	scaleStepWidth : 20,
	//Number - The scale starting value
	scaleStartValue : 0,
        scaleShowLabels : false
    }
//    console.log(data.labels);
//    var chartDate = chartDate.split(',');
//    data.labels = chartDate;
//    console.log(data.labels);
if(document.getElementById("myChart")!= undefined){
    var ctx = document.getElementById("myChart").getContext("2d");
    var myNewChart = new Chart(ctx).Line(data,  options);
}


    $(function() {
        $( ".datepicker" ).datepicker();
        $( "#datepicker2" ).datepicker(); 
        
    });
   
    $('.timepicker').click(function(e)  { 
        var timepicker = '<div class="timepicker-layer" style="position: absolute;">';
        timepicker+= '<div class="timepicker-row timepicker-border-bottom clearfix">';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">7:00</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">7:15</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">7:30</div>';
        timepicker+=  '<div class="timepicker-cell">7:45</div>';
        timepicker+= '</div>'
       
        timepicker+= '<div class="timepicker-row timepicker-border-bottom clearfix">';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">8:00</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">8:15</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">8:30</div>';
        timepicker+=  '<div class="timepicker-cell">8:45</div>';
        timepicker+= '</div>'
       
        timepicker+= '<div class="timepicker-row timepicker-border-bottom clearfix">';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">9:00</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">9:15</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">9:30</div>';
        timepicker+=  '<div class="timepicker-cell">9:45</div>';
        timepicker+= '</div>'
       
        timepicker+= '<div class="timepicker-row timepicker-border-bottom clearfix">';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">10:00</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">10:15</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">10:30</div>';
        timepicker+=  '<div class="timepicker-cell">10:45</div>';
        timepicker+= '</div>'
       
        timepicker+= '<div class="timepicker-row timepicker-border-bottom clearfix">';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">11:00</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">11:15</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">11:30</div>';
        timepicker+=  '<div class="timepicker-cell">11:45</div>';
        timepicker+= '</div>'
       
        timepicker+= '<div class="timepicker-row timepicker-border-bottom clearfix">';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">12:00</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">12:15</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">12:30</div>';
        timepicker+=  '<div class="timepicker-cell">12:45</div>';
        timepicker+= '</div>'
       
        timepicker+= '<div class="timepicker-row timepicker-border-bottom clearfix">';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">13:00</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">13:15</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">13:30</div>';
        timepicker+=  '<div class="timepicker-cell">13:45</div>';
        timepicker+= '</div>'
       
        timepicker+= '<div class="timepicker-row timepicker-border-bottom clearfix">';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">14:00</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">14:15</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">14:30</div>';
        timepicker+=  '<div class="timepicker-cell">14:45</div>';
        timepicker+= '</div>'
       
        timepicker+= '<div class="timepicker-row timepicker-border-bottom clearfix">';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">15:00</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">15:15</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">15:30</div>';
        timepicker+=  '<div class="timepicker-cell">15:45</div>';
        timepicker+= '</div>'
       
        timepicker+= '<div class="timepicker-row timepicker-border-bottom clearfix">';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">16:00</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">16:15</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">16:30</div>';
        timepicker+=  '<div class="timepicker-cell">16:45</div>';
        timepicker+= '</div>'
       
        timepicker+= '<div class="timepicker-row timepicker-border-bottom clearfix">';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">17:00</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">17:15</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">17:30</div>';
        timepicker+=  '<div class="timepicker-cell">17:45</div>';
        timepicker+= '</div>'
       
        timepicker+= '<div class="timepicker-row timepicker-border-bottom clearfix">';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">18:00</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">18:15</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">18:30</div>';
        timepicker+=  '<div class="timepicker-cell">18:45</div>';
        timepicker+= '</div>'
       
        timepicker+= '<div class="timepicker-row timepicker-border-bottom clearfix">';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">19:00</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">19:15</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">19:30</div>';
        timepicker+=  '<div class="timepicker-cell">19:45</div>';
        timepicker+= '</div>'
       
        timepicker+= '<div class="timepicker-row timepicker-border-bottom clearfix">';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">20:00</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">20:15</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">20:30</div>';
        timepicker+=  '<div class="timepicker-cell">20:45</div>';
        timepicker+= '</div>'
       
        timepicker+= '<div class="timepicker-row timepicker-border-bottom clearfix">';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">21:00</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">21:15</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">21:30</div>';
        timepicker+=  '<div class="timepicker-cell">21:45</div>';
        timepicker+= '</div>'
       
        timepicker+= '<div class="timepicker-row timepicker-border-bottom clearfix">';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">22:00</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">22:15</div>';
        timepicker+=  '<div class="timepicker-cell timepicker-border-right">22:30</div>';
        timepicker+=  '<div class="timepicker-cell">22:45</div>';
        timepicker+= '</div>'
       
        
           
        timepicker+='</div>';
        $(this).closest('.pat-form-wrap').append(timepicker);
   
    });

    $(document).on("click", ".timepicker-cell", function() {
        var value = $(this).text();
     
        $(this).closest('.pat-form-wrap').find('input').val(value);
        $('.timepicker-layer').empty();
    
    });

 
    
      
}); //End jquery



