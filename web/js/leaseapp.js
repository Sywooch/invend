$(document).ready(function(){
  getPropertyType($('#agreement-property_id'));
});

// Get Property Types

function getPropertyType(component) {
  var property_id;
  property_id = $(component).val();
  if(property_id != undefined && property_id != 0 && property_id != null)
  {
    $.ajax({
      url: '../get-property-type',
      data: {id: property_id },
      success: function(data) {
        if (data)
        {
          var property_type = JSON.parse(data);
          $('#agreement-currency_goodwill').text(property_type.currency);
          $('#agreement-currency_rent_amount').text(property_type.currency);
          $('#agreement-frequency').val(property_type.frequency).attr("selected", "selected");
          $('#agreement-notes').text(property_type.name);
        }else {
          alert('No Data');
        }
        return true;
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) { 
          
          $.ajax({
            url: '../agreement/get-property-type',
            data: {id: property_id },
            success: function(data) {
              if (data)
              {
                var property_type = JSON.parse(data);
                $('#agreement-currency_goodwill').text(property_type.currency);
                $('#agreement-currency_rent_amount').text(property_type.currency);
                $('#agreement-frequency').val(property_type.frequency).attr("selected", "selected");
                $('#agreement-notes').text(property_type.name);
              }else {
                alert('No Data');
              }
              return true;
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                console.log("Status: " + textStatus);
                console.log("Error: " + errorThrown); 
            }     

          }); 
      }     

    });
  }
  
}


// Get Payment Plan 

function getGoodwillSummary(component) {
  var agreement_id;
  agreement_id = $(component).val();
  console.log(agreement_id);
  if(agreement_id != undefined && agreement_id != 0 && agreement_id != null)
  {
    $.ajax({
      url: '../payment/get-goodwill-summary',
      data: {id: agreement_id },
      success: function(data) {
        if (data)
        {
          var payment_plan_summary = JSON.parse(data);
          console.log('payment_plan_summary');
          console.log(payment_plan_summary);
          console.log(payment_plan_summary.currency);
          $('#payment-currency_amount_paid').text(payment_plan_summary.currency);
          $('#payment-currency_amount_paid').attr("value", payment_plan_summary.currency);
          $('#payment-total_rent_paid').attr("value", payment_plan_summary.total_rent_paid);
          $('#payment-total_rent_arrears').attr("value", payment_plan_summary.total_rent_arrears);
          $('#payment-total_goodwill_paid').attr("value", payment_plan_summary.total_goodwill_paid);
          $('#payment-total_goodwill_arrears').attr("value", payment_plan_summary.total_goodwill_arrears);
        }else {
          alert('No Data');
        }
        return true;
      }
    });
  }
}


// Get Total
function getSubTotal(component) {

  console.log(component.id);
  
  console.log($('#' +  component.id + '').val());
  
  var amount = $('#' +  component.id + '').val();

  var input = component.id;

  // bomcomponents-0-1-quantity
  var fields = input.split('-');
  console.log(fields);

  var index_1 = fields[1];
  var index_2 = fields[2];
  var name = fields[3];

  var quantity = 0;
  var last_cost = 0;
  var total_line_cost = 0;

  console.log(index_1 + '' + index_2 + name);

  if(name == 'quantity') {
      quantity = Number($('#bomcomponents-' +  index_1 + '-' + index_2 + '-quantity').val());
      console.log('quantity');
      console.log(quantity);
  }
  
  if(name == "last_cost") {
      last_cost = Number($('#bomcomponents-' +  index_1 + '-' + index_2 + '-last_cost').val());
      console.log('last_cost');
      console.log(last_cost);
  }

  total_line_cost = Number(quantity) * Number(last_cost);
  console.log(total_line_cost);

  $('#bomcomponents-' +  index_1 + '-' + index_2 + '-total_line_cost').attr("value", Number(total_line_cost));
  
  var grand_total_amount = 0;
  for(var i=0;i< 6; i++) {
    grand_total_amount = Number(grand_total_amount) + Number($('#dailysales-' +  i + '-total_amount').val());

    console.log(grand_total_amount);

  }
  $('#dailysales-grand_total_amount').attr("value", grand_total_amount);
}