$(document).ready(function() {

    
    
   
});

$(function(){
    
    //add no ddata found to empty tables
     if($('.pat-list').length){
        if($('.pat-list').height() < 5) {
            $('.pat-list').html('<p><br>&nbsp;&nbsp;&nbsp;No data found.</p>');
        }   
    }
    
    //Datepicker
    $('.datepicker').datepicker();
    
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


});