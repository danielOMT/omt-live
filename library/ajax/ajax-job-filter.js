$('.jobs_filterd').change(function() {
        $('#jobs').hide();
        $("#filter_loader").show();
        var category =  document.getElementsByName('category');
        var erfahrung =  document.getElementsByName('erfahrung');
        var arbeiten =  document.getElementsByName('stadt');
        var occupation =  document.getElementsByName('occupation');
        var resultCategory = [];
        var resultErfahrung = [];
        var queryString = $('#jobs_filter_form').serialize();

        var resultArbeiten = [];
        var resultOccupation = [];
 
        var result = [];
        for (var i = 0; i < category.length; i++) {
            if (category[i].checked) {
                resultCategory.push(category[i].value);
            }
        }
        for (var i = 0; i < erfahrung.length; i++) {
            if (erfahrung[i].checked) {
                resultErfahrung.push(erfahrung[i].value);
            }
        }

        for (var i = 0; i < arbeiten.length; i++) {
            if (arbeiten[i].checked) {
                resultArbeiten.push(arbeiten[i].value);
            }
        }

        for (var i = 0; i < occupation.length; i++) {
            if (occupation[i].checked) {
                resultOccupation.push(occupation[i].value);
            }
        }
        result = [ resultCategory, resultErfahrung];

        $('.category_c').each(function(){
          var $this = $(this),
              categoty_id = $this.attr('id'); // Capture the ID
              //console.log(categoty_id);
        });


        //console.log(resultCategory);


        $.ajax({
            url: jobfilter.ajax_url,
            data: {
                action: 'do_filter_jobs',
                categories: resultCategory,
                erfahrung: resultErfahrung,
                arbeitens: resultArbeiten,
                occupations: resultOccupation,
                nonce: jobfilter.nonce
            },
            type: 'post',
            dataType: 'json',
            success: function (data, textStatus, XMLHttpRequest) {
                if (data.status === 200) {
                    //console.log(data);
                    $("#filter_loader").hide();
                    $('#jobs').html(data.content).show();
                    console.log(data.arbeiten);
                   
                    if(data.checkedCat !== null && data.checkedErf === null && data.checkedArb === null && data.checkedOcc === null){
                        //Occupation count
                        $('.besch_c').html('(0)').show();//empty filter data
                        $('#occup').html(data.occupation).show();//empty filter data
                        //Cities count
                        $('.stadt_c').html('(0)').show();//empty filter data
                        $('#cities__').html(data.arbeiten).show();//empty filter data
                        //Erfahrung count
                        $('.erfahrung_c').html('(0)').show();//empty filter data
                        $('#erfahrung').html(data.erfahrung).show();//empty filter data
                    }
                    else if(data.checkedCat === null && data.checkedErf === null && data.checkedArb === null && data.checkedOcc !== null){
                        //Cities count
                        $('.stadt_c').html('(0)').show();//empty filter data
                        $('#cities__').html(data.arbeiten).show();//empty filter data
                        //Erfahrung count
                        $('.erfahrung_c').html('(0)').show();//empty filter data
                        $('#erfahrung').html(data.erfahrung).show();//empty filter data
                        // Category count
                        $('.category_c').html('(0)').show();//empty filter data
                        $('#category_id').html(data.categories).show();//empty filter data
                    }
                    else if(data.checkedCat === null && data.checkedErf === null && data.checkedArb !== null && data.checkedOcc === null){
                        $('.besch_c').html('(0)').show();//empty filter data
                        $('#occup').html(data.occupation).show();//empty filter data
                        //Erfahrung count
                        $('.erfahrung_c').html('(0)').show();//empty filter data
                        $('#erfahrung').html(data.erfahrung).show();//empty filter data
                        // Category count
                        $('.category_c').html('(0)').show();//empty filter data
                        $('#category_id').html(data.categories).show();//empty filter data
                    }
                    else if(data.checkedCat === null && data.checkedErf !== null && data.checkedArb === null && data.checkedOcc === null){
                        $('.besch_c').html('(0)').show();//empty filter data
                        $('#occup').html(data.occupation).show();//empty filter data
                        //Cities count
                        $('.stadt_c').html('(0)').show();//empty filter data
                        $('#cities__').html(data.arbeiten).show();//empty filter data
                        // Category count
                        $('.category_c').html('(0)').show();//empty filter data
                        $('#category_id').html(data.categories).show();//empty filter data
                    }else{
                        $('.besch_c').html('(0)').show();//empty filter data
                        $('#occup').html(data.occupation).show();//empty filter data
                        //Cities count
                        $('.stadt_c').html('(0)').show();//empty filter data
                        $('#cities__').html(data.arbeiten).show();//empty filter data
                        // Category count
                        $('.category_c').html('(0)').show();//empty filter data
                        $('#category_id').html(data.categories).show();//empty filter data
                        //Erfahrung count
                        $('.erfahrung_c').html('(0)').show();//empty filter data
                        $('#erfahrung').html(data.erfahrung).show();//empty filter data
                    }
              
                    

                    $("form#jobs_filter_form :input").each(function(){
                        var input = $(this); // This is the jquery object of the input, do what you will;
                        $.each(data.checkedErf, function(index, value){
                            if(input.val() === value){
                                $('#'+input[0].id).prop('checked', true);
                            }
                        });
                        $.each(data.checkedCat, function(index, value){
                            if(input.val() === value){
                                $('#'+input[0].id).prop('checked', true);
                            }
                        });
                        $.each(data.checkedArb, function(index, value){
                            if(input.val() === value){
                                $('#'+input[0].id).prop('checked', true);
                            }
                        });
                        $.each(data.checkedOcc, function(index, value){
                            if(input.val() === value){
                                $('#'+input[0].id).prop('checked', true);
                            }
                        });


                    });
                    
                } else if (data.status === 201) {}
            },
            complete: function (data, textStatus) {
                msg = textStatus;
                if (textStatus === 'success') {
                    msg = data.responseJSON.found;

                }
            }



        });
});



function notEmpty(obj) {
    if(Object.keys(obj).length === 0){
        $result = false;
    }else{
        $result = true;
    }
    return $result;
}

function filterJobs(){

    $('#jobs').hide();
        $("#filter_loader").show();
        var category =  document.getElementsByName('category');
        var erfahrung =  document.getElementsByName('erfahrung');
        var arbeiten =  document.getElementsByName('stadt');
        var occupation =  document.getElementsByName('occupation');
        var resultCategory = [];
        var resultErfahrung = [];
        var queryString = $('#jobs_filter_form').serialize();

        var resultArbeiten = [];
        var resultOccupation = [];

        var result = [];
        for (var i = 0; i < category.length; i++) {
            if (category[i].checked) {
                resultCategory.push(category[i].value);
            }
        }
        for (var i = 0; i < erfahrung.length; i++) {
            if (erfahrung[i].checked) {
                resultErfahrung.push(erfahrung[i].value);
            }
        }

        for (var i = 0; i < arbeiten.length; i++) {
            if (arbeiten[i].checked) {
                resultArbeiten.push(arbeiten[i].value);
            }
        }

        for (var i = 0; i < occupation.length; i++) {
            if (occupation[i].checked) {
                resultOccupation.push(occupation[i].value);
            }
        }
        result = [ resultCategory, resultErfahrung];

        $('.category_c').each(function(){
          var $this = $(this),
              categoty_id = $this.attr('id'); // Capture the ID
              //console.log(categoty_id);
        });


        //console.log(resultCategory);


        $.ajax({
            url: jobfilter.ajax_url,
            data: {
                action: 'do_filter_jobs',
                categories: resultCategory,
                erfahrung: resultErfahrung,
                arbeitens: resultArbeiten,
                occupations: resultOccupation,
                nonce: jobfilter.nonce
            },
            type: 'post',
            dataType: 'json',
            success: function (data, textStatus, XMLHttpRequest) {
                if (data.status === 200) {
                    //console.log(data);
                    $("#filter_loader").hide();
                    $('#jobs').html(data.content).show();

                   
                    if(data.checkedCat !== null && data.checkedErf === null && data.checkedArb === null && data.checkedOcc === null){
                        //Occupation count
                        $('.besch_c').html('(0)').show();//empty filter data
                        $('#occup').html(data.occupation).show();//empty filter data
                        //Cities count
                        $('.stadt_c').html('(0)').show();//empty filter data
                        $('#cities__').html(data.arbeiten).show();//empty filter data
                        //Erfahrung count
                        $('.erfahrung_c').html('(0)').show();//empty filter data
                        $('#erfahrung').html(data.erfahrung).show();//empty filter data
                    }
                    else if(data.checkedCat === null && data.checkedErf === null && data.checkedArb === null && data.checkedOcc !== null){
                        //Cities count
                        $('.stadt_c').html('(0)').show();//empty filter data
                        $('#cities__').html(data.arbeiten).show();//empty filter data
                        //Erfahrung count
                        $('.erfahrung_c').html('(0)').show();//empty filter data
                        $('#erfahrung').html(data.erfahrung).show();//empty filter data
                        // Category count
                        $('.category_c').html('(0)').show();//empty filter data
                        $('#category_id').html(data.categories).show();//empty filter data
                    }
                    else if(data.checkedCat === null && data.checkedErf === null && data.checkedArb !== null && data.checkedOcc === null){
                        $('.besch_c').html('(0)').show();//empty filter data
                        $('#occup').html(data.occupation).show();//empty filter data
                        //Erfahrung count
                        $('.erfahrung_c').html('(0)').show();//empty filter data
                        $('#erfahrung').html(data.erfahrung).show();//empty filter data
                        // Category count
                        $('.category_c').html('(0)').show();//empty filter data
                        $('#category_id').html(data.categories).show();//empty filter data
                    }
                    else if(data.checkedCat === null && data.checkedErf !== null && data.checkedArb === null && data.checkedOcc === null){
                        $('.besch_c').html('(0)').show();//empty filter data
                        $('#occup').html(data.occupation).show();//empty filter data
                        //Cities count
                        $('.stadt_c').html('(0)').show();//empty filter data
                        $('#cities__').html(data.arbeiten).show();//empty filter data
                        // Category count
                        $('.category_c').html('(0)').show();//empty filter data
                        $('#category_id').html(data.categories).show();//empty filter data
                    }else{
                        $('.besch_c').html('(0)').show();//empty filter data
                        $('#occup').html(data.occupation).show();//empty filter data
                        //Cities count
                        $('.stadt_c').html('(0)').show();//empty filter data
                        $('#cities__').html(data.arbeiten).show();//empty filter data
                        // Category count
                        $('.category_c').html('(0)').show();//empty filter data
                        $('#category_id').html(data.categories).show();//empty filter data
                        //Erfahrung count
                        $('.erfahrung_c').html('(0)').show();//empty filter data
                        $('#erfahrung').html(data.erfahrung).show();//empty filter data
                    }
              
                    

                    $("form#jobs_filter_form :input").each(function(){
                        var input = $(this); // This is the jquery object of the input, do what you will;
                        $.each(data.checkedErf, function(index, value){
                            if(input.val() === value){
                                $('#'+input[0].id).prop('checked', true);
                            }
                        });
                        $.each(data.checkedCat, function(index, value){
                            if(input.val() === value){
                                $('#'+input[0].id).prop('checked', true);
                            }
                        });
                        $.each(data.checkedArb, function(index, value){
                            if(input.val() === value){
                                $('#'+input[0].id).prop('checked', true);
                            }
                        });
                        $.each(data.checkedOcc, function(index, value){
                            if(input.val() === value){
                                $('#'+input[0].id).prop('checked', true);
                            }
                        });


                    });
                    
                } else if (data.status === 201) {}
            },
            complete: function (data, textStatus) {
                msg = textStatus;
                if (textStatus === 'success') {
                    msg = data.responseJSON.found;

                }
            }


            
        });

}