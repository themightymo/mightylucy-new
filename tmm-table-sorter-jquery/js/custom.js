jQuery(document).ready(function($) {
    //alert('test');
    $("#myTable").tablesorter({sortList: [[3,0],[2,1]]});
    jQuery('#table2CSV').click(function(){
		$('#myTable').table2CSV();
	});
});