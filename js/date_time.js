//startTime();
            function getDateTime() {
                var now     = new Date(); 
                var year    = now.getFullYear();
                var month   = now.getMonth()+1; 
                var day     = now.getDate();
                var hour    = now.getHours();
                var minute  = now.getMinutes();
                var second  = now.getSeconds(); 
                if(month.toString().length == 1) {
                    var month = '0'+month;
                }
                if(day.toString().length == 1) {
                    var day = '0'+day;
                }   
                if(hour.toString().length == 1) {
                    var hour = '0'+hour;
                }
                if(minute.toString().length == 1) {
                    var minute = '0'+minute;
                }
                if(second.toString().length == 1) {
                    var second = '0'+second;
                }   
                var dateTime = year+'/'+month+'/'+day+' '+hour+':'+minute+':'+second;   
                return dateTime;
            }

            function startTime() {
                document.getElementById('demo').innerHTML = String(getDateTime());
                t = setTimeout(function () {
                    startTime()
                }, 500);
            }
 setInterval(function updatelastlogin(){ 
		var dataString = 'update=true' + '&case=2' ;
			$.ajax({
				type: "POST",
				url: "ajax/updatetime.php",
				data: dataString,
				cache: false,
			});
		},600000)();
