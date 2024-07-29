
function deleteCustomer(id) {
  if (confirm("Are you sure you want to delete this customer? It is not recoverable.")) {
    $.ajax({
      url: "/clients/bikeandride/dashboard/admin/deletecustomer/" + id,
      type: 'POST',
      success: function (data) {
        $("a[href='http://www.nexvistech.com/clients/bikeandride/dashboard/admin/editcustomer/"+id+"']").parent("td").parent("tr").remove();
        alert("Customer is deleted successfully.");
      }
    });
  } else {
    console.log("You pressed Cancel!");
  }
}



function deleteLockCustomer(id) {
  if (confirm("Are you sure you want to delete this customer? It is not recoverable.")) {
    $.ajax({
      url: "/locksmith/deletecustomer/" + id,
      type: 'POST',
      success: function (data) {
        $(".user-" + id).remove();
        alert("Customer is deleted successfully.");
      }
    });
  } else {
    console.log("You pressed Cancel!");
  }
}
function deleteAdminOrder(id) {
  if (confirm("Are you sure you want to delete this order? It is not recoverable.")) {
    $.ajax({
      url: "/clients/bikeandride/dashboard/admin/deleteorder/" + id,
      type: 'POST',
      success: function (data) {
        $("a[href='http://www.nexvistech.com/clients/bikeandride/dashboard/admin/editorder/"+id+"']").parent("td").parent("tr").remove();
        alert("Order is deleted successfully.");
      }
    });
  } else {
    console.log("You pressed Cancel!");
  }
}

function detailAdminOrder(id) {
  
$id = id;
 $customer = $('#dt'+id).data("cust");
 $price = $('#dt'+id).data("price");
 $status = $('#dt'+id).data("status");
 $start_date = $('#dt'+id).data("startdate");
 $enddate = $('#dt'+id).data("enddate");
 $start_address = $('#dt'+id).data("startaddress");
$end_address =  $('#dt'+id).data("endaddress");

 $distance = $('#dt'+id).data("distance");
$calories =  $('#dt'+id).data("calories");
 $carbonkg = $('#dt'+id).data("carbonkg");
$totaltime =  $('#dt'+id).data("totaltime");

  $("td.dataid").text($id);
  $("td.custname").text( $customer);
  $("td.price").text( $price);
  $("td.status").text( $status);
  $("td.stdate").text( $start_date);
    $("td.endate").text( $enddate);
  $("td.staddress").text($start_address);
  $("td.endaddress").text($end_address);

   $("td.distance").text($distance);
  $("td.calories").text($calories);
   $("td.carbon").text($carbonkg);
  $("td.ridetime").text($totaltime);

    $.ajax({
      url: "/clients/bikeandride/dashboard/admin/detailadminorder/" + id,
      type: 'POST',
      success: function (data) {
        
        $('.rightbar').css("right", "0");
        $('.overlayleft').css("top", "0");
        
      }
    });
  
 
}

$('.closebar').click(function(){
     $('.rightbar').css("right", "-100%");
        $('.overlayleft').css("top", "-100%");
});


function deleteAdminReview(id) {
  if (confirm("Are you sure you want to delete this review? It is not recoverable.")) {
    $.ajax({
      url: "/clients/bikeandride/dashboard/admin/deletereview/" + id,
      type: 'POST',
      success: function (data) {
        $("a[href='http://www.nexvistech.com/clients/bikeandride/dashboard/admin/editreview/"+id+"']").parent("td").parent("tr").remove();
        alert("Review is deleted successfully.");
      }
    });
  } else {
    console.log("You pressed Cancel!");
  }
}
function deleteLocksmithOrder(id) {
  if (confirm("Are you sure you want to delete this order? It is not recoverable.")) {
    $.ajax({
      url: "/locksmith/deleteorder/" + id,
      type: 'POST',
      success: function (data) {
        $("a[href='http://locksmith.nexvistech.com/locksmith/editorder/"+id+"']").parent("td").parent("tr").remove();
        alert("Order is deleted successfully.");
      }
    });
  } else {
    console.log("You pressed Cancel!");
  }
}

function deleteLocksmithReview(id) {
  if (confirm("Are you sure you want to delete this review? It is not recoverable.")) {
    $.ajax({
      url: "/locksmith/deletereview/" + id,
      type: 'POST',
      success: function (data) {
        $("a[href='http://locksmith.nexvistech.com/locksmith/editreview/"+id+"']").parent("td").parent("tr").remove();
        alert("Review is deleted successfully.");
      }
    });
  } else {
    console.log("You pressed Cancel!");
  }

}

function deleteBike(id) {
  if (confirm("Are you sure you want to delete this review? It is not recoverable.")) {
    $.ajax({
      url: "/clients/bikeandride/dashboard/admin/deletebike/" + id,
      type: 'POST',
      success: function (data) {
        $("a[href='http://www.nexvistech.com/clients/bikeandride/dashboard/admin/editbike/"+id+"']").parent("td").parent("tr").remove();
        alert("Review is deleted successfully.");
      }
    });
  } else {
    console.log("You pressed Cancel!");
  }
  }





$(document).ready(function () {
  $('.view_profile').click(function(){
    if ( $(this).hasClass('active') ){
      $(this).removeClass('active');
    } else {
      $(this).removeClass('active');
      $(this).addClass('active');
    }
  });
  $( ".toggle_menu").click(function(){
    $(".menu_sidebar").toggleClass("main");
    $(".overlay-bg").toggleClass("main");
  });
  $( ".overlay-bg").click(function(){
    $(".menu_sidebar").toggleClass("main");
    $(".overlay-bg").toggleClass("main");
  });
});