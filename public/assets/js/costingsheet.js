$(document).ready(function(){
    var i = 1;
    //Upper Materials
    $('#upper').click(function(){
        var typee = "upper";
        i++;
        $('#upperrow').append(
                            '<div id="upperrow'+i+'" name="upper" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1" style="display: inline-flex;">'+
                                    '<span>'+
                                        '<input id="u_item_code'+i+'" type="text" name="u_item_code[]" class="form-control py-2 yourclass" placeholder="Code" required>'+                                     
                                    '</span>'+
                                    '<span>'+
                                        '<a data-toggle="modal" data-id='+i+' onclick="myFunction1('+i+','+typee+')" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #fc5c04 0%, #f96c07); border: none;" class="btn text-white ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>'+                                        
                                    '</span>'+
                                '</div>'+
                                '<div class="col-sm-3 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="u_description'+i+'" name="u_description[]" placeholder="Enter Description" required>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="u_uom'+i+'" name="u_uom[]" placeholder="Unit">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<select id="u_component" name="u_component[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option value="Local">Local</option>'+     
                                        '<option value="Imported">Imported</option>'+                                            
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="u_output" name="u_output[]" placeholder="Output">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="u_cons" name="u_cons[]" placeholder="Quantity">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="u_qty" name="u_qty[]" placeholder="Quantity">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1 text-center">'+
                                    '<button id="'+i+'" type="button" class="btn btn-outline-danger btn-round px-4 upper_remove" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');
    });

    $(document).on('click', '.upper_remove', function(){
        var id = $(this).attr("id"); 
        $('#upperrow'+id+'').remove();
    });

    //Upper Materials
    $('#linning').click(function(){
        var typee = "linning";
        i++;
        $('#linningrow').append(
                            '<div id="linningrow'+i+'" name="linning" class="form-group row mb-2">'+
                                '<div class="col-sm-2 py-1" style="display: inline-flex;">'+
                                    '<span>'+
                                        '<input id="b_item_code'+i+'" type="text" name="b_item_code[]" class="form-control py-2 yourclass" placeholder="Code" required>'+                                     
                                    '</span>'+
                                    '<span>'+
                                        '<a data-toggle="modal" data-id='+i+' onclick="myFunction1('+i+','+typee+')" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #fc5c04 0%, #f96c07); border: none;" class="btn text-white ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>'+                                        
                                    '</span>'+
                                '</div>'+
                                '<div class="col-sm-3 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="b_description'+i+'" name="b_description[]" placeholder="Enter Description" required>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="b_uom'+i+'" name="b_uom[]" placeholder="Unit">'+
                                '</div>'+
                                '<div class="col-sm-2 py-1">'+
                                    '<select id="b_component" name="b_component[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option value="Local">Local</option>'+     
                                        '<option value="Imported">Imported</option>'+    
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="b_output" name="b_output[]" placeholder="Output">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="b_cons" name="b_cons[]" placeholder="Quantity">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1">'+
                                    '<input type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="b_qty" name="b_qty[]" placeholder="Quantity">'+
                                '</div>'+
                                '<div class="col-sm-1 py-1 text-center">'+
                                    '<button id="'+i+'" type="button" class="btn btn-outline-danger btn-round px-4 linning_remove" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');
    });

    $(document).on('click', '.linning_remove', function(){
        var id = $(this).attr("id"); 
        $('#linningrow'+id+'').remove();
    });
});