  // Load the Visualization API and the piechart package.
google.load('visualization', '1.0', {'packages':['corechart']});
 
  // Set a callback to run when the Google Visualization API is loaded.
  //google.setOnLoadCallback(drawChart);
  // Callback that creates and populates a data table, 
  // instantiates the pie chart, passes in the data and
  // draws it.
function drawChart() {
	var data1 = parseInt(document.getElementById("graph_val_1").innerHTML) ;
	var data2 = parseInt(document.getElementById("graph_val_2").innerHTML) ;
	var data3 = parseInt(document.getElementById("graph_val_3").innerHTML) ;
	// Create the data table.
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Topping');
	data.addColumn('number', 'Slices');
	data.addRows([ ['On Track', data1], ['Submitted', data2], ['Completed', data3] ]);
	// Set chart options
	var options = {'title':'Tasks', 'width':350, 'height':170};
	// Instantiate and draw our chart, passing in some options.
	var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
	chart.draw(data, options);
}

function drawChart2() {
	var data1 = parseInt(document.getElementById("graph2_val_1").innerHTML) ;
	var data2 = parseInt(document.getElementById("graph2_val_2").innerHTML) ;
	var data3 = parseInt(document.getElementById("graph2_val_3").innerHTML) ;
	var data4 = parseInt(document.getElementById("graph2_val_4").innerHTML) ;
	var data5 = parseInt(document.getElementById("graph2_val_5").innerHTML) ;
	// Create the data table.
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Topping');
	data.addColumn('number', 'Slices');
	data.addRows([ ['Open', data1], ['Closed', data2], ['Accepted', data3], ['Submitted', data4], ['Completed', data5] ]);
	// Set chart options
	var options = {'title':'Challenges', 'width':350, 'height':220};
	// Instantiate and draw our chart, passing in some options.
	var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));
	chart.draw(data, options);
}
