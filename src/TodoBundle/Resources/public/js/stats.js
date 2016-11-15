$(document).ready(function(){

    var ctx = $("#veracity");
    var veracityDonut = new Chart(ctx, {
        type: 'doughnut',
        data: dataVeracity
    });

    var avg = $("#averagetime");
    var veracityDonut = new Chart(avg, {
        type: 'doughnut',
        data: dataAvg
    });

    var bars = $('#taskTime');
    new Chart(bars, {
        type: 'bar',
        data: dataTasksBar
    });

    var complexity = $('#taskComplexity');
    new Chart(complexity, {
        type: 'bar',
        data: dataComplexity
    });
});