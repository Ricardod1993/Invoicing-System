$(function(){
	// When the combobox of the invoice status changes
	$(document).on("change", ".invoice-status-changer", function(){
		var invoice_id = $(this).data("invoiceid"); // getting the data atribute invoice ID from the select element
		var status = $(this).val(); // getting the value of the current option selected

		// Excuting the function changeInvoiceStatus() passing the invoice_id and status. See function below
		changeInvoiceStatus(invoice_id, status);
	});

	// When one of the pagination links is clicked
	$("#invoice-list-pagination").on("click", "li a", function(){
		// See function below changeInvoicesListPage()
		changeInvoicesListPage($(this));
	});

});


//Functions
function changeInvoiceStatus(invoice_id, status){
	// displaying preloader
	preload("show");

	/*
		* Ajax post request to controller utilities method change_invoice_status, passing the invoice_id and the status
		* See file: /app/controllers/Site/utilities.php, function change_invoice_status()
	*/
	$.ajax({
		method: "POST",
		url: "/utilities/change_invoice_status",
		data: {invoice_id: invoice_id, status: status},
		success: function(data){
			var response = $.parseJSON(data);

			// if response.proceed is false, then alert the user with the message returned by PHP
			if(response.proceed == false){
				alert(response.message);
			}

			// Hiding preloader
			preload("hide");
		}
	});
}

function changeInvoicesListPage($button){
	preload("show"); // Showing preloader

	// Here we have 2 cases, if it's not the backward or forward button being clicked or if it is
	if(!$button.hasClass("backward") && !$button.hasClass("forward")){
		// If it's not forward or backward, then the page will be equal to the page of the link being clicked
		var page = $button.data("page");
	}else{
		// If it's backward or forward, then store the url parameter page, if it's null then the page is 1, if not null, then is equal to the param value 
		var page_param = getUrlParam("page");
		page_param = page_param == null ? 1 : Number(page_param);

		//Checking wich button was clicked
		if($button.hasClass("backward")){
			var page = Number(page_param) - 1; // IF backward, then the value of page is subtracted by 1
		}else if($button.hasClass("forward")){
			var page = Number(page_param) + 1; // IF backward, then the 1 is added to the value of page
		}
	}

	var limit = $button.closest("ul").data("limit"); // Storing the value of the data atribute limit, which is in the ul element

	/*
		* Ajax request of type post, passing 2 parameters, page and limit
		* See file /app/controllers/Site/utilities, function change_invoices_list_page()
	*/
	$.ajax({
		method: "POST",
		url: "/utilities/change_invoices_list_page",
		data: {page: page, limit: limit},
		success: function(data){
			var response = $.parseJSON(data);
 
			if(response.proceed == true){
				$invoices_list = $("#invoices-list").empty(); // removing all rows inside of the list, to fill it up with the next page rows

				var invoices = response.invoices; // Storing the invoices returned by the response

				//Looping through the returned invoices and filling the list with them
				for (var i = 0; i < invoices.length; i++) {
					$status_select = $("<select>").addClass("form-control invoice-status-changer").data("invoiceid", invoices[i].id).append(
						$("<option>").attr({"value": "paid"}).text("Paid")
					).append(
						$("<option>").attr({"value": "unpaid"}).text("Not paid")
					);
					$status_select.find("option[value='" + invoices[i].invoice_status + "']").attr("selected", true);


					$invoices_list.append(
						$("<tr>").append(
							$("<td>").attr({align: "center", width: "10"}).text(invoices[i].id)
						).append(
							$("<td>").text(invoices[i].client)
						).append(
							$("<td>").text(invoices[i].invoice_amount + "€")
						).append(
							$("<td>").text(invoices[i].invoice_amount_plus_vat + "€")
						).append(
							$("<td>").addClass("text-center").text(invoices[i].vat_rate + "%")
						).append(
							$("<td>").append(
								$status_select
							)
						).append(
							$("<td>").text(invoices[i].invoice_date)
						).append(
							$("<td>").text(invoices[i].created_at)
						)
					);
				}

				// If the current page is bigger than 1, then enable the backward button, otherwise, disable it
				if(response.current_page > 1){
					$("#invoice-list-pagination").find("li:first-child").removeClass("disabled");
				}else{
					$("#invoice-list-pagination").find("li:first-child").addClass("disabled");
				}

				// If the current page is equal to the number of total pages, then disable the forward button, otherwise, enable it
				if(response.current_page == response.total_pages){
					$("#invoice-list-pagination").find("li:last-child").addClass("disabled");
				}else{
					$("#invoice-list-pagination").find("li:last-child").removeClass("disabled");
				}

				// Remove class active from the previous page link element, and then add an active class to the current link element
				$("#invoice-list-pagination").find("li").removeClass("active");
				if(!$button.hasClass("backward") && !$button.hasClass("forward")){
					$button.parent("li").addClass("active");
				}else{
					$("#invoice-list-pagination").find("li a[data-page='" + page + "']").parent("li").addClass("active");
				}

				/*
					* This function changes the url parameter page to the current, by doing this, when the page is refreshed it will not reset the list
					* because PHP is expecting the parameter page to redo the query as it was in the previous state of the page.
				*/
				changeUrlParam("page", page);
			}else{
				alert(response.message);
			}

			preload("hide");
		}
	});
}

function preload(action){
	if(action == "show"){
		$(".preloader-wrapper").show();
	}else if(action == "hide"){
		$(".preloader-wrapper").hide();
	}
}

function getUrlParam(name, url) {
    if (!url) {
      url = window.location.href;
    }
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function changeUrlParam (param, value) {

    var currentURL = window.location.href+'&';
    var change = new RegExp('('+param+')=(.*)&', 'g');
    var newURL = currentURL.replace(change, '$1='+value+'&');

    if (getUrlParam(param) !== null){

        try {
            window.history.replaceState('', '', newURL.slice(0, - 1) );
        } catch (e) {
            console.log(e);
        }
    } else {

        var currURL = window.location.href;
        if (currURL.indexOf("?") !== -1){
            window.history.replaceState('', '', currentURL.slice(0, - 1) + '&' + param + '=' + value);
        } else {
            window.history.replaceState('', '', currentURL.slice(0, - 1) + '?' + param + '=' + value);
        }
    }
}