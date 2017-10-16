$(document).ready(function(){
  console.log('loading');
});

// Get Total
function getSubTotal(component) {

  console.log(component);
  console.log(component.id);
  console.log(component.value);

  var amount = $('#' +  component.id + '').val();
  var input = component.id;
  var fields = input.split('-');

  var index_1 = fields[1];
  var index_2 = fields[2];
  var name = fields[3];

  var quantity = 0;
  var last_cost = 0;
  var total_line_cost = 0;

  console.log(index_1 + '' + index_2 + name);

  quantity = parseFloat($('#bomcomponents-' +  index_1 + '-' + index_2 + '-quantity').val());
  quantity = parseFloat(quantity);
  if(isNaN(quantity))
  {
    quantity = 0;
  }
  
  last_cost = parseFloat($('#bomcomponents-' +  index_1 + '-' + index_2 + '-last_cost').val());
  last_cost = parseFloat(last_cost);
  if(isNaN(last_cost))
  {
    last_cost = 0;
  }

  total_line_cost = parseFloat(quantity) * parseFloat(last_cost);
  total_line_cost = parseFloat(total_line_cost);

  if(isNaN(total_line_cost))
  {
    total_line_cost = 0;
  }

  var txttotal_line_cost = document.getElementById('bomcomponents-' +  index_1 + '-' + index_2 + '-total_line_cost');
  txttotal_line_cost.value= total_line_cost;

  count = parseFloat($('#bomstage-' +  index_1 + '-count').val());
  count = parseFloat(count);
  console.log(count);
  if(isNaN(count))
  {
    count = 0;
  }

  console.log(count);
  var i =0;
  var total = 0;

  for(i=0;i<count;i++) {

    console.log("Calculate Component Total");
    total_line_cost = parseFloat($('#bomcomponents-' +  index_1 + '-' + i + '-total_line_cost').val());
    if(isNaN(total_line_cost))
    {
      total_line_cost = 0;
    }
    total = total + total_line_cost;

    var txttotal = document.getElementById('bomcomponents-sub_total');
    txttotal.value= total;

    var txttotal = document.getElementById('salesorderreturn-total');
    txttotal.value= total;
  }

  $('#bomstages-' +  index_1 + '-total_input_cost').val(total).trigger('change');
}


function getTotal(component) {
  console.log("total change");
  console.log(component);

  var input = component.id;

  var fields = input.split('-');
  console.log(fields);

  var index_1 = fields[1];
  var index_2 = fields[2];

  var total_component = parseFloat($('#bomcomponents-' +  index_1 + '-total_component').val());
  total_component = parseFloat(total_component);

  if(isNaN(total_component))
  {
    total_component = 0;
  }

  console.log('total_component');
  console.log(total_component);

  console.log('component.oldvalue');
  console.log(component.oldvalue);
  console.log('component.defaultvalue');
  console.log(component.defaultvalue);
  
  old_total_line_cost = parseFloat(component.oldvalue);

  console.log('begin');
  console.log(old_total_line_cost);
  console.log('end');
  if(isNaN(old_total_line_cost))
  {
    old_total_line_cost = parseFloat(component.defaultValue);
    if(isNaN(old_total_line_cost)){
      old_total_line_cost = 0;
    }
  }
  console.log('old_total_line_cost');
  console.log(old_total_line_cost);

  total_line_cost = parseFloat(component.value);


  if(isNaN(total_line_cost))
  {
    total_line_cost = 0;
  }

  total_component = total_component - old_total_line_cost;
  console.log('old_total_component');
  console.log(total_component);
  total_component = total_component + total_line_cost;

  console.log('new_total_component');
  console.log(total_component);
  
  var txttotal_component = document.getElementById('bomcomponents-' +  index_1  + '-total_component');
  txttotal_component.value= total_component;

  var txttotal_input_cost = document.getElementById('bomstages-' +  index_1  + '-total_input_cost');
  txttotal_input_cost.value= total_component;

  $('#bomcomponents-' +  index_1 + '-total_component').val(total_component).trigger('change');

}

function getGrandTotal(component) {
  console.log("grand total change");
  console.log(component);

  var input = component.id;

  var fields = input.split('-');
  console.log(fields);

  var index_1 = fields[1];
  var index_2 = fields[2];

  var grand_total_component = parseFloat($('#bomcomponents-total_component').val());
  grand_total_component = parseFloat(grand_total_component);

  if(isNaN(grand_total_component))
  {
    grand_total_component = 0;
  }

  console.log('grand_total_component');
  console.log(grand_total_component);

  old_total_component = parseFloat(component.oldvalue);
  if(isNaN(old_total_component))
  {
    old_total_component = 0;
  }
  console.log('old_total_component');
  console.log(old_total_component);

  total_component = parseFloat(component.value);
  if(isNaN(total_component))
  {
    total_component = 0;
  }

  grand_total_component = grand_total_component - old_total_component;
  console.log('old_grand_total_component');
  console.log(grand_total_component);
  grand_total_component = grand_total_component + total_component;

  console.log('new_grand_total_component');
  console.log(grand_total_component);
  
  var txtgrand_total_component = document.getElementById('bomcomponents-total_component');
  txtgrand_total_component.value= grand_total_component;

  var txtcost = document.getElementById('bomoutputs-0-cost');
  txtcost.value= grand_total_component;

  var txtcost_percentage = document.getElementById('bomoutputs-0-cost_percentage');
  txtcost_percentage.value= 100;

}



// Get Po SubTotal
function getPoSubTotal(component) {

  console.log(component);
  console.log(component.id);
  console.log(component.value);

  console.log($('#' +  component.id + '').val());
  
  var amount = $('#' +  component.id + '').val();

  var input = component.id;

  var fields = input.split('-');
  console.log(fields);

  var index_1 = fields[1];

  var quantity = 0;
  var last_cost = 0;
  var total_line_cost = 0;

  quantity = parseFloat($('#polines-' +  index_1 + '-quantity').val());
  quantity = parseFloat(quantity);
  if(isNaN(quantity))
  {
    quantity = 0;
  }
  
  last_cost = parseFloat($('#polines-' +  index_1 + '-unit_price').val());
  last_cost = parseFloat(last_cost);
  if(isNaN(last_cost))
  {
    last_cost = 0;
  }

  total_line_cost = parseFloat(quantity) * parseFloat(last_cost);
  total_line_cost = parseFloat(total_line_cost);

  if(isNaN(total_line_cost))
  {
    total_line_cost = 0;
  }

  var txtsubtotal = document.getElementById('polines-' +  index_1 + '-sub_total');
  txtsubtotal.value= total_line_cost;

  count = parseFloat($('#po_line-count').val());
  count = parseFloat(count);
  console.log(count);
  if(isNaN(count))
  {
    count = 0;
  }


  console.log(count);
  var i =0;
  var total = 0;

  for(i=0;i<count;i++) {

    console.log("Calculate Total");
    sub_total = parseFloat($('#polines-' +  i + '-sub_total').val());
    if(isNaN(sub_total))
    {
      sub_total = 0;
    }
    total = total + sub_total;

    var txttotal = document.getElementById('po_line-sub_total');
    txttotal.value= total;

    var txtpaid = document.getElementById('po-paid');
    txtpaid.value= total;

    var txttotal = document.getElementById('po-total');
    txttotal.value= total;
  }

  $('#po-total').val(total).trigger('change');
}

function getPoBalance(component) {
  console.log("Calculate Po Balance");
  console.log(component);

  var input = component.id;

  var fields = input.split('-');
  var name = fields[1];
  console.log(name);


  if(name === "paid") {
    // get total value
    var total = parseFloat($('#po-total').val());
    total = parseFloat(total);

    if(isNaN(total))
    {
      total = 0;
    }

    paid = parseFloat(component.value);

    if(isNaN(paid))
    {
      paid = 0;
    }


  }else if(name === "total") {
    // get paid value
    var paid = parseFloat($('#po-paid').val());
    paid = parseFloat(paid);

    if(isNaN(paid))
    {
      paid = 0;
    }

    total = parseFloat(component.value);
    if(isNaN(total))
    {
      total = 0;
    }
  }

  balance = total - paid;

  var txtbalance = document.getElementById('po-balance');
  txtbalance.value= balance;

}

// Get So SubTotal
function getSoSubTotal(component) {

  console.log(component);
  console.log(component.id);
  console.log(component.value);

  console.log($('#' +  component.id + '').val());
  
  var amount = $('#' +  component.id + '').val();

  var input = component.id;

  var fields = input.split('-');
  console.log(fields);

  var index_1 = fields[1];

  var quantity = 0;
  var last_cost = 0;
  var total_line_cost = 0;

  quantity = parseFloat($('#salesorderlines-' +  index_1 + '-quantity').val());
  quantity = parseFloat(quantity);
  if(isNaN(quantity))
  {
    quantity = 0;
  }
  
  last_cost = parseFloat($('#salesorderlines-' +  index_1 + '-unit_price').val());
  last_cost = parseFloat(last_cost);
  if(isNaN(last_cost))
  {
    last_cost = 0;
  }

  total_line_cost = parseFloat(quantity) * parseFloat(last_cost);
  total_line_cost = parseFloat(total_line_cost);

  if(isNaN(total_line_cost))
  {
    total_line_cost = 0;
  }

  var txtsubtotal = document.getElementById('salesorderlines-' +  index_1 + '-sub_total');
  txtsubtotal.value= total_line_cost;

  count = parseFloat($('#so_line-count').val());
  count = parseFloat(count);
  console.log(count);
  if(isNaN(count))
  {
    count = 0;
  }


  console.log(count);
  var i =0;
  var total = 0;

  for(i=0;i<count;i++) {

    console.log("Calculate Total");
    sub_total = parseFloat($('#salesorderlines-' +  i + '-sub_total').val());
    if(isNaN(sub_total))
    {
      sub_total = 0;
    }
    total = total + sub_total;

    var txttotal = document.getElementById('so_line-sub_total');
    txttotal.value= total;

    var txtpaid = document.getElementById('salesorder-paid');
    txtpaid.value= total;

    var txttotal = document.getElementById('salesorder-total');
    txttotal.value= total;
  }

  $('#salesorder-total').val(total).trigger('change');
}

function getSoBalance(component) {
  console.log("Calculate So Balance");
  console.log(component);

  var input = component.id;

  var fields = input.split('-');
  var name = fields[1];
  console.log(name);


  if(name === "paid") {
    // get total value
    var total = parseFloat($('#salesorder-total').val());
    total = parseFloat(total);
    console.log(total);

    if(isNaN(total))
    {
      total = 0;
    }

    paid = parseFloat(component.value);
    if(isNaN(paid))
    {
      paid = 0;
    }
  }else if(name === "total") {
    // get paid value
    var paid = parseFloat($('#salesorder-paid').val());
    paid = parseFloat(paid);
    console.log(paid);

    if(isNaN(paid))
    {
      paid = 0;
    }
    total = parseFloat(component.value);
    if(isNaN(total))
    {
      total = 0;
    }
  }

  balance = total - paid;

  var txtbalance = document.getElementById('salesorder-balance');
  txtbalance.value= balance;

}



// Get PoReturn SubTotal
function getPoReturnSubTotal(component) {

  console.log(component);
  console.log(component.id);
  console.log(component.value);

  console.log($('#' +  component.id + '').val());
  
  var amount = $('#' +  component.id + '').val();

  var input = component.id;

  var fields = input.split('-');
  console.log(fields);

  var index_1 = fields[1];

  var quantity = 0;
  var last_cost = 0;
  var total_line_cost = 0;

  quantity = parseFloat($('#poreturnlines-' +  index_1 + '-quantity').val());
  quantity = parseFloat(quantity);
  if(isNaN(quantity))
  {
    quantity = 0;
  }
  
  last_cost = parseFloat($('#poreturnlines-' +  index_1 + '-unit_price').val());
  last_cost = parseFloat(last_cost);
  if(isNaN(last_cost))
  {
    last_cost = 0;
  }

  total_line_cost = parseFloat(quantity) * parseFloat(last_cost);
  total_line_cost = parseFloat(total_line_cost);

  if(isNaN(total_line_cost))
  {
    total_line_cost = 0;
  }

  var txtsubtotal = document.getElementById('poreturnlines-' +  index_1 + '-sub_total');
  txtsubtotal.value= total_line_cost;

  count = parseFloat($('#po_return_line-count').val());
  count = parseFloat(count);
  console.log(count);
  if(isNaN(count))
  {
    count = 0;
  }


  console.log(count);
  var i =0;
  var total = 0;

  for(i=0;i<count;i++) {

    console.log("Calculate Total");
    sub_total = parseFloat($('#poreturnlines-' +  i + '-sub_total').val());
    if(isNaN(sub_total))
    {
      sub_total = 0;
    }
    total = total + sub_total;

    var txttotal = document.getElementById('po_return_line-sub_total');
    txttotal.value= total;

    var txtpaid = document.getElementById('poreturn-paid');
    txtpaid.value= total;

    var txttotal = document.getElementById('poreturn-total');
    txttotal.value= total;
  }

  $('#poreturn-total').val(total).trigger('change');
}

function getPoReturnBalance(component) {
  console.log("Calculate PoReturn Balance");
  console.log(component);

  var input = component.id;

  var fields = input.split('-');
  var name = fields[1];
  console.log(name);


  if(name === "paid") {
    // get total value
    var total = parseFloat($('#poreturn-total').val());
    total = parseFloat(total);
    console.log(total);

    if(isNaN(total))
    {
      total = 0;
    }

    paid = parseFloat(component.value);
    if(isNaN(paid))
    {
      paid = 0;
    }
  }else if(name === "total") {
    // get paid value
    var paid = parseFloat($('#poreturn-paid').val());
    paid = parseFloat(paid);
    console.log(paid);

    if(isNaN(paid))
    {
      paid = 0;
    }
    total = parseFloat(component.value);
    if(isNaN(total))
    {
      total = 0;
    }
  }

  balance = total - paid;

  var txtbalance = document.getElementById('poreturn-balance');
  txtbalance.value= balance;

}


// Get SoReturn SubTotal
function getSoReturnSubTotal(component) {

  console.log(component);
  console.log(component.id);
  console.log(component.value);

  console.log($('#' +  component.id + '').val());
  
  var amount = $('#' +  component.id + '').val();

  var input = component.id;

  var fields = input.split('-');
  console.log(fields);

  var index_1 = fields[1];

  var quantity = 0;
  var last_cost = 0;
  var total_line_cost = 0;

  quantity = parseFloat($('#salesorderreturnlines-' +  index_1 + '-quantity').val());
  quantity = parseFloat(quantity);
  if(isNaN(quantity))
  {
    quantity = 0;
  }
  
  last_cost = parseFloat($('#salesorderreturnlines-' +  index_1 + '-unit_price').val());
  last_cost = parseFloat(last_cost);
  if(isNaN(last_cost))
  {
    last_cost = 0;
  }

  total_line_cost = parseFloat(quantity) * parseFloat(last_cost);
  total_line_cost = parseFloat(total_line_cost);

  if(isNaN(total_line_cost))
  {
    total_line_cost = 0;
  }

  var txtsubtotal = document.getElementById('salesorderreturnlines-' +  index_1 + '-sub_total');
  txtsubtotal.value= total_line_cost;

  count = parseFloat($('#so_return_line-count').val());
  count = parseFloat(count);
  console.log(count);
  if(isNaN(count))
  {
    count = 0;
  }


  console.log(count);
  var i =0;
  var total = 0;

  for(i=0;i<count;i++) {

    console.log("Calculate So Total");
    sub_total = parseFloat($('#salesorderreturnlines-' +  i + '-sub_total').val());
    if(isNaN(sub_total))
    {
      sub_total = 0;
    }
    total = total + sub_total;

    var txttotal = document.getElementById('so_return_line-sub_total');
    txttotal.value= total;

    var txtpaid = document.getElementById('salesorderreturn-paid');
    txtpaid.value= total;

    var txttotal = document.getElementById('salesorderreturn-total');
    txttotal.value= total;
  }

  $('#salesorderreturn-total').val(total).trigger('change');
}

function getSoReturnBalance(component) {
  console.log("Calculate So Balance");
  console.log(component);

  var input = component.id;

  var fields = input.split('-');
  var name = fields[1];
  console.log(name);


  if(name === "paid") {
    // get total value
    var total = parseFloat($('#salesorderreturn-total').val());
    total = parseFloat(total);
    console.log(total);

    if(isNaN(total))
    {
      total = 0;
    }

    paid = parseFloat(component.value);
    if(isNaN(paid))
    {
      paid = 0;
    }
  }else if(name === "total") {
    // get paid value
    var paid = parseFloat($('#salesorderreturn-paid').val());
    paid = parseFloat(paid);
    console.log(paid);

    if(isNaN(paid))
    {
      paid = 0;
    }
    total = parseFloat(component.value);
    if(isNaN(total))
    {
      total = 0;
    }
  }

  balance = total - paid;

  var txtbalance = document.getElementById('salesorderreturn-balance');
  txtbalance.value= balance;

}

// Get Vendor Info
function getVendor(component) {

  console.log('component');
  console.log(component);
  console.log(component.id);
  console.log(component.value);
  
  var vendor_id = component.value;
  console.log('vendor_id');
  console.log(vendor_id);

  if(vendor_id != undefined && vendor_id != 0 && vendor_id != null && !isNaN(vendor_id))
  {
    $.ajax({
      url: '/vendor/get-vendor-info',
      data: {id: vendor_id },
      success: function(data) {
        if (data)
        {
          var vendor = JSON.parse(data);
          console.log('vendor');
          console.log(vendor);
          console.log(vendor.name);

          var txtcontact = document.getElementById('vendor-contact');
          txtcontact.value= vendor.contact;

          var txtphone = document.getElementById('vendor-phone');
          txtphone.value= vendor.phone;

          var txtaddress= document.getElementById('vendor-address');
          txtaddress.value= vendor.address;

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
}


// Get Customer Info
function getCustomer(component) {

  console.log('component');
  console.log(component);
  console.log(component.id);
  console.log(component.value);
  
  var customer_id = component.value;
  console.log('customer_id');
  console.log(customer_id);

  if(customer_id != undefined && customer_id != 0 && customer_id != null && !isNaN(customer_id))
  {
    $.ajax({
      url: '/customer/get-customer-info',
      data: {id: customer_id },
      success: function(data) {
        if (data)
        {
          var customer = JSON.parse(data);
          console.log('customer');
          console.log(customer);
          console.log(customer.name);

          var txtcontact = document.getElementById('customer-contact');
          txtcontact.value= customer.contact;

          var txtphone = document.getElementById('customer-phone');
          txtphone.value= customer.phone;

          var txtaddress= document.getElementById('customer-address');
          txtaddress.value= customer.address;

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
}


function getNetWeight(component) {
  console.log("Calculate Net Weight");
  console.log(component);

  var name = component.id;
  var net_weight = 0;
  console.log(name);


  if(name === "production-start_weight") {
    // get end_weight value
    var end_weight = parseFloat($('#production-end_weight').val());
    end_weight = parseFloat(end_weight);
    console.log(end_weight);

    if(isNaN(end_weight))
    {
      end_weight = 0;
    }

    start_weight = parseFloat(component.value);
    if(isNaN(start_weight))
    {
      start_weight = 0;
    }
  }else if(name === "production-end_weight") {
    // get start weight value
    var start_weight = parseFloat($('#production-start_weight').val());
    start_weight = parseFloat(start_weight);
    console.log(start_weight);

    if(isNaN(start_weight))
    {
      start_weight = 0;
    }
    end_weight = parseFloat(component.value);
    if(isNaN(end_weight))
    {
      end_weight = 0;
    }
  }

  net_weight = start_weight - end_weight;
  

  var txtnetweight = document.getElementById('production-net_weight');
  txtnetweight.value= net_weight;

}