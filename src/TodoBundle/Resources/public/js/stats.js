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
});