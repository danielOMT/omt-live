$('.jobs_filter').change(function() {
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

                    // Category count
                    $('.category_c').html('(0)').show();//empty filter data
                    data.categories.sort();
                    var currentCat = null;
                    var cntCat = 0;
                    for (var i = 0; i < data.categories.length; i++) {
                        if (data.categories[i] != currentCat) {
                            categoriesSel = $("#jobs_filter_form").find("[data-selector='" +currentCat + "']"); 
                            if (cntCat > 0) {
                                if(notEmpty(categoriesSel)){
                                    $('#'+categoriesSel[0].id).html('('+ cntCat + ')').show();}
                                }
                            currentCat = data.categories[i];
                            cntCat = 1;
                        } else {cntCat++;}
                    }
                    if (cntCat > 0) {
                        categoriesSel = $("#jobs_filter_form").find("[data-selector='" + currentCat + "']"); 
                        if (categoriesSel[0] !== null){
                        }else{
                            $('#'+categoriesSel[0].id).html('('+ cntCat + ')').show();
                        }
                        
                    }


                    //Occupation count
                    $('.besch_c').html('(0)').show();//empty filter data
                    data.occupation.sort();
                    var currentOcc = null;
                    var cntOcc = 0;
                    for (var i = 0; i < data.occupation.length; i++) {
                        if (data.occupation[i] != currentOcc) {
                            occupationSel = $("#jobs_filter_form").find("[data-selector='" +currentOcc + "']"); 
                            if (cntOcc > 0) {
                                if(notEmpty(occupationSel)){
                                    $('#'+occupationSel[0].id).html('('+ cntOcc + ')').show();
                                }
                            }
                            currentOcc = data.occupation[i];
                            cntOcc = 1;
                        } else {cntOcc++;}
                    }
                    if (cntOcc > 0) {
                        occupationSel = $("#jobs_filter_form").find("[data-selector='" + currentOcc + "']"); 
                        if (occupationSel[0] !== null){
                        }else{
                            $('#'+occupationSel[0].id).html('('+ cntOcc + ')').show();
                        }
                    }


                    //Occupation count
                    $('.stadt_c').html('(0)').show();//empty filter data

                    data.arbeiten.sort();
                    var currentArd = null;
                    var cntArb = 0;
                    for (var i = 0; i < data.arbeiten.length; i++) {
                        if (data.arbeiten[i] != currentArd) {
                            arbeitenSel = $("#jobs_filter_form").find("[data-selector='" +currentArd + "']"); 
                            if (cntArb > 0) { 
                                if(notEmpty(arbeitenSel)){
                                    $('#'+arbeitenSel[0].id).html('('+ cntArb + ')').show();
                                }
                            }
                            currentArd = data.arbeiten[i];
                            cntArb = 1;
                        } else {cntArb++;}
                    }
                    if (cntArb > 0) {
                        arbeitenSel = $("#jobs_filter_form").find("[data-selector='" + currentArd + "']"); 
                        if (arbeitenSel[0] !== null){
                        }else{
                            $('#'+arbeitenSel[0].id).html('('+ cntArb + ')').show();
                        }
                        
                    }

                    //Erfahrung count
                    console.log(data.erfahrung);
                    $('.erfahrung_c').html('(0)').show();//empty filter data
                    data.erfahrung.sort();
                    var currentErf = null;
                    var cntErf = 0;
                    for (var i = 0; i < data.erfahrung.length; i++) {
                        if (data.erfahrung[i] != currentErf) {
                            erfahrungSel = $("#jobs_filter_form").find("[data-selector='" +currentErf + "']"); 
                            if (cntErf > 0) { 
                                if(notEmpty(erfahrungSel)){
                                    $('#'+erfahrungSel[0].id).html('('+ cntErf + ')').show();
                                }
                            }
                            currentErf = data.erfahrung[i];
                            cntErf = 1;
                        } else {cntErf++;}
                    }
                    if (cntErf > 0) {
                        erfahrungSel = $("#jobs_filter_form").find("[data-selector='" + currentErf + "']"); 
                        if (erfahrungSel[0] !== null){
                        }else{
                            $('#'+erfahrungSel[0].id).html('('+ cntErf + ')').show();
                        }
                    }
                    
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