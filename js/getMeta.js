function url_domain(data) {
  var    a      = document.createElement('a');
         a.href = data;
  return a.hostname;
}
    jQuery.ajax=function(e){function o(e){return!r.test(e)&&/:\/\//.test(e)}var t=location.protocol,n=location.hostname,r=RegExp(t+"//"+n),i="http"+(/^https/.test(t)?"s":"")+"://query.yahooapis.com/v1/public/yql?callback=?",s='select * from html where url="{URL}" and xpath="*"';return function(t){var n=t.url;if(/get/i.test(t.type)&&!/json/i.test(t.dataType)&&o(n)){t.url=i;t.dataType="json";t.data={q:s.replace("{URL}",n+(t.data?(/\?/.test(n)?"&":"?")+jQuery.param(t.data):"")),format:"xml"};if(!t.success&&t.complete){t.success=t.complete;delete t.complete}t.success=function(e){return function(t){if(e){e.call(this,{responseText:(t.results[0]||"").replace(/<script[^>]+?\/>|<script(.|\s)*?\/script>/gi,"")},"success")}}}(t.success)}return e.apply(this,arguments)}}(jQuery.ajax);

function getUrlData(url_get){
	var url_data = {};
	$.ajax({
		url: url_get,
		type: "GET",
		async: false
	}).done(function (response) {
		var div = document.createElement("div"),
			responseText = response.results[0],
			title, metas, meta, name, description, metaImg, property, i, author;
		//console.log(response.results[0]);
		div.innerHTML = responseText;
		//console.log(div.getElementsByTagName("meta").length);
		title = div.getElementsByTagName("title");
		title = title.length ? title[0].innerHTML : undefined;
		
		metas = div.getElementsByTagName("meta");
		//console.log(metas);
		description = "";
		for (i = 0; i < metas.length; i++) {
		//console.log(metas.length,i,metas[i].outerHTML);
			name = metas[i].getAttribute("name");
			if (name === "description") {
				meta = metas[i];
				description = meta.getAttribute("content");
				break;
			}
		}
		if(description == ""){

			for (i = 0; i < metas.length; i++) {
				name = metas[i].getAttribute("name");
				//console.log(name);
				if (name === "twitter:description") {
					meta = metas[i];
					//console.log(meta);
					description = meta.getAttribute("value")?meta.getAttribute("value"):meta.getAttribute("content");
					//break;
				}
			}

		}
		
		for (i = 0; i < metas.length; i++) {
			name = metas[i].getAttribute("property");
		//console.log(metas.length,i,metas[i].outerHTML);
			if (name === "author") {
				meta = metas[i];
				author = meta.getAttribute("content");
				break;
			}
			name = metas[i].getAttribute("name");
		   //  console.log(name);
		if (name === "twitter:creator") {
				meta = metas[i];
			//console.log(meta);
				author = meta.getAttribute("value")?meta.getAttribute("value"):meta.getAttribute("content");
				break;
			} else if (name === "twitter:site") {
				meta = metas[i];
			//console.log(meta);
				author = meta.getAttribute("value")?meta.getAttribute("value"):meta.getAttribute("content");
				break;
			}
		}
		for (i = 0; i < metas.length; i++) {
			property = metas[i].getAttribute("content");
			//console.log(property);
			
			if (property != null  && property.substr(property.length - 4) === ".jpg") {
				
				metaImg = property;
				break;
			}
		}

		if (metaImg == undefined){
			for (i = 0; i < metas.length; i++) {
			name = metas[i].getAttribute("name");
					//console.log(name);
				if (name === "twitter:image:src") {
						meta = metas[i];
					console.log(meta);
						metaImg = meta.getAttribute("value")?meta.getAttribute("value"):meta.getAttribute("content");
						break;
					}
			}

		}
		if (metaImg == undefined){
		
			imgs = div.getElementsByTagName("img");
			for (var i=0, n=imgs.length;i<n;i++) 
			allImg = '<img src="'+imgs[i].src+'" width="60%">';
			metaImg = imgs[0].src;
			  
		}
    //console.log("Title:", title);
    //document.getElementById("title").innerHTML = title;
    //console.log("Description:", description);
    //document.getElementById("dec").innerHTML = description;
    
    //document.getElementById("author").innerHTML = author;
    

    //console.log("Image:", metaImg);
    //document.getElementById("allImgD").innerHTML = allImg;
    /*
	document.getElementById("imgD").innerHTML = "<img src=\'"+metaImg+"\' height= \'200px\'/>";
    */
    
		url_data.title = convertSpecialChar(title);
		url_data.description = convertSpecialChar(description);
		url_data.domain = convertSpecialChar(url_domain(url_get));
		url_data.author = convertSpecialChar(url_data.author?author:url_data.domain.split(".")[1]);
		url_data.metaImg = metaImg;
		var Image = "<img src=\""+url_data.metaImg+"\" style=\"max-width: 100%;\" onError=\"this.src=\"img/default.gif\"\" />";
		var IDPr = parseInt($("#ProjectIDValue").val()) ;
		var dataString = 'title='+ replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',title))))) 
						+ '&description=' + replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',description))))) 
						+ '&url=' + replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',url_get))))) 
						+ '&author=' + replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',url_data.author))))) 
						+ '&domain=' + replaceAll('  ',' <s>',replaceAll('\n',' <br/>  ',replaceAll("'",'<r>',replaceAll('&','<a>',replaceAll('[+]','<an>',url_data.domain))))) 
						+ '&img=' + Image + '&id=' + IDPr ;
		$.ajax({
			type: "POST",
			url: "ajax/submit_link.php",
			async: false ,
			data: dataString,
			cache: false,
			success: function(result){
				var notice = result.split("|+");
				if(notice['0'] == "Posted"){
					bootstrap_alert(".alert_placeholder", "Posted Succeccfully !!", 5000,"alert-success");
					$("#create_link").removeAttr('disabled');
					$('.loading').remove();
					$("#sharedlink").val("");
					$(".newPosts").prepend(notice['1']) ;
					$(".editbox").hide() ;
				}
				else {
					bootstrap_alert(".alert_placeholder", notice['0'], 5000,"alert-warning");
					$("#create_link").removeAttr('disabled');
					$('.loading').remove();
				}
			}
		}); 
		console.log(url_data);
		//return  url_data ;

		}).fail(function (jqXHR, textStatus, errorThrown) {
			console.log("AJAX ERROR:", textStatus, errorThrown);		
	});
   
}
